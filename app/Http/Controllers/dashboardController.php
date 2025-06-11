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
            $clients = clients::all();
            $attendances = Attendance::select([
                'attendance.check_in',
                'attendance.check_out',
                'attendance.package_type',
                'attendance.classes_remaining',
                'clients.nombre'
            ])
                ->leftJoin('clients', 'attendance.client_id', '=', 'clients.id')
                ->get();

            return view('home', ['type' => $type, 'clients' => $clients, 'attendances' => $attendances]);
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
