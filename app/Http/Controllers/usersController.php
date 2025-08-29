<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class usersController extends Controller
{

    public function gettype()
    {
        $type ="";
        if (Auth::check()) {
            $type = Auth::user()->role;
        }
        return $type;
    }
    public function usuarios()
    {

        $usuarios = User::select('id', 'name')
            ->orderBy('name', 'asc')
            ->where('status', '=', '1')
            ->get();

        $idssucursales = warehouse::select('id', 'name')
            ->get();
        $type = $this->gettype();
        return view('usuarios.usuarios', ['usuarios' => $usuarios, 'type' => $type, 'idssucursales' => $idssucursales]);
    }
    public function listausuarios()
    {
        $roles = [
            1 => 'Super Administrador',
            2 => 'Facturas/Vendedor',
            3 => 'Instructor Gimnasio',
            4 => 'Instructor Alberca',
        ];

        $users = User::select(
            'users.name as nombre',
            'users.email as correo',
            'users.pass as contrasena',
            'users.role as rol',
            DB::raw('CASE WHEN users.status = 1 THEN "Activo" ELSE "Inactivo" END as estatus')
        )
            ->get()
            ->map(function ($item) use ($roles) {
                // Transformar el rol numérico a texto usando el map
                $item->rol = $roles[$item->rol] ?? 'Desconocido';
                return $item;
            });

        $type = $this->gettype();

        return view('usuarios.lista', [
            'type'  => $type,
            'users' => $users,
        ]);
    }

    public function crearusuario(Request $request)
    {

        try {
            // Validar los datos del formulario

            $request->validate([
                'usuario'    => 'required',
                'contrasena' => ['required', 'string', 'min:8'],
                'tipo'       => 'required',
                'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

            // Crear una nueva instancia del modelo Usuario
            $usuario           = new User();
            $usuario->name     = $request->usuario;
            $usuario->password = Hash::make($request->contrasena);
            $usuario->pass     = $request->contrasena;
            $usuario->role     = $request->tipo;
            $usuario->email    = $request->email;
            $usuario->phone    = $request->telefono;

            $usuario->status = 1;

            // Guardar el usuario en la base de datos
            $usuario->save();
            // Devolver una respuesta de éxito
            return response()->json(['message' => 'Usuario creado correctamente'], 200);
        } catch (\Throwable $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al crear el usuario' . $e->getMessage()], 500);
        }
    }

    public function actualizarusuario(Request $request)
    {

        try {
            // Encuentra el usuario por su ID
            $usuarioEncriptado      = $request->id;
            $usuarioIdDesencriptado = Crypt::decrypt($usuarioEncriptado);
            $usuario                = User::findOrFail($usuarioIdDesencriptado);

            // Actualiza los datos del usuario
            $usuario->password = Hash::make($request->contrasena);
            $usuario->pass     = $request->contrasena;
            $usuario->type     = $request->tipo;
            // Otros campos que quieras actualizar

            $usuario->save();

            return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
        } catch (\Throwable $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al actualizar el usuario'], 500);
        }

    }
    public function actualizarext(Request $request)
    {

        try {
            // Encuentra el usuario por su ID
            $usuarioEncriptado      = $request->id;
            $usuarioIdDesencriptado = Crypt::decrypt($usuarioEncriptado);
            $usuario                = User::findOrFail($usuarioIdDesencriptado);
            // Actualiza los datos del usuario
            $usuario->password = Hash::make($request->contrasena);
            $usuario->pass     = $request->contrasena;
            $usuario->save();
            $mess = 'Usuario actualizado correctamente';

            return response()->json(['message' => $mess], 200);
        } catch (\Throwable $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al actualizar el usuario'], 500);
        }

    }
    public function eliminarusuario(Request $request)
    {

        try {
            $contrasena = 'Progyms123#';
            // Encuentra el usuario por su ID
            $usuarioEncriptado      = $request->id;
            $usuarioIdDesencriptado = Crypt::decrypt($usuarioEncriptado);
            $usuario                = User::findOrFail($usuarioIdDesencriptado);
            $usuario->password      = Hash::make($contrasena);
            $usuario->pass          = $contrasena;
            $usuario->status        = 0;
            $usuario->save();
            // Eliminar usuario

            $mess = 'Usuario eliminado correctamente';

            return response()->json(['message' => $mess], 200);
        } catch (\Throwable $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al eliminar el usuario: ' . $e->getMessage()], 500);
        }

    }





}
