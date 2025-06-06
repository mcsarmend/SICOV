<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\clients;

class pagosController extends Controller
{
    public function registropagos()
    {

        $type = $this->gettype();
        $clients = clients::where('status', 1)->get();
        return view('pagos.registrodepagos', ['type' => $type, 'clients' => $clients]);
    }




        public function gettype()
    {
        if (Auth::check()) {
            $type = Auth::user()->role;
        }
        return $type;
    }
}
