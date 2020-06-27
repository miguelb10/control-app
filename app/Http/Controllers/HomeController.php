<?php

namespace App\Http\Controllers;

use App\Log;
use App\NmLndocumento;
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
        
        //return Log::all();

        $cantLogin = Log::where('description', 'Inicio sesión')->get();
        $cantHome = Log::where('description', 'Inicio')->get();
        $cantBoletas = Log::where('description', 'Vista Facturas')->get();
        $cantDescargas = NmLndocumento::all();

        return view('home', compact('validateFirstLogin', 'cantLogin', 'cantHome', 'cantBoletas', 'cantDescargas'));
    }
}
