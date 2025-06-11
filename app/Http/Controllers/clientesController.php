<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\attendance;
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
    public function asistencias()
    {

        $type = $this->gettype();
        $clients = clients::all();



        $tipo = intval( Auth::user()->role);


        if ($tipo == 3 || $tipo == 4) {
            $attendances = attendance::select([
                'attendance.check_in',
                'attendance.check_out',
                'attendance.package_type',
                'attendance.classes_remaining',
                'clients.nombre',
                'clients.id'
            ])
                ->leftJoin('clients', 'attendance.client_id', '=', 'clients.id')
                ->whereDate('attendance.check_in', today())
                ->where('attendance.type', Auth::user()->role)
                ->get();
        } else {
            $attendances = attendance::select([
                'attendance.check_in',
                'attendance.check_out',
                'attendance.package_type',
                'attendance.classes_remaining',
                'clients.nombre',
                'clients.id'
            ])
                ->leftJoin('clients', 'attendance.client_id', '=', 'clients.id')
                ->whereDate('attendance.check_in', today())
                ->get();
        }



        return view('clientes.asistencias', ['type' => $type, 'clients' => $clients, 'attendances' => $attendances, 'tipo' => $tipo]);
    }
    public function clientes()
    {
        $type = $this->gettype();
        $clients = clients::select(
            'clients.id',
            'clients.nombre',
            'clients.telefono',
            'clients.gimnasio',
            'clients.alberca',
            'clients.observaciones',
            'clients.tipo',
            'clients.fecha_creacion',
            'clients.status',
            DB::raw('COALESCE(clients.paquete_alberca, "Sin paquete") as paquete_alberca'),
            DB::raw('COALESCE(clients.horario_alberca, "Sin horario") as horario_alberca'),
        )
            ->orderBy('clients.id', 'desc')
            ->get()
            ->map(function ($item) {
                // Transformar booleanos a texto
                $item->gimnasio = $item->gimnasio ? 'Sí' : 'No';
                $item->alberca = $item->alberca ? 'Sí' : 'No';
                $item->status = $item->status ? 'Activo' : 'Inactivo';
                return $item;
            });

        return view('clientes.clientes', ['type' => $type, 'clients' => $clients]);
    }
    public function edicioncliente()
    {
        $type = $this->gettype();
        $clients = clients::all();

        $sucursales = warehouse::all();
        return view('clientes.edicion', ['type' => $type, 'clients' => $clients, 'sucursales' => $sucursales]);
    }


    public function registrarasistencia(Request $request)
    {
        try {
            // Configurar timezone para México
            date_default_timezone_set('America/Mexico_City');

            $client = clients::findOrFail($request->client_id);

            // Obtener fecha y hora actual en México
            $nowMexico = now('America/Mexico_City');
            $todayMexico = $nowMexico->toDateString();

            // 1. Verificar registro activo hoy
            $existingAttendance = Attendance::where('client_id', $client->id)
                ->whereDate('check_in', $todayMexico)
                ->whereNull('check_out')
                ->first();

            if ($existingAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya tienes un registro de asistencia activo hoy'
                ]);
            }

            // 2. Extraer límites del paquete
            $packageParts = explode('_', $client->paquete_alberca);
            $maxClassesPerWeek = (int) $packageParts[0];
            $maxClassesPerMonth = $maxClassesPerWeek * 4;

            // 3. Contar asistencias SEMANALES (usando hora de México)
            $startOfWeek = $nowMexico->copy()->startOfWeek();
            $endOfWeek = $nowMexico->copy()->endOfWeek();

            $weeklyCount = Attendance::where('client_id', $client->id)
                ->whereBetween('check_in', [$startOfWeek, $endOfWeek])
                ->count();

            // 4. Contar asistencias MENSUALES (usando hora de México)
            $startOfMonth = $nowMexico->copy()->startOfMonth();
            $endOfMonth = $nowMexico->copy()->endOfMonth();

            $monthlyCount = Attendance::where('client_id', $client->id)
                ->whereBetween('check_in', [$startOfMonth, $endOfMonth])
                ->count();

            // 5. Validar límites
            if ($weeklyCount >= $maxClassesPerWeek) {
                return response()->json([
                    'success' => false,
                    'message' => 'Límite semanal alcanzado: ' . $weeklyCount . '/' . $maxClassesPerWeek,
                    'monthly_usage' => $monthlyCount . '/' . $maxClassesPerMonth
                ]);
            }

            $message_monthly = $monthlyCount + 1 . '/' . $maxClassesPerMonth;
            if ($monthlyCount >= $maxClassesPerMonth) {
                return response()->json([
                    'success' => false,
                    'message' => 'Límite mensual alcanzado: ' . $monthlyCount . '/' . $maxClassesPerMonth,
                    'monthly_usage' => $monthlyCount . '/' . $maxClassesPerMonth
                ]);
            }

            // 6. Registrar nueva asistencia con hora de México
            $attendance = new Attendance();
            $attendance->client_id = $client->id;
            $attendance->check_in = $nowMexico;
            $attendance->package_type = $client->paquete_alberca;
            $attendance->classes_remaining = $message_monthly;
            $attendance->type = auth()->user()->role; // Asignar tipo de acceso del usuario
            $attendance->save();

            // 7. Devolver respuesta con contadores actualizados
            return response()->json([
                'success' => true,
                'message' => 'Asistencia registrada exitosamente',
                'weekly_usage' => ($weeklyCount + 1) . '/' . $maxClassesPerWeek,
                'monthly_usage' => ($monthlyCount + 1) . '/' . $maxClassesPerMonth,
                'hora_registro' => $nowMexico->format('Y-m-d H:i:s') // Opcional: devolver hora de registro
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar asistencia: ' . $e->getMessage()
            ], 500);
        }
    }

    public function registrarsalida(Request $request)
    {
        try {
            // Configurar timezone para México
            date_default_timezone_set('America/Mexico_City');

            $client = clients::findOrFail($request->client_id);

            // Obtener fecha y hora actual en México
            $nowMexico = now('America/Mexico_City');

            // 1. Verificar si hay un registro activo hoy
            $attendance = Attendance::where('client_id', $client->id)
                ->whereDate('check_in', $nowMexico->toDateString())
                ->whereNull('check_out')
                ->first();

            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes un registro de asistencia activo hoy'
                ]);
            }

            // 2. Actualizar el campo check_out con la hora actual
            $attendance->check_out = $nowMexico;
            $attendance->save();

            return response()->json([
                'success' => true,
                'message' => 'Salida registrada exitosamente',
                'hora_salida' => $nowMexico->format('Y-m-d H:i:s') // Opcional: devolver hora de salida
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar salida: ' . $e->getMessage()
            ], 500);
        }
    }

    public function actualizarasistencias(Request $request)
    {

        try {

            $type = $this->gettype();
            $type = intval($type);
            if ($type == 3 || $type == 4) {
                $attendances = attendance::select([
                    'attendance.check_in',
                    'attendance.check_out',
                    'attendance.package_type',
                    'attendance.classes_remaining',
                    'clients.nombre',
                    'clients.id'
                ])
                    ->leftJoin('clients', 'attendance.client_id', '=', 'clients.id')
                    ->whereDate('attendance.check_in', today())
                    ->where('attendance.type', Auth::user()->role)
                    ->get();
            } else {
                $attendances = attendance::select([
                    'attendance.check_in',
                    'attendance.check_out',
                    'attendance.package_type',
                    'attendance.classes_remaining',
                    'clients.nombre',
                    'clients.id'
                ])
                    ->leftJoin('clients', 'attendance.client_id', '=', 'clients.id')
                    ->whereDate('attendance.check_in', today())
                    ->get();
            }


            return response()->json($attendances);
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
            $client->status = 1;
            $client->save();

            $idpreregistro = $request->preregistro_id;

            $preregistro = preregistration::findOrFail($idpreregistro);
            $preregistro->delete();


            return response()->json(['message' => 'Cliente creado correctamente'], 200);
        } catch (\Throwable $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al crear el cliente: ' . $e->getMessage()], 500);
        }
    }
    public function eliminarcliente(Request $request)
    {
        try {
            // Encuentra el cliente por su ID
            $id = $request->id;
            $clientid = Crypt::decrypt($id);

            // Actualizar solo el campo status a 0
            $client = clients::findOrFail($clientid);
            $client->status = 0;
            $client->save();

            return response()->json(['message' => 'Estado del cliente actualizado correctamente'], 200);
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
            $telefono = $request->telefono;

            $cliente = clients::findOrFail($idcliente);

            // Actualizar campos básicos
            if ($nuevo_nombre) {
                $cliente->nombre = $nuevo_nombre;
            }

            if ($telefono) {
                $cliente->telefono = $telefono;
            }

            // Actualizar servicios
            $servicios = $request->servicios ?? [];
            $tieneGimnasio = in_array("gimnasio", $servicios);
            $tieneAlberca = in_array("alberca", $servicios);

            $cliente->gimnasio = $tieneGimnasio ? 1 : 0;
            $cliente->alberca = $tieneAlberca ? 1 : 0;

            // Si tiene alberca, actualizar paquete y horario
            if ($tieneAlberca) {
                $cliente->paquete_alberca = $request->paquete_alberca;
                $cliente->horario_alberca = $request->horario_alberca;
            } else {
                $cliente->paquete_alberca = null;
                $cliente->horario_alberca = null;
            }

            // Actualizar observaciones si existen
            if ($request->has('observaciones')) {
                $cliente->observaciones = $request->observaciones;
            }

            // Actualizar tipo de acceso si existe
            if ($request->has('tipo_acceso')) {
                $cliente->tipo = $request->tipo_acceso;
            }

            $cliente->save();

            return response()->json(['message' => "Cliente actualizado correctamente"], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al actualizar el cliente',
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
