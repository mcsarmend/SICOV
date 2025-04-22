<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ventasController extends Controller
{
    public function gimnasio()
    {
        $type = $this->getusertype();

        return view('ventas.gimnasio', ['type' => $type]);
    }

    public function getusertype()
    {
        if (Auth::check()) {
            $type = Auth::user()->type;
            return $type;
        } else {
            return "Usuario no autenticado.";
        }
    }
}
