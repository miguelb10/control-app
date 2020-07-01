<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\NmLndocumento;
use App\Models\WebConfig;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $validateFirstLogin = Auth::user()->first_login;
            Log::create([
                'ccod_traba' => Auth::user()->ccod_traba,
                'page' => '/home',
                'description' => 'Inicio',
                'created_at' => ''
            ]);

            $tryCorrect = true;
            $cantLogin = Log::where('description', 'Inicio sesión')->get();
            $cantHome = Log::where('description', 'Inicio')->get();
            $cantBoletas = Log::where('description', 'Vista Facturas')->get();
            $cantDescargas = NmLndocumento::all();

            return view('home', compact('validateFirstLogin', 'cantLogin', 'cantHome', 'cantBoletas', 'cantDescargas', 'tryCorrect'));
        } catch (Exception $e) {
            $tryCorrect = false;
            return view('home', compact('tryCorrect'));
        }
    }

    public function change(Request $request)
    {
        try {
            $newColor = $request->input('tema');
            WebConfig::where('ccod_regtri', session('rucSession'))->update(
                array(
                    'tema_color' => $newColor . '.css'
                )
            );
            session(['tema' => $newColor.'.css']);

            return redirect()->route('home')->with('status', 'Se aplico el nuevo tema');
        } catch (Exception $e) {
            return redirect()->route('home')->with('statusFail', 'Error al aplicar tema');;
        }
    }
}
