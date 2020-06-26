<?php

namespace App\Http\Controllers;

use App\Log;
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
        $validateFirstLogin = Auth::user()->first_login;
        Log::create([
            'user_id' => Auth::user()->id,
            'page' => '/home',
            'description' => 'Inicio',
            'created_at' => ''
        ]);
        //return session('rucSession');
        return view('home', compact('validateFirstLogin'));
    }
}
