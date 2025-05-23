<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class statusController extends Controller
{
    public function avisos()
    {
        return view('estatus.avisos');
    }
    public function importantes()
    {
        return view('estatus.importantes');
    }
    public function informacion()
    {
        return view('estatus.informacion');
    }
}
