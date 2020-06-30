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
                'user_id' => Auth::user()->id_cttraba,
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
            //if ($request->input('tema') == 'verde') {
            WebConfig::where('ccod_regtri', session('rucSession'))->update(
                array(
                    'tema_color' => 'css/dashboard/' . $newColor . '.css'
                )
            );
            session(['tema' => 'css/dashboard/'.$newColor.'.css']);

            return redirect()->route('home')->with('status', 'Se aplico el nuevo tema');
            /*} else if ($request->input('tema') == 'rojo') {
                WebConfig::where('ccod_regtri', session('rucSession'))->update(
                    array(
                        'tema_color' => 'css/dashboard/rojo.css'
                    )
                );
                session(['tema' => 'css/dashboard/rojo.css']);

                return redirect()->route('home')->with('status', 'Se aplico el nuevo tema');
            } else if ($request->input('tema') == 'azul') {
                WebConfig::where('ccod_regtri', session('rucSession'))->update(
                    array(
                        'tema_color' => 'css/dashboard/azul.css'
                    )
                );
                session(['tema' => 'css/dashboard/azul.css']);

                return redirect()->route('home')->with('status', 'Se aplico el nuevo tema');
            } else {
                return redirect()->route('home')->with('statusFail', 'No se encontro el tema seleccionado');
            }*/
        } catch (Exception $e) {
            return redirect()->route('home')->with('statusFail', 'Error al aplicar tema');;
        }
    }
}
