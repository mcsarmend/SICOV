<?php

namespace App\Http\Controllers;
use App\Models\warehouse;
use App\Models\product;
use App\Models\productwarehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
class inventarioController extends Controller
{
    public function altainventario()
    {
        $type = $this->gettype();
        $almacenes = warehouse::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return view('inventario.alta', ['type' => $type, 'almacenes' => $almacenes,]);
    }
    public function edicioninventario()
    {
        $type = $this->gettype();
        $products = DB::table('product as p')
            ->select(
                'p.id',
                'p.nombre',
            )
            ->where('p.estatus', '=', 1)
            ->get();
        $almacenes = warehouse::all();
        return view('inventario.edicion', ['type' => $type, 'productos' => $products, 'almacenes' => $almacenes]);
    }
    public function bajainventario()
    {
        $type = $this->gettype();

        $products = DB::table('product as p')
            ->select(
                'p.id',
                'p.nombre',
            )
            ->where('p.estatus', '=', 1)
            ->get();

        return view('inventario.baja', ['type' => $type, 'productos' => $products]);
    }
    public function ingresoinventario()
    {
        $type = $this->gettype();
        $almacenes = warehouse::all();
        $productos = product::where('estatus', 1)
            ->select('id', 'nombre', 'precio')
            ->orderBy('nombre', 'asc')
            ->get();
        return view('inventario.entrada', ['type' => $type, 'sucursales' => $almacenes, 'productos' => $productos]);
    }
    public function salidainventario()
    {
        $type = $this->gettype();

        $almacenes = warehouse::all();
        $productos = product::where('estatus', 1)
            ->select('id', 'nombre', 'precio')
            ->orderBy('nombre', 'asc')
            ->get();
        return view('inventario.salida', ['type' => $type, 'sucursales' => $almacenes, 'productos' => $productos]);
    }
    public function altaproducto(Request $request)
    {
        try {

            $product = new product();
            $product->nombre = $request->name;
            $product->precio = $request->precio;
            $product->id_almacen = 1;
            $product->estatus = 1;
            $product->save();

            $pw = new productwarehouse();
            $pw->idproducto = $product->id;
            $pw->idwarehouse = 1; // Asignar el ID del almacén por defecto
            $pw->existencias = $request->existencia;
            $pw->save();

            return response()->json(['message' => 'Producto creado correctamente'], 200);
        } catch (\Throwable $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al crear el producto: ' . $e->getMessage()], 500);
        }

    }

    public function bajaproducto(Request $request)
    {
        try {

            $idproducto = $request->id;
            $productodesencriptado = Crypt::decrypt($idproducto);
            $producto = product::findOrFail($productodesencriptado);
            $producto->estatus = 0;
            $producto->save();
            // Eliminar producto
            $mess = 'Producto eliminado correctamente';
            return response()->json(['message' => $mess], 200);
        } catch (\Throwable $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al eliminar el producto: ' . $e->getMessage()], 500);
        }

    }
    public function buscarpreciocompras(Request $request)
    {
        $idproducto = $request->id_producto;
        $cantidad = $request->cantidad;
        $nombre = product::where('id', '=', $idproducto)->value('nombre');
        $costo = product::where('id', '=', $idproducto)->value('precio');


        return response()->json([
            'idproducto' => $idproducto,
            'costo' => $costo,
            'nombre' => $nombre,
            'cantidad' => $cantidad,
        ]);

    }
    public function enviarentrada(Request $request)
    {

        try {
            $productos = json_decode($request->productos);
            // ALMACEN 1 es ZARAGOZA
            $ok = [];
            foreach ($productos as $producto) {
                $idproducto = $producto->Codigo;

                $existenciasActual = productwarehouse::select('existencias')
                    ->where('idproducto', intVal($idproducto))
                    ->where('idwarehouse', '1')
                    ->first();

                $CantidadDSumar = $producto->Cantidad;

                if ($existenciasActual == "") {
                    $nuevaexistencia = intVal($CantidadDSumar);
                    productwarehouse::insert([
                        'idproducto' => intval($idproducto),
                        'idwarehouse' => intval(1),
                        'existencias' => $nuevaexistencia,
                    ]);
                } else {

                    $nuevaexistencia = $existenciasActual->existencias + intVal($CantidadDSumar);

                    $ok = productwarehouse::where('idproducto', intVal($idproducto))
                        ->where('idwarehouse', intVal(1))
                        ->update([
                            'existencias' => $nuevaexistencia,
                        ]);
                }

            }

            return response()->json(['message' => "Ingreso realizado correctamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => "Error: " . $th->getMessage()], 500);
        }

    }
    public function detalleamacenes(Request $request)
    {

        $productosAlmacen = DB::table('product_warehouse as pw')
            ->select('pw.idproducto', 'w.name as nombre', 'pw.existencias')
            ->leftJoin('warehouse as w', 'pw.idwarehouse', '=', 'w.id')
            ->where('pw.idproducto', '=', $request["id_producto"])
            ->get();

        return $productosAlmacen;
    }
    public function detalleprecios(Request $request)
    {

        $productosPrecios = DB::table('product as p')
            ->select('p.id as idproducto', 'p.nombre', 'p.precio as price')
            ->where('p.id', '=', $request["id_producto"])
            ->get();

        return $productosPrecios;
    }

    public function enviareditaralmacenes(Request $request)
    {

        try {
            $idproducto = intval($request->id);
            $almacen = $request->almacen;
            $nueva_existencia = floatval($request->nueva_existencia);

            $id_warehouse = warehouse::select('id')
                ->where('name', "=", $almacen)
                ->first();

            $idwarehouse = $id_warehouse->id;
            productwarehouse::where('idproducto', '=', $idproducto)
                ->where('idwarehouse', '=', $idwarehouse)
                ->update(['existencias' => $nueva_existencia]);
            return response()->json(['message' => "Producto actualizado correctamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function enviareditarprecio(Request $request)
    {
        try {
            $idproducto = intval($request->id);
            $nuevo_precio = floatval($request->nuevo_precio);

            product::where('id', '=', $idproducto)
                ->update(['precio' => $nuevo_precio]);
            return response()->json(['message' => "Producto actualizado correctamente"], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
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
