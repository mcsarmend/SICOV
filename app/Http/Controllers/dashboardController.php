<?php
namespace App\Http\Controllers;

use App\Models\category;
use App\Models\task;
use App\Models\User;
use Carbon\Carbon; // Add this line
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

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

            $type   = Auth::user()->role;
            $iduser = Auth::user()->id;


            return view('home', ['type' => $type,]);
        } else {

            return view('welcome', []);

        }
    }
    public function checkDashboard()
    {

        $type   = Auth::user()->role;
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
