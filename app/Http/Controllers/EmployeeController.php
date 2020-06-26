<?php

namespace App\Http\Controllers;

use App\Log;
use App\NmCttraba;
use App\User;
use Carbon\Carbon;
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
        $employee = NmCttraba::where('ccod_traba', $id)->first();
        return view('employee', compact('employee'));
        //return date('d-m-yy');
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
        if ($userData != null) {
            $maxAccess = date('d/m/Y', strtotime($request->input('fechaCaducidad')));
            if ($userData->access == false) {
                NmCttraba::where('ccod_traba', $userData['ccod_traba'])->update(
                    array(
                        'acceso_web_traba' => true
                    )
                );
                User::where('ccod_traba', $request->input('ccod_traba'))->update(
                    array(
                        'access' => true,
                        'access_end_at' => null
                    )
                );
                return redirect()->route('employees')->with('status', 'Se otorgarón los accesos a la web');
            }
            if ($maxAccess >= date('d/m/Y')) {

                NmCttraba::where('ccod_traba', $request->input('id'))->update(
                    array(
                        'fdef10' => $maxAccess
                    )
                );
                User::where('ccod_traba', $request->input('id'))->update(
                    array(
                        'access_end_at' => $maxAccess
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
                    'acceso_web_traba' => true
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
