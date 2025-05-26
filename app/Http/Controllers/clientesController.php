<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\clients;

use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class clientesController extends Controller
{
    public function altacliente()
    {
        $type = $this->gettype();
        $warehouse = warehouse::all();

        return view('clientes.alta', ['type' => $type, 'warehouses' => $warehouse]);
    }
    public function bajacliente()
    {
        $clients = clients::all();
        $type = $this->gettype();
        return view('clientes.baja', ['type' => $type, 'clients' => $clients]);
    }
    public function clientes()
    {
        $type = $this->gettype();
        $clients = clients::select('clients.id', 'clients.nombre', 'clients.telefono', 'warehouse.nombre as sucursal')
            ->leftJoin('warehouse', 'clients.sucursal', '=', 'warehouse.id')
            ->get();

        return view('clientes.clientes', ['type' => $type, 'clients' => $clients]);
    }
    public function edicioncliente()
    {
        $type = $this->gettype();
        $clients = clients::all();

        $sucursales = warehouse::all();
        return view('clientes.edicion', ['type' => $type, 'clients' => $clients, 'sucursales' => $sucursales]);
    }
    public function verdireccioncliente(Request $request)
    {

        try {
            $direccion = address::where('idcliente', $request->id)->get();
            return response()->json(['message' => 'Reporte Generado Correctamente', 'direccion' => $direccion], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al generar el reporte' . $th->getMessage()], 500);
        }
    }

    public function crearcliente(Request $request)
    {

        try {

            // Crear una nueva instancia del modelo Usuario
            $cliente = new clients();
            $cliente->nombre = $request->cliente;
            $cliente->sucursal = intval($request->sucursal);
            $cliente->telefono = $request->telefono;
            $cliente->precio = intval($request->precio);
            $iduser = Auth::user()->id;
            $cliente->ejecutivo = intval($iduser);

            // Guardar el usuario en la base de datos
            $cliente->save();
            $newdireccion = new address();
            $newdireccion2 = new address();

            $newdireccion->idcliente = $cliente->id;
            $newdireccion2->idcliente = $cliente->id;
            $direccion1 = $request->direccion;
            $direccion2 = $request->direccion2;
            if ($direccion1) {
                $newdireccion->direccion = $direccion1;
                $newdireccion->latitud = $request->latitud;
                $newdireccion->longitud = $request->longitud;
                $newdireccion->save();
            }
            if ($direccion2) {
                $newdireccion2->direccion = $direccion2;
                $newdireccion2->latitud = $request->latitud2;
                $newdireccion2->longitud = $request->longitud2;
                $newdireccion2->save();
            }

            // Devolver una respuesta de éxito
            return response()->json(['message' => 'Cliente creado correctamente'], 200);
        } catch (\Throwable $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al crear el cliente: ' . $e->getMessage()], 500);
        }
    }

    public function eliminarcliente(Request $request)
    {
        try {
            // Encuentra el usuario por su ID
            $id = $request->id;

            $clientid = Crypt::decrypt($id);
            clients::findOrFail($clientid)->delete();
            return response()->json(['message' => 'cliente eliminado correctamente'], 200);
        } catch (\Throwable $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function editarcliente(Request $request)
    {
        try {
            $idcliente = intval(Crypt::decrypt($request->id));
            $nuevo_nombre = $request->nombre;
            $idsucursal = intval(Crypt::decrypt($request->id_sucursal));

            $telefono = $request->telefono;
            $direccion1 = $request->direccion;
            $direccion2 = $request->direccion2;

            $cliente = clients::find($idcliente);
            if ($nuevo_nombre) {
                $cliente->nombre = $nuevo_nombre;
            }
            if ($idsucursal) {
                $cliente->sucursal = $idsucursal;
            }

            if ($telefono) {
                $cliente->telefono = $telefono;
            }
            $cliente->save();

            // Buscar la primera dirección del cliente
            if ($direccion1) {
                $direccionPrincipal = Address::where('idcliente', $idcliente)
                    ->orderBy('id', 'asc')
                    ->first();

                if ($direccionPrincipal) {
                    $direccionPrincipal->direccion = $direccion1;
                    $direccionPrincipal->latitud = $request->latitud;
                    $direccionPrincipal->longitud = $request->longitud;
                    $direccionPrincipal->save();

                } else {
                    // Si no hay dirección principal, crear una nueva
                    Address::create([
                        'direccion' => $direccion1,
                        'latitud' => $request->latitud,
                        'longitud' => $request->longitud,
                        'idcliente' => $idcliente,
                    ]);
                }
            }

            // Buscar la segunda dirección del cliente
            if ($direccion2) {
                $direccionSecundaria = Address::where('idcliente', $idcliente)
                    ->orderBy('id', 'asc')
                    ->skip(1)
                    ->first();

                if ($direccionSecundaria) {
                    $direccionSecundaria->direccion = $direccion2;
                    $direccionSecundaria->latitud = $request->latitud2;
                    $direccionSecundaria->longitud = $request->longitud2;
                    $direccionSecundaria->save();

                } else {
                    // Si no hay dirección principal, crear una nueva
                    Address::create([
                        'direccion' => $direccion2,
                        'latitud' => $request->latitud2,
                        'longitud' => $request->longitud2,
                        'idcliente' => $idcliente,
                    ]);
                }
            }

            return response()->json(['message' => "Cliente actualizado correctamente"], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Payload inválido',
                'errors' => $th->getMessage()
            ], 422);
        }
    }

    public function gettype()
    {
        if (Auth::check()) {
            $type = Auth::user()->role;
        }
        return $type;
    }

}
