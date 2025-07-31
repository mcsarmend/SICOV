<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\cash_closure;
use App\Models\clients;
use App\Models\prices;
use App\Models\product;
use App\Models\productprice;
use App\Models\productwarehouse;
use App\Models\referrals;
use App\Models\stockMovements;
use App\Models\user;
use App\Models\warehouse;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ventasController extends Controller
{
    public function remisionar()
    {
        $idsucursal = 1;
        $vendedor = Auth::user()->name;
        $idvendedor = Auth::user()->id;
        $nombresucursal = warehouse::select('name')
            ->where('id', '=', $idsucursal)
            ->first();
        $idssucursales = warehouse::select('id', 'name')
            ->get();

        $clientes = clients::all();
        $type = $this->gettype();
        $vendedores = DB::table('users')
            ->select('id', 'name')
            ->get();
        $productos = Product::leftJoin('product_warehouse', 'product.id', '=', 'product_warehouse.idproducto')
            ->where('product_warehouse.idwarehouse', $idsucursal)
            ->select('product.*') // Selecciona las columnas de la tabla principal
            ->get();

        return view('ventas.remisionar', ['type' => $type, 'idssucursales' => $idssucursales, 'idsucursal' => $idsucursal, 'nombresucursal' => $nombresucursal, 'idvendedor' => $idvendedor, 'vendedor' => $vendedor, 'clientes' => $clientes, 'productos' => $productos, 'vendedores' => $vendedores]);
    }
    public function remisionarlista()
    {
        $idsucursal = Auth::user()->warehouse;
        $vendedor = Auth::user()->name;
        $idvendedor = Auth::user()->id;
        $nombresucursal = warehouse::select('nombre')
            ->where('id', '=', $idsucursal)
            ->first();
        $idssucursales = warehouse::select('id', 'nombre')
            ->get();
        $vendedores = user::all();

        $clientes = clients::all();
        $type = $this->gettype();
        $productos = Product::leftJoin('product_warehouse', 'product.id', '=', 'product_warehouse.idproducto')
            ->leftJoin('product_price', 'product.id', '=', 'product_price.idproducto') // Relación correcta
            ->where('product_warehouse.idwarehouse', $idsucursal)
            ->where('product_price.idprice', 6) // Filtro adicional (si es necesario)
            ->select('product.*', 'product_price.price as precio')
            ->get();

        return view('ventas.remisionarlista', [
            'type' => $type,
            'idssucursales' => $idssucursales,
            'idsucursal' => $idsucursal,
            'nombresucursal' => $nombresucursal,
            'idvendedor' => $idvendedor,
            'vendedor' => $vendedor,
            'clientes' => $clientes,
            'productos' => $productos,
            'vendedores' => $vendedores
        ]);
    }
    public function remisiones()
    {

        $timezone = 'America/Mexico_City';
        $hoy_inicio = Carbon::today($timezone)->startOfDay()->toDateTimeString(); // '2024-12-10 00:00:00'
        $hoy_fin = Carbon::today($timezone)->endOfDay()->toDateTimeString();   // '2024-12-10 23:59:59'
        $id = Auth::user()->id;
        $query = 'CALL obtenerremisiones("' . $hoy_inicio . '","' . $hoy_fin . '",' . $id . ')';

        $remisiones = DB::select($query);

        $type = $this->gettype();

        return view('ventas.remisiones', ['type' => $type, 'remisiones' => $remisiones]);
    }
    public function ventasreportes()
    {
        $type = $this->gettype();
        return view('ventas.reportes', ['type' => $type]);
    }

    public function buscarexistencias(Request $request)
    {

        $idwarehouse = 1;
        $idproducto = $request->id_producto;
        $existencias = productwarehouse::where('idproducto', '=', $idproducto)
            ->where('idwarehouse', '=', $idwarehouse)
            ->value('existencias');
        $precio = product::where('id', '=', $idproducto)
            ->value('precio');
        return response()->json([
            'existencias' => $existencias,
            'precio' => $precio
        ]);
    }


    public function validarremision(Request $request)
    {
        try {
            // Crear una nueva instancia del modelo referrals
            $remision = new referrals();
            $date = DateTime::createFromFormat('j/n/Y, H:i:s', $request->fecha);
            $fechaMysql = $date->format('Y-m-d H:i:s');
            $remision->fecha = $fechaMysql;
            $remision->nota = $request->nota;
            $remision->forma_pago = $request->forma_pago;
            $remision->vendedor = $request->vendedor;

            $remision->cliente = $request->cliente;
            $id_sucursal = 1; // Asignar el ID de la sucursal, si es necesario

            $remision->almacen = $id_sucursal;
            $remision->total = $request->total;
            $remision->estatus = "emitida";


            $productos = json_decode($request->productos);
            $remision->productos = json_encode($productos); // Convertir el array de productos a JSON

            foreach ($productos as $producto) {

                $idproducto = $producto->Codigo;

                $existenciasActual = productwarehouse::select('existencias')
                    ->where('idproducto', intVal($idproducto))
                    ->where('idwarehouse', intVal($id_sucursal))
                    ->first();

                $CantidadDescontar = $producto->Cantidad;
                $nuevaexistencia = $existenciasActual->existencias - intVal($CantidadDescontar);

                productwarehouse::where('idproducto', intVal($idproducto))
                    ->where('idwarehouse', intVal($id_sucursal))
                    ->update([
                        'existencias' => $nuevaexistencia,
                    ]);
            }

            // Guardar la remisión en la base de datos
            $remision->save();

            // Obtener el ID recién creado
            $idCreado = $remision->id;



            // Devolver una respuesta de éxito con el ID
            return response()->json(['message' => 'Remisión creada correctamente', 'id' => $idCreado], 200);
        } catch (\Throwable $th) {

            return response()->json(['message' => 'Error al realizar remisión' . $th->getMessage()], 500);
        }
    }

    public function verproductosremision(Request $request)
    {
        $idremision = $request->id;
        $remision = referrals::find($idremision);
        $productos = json_decode($remision->productos);

        return response()->json(['productos' => $productos], 200);
    }

    public function buscarremision(Request $request)
    {

        $remision = $request->numero_remision;

        try {
            $data = [];
            $referral = referrals::select([
                'r.id',
                'r.fecha',
                'r.nota',
                'r.forma_pago',
                'w.nombre as almacen',
                'u.name as vendedor',
                'c.nombre as cliente',
                'c.id as idcliente',
                'r.productos',
                'r.total',
                'r.estatus',
                'r.total',
                'ar.saldo_restante as saldo_restante',
                'ar.id as id_cxc',
            ])
                ->from('referrals as r')
                ->leftJoin('users as u', 'r.vendedor', '=', 'u.id')
                ->leftJoin('clients as c', 'r.cliente', '=', 'c.id')
                ->leftJoin('warehouse as w', 'r.almacen', '=', 'w.id')
                ->leftJoin('accounts_receivable as ar', 'ar.remision_id', '=', 'r.id')
                ->where('r.id', $remision)
                ->first();
            $datos = json_decode($referral, true);
            $datos['productos'] = json_decode($datos['productos'], true);

            $respuesta = ['data' => $datos];

            return response()->json([
                'success' => true,
                'message' => 'Remisión encontrada',
                'data' => $respuesta,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar remisión: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }

    }

    public function cortedecaja()
    {
        $type = $this->gettype();
        $timezone = 'America/Mexico_City';
        $hoy_inicio = Carbon::today($timezone)->startOfDay()->toDateTimeString();
        $hoy_fin = Carbon::today($timezone)->endOfDay()->toDateTimeString();
        $id = Auth::user()->id;

        $remisiones = collect(DB::select('CALL obtenerremisiones(?, ?, ?)', [$hoy_inicio, $hoy_fin, $id]));

        // Define las formas de pago que siempre quieres mostrar
        $formas_pago_base = ['efectivo', 'transferencia', 'terminal', 'clip', 'mercado_pago', 'vales'];

        // Agrupar remisiones por forma de pago
        $remisiones_por_pago = $remisiones->groupBy('forma_pago');

        // Añadir formas de pago sin datos (si no existen en los resultados)
        foreach ($formas_pago_base as $forma_pago) {
            if (!$remisiones_por_pago->has($forma_pago)) {
                $remisiones_por_pago[$forma_pago] = collect(); // Agregar un grupo vacío
            }
        }

        $datos = json_decode($remisiones_por_pago, true);

        // Filtrar cada método de pago
        $resultado = [];
        foreach ($datos as $metodo => $ventas) {
            // Si no hay ventas, mantener el array vacío
            if (empty($ventas)) {
                $resultado[$metodo] = [];
                continue;
            }

            // Filtrar solo las ventas con estatus "emitida"
            $ventasFiltradas = array_filter($ventas, function ($venta) {
                return $venta['estatus'] === 'emitida';
            });

            // Reindexar el array (opcional, para que no queden huecos en los índices)
            $resultado[$metodo] = array_values($ventasFiltradas);
        }

        //return ['remisiones_por_pago' => $remisiones_por_pago, "*************************************************************", 'resultado' => $resultado];
        $remisiones_por_pago = $resultado;

        $remisiones_por_pago = array_map(function ($metodo) {
            return array_map(function ($remision) {
                return (object) $remision; // Convierte cada array a objeto
            }, $metodo);
        }, $remisiones_por_pago);

        $totales_por_pago = [
            "efectivo" => array_sum(array_column($remisiones_por_pago["efectivo"], "total")),
            "transferencia" => array_sum(array_column($remisiones_por_pago["transferencia"], "total")),
            "clip" => array_sum(array_column($remisiones_por_pago["clip"], "total")),
            "terminal" => array_sum(array_column($remisiones_por_pago["terminal"], "total")),
            "mercado_pago" => array_sum(array_column($remisiones_por_pago["mercado_pago"], "total")),
            "vales" => array_sum(array_column($remisiones_por_pago["vales"], "total")),
        ];

        $total_general = array_sum($totales_por_pago);

        return view('ventas.cortedecaja', [
            'type' => $type,
            'remisiones_por_pago' => $remisiones_por_pago,
            'totales_por_pago' => $totales_por_pago,
            'total_general' => $total_general,
        ]);
    }

    public function cancelarremision(Request $request)
    {
        try {
            $idremision = $request->id;
            $remision = referrals::find($idremision);
            $remision->estatus = "cancelada";
            $almacen = $remision->almacen;
            $productos = $remision->productos;

            $productos = json_decode($productos);
            foreach ($productos as $producto) {

                $idproducto = $producto->Codigo;

                $existenciasActual = productwarehouse::select('existencias')
                    ->where('idproducto', intVal($idproducto))
                    ->where('idwarehouse', intVal($almacen))
                    ->first();

                $CantidadSumar = $producto->Cantidad;
                $nuevaexistencia = $existenciasActual->existencias + intVal($CantidadSumar);

                productwarehouse::where('idproducto', intVal($idproducto))
                    ->where('idwarehouse', intVal($almacen))
                    ->update([
                        'existencias' => $nuevaexistencia,
                    ]);
            }

            $idremision = $request->id;
            $remision = referrals::find($idremision);
            $importe = $remision->total;
            $productos = $remision->productos;
            $remision->estatus = "cancelada";
            $remision->save();

            // REGISTRAR EL MOVIMIENTO



            return response()->json(['message' => 'Remisión cancelada correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al cenlar la remision' . $th->getMessage()], 200);
        }

    }

    public function enviarinfocortecaja(Request $request)
    {
        DB::beginTransaction();

        try {

            $corteCaja = new cash_closure();
            $corteCaja->total_general = (float) $request->total_general;
            $corteCaja->total_efectivo_entregar = (float) $request->total_efectivo_entregar;
            $corteCaja->formas_pago = json_encode($request->formas_pago);              // Convertir a JSON
            $corteCaja->inputs_adicionales = json_encode($request->inputs_adicionales ?? []); // Convertir a JSON
            $corteCaja->vendedor = auth()->id() ?? 1;
            $corteCaja->estado = 'pendiente';
            $corteCaja->observaciones = $request->observaciones ?? null;

            // Guardar el usuario en la base de datos
            $corteCaja->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Corte de caja registrado correctamente',
                'data' => $corteCaja,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el corte de caja',
                'error' => $e->getMessage(),
                'trace' => env('APP_DEBUG') ? $e->getTrace() : null,
            ], 500);
        }
    }

    public function reporteremisiones(Request $request)
    {
        try {
            $dateStart = Carbon::parse($request->dateStart)->startOfDay();
            $dateEnd = Carbon::parse($request->dateEnd)->endOfDay();

            // Obtener remisiones en el rango de fechas

            $remisiones = referrals::whereBetween('fecha', [$dateStart, $dateEnd])
                ->leftJoin('warehouse as w', 'referrals.almacen', '=', 'w.id')
                ->leftJoin('users as u', 'referrals.vendedor', '=', 'u.id')
                ->select(
                    'referrals.id',
                    'referrals.fecha',
                    DB::raw('IFNULL(referrals.nota, "SIN NOTA") as nota'),
                    'referrals.forma_pago',
                    'referrals.cliente',
                    'referrals.productos',
                    'referrals.total',
                    'w.nombre as almacen',
                    'u.name as vendedor',
                    'referrals.estatus'
                )
                ->get();
            return response()->json(['message' => 'Reporte Generado Correctamente', 'remisiones' => $remisiones], 200);
        } catch (\Throwable $th) {

            return response()->json(['message' => 'Error al generar el reporte' . $th->getMessage()], 500);
        }

    }
    public function gettype()
    {
        if (Auth::check()) {
            $type = Auth::user()->role;
        }
        return $type;
    }

    public function extraerNumeroInicial($cadena)
    {
        if (preg_match('/^(\d+)-/', $cadena, $matches)) {
            return (int) $matches[1]; // Convertimos a entero
        }
        return null; // Si no encuentra el patrón
    }

}
