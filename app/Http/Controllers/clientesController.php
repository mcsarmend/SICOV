<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\clients;
use App\Models\preregistration;
use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;


class clientesController extends Controller
{
    public function preregistro()
    {
        $type = $this->gettype();
        $warehouse = warehouse::all();

        return view('clientes.preregistro', ['type' => $type, 'warehouses' => $warehouse]);
    }
    public function altacliente()
    {
        $type = $this->gettype();
        $preregistration = preregistration::select([
            'preregistration.id',
            'preregistration.nombre',
            'preregistration.telefono',
            'preregistration.gimnasio',
            'preregistration.alberca',
            'preregistration.observaciones',
            DB::raw('COALESCE(preregistration.paquete_alberca, "Sin paquete") as paquete_alberca'),
            DB::raw('COALESCE(preregistration.horario_alberca, "Sin horario") as horario_alberca'),
            'preregistration.idusuario',
            DB::raw('COALESCE(users.name, "Sin asignar") as creado_por')
        ])
            ->leftJoin('users', 'preregistration.idusuario', '=', 'users.id')
            ->get()
            ->map(function ($item) {
                // Transformar booleanos a texto
                $item->gimnasio = $item->gimnasio ? 'Sí' : 'No';
                $item->alberca = $item->alberca ? 'Sí' : 'No';
                return $item;
            });

        return view('clientes.alta', ['type' => $type, 'preregistration' => $preregistration]);
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

    public function infopreregistro(Request $request) // ✅ Correcto
    {
        try {
            $id = $request->input('id'); // o $request->id

            $preregistration = preregistration::select([
                'id',
                'nombre',
                'telefono',
                'gimnasio',
                'alberca',
                'observaciones',
                'paquete_alberca',
                'horario_alberca',
                'idusuario'
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $preregistration
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function precrearcliente(Request $request)
    {

        try {

            // Crear una nueva instancia del modelo Usuario
            $preregistration = new preregistration();
            $preregistration->nombre = $request->nombre;
            $preregistration->telefono = $request->telefono;
            $servicios = $request->servicios;
            $tieneGimnasio = in_array("gimnasio", $servicios);
            $tieneAlberca = in_array("alberca", $servicios);

            if ($tieneGimnasio)
                $preregistration->gimnasio = 1;
            if ($tieneAlberca) {
                $preregistration->alberca = 1;
                $preregistration->paquete_alberca = $request->paquete_alberca;
                $preregistration->horario_alberca = $request->horario_alberca;
            }
            $preregistration->observaciones = $request->observaciones;
            $iduser = Auth::user()->id;
            $preregistration->idusuario = intval($iduser);

            // Guardar el usuario en la base de datos
            $preregistration->save();


            return response()->json(['message' => 'Cliente pre-creado correctamente'], 200);
        } catch (\Throwable $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al pre-crear el cliente: ' . $e->getMessage()], 500);
        }
    }

    public function crearcliente(Request $request)
    {
        try {

            $client = new clients();
            $client->nombre = $request->nombre;
            $client->telefono = $request->telefono;
            $servicios = $request->servicios;
            $tieneGimnasio = in_array("gimnasio", $servicios);
            $tieneAlberca = in_array("alberca", $servicios);

            if ($tieneGimnasio)
                $client->gimnasio = 1;
            if ($tieneAlberca) {
                $client->alberca = 1;
                $client->paquete_alberca = $request->paquete_alberca;
                $client->horario_alberca = $request->horario_alberca;
            }
            $client->observaciones = $request->observaciones;
            $iduser = Auth::user()->id;
            $client->idusuario = intval($iduser);
            $client->tipo = $request->tipo_acceso;
            $client->save();


            // Obtener el ID del cliente recién creado


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
