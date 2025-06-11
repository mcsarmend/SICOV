<?php
namespace App\Http\Controllers;

use App\Models\category;
use App\Models\task;
use App\Models\User;
use Carbon\Carbon; // Add this line
use DateTime;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\attendance;
use App\Models\clients;


class dashboardController extends Controller
{
    public function recuperarcontrasena()
    {
        $usuarios = User::select('id', 'name')->get();
        return view('recuperarcontrasena', ['usuarios' => $usuarios]);
    }


    public function showDashboard()
    {


        if (Auth::check()) {

            $type = Auth::user()->role;
            $totalClientes = clients::count();
            $asistenciasHoy = attendance::whereDate('check_in', today())->count();
            $asistenciasManana = attendance::whereBetween('check_in', [today()->startOfDay(), today()->setTime(12, 0, 0)])->count();
            $asistenciasTarde = attendance::whereBetween('check_in', [today()->setTime(12, 0, 1), today()->endOfDay()])->count();
            $asistenciasSemana = attendance::whereBetween('check_in', [now()->startOfWeek(), now()->endOfWeek()])->count();
            $clientesActivos = clients::where('status', 1)->count();
            $metaClientes=350;

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
        } else {

            return view('welcome', []);

        }
    }
    public function checkDashboard()
    {

        $type = Auth::user()->role;
        $iduser = Auth::user()->id;



        return view('dashboard', ['type' => $type]);
    }


    public function gettype()
    {
        if (Auth::check()) {
            $type = Auth::user()->role;
        }
        return $type;
    }
}
