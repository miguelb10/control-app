<?php

namespace App\Http\Controllers;

use App\Log;
use App\NmCttraba;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
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
        $employees = DB::select('EXEC dbo.sp_Web_Consulta_Login @cruc = ?, @ccod_traba = ?, 
        @ctipo = ?', [session('rucSession'), 70355383, "E"]);

        //NmCttraba::where('ccod_cia', session('rucSession'))->get();
        //DB::table('nm_cttraba')->get();

        Log::create([
            'user_id' => Auth::user()->id,
            'page' => '/employees',
            'description' => 'administrar empleados'
        ]);
        return view('employees', compact('employees'));
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
        try {
            $employee = NmCttraba::where('ccod_traba', $id)->first();
            if ($employee != null) {
                return view('employee', compact('employee'));
            } else {
                return redirect()->route('employees')->with('statusFail', 'Usuario no encontrado!');
            }
        } catch (Exception $e) {
            return redirect()->route('employees')->with('statusFail', 'Usuario no encontrado!');
        }
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
        $userData = User::where('ccod_traba', $request->input('id'))->first();
        $dateCreate = date_create(date('Y-m-d'));
        if ($userData != null) {
            $maxAccess = date('d/m/Y', strtotime($request->input('fechaCaducidad')));
            if ($userData->access == 0) {
                NmCttraba::where('ccod_traba', $request->input('id'))->update(
                    array(
                        'acceso_web_traba' => true,
                        'fdef10' => null
                    )
                );
                User::where('ccod_traba', $request->input('id'))->update(
                    array(
                        'access' => true,
                        'access_end_at' => null,
                        'first_login' => true
                    )
                );
                return redirect()->route('employees')->with('status', 'Se otorgarón los accesos a la web 1');
            }
            //$maxAccess >= date('d/m/Y')
            if ($dateCreate <= date_create($request->input('fechaCaducidad'))) {

                NmCttraba::where('ccod_traba', $request->input('id'))->update(
                    array(
                        'fdef10' => $maxAccess,
                        'acceso_web_traba' => true
                    )
                );
                User::where('ccod_traba', $request->input('id'))->update(
                    array(
                        'access_end_at' => $maxAccess,
                        'access' => true
                    )
                );

                return redirect()->route('employees')->with('status', 'El usuario tiene accesos hasta: ' . $maxAccess);
            } else {
                return redirect()->route('employees')->with('statusFail', 'La fecha no puede ser menor a la fecha actual');
            }
        } else {
            $newUser = NmCttraba::where('ccod_traba', $request->input('id'))->first();
            User::create([
                'name' => $newUser['cnomb_traba'],
                'email' => $newUser['cemail_traba'],
                'first_login' => true,
                'ccod_traba' => $newUser['ccod_traba'],
                'password' => Hash::make($newUser['ccod_traba'])
            ]);
            NmCttraba::where('ccod_traba', $newUser['ccod_traba'])->update(
                array(
                    'acceso_web_traba' => true,
                    'fdef10' => null
                )
            );
            return redirect()->route('employees')->with('status', 'Se otorgarón los accesos a la web');
        }
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
