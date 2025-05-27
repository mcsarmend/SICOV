<?php

namespace App\Http\Controllers;
use App\Models\warehouse;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class inventarioController extends Controller
{
    public function altainventario()
    {
        $type = $this->gettype();
        $almacenes = warehouse::select('id', 'nombre')
            ->orderBy('nombre', 'asc')
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
            ->get();

        return view('inventario.baja', ['type' => $type, 'productos' => $products]);
    }
    public function ingresoinventario()
    {
        $type = $this->gettype();
        $almacenes = warehouse::all();
        $productos = product::all();
        return view('inventario.entrada', ['type' => $type, 'sucursales' => $almacenes, 'productos' => $productos]);
    }
    public function salidainventario()
    {
        $type = $this->gettype();

        $almacenes = warehouse::all();
        $productos = product::all();
        return view('inventario.salida', ['type' => $type, 'sucursales' => $almacenes, 'productos' => $productos]);
    }





    public function gettype()
    {
        if (Auth::check()) {
            $type = Auth::user()->role;
        }
        return $type;
    }
}
