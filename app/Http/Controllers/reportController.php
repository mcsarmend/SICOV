<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class reportController extends Controller
{
    public function existencias()
    {
        $type = $this->gettype();

        $products = DB::select('CALL lista_existencias_activas()');
        return view('inventario.existencias', ['type' => $type,]);
    }
    public function reporteremisiones()
    {
        $type = $this->gettype();
        return view('reportes.remisiones', ['type' => $type]);
    }
    public function reportecortecaja()
    {
        $type = $this->gettype();
        return view('reportes.cortedecaja', ['type' => $type]);
    }
    public function gettype()
    {
        if (Auth::check()) {
            $type = Auth::user()->role;
        }
        return $type;
    }
}
