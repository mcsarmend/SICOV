<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class reportController extends Controller
{
       public function existencias()
    {
        $type = $this->gettype();

        // $products = DB::select('CALL lista_existencias_activas()');
        return view('reportes.inventario.existencias', ['type' => $type, ]);
    }
}
