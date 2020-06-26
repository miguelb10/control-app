<?php

namespace App\Http\Controllers;

use App\Log;
use App\NmCttraba;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::create([
            'user_id' => Auth::user()->id,
            'page' => '/profile',
            'description' => 'Ver Perfil',
            'created_at' => ''
        ]);
        $profile = NmCttraba::where('ccod_traba', Auth::user()->ccod_traba)->first();
        return view('profile', [
            'profile' => $profile
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //return $request->input('ccod_traba');
        $rules = [
            'password' =>  'required|min:5|confirmed'
        ];

        $messages = [
            'password.confirmed' => 'Las contraseña no coinciden',
            'password.min' => 'La contraseña debe ser de minimo 7 digitos'
        ];

        $this->validate($request, $rules, $messages);
        NmCttraba::where('ccod_traba', $request->input('ccod_traba'))->update(
            array(
                'cnomb_traba' => $request->input('cnomb_traba'),
                'capat_traba' => $request->input('capat_traba'),
                'camat_traba' => $request->input('camat_traba'),
                'cndni_traba' => $request->input('cndni_traba'),
                'cnruc_traba' => $request->input('cnruc_traba'),
                'cdire_traba' => $request->input('cdire_traba'),
                'cemail_traba' => $request->input('cemail_traba'),
            )
        );

        User::where('ccod_traba', $request->input('ccod_traba'))->update(
            array(
                'name' => $request->input('cnomb_traba'),
                'password' => Hash::make($request->input('password')),
                'first_login' => false,
            )
        );

        return redirect()->route('profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
