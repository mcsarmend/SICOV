<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class usersController extends Controller
{

    public function usuarios()
    {

        $usuarios = User::select('id', 'name')
        ->orderBy('name', 'asc')
        ->get();
        if (Auth::check()) {
            $type = Auth::user()->type;
        }
        return view('usuarios.usuarios', ['usuarios' => $usuarios, 'type'=>$type]);
    }

    public function guardar(Request $request)
    {

        try {
            // Validar los datos del formulario

            $request->validate([
                'usuario' => 'required',
                'contrasena' => ['required', 'string', 'min:8'],
                'tipo' => 'required',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

            // Crear una nueva instancia del modelo Usuario
            $usuario = new User();
            $usuario->name = $request->usuario;
            $usuario->password = Hash::make($request->contrasena);
            $usuario->type = $request->tipo;
            $usuario->email = $request->email;

            // Guardar el usuario en la base de datos
            $usuario->save();
            // Devolver una respuesta de éxito
            return response()->json(['message' => 'Usuario creado correctamente'], 200);
        } catch (Exception $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al crear el usuario'], 500);
        }
    }

    public function actualizar(Request $request)
    {

        try {
            // Encuentra el usuario por su ID
            $usuarioEncriptado = $request->id;
            $usuarioIdDesencriptado = Crypt::decrypt($usuarioEncriptado);
            $usuario = User::findOrFail($usuarioIdDesencriptado);

            // Actualiza los datos del usuario
            $usuario->password = Hash::make($request->contrasena);
            $usuario->type = $request->tipo;
            // Otros campos que quieras actualizar

            $usuario->save();

            return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
        } catch (Exception $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al actualizar el usuario'], 500);
        }

    }
    public function actualizarext(Request $request)
    {

        try {
            // Encuentra el usuario por su ID
            $usuarioEncriptado = $request->id;
            $usuarioIdDesencriptado = Crypt::decrypt($usuarioEncriptado);
            $usuario = User::findOrFail($usuarioIdDesencriptado);
            // Actualiza los datos del usuario
            $usuario->password = Hash::make($request->contrasena);
            $usuario->save();
            $mess = 'Usuario actualizado correctamente';

            return response()->json(['message' => $mess], 200);
        } catch (Exception $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al actualizar el usuario'], 500);
        }

    }
    public function eliminar(Request $request)
    {

        try {
            // Encuentra el usuario por su ID
            $usuarioEncriptado = $request->id;
            $usuarioIdDesencriptado = Crypt::decrypt($usuarioEncriptado);
            User::findOrFail($usuarioIdDesencriptado)->delete();
            // Eliminar usuario

            $mess = 'Usuario eliminado correctamente';

            return response()->json(['message' => $mess], 200);
        } catch (Exception $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al actualizar el usuario'], 500);
        }

    }

    public function obtenerTipo(Request $request) {
        $usuarioEncriptado = $request->id;
        $usuarioIdDesencriptado = Crypt::decrypt($usuarioEncriptado);
        $usuario = User::find($usuarioIdDesencriptado);
        return response()->json(['tipo' => $usuario->type]);
    }

}
