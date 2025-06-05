<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
class pagosController extends Controller
{
    public function registrodepagos()
    {

        $type = $this->gettype();
        return view('pagos.registrodepagos', ['type' => $type]);
    }
        public function gettype()
    {
        if (Auth::check()) {
            $type = Auth::user()->role;
        }
        return $type;
    }
}
