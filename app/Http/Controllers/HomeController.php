<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $type = Auth::user()->role;
        $totalClientes = clients::count();
        $asistenciasHoy = attendance::whereDate('check_in', today())->count();
        $asistenciasManana = attendance::whereBetween('check_in', [today()->startOfDay(), today()->setTime(12, 0, 0)])->count();
        $asistenciasTarde = attendance::whereBetween('check_in', [today()->setTime(12, 0, 1), today()->endOfDay()])->count();
        $asistenciasSemana = attendance::whereBetween('check_in', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $clientesActivos = clients::where('status', 1)->count();
        $metaClientes = 350;

        return view('home', [
            'type' => $type,
            'totalClientes' => $totalClientes,
            'metaClientes' => $metaClientes,
            'asistenciasHoy' => $asistenciasHoy,
            'asistenciasManana' => $asistenciasManana,
            'asistenciasTarde' => $asistenciasTarde,
            'asistenciasSemana' => $asistenciasSemana,
            'clientesActivos' => $clientesActivos
        ]);
    }


}
