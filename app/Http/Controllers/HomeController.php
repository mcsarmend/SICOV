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
    }


}
