<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\agenda;
use App\Models\attendance;
use App\Models\clients;
use App\Models\payments;
use App\Models\preregistration;
use App\Models\warehouse;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class clientesController extends Controller
{
    public function preregistro()
    {
        $type      = $this->gettype();
        $warehouse = warehouse::all();

        return view('clientes.preregistro', ['type' => $type, 'warehouses' => $warehouse]);
    }
    public function agenda()
    {

        $horarios = [
            1 => ['06:00:00', '07:00:00'],
            2 => ['07:00:00', '08:00:00'],
            3 => ['08:00:00', '09:00:00'],
            4 => ['15:00:00', '16:00:00'],
            5 => ['16:00:00', '17:00:00'],
            6 => ['17:00:00', '18:00:00'],
            7 => ['18:00:00', '19:00:00'],
        ];

        $events = Agenda::select(
            'agenda_clientes.id_agenda',
            'agenda_clientes.id_cliente',
            'c.nombre as nombre_cliente',
            'agenda_clientes.fecha_sesion',
            'agenda_clientes.estatus',
            'agenda_clientes.horario as horario_id',
            'h.descripcion as horario_desc',
            'agenda_clientes.paquete'
        )
            ->leftJoin('clients as c', 'agenda_clientes.id_cliente', '=', 'c.id')
            ->leftJoin('horarios as h', 'agenda_clientes.horario', '=', 'h.id')
            ->get()
            ->map(function ($item) use ($horarios) {
                $today = now()->toDateString();
                $color = '#3788d8'; // Default

                if ($item->estatus == 'PENDIENTE') {
                    $color = ($item->fecha_sesion < $today) ? 'red' : 'green';
                } elseif ($item->estatus == 'REGISTRADA') {
                    $color = '#3788d8';
                } elseif ($item->estatus == 'TOMADA') {
                    $color = 'yellow';
                }

                // Usar el ID de horario
                $hora  = $horarios[$item->horario_id] ?? ['08:00:00', '09:00:00'];
                $start = $item->fecha_sesion . 'T' . $hora[0];
                $end   = $item->fecha_sesion . 'T' . $hora[1];

                return [
                    'title'         => $item->nombre_cliente,
                    'start'         => $start,
                    'end'           => $end,
                    'extendedProps' => [
                        'description'  => $item->estatus,
                        'horario_desc' => $item->horario_desc,
                        'cliente_id'   => $item->id_cliente,
                        'id_agenda'    => $item->id_agenda,
                    ],
                    'color'         => $color,
                ];
            });
        return view('clientes.agenda', [
            'events' => json_encode($events),
        ]);
    }
    public function reagendar()
    {
        $clientes = DB::table('agenda_clientes as a')
            ->leftJoin('clients as c', 'a.id_cliente', '=', 'c.id')
            ->leftJoin('horarios as h', 'h.id', '=', 'a.horario')
            ->where('c.alberca', 1)
            ->select('a.id_agenda', 'c.id as idcliente', 'c.nombre', 'h.descripcion', 'a.fecha_sesion', 'a.estatus', 'a.reagendada as reagendada')
            ->get()
            ->map(function ($item) {
                // Transformar booleanos a texto
                $item->reagendada = $item->reagendada ? 'Sí' : 'No';
                return $item;
            });

        return view('clientes.reagendar', ['clientes' => $clientes]);
    }

    public function altacliente()
    {
        $type            = $this->gettype();
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
            DB::raw('COALESCE(users.name, "Sin asignar") as creado_por'),
        ])
            ->leftJoin('users', 'preregistration.idusuario', '=', 'users.id')
            ->get()
            ->map(function ($item) {
                // Transformar booleanos a texto
                $item->gimnasio = $item->gimnasio ? 'Sí' : 'No';
                $item->alberca  = $item->alberca ? 'Sí' : 'No';
                return $item;
            });

        return view('clientes.alta', ['type' => $type, 'preregistration' => $preregistration]);
    }
    public function bajacliente()
    {
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
                $item->alberca  = $item->alberca ? 'Sí' : 'No';
                $item->status   = $item->status ? 'Activo' : 'Inactivo';
                return $item;
            });
        $type = $this->gettype();
        return view('clientes.baja', ['type' => $type, 'clients' => $clients]);
    }
    public function asistenciaalberca()
    {

        $type    = $this->gettype();
        $clients = clients::all();

        $tipo = intval(Auth::user()->role);

        $attendances = attendance::select([
            'attendance.check_in',
            'attendance.check_out',
            'attendance.package_type',
            'attendance.classes_remaining',
            'clients.nombre',
            'clients.id',
        ])
            ->leftJoin('clients', 'attendance.client_id', '=', 'clients.id')
            ->whereDate('attendance.check_in', today())
            ->where('attendance.type', 1)
            ->get();

        return view('clientes.asistenciaalberca', ['type' => $type, 'clients' => $clients, 'attendances' => $attendances, 'tipo' => $tipo]);
    }
    public function historicoasistencias()
    {

        $tipo = [
            1 => 'ALBERCA',
            2 => 'GIMNASIO',
        ];

        $type    = $this->gettype();
        $clients = clients::all();

        $clients = attendance::select([
            'attendance.check_in',
            'attendance.check_out',
            'attendance.package_type',
            'attendance.classes_remaining',
            'attendance.type',
            'clients.nombre',
            'clients.id',
        ])
            ->leftJoin('clients', 'attendance.client_id', '=', 'clients.id')
            ->whereDate('attendance.check_in', today())
            ->get()
            ->map(function ($item) use ($tipo) {
                // Transformar booleanos a texto
                $item->type             = $tipo[$item->type];
                $item->fecha_asistencia = \Carbon\Carbon::parse($item->check_in)->toDateString();
                return $item;
            });

        return view('clientes.historicoasistencias', ['type' => $type, 'clients' => $clients, 'tipo' => $tipo]);
    }

    public function asistenciagimnasio()
    {
        $type    = $this->gettype();
        $clients = clients::all();

        $tipo = intval(Auth::user()->role);

        $attendances = attendance::select([
            'attendance.check_in',
            'attendance.check_out',
            'attendance.package_type',
            'attendance.classes_remaining',
            'clients.nombre',
            'clients.id',
        ])
            ->leftJoin('clients', 'attendance.client_id', '=', 'clients.id')
            ->whereDate('attendance.check_in', today())
            ->where('attendance.type', 2)
            ->get();

        return view('clientes.asistenciagimnasio', ['type' => $type, 'clients' => $clients, 'attendances' => $attendances, 'tipo' => $tipo]);
    }

    public function seguro()
    {
        $type    = $this->gettype();
        $clients = clients::select(
            'clients.id',
            'clients.nombre',
            'clients.status',
            'clients.idseguro',
        )
            ->orderBy('clients.id', 'desc')
            ->get()
            ->map(function ($item) {
                // Transformar booleanos a texto
                $item->status = $item->status ? 'Activo' : 'Inactivo';
                return $item;
            });

        return view('clientes.seguro', ['type' => $type, 'clients' => $clients]);
    }
    public function actualizarSeguro(Request $request)
    {

        try {
            // Buscar el cliente
            $cliente = clients::findOrFail($request->cliente_id);

            // Actualizar el seguro
            $cliente->idseguro = $request->idseguro;
            $cliente->save();

            // Responder con éxito
            return response()->json([
                'success' => true,
                'message' => 'Seguro actualizado correctamente',
            ]);
        } catch (\Exception $e) {
            // Responder con error
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el seguro: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function clientes()
    {
        $type    = $this->gettype();
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
            DB::raw('COALESCE(h.descripcion, "Sin horario") as horario_alberca'),
        )
            ->leftjoin('horarios as h', 'h.id', '=', 'clients.horario_alberca')
            ->orderBy('clients.id', 'desc')
            ->get()
            ->map(function ($item) {
                // Transformar booleanos a texto
                $item->gimnasio = $item->gimnasio ? 'Sí' : 'No';
                $item->alberca  = $item->alberca ? 'Sí' : 'No';
                $item->status   = $item->status ? 'Activo' : 'Inactivo';
                return $item;
            });

        return view('clientes.clientes', ['type' => $type, 'clients' => $clients]);
    }
    public function edicioncliente()
    {
        $type    = $this->gettype();
        $clients = clients::all();

        $sucursales = warehouse::all();
        return view('clientes.edicion', ['type' => $type, 'clients' => $clients, 'sucursales' => $sucursales]);
    }

    public function reportehistoricoasistencias(Request $request)
    {
        try {
            $tipo = [
                1 => 'ALBERCA',
                2 => 'GIMNASIO',
            ];

            $fecha_inicio = $request->input('dateStart');
            $fecha_fin    = $request->input('dateEnd');

            $type = $this->gettype();

            $attendances = attendance::select([
                'attendance.check_in',
                'attendance.check_out',
                'attendance.package_type',
                'attendance.classes_remaining',
                'attendance.type',
                'clients.nombre',
                'clients.id',
            ])
                ->leftJoin('clients', 'attendance.client_id', '=', 'clients.id')
                ->whereDate('attendance.check_in', '>=', $fecha_inicio)
                ->whereDate('attendance.check_in', '<=', $fecha_fin)
                ->get()
                ->map(function ($item) use ($tipo) {
                    // Transformar booleanos a texto
                    $item->type             = $tipo[$item->type];
                    $item->fecha_asistencia = \Carbon\Carbon::parse($item->check_in)->toDateString();
                    return $item;
                });

            return response()->json(['message' => 'Reporte Generado Correctamente', 'asistencias' => $attendances], 200);
        } catch (\Throwable $th) {

            return response()->json(['message' => 'Error al generar el reporte' . $th->getMessage()], 500);
        }
    }

    public function accionreagendar(Request $request)
    {
        try {
            $id_agenda     = $request->input('id_agenda');
            $nueva_fecha   = $request->input('fecha_sesion');
            $nuevo_horario = $request->input('horario_alberca');

            // Buscar el registro
            $agenda = DB::table('agenda_clientes')->where('id_agenda', $id_agenda)->first();

            if (! $agenda) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el registro en la agenda',
                ], 404);
            }

            // Actualizar los datos
            DB::table('agenda_clientes')
                ->where('id_agenda', $id_agenda)
                ->update([
                    'fecha_sesion' => $nueva_fecha,
                    'horario'      => $nuevo_horario,
                    'reagendada'   => 1,
                ]);

            return response()->json([
                'success' => true,
                'message' => 'La sesión fue reagendada correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al reagendar: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function consultarpagos(Request $request)
    {
        $id = $request->input('id');

        // Obtener los pagos del cliente con el ID proporcionado
        $pagos = payments::where('idcliente', $id)
            ->select(['fecha_pago', 'monto', 'concepto', 'metodo_pago', 'id', 'observaciones', 'estatus', 'mes_correspondiente'])
            ->orderBy('fecha_pago', 'desc')
            ->get();

        // Preparar la respuesta en formato JSON
        return response()->json([
            'productos' => $pagos,
        ]);
    }

    public function registrarasistencia(Request $request)
    {
        try {

            // 1 es para alberca 2 es para gimnasio
            $type = $request->input('type');

            date_default_timezone_set('America/Mexico_City');

            $client = clients::findOrFail($request->client_id);

            // Obtener fecha y hora actual en México
            $nowMexico   = now('America/Mexico_City');
            $todayMexico = $nowMexico->toDateString();

            if ($type == 1) {

                // ALBERCA
                if ($client->alberca == 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'EL CLIENTE NO TIENE PAQUETE DE ALBERCA',
                    ]);
                }

                $asistencia = attendance::where('client_id', $client->id)
                    ->whereDate('check_in', $todayMexico)
                    ->whereNull('check_out')
                    ->where('type', 1)
                    ->first();

                $agenda = agenda::where('id_cliente', $client->id)
                    ->whereDate('fecha_sesion', $todayMexico)
                    ->first();
                if ($agenda == null) {
                    return response()->json([
                        'success' => false,
                        'message' => 'NO HAY SESIÓN REGISTRADA PARA HOY',
                    ]);
                }

                if ($agenda->estatus == "REGISTRADA" || $asistencia) {
                    return response()->json([
                        'success' => false,
                        'message' => 'YA CUENTA CON ASISTENCIA',

                    ]);

                } else {
                    // Registrar nueva asistencia
                    $attendance               = new Attendance();
                    $attendance->client_id    = $client->id;
                    $attendance->check_in     = $nowMexico;
                    $attendance->package_type = $client->paquete_alberca;
                    $attendance->type         = $type;

                    $agenda = agenda::where('id_cliente', $client->id)
                        ->whereDate('fecha_sesion', '<=', $todayMexico)
                        ->orderBy('fecha_sesion', 'desc')
                        ->first();
                    $sesiones_usadas = $agenda->sesiones_usadas + 1;

                    $agenda->sesiones_usadas = $sesiones_usadas;
                    $agenda->estatus         = "REGISTRADA";

                    $attendance->classes_remaining = $agenda->sesiones_usadas . "/" . $agenda->sesiones_totales;

                    $agenda->save();
                    $attendance->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'Asistencia registrada exitosamente',

                    ]);

                }
            } else {
                // GIMNASIO
                $asistencia = attendance::where('client_id', $client->id)
                    ->whereDate('check_in', $todayMexico)
                    ->whereNull('check_out')
                    ->where('type', 2)
                    ->first();
                if ($client->gimnasio == 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'EL CLIENTE NO TIENE PAQUETE DE GIMNASIO',
                    ]);
                }
                if ($asistencia) {
                    return response()->json([
                        'success' => false,
                        'message' => 'YA CUENTA CON ASISTENCIA',

                    ]);
                } else {
                    // Registrar nueva asistencia con hora de México
                    $attendance               = new Attendance();
                    $attendance->client_id    = $client->id;
                    $attendance->check_in     = $nowMexico;
                    $attendance->package_type = $client->paquete_alberca;
                    // $attendance->classes_remaining = $message_monthly;
                    $attendance->type = $type;
                    $attendance->save();

                    // Devolver respuesta con contadores actualizados
                    return response()->json([
                        'success' => true,
                        'message' => 'Asistencia registrada exitosamente',

                    ]);
                }
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar asistencia: ' . $e->getMessage(),
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

            if (! $attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes un registro de asistencia activo hoy',
                ]);
            }

            // 2. Actualizar el campo check_out con la hora actual
            $attendance->check_out = $nowMexico;
            $attendance->save();

            return response()->json([
                'success'     => true,
                'message'     => 'Salida registrada exitosamente',
                'hora_salida' => $nowMexico->format('Y-m-d H:i:s'), // Opcional: devolver hora de salida
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar salida: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function actualizarasistencias(Request $request)
    {

        try {

            $type = $request->input('type');

            $attendances = attendance::select([
                'attendance.check_in',
                'attendance.check_out',
                'attendance.package_type',
                'attendance.classes_remaining',
                'clients.nombre',
                'clients.id',
            ])
                ->leftJoin('clients', 'attendance.client_id', '=', 'clients.id')
                ->whereDate('attendance.check_in', today())
                ->where('attendance.type', $type)
                ->get();

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
                'idusuario',
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => $preregistration,
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function precrearcliente(Request $request)
    {

        try {

            // Crear una nueva instancia del modelo Usuario
            $preregistration           = new preregistration();
            $preregistration->nombre   = $request->nombre;
            $preregistration->telefono = $request->telefono;
            $servicios                 = $request->servicios;
            $tieneGimnasio             = in_array("gimnasio", $servicios);
            $tieneAlberca              = in_array("alberca", $servicios);

            if ($tieneGimnasio) {
                $preregistration->gimnasio = 1;
            }

            if ($tieneAlberca) {
                $preregistration->alberca         = 1;
                $preregistration->paquete_alberca = $request->paquete_alberca;
                $preregistration->horario_alberca = $request->horario_alberca;
            }
            $preregistration->observaciones = $request->observaciones;
            $iduser                         = Auth::user()->id;
            $preregistration->idusuario     = intval($iduser);

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
            $client           = new clients();
            $client->nombre   = $request->nombre;
            $client->telefono = $request->telefono;
            $servicios        = $request->servicios;
            $tieneGimnasio    = in_array("gimnasio", $servicios);
            $tieneAlberca     = in_array("alberca", $servicios);

            if ($tieneGimnasio) {
                $client->gimnasio = 1;
            }

            if ($tieneAlberca) {
                $client->alberca         = 1;
                $client->paquete_alberca = $request->paquete_alberca;
                $client->horario_alberca = $request->horario_alberca;
            }

            $client->observaciones  = $request->observaciones;
            $iduser                 = Auth::user()->id;
            $client->idusuario      = intval($iduser);
            $client->tipo           = $request->tipo_acceso;
            $client->status         = 1;
            $client->fecha_creacion = date('Y-m-d');
            $client->save();

            // Obtener el ID del cliente recién creado
            $id_cliente = $client->id;

            // Si tiene alberca, crear las agendas
            if ($tieneAlberca && ! empty($request->dias)) {
                $this->crearAgendasCliente($id_cliente, $request);
            }

            $idpreregistro = $request->preregistro_id;
            $preregistro   = preregistration::findOrFail($idpreregistro);
            $preregistro->delete();

            return response()->json(['message' => 'Cliente creado correctamente'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Error al crear el cliente: ' . $e->getMessage()], 500);
        }
    }

    private function crearAgendasCliente($id_cliente, $request)
    {

        // Configurar zona horaria
        date_default_timezone_set('America/Mexico_City');

        $paquete              = $request->paquete_alberca;
        $numero_clases_semana = (int) explode('_', $paquete)[0];
        $sesiones_totales     = $numero_clases_semana * 4;
        $sesiones_usadas      = 0;
        $reagendada           = 0;
        // Convertir fecha de inicio
        $fecha_inicio = DateTime::createFromFormat('d/m/Y', $request->fecha);
        if (! $fecha_inicio) {
            throw new \Exception("Formato de fecha inválido. Se requiere d/m/Y");
        }
        $fecha_inicio->setTime(0, 0, 0);

        $fecha_fin = clone $fecha_inicio;
        $fecha_fin->modify('+4 weeks')->setTime(23, 59, 59);

        $dias_seleccionados = $request->dias; // array de strings '1','3','5'
        $horario            = $request->horario_alberca;

        // Mapeo de días a números (1 = lunes, 7 = domingo)
        $dias_numeros = [
            '1' => 1, // Lunes
            '2' => 2, // Martes
            '3' => 3, // Miércoles
            '4' => 4, // Jueves
            '5' => 5, // Viernes
            '6' => 6, // Sábado
            '7' => 7, // Domingo
        ];

        $fechas_sesiones = [];

        // Generar sesiones para cada día seleccionado
        foreach ($dias_seleccionados as $dia) {
            $dia_deseado = $dias_numeros[$dia];
            $dow_inicio  = (int) $fecha_inicio->format('N'); // día de inicio (1..7)

            // Diferencia para alcanzar el primer día válido
            $delta   = ($dia_deseado - $dow_inicio + 7) % 7;
            $primera = clone $fecha_inicio;
            if ($delta > 0) {
                $primera->modify("+$delta days");
            }

            // Generar las 4 semanas
            for ($semana = 0; $semana < 4; $semana++) {
                $fecha_sesion = clone $primera;
                if ($semana > 0) {
                    $fecha_sesion->modify("+$semana weeks");
                }

                if ($fecha_sesion >= $fecha_inicio && $fecha_sesion <= $fecha_fin) {
                    $fechas_sesiones[] = clone $fecha_sesion;
                }
            }
        }

        // Ordenar cronológicamente
        usort($fechas_sesiones, fn($a, $b) => $a <=> $b);

        // Cortar al número exacto de sesiones
        if (count($fechas_sesiones) > $sesiones_totales) {
            $fechas_sesiones = array_slice($fechas_sesiones, 0, $sesiones_totales);
        }

        // Armar registros de inserción
        $registros = [];
        foreach ($fechas_sesiones as $fecha_sesion) {

            agenda::create([
                'id_cliente'       => $id_cliente,
                'horario'          => $horario,
                'paquete'          => $paquete,
                'sesiones_totales' => $sesiones_totales,
                'sesiones_usadas'  => $sesiones_usadas,
                'fecha_inicio'     => $fecha_inicio->format('Y-m-d'),
                'fecha_fin'        => $fecha_fin->format('Y-m-d'),
                'fecha_sesion'     => $fecha_sesion->format('Y-m-d'),
                'estatus'          => 'PENDIENTE',
                'reagendada'       => $reagendada,
            ]);
        }

    }

    public function eliminarcliente(Request $request)
    {
        try {
            // Encuentra el cliente por su ID
            $clientid       = $request->id;
            $client         = clients::findOrFail($clientid);
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
            $idcliente    = intval(Crypt::decrypt($request->id));
            $nuevo_nombre = $request->nombre;
            $telefono     = $request->telefono;

            $cliente = clients::findOrFail($idcliente);

            // Actualizar campos básicos
            if ($nuevo_nombre) {
                $cliente->nombre = $nuevo_nombre;
            }

            if ($telefono) {
                $cliente->telefono = $telefono;
            }

            // Actualizar servicios
            $servicios     = $request->servicios ?? [];
            $tieneGimnasio = in_array("gimnasio", $servicios);
            $tieneAlberca  = in_array("alberca", $servicios);

            $cliente->gimnasio = $tieneGimnasio ? 1 : 0;
            $cliente->alberca  = $tieneAlberca ? 1 : 0;

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
                'errors'  => $th->getMessage(),
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
