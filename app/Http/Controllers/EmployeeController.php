<?php

namespace App\Http\Controllers;

use App\Log;
use App\Mail\MailableClass;
use App\NmCttraba;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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

    public function update(Request $request)
    {
        try {
            $userData = User::where('ccod_traba', $request->input('id'))->first();
            $newUser = NmCttraba::where('ccod_traba', $request->input('id'))->first();
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
                    //Mail::to($newUser['cemail_traba'])->send(new MailableClass);
                    Mail::to('miguel.blas_03@hotmail.com')->send(new MailableClass($newUser));
                    return redirect()->route('employees')->with('status', 'Se otorgarón los accesos a la web');
                }
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
                    $userLimit = NmCttraba::where('ccod_traba', $request->input('id'))->first();

                    //Mail::to($newUser['cemail_traba'])->send(new MailableClass);
                    Mail::to('miguel.blas_03@hotmail.com')->send(new MailableClass($userLimit));
                    return redirect()->route('employees')->with('status', 'El usuario tiene accesos hasta: ' . $maxAccess);
                } else {
                    return redirect()->route('employees')->with('statusFail', 'La fecha no puede ser menor a la fecha actual');
                }
            } else {
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
                //Mail::to($newUser['cemail_traba'])->send(new MailableClass);
                Mail::to('miguel.blas_03@hotmail.com')->send(new MailableClass($newUser));

                return redirect()->route('employees')->with('status', 'Se otorgarón los accesos a la web');
            }
        } catch (Exception $e) {
            return redirect()->route('employees')->with('statusFail', 'Ocurrio un error en la solicitud!');
        }
    }
}
