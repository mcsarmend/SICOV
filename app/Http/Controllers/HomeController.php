<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\clients;
use App\Models\task;
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
        $attendances = Attendance::with('client')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', ['type' => $type, 'clients' => $clients, 'attendances' => $attendances]);
    }


    public function attendancesThisMonth()
    {
        return $this->hasMany(attendance::class)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }
}
