<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\NmCttraba;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            Log::create([
                'user_id' => Auth::user()->ccod_traba,
                'page' => '/profile',
                'description' => 'Ver Perfil',
                'created_at' => ''
            ]);
            $profile = NmCttraba::where('ccod_traba', Auth::user()->ccod_traba)->first();
            return view('profile', compact('profile'));
        } catch (Exception $e) {
            $profile = null;
            return view('profile', compact('profile'));
        }
    }

    public function update(Request $request)
    {
        $rules = [
            'password' =>  'required|min:5|confirmed',
            /*'cndni_traba' => 'required|min:8|max:8',
            'cnomb_traba' => 'required',
            'capat_traba' => 'required',
            'camat_traba' => 'required',
            'cemail_traba' => 'required|email',
            'cnruc_traba' => 'numeric|nullable'*/
        ];

        $messages = [
            'password.required' => 'El campo no puede ser vacío',
            'password.confirmed' => 'Las contraseña no coinciden',
            'password.min' => 'La contraseña debe ser de mínimo 5 dígitos',
            /*'cndni_traba.min' => 'El DNI debe tener 8 dígitos',
            'cndni_traba.max' => 'El DNI debe tener 8 dígitos',
            'cnomb_traba.required' => 'El campo no puede ser vacío',
            'capat_traba.required' => 'El campo no puede ser vacío',
            'camat_traba.required' => 'El campo no puede ser vacío',
            'cemail_traba.required' => 'El campo no puede ser vacío',
            'cemail_traba.email' => 'Formato email incorrecto',
            'cnruc_traba.numeric' => 'Formato numérico incorrecto'*/
        ];

        $this->validate($request, $rules, $messages);
        try {
            NmCttraba::where('ccod_traba', $request->input('ccod_traba'))->update(
                array(
                    /*'cnomb_traba' => $request->input('cnomb_traba'),
                    'capat_traba' => $request->input('capat_traba'),
                    'camat_traba' => $request->input('camat_traba'),
                    'cndni_traba' => $request->input('cndni_traba'),
                    'cnruc_traba' => $request->input('cnruc_traba'),
                    'cdire_traba' => $request->input('cdire_traba'),
                    'cemail_traba' => $request->input('cemail_traba'),*/
                    'password' => Hash::make($request->input('password')),
                    'first_login' => false,
                )
            );

            return redirect()->route('profile')->with('status', 'Datos actualizados correctamente');
        } catch (Exception $e) {
            return redirect()->route('profile')->with('statusFail', 'Ocurrió un error, por favor vuelva a intentarlo');
        }
    }
}
