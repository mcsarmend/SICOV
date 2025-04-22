<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        $type = Auth::user()->type;
        return view('home', compact('type'));
    }
}
