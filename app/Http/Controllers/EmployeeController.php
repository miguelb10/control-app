<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Mail\MailableClass;
use App\Models\NmCttraba;
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
        if (Auth::user()->crole_traba == 'admin') {
            try {
                $employees = DB::select('EXEC dbo.sp_Web_Consulta_Login @cruc = ?, @ccod_traba = ?, 
            @ctipo = ?', [session('rucSession'), '', "E"]);

                Log::create([
                    'ccod_traba' => Auth::user()->ccod_traba,
                    'page' => '/employees',
                    'description' => 'administrar empleados'
                ]);
                return view('employees', compact('employees'));
            } catch (Exception $e) {
                $employees = null;
                return view('employees', compact('employees'));
            }
        } else {
            return redirect()->route('home')->with('statusFail', 'Usted no cuenta con permisos de administrador');
        }
    }

    public function show($id)
    {
        if (Auth::user()->crole_traba == 'admin') {
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
        } else {
            return redirect()->route('home')->with('statusFail', 'Usted no cuenta con permisos de administrador');
        }
    }

    public function update(Request $request)
    {
        if (Auth::user()->crole_traba == 'admin') {
            try {
                $userData = NmCttraba::where('ccod_traba', $request->input('id'))->first();
                $dateCreate = date_create(date('Y-m-d'));
                $maxAccess = date('d/m/Y', strtotime($request->input('fechaCaducidad')));
                if ($userData->acceso_web_traba == 0) {
                    NmCttraba::where('ccod_traba', $request->input('id'))->update(
                        array(
                            'first_login' => true,
                            'acceso_web_traba' => true,
                            'fdef10' => null,
                            'password' => Hash::make($userData['ccod_traba'])
                        )
                    );
                    //Mail::to($newUser['cemail_traba'])->send(new MailableClass);
                    Mail::to('miguel.blas_03@hotmail.com')->send(new MailableClass($userData));
                    return redirect()->route('employees')->with('status', 'Se otorgarón los accesos a la web');
                }
                if ($dateCreate <= date_create($request->input('fechaCaducidad'))) {
                    NmCttraba::where('ccod_traba', $request->input('id'))->update(
                        array(
                            'fdef10' => $maxAccess,
                            'acceso_web_traba' => true
                        )
                    );
                    $userLimit = NmCttraba::where('ccod_traba', $request->input('id'))->first();

                    //Mail::to($newUser['cemail_traba'])->send(new MailableClass);
                    Mail::to('miguel.blas_03@hotmail.com')->send(new MailableClass($userLimit));
                    return redirect()->route('employees')->with('status', 'El usuario tiene accesos hasta: ' . $maxAccess);
                } else {
                    return redirect()->route('employees')->with('statusFail', 'La fecha no puede ser menor a la fecha actual');
                }
            } catch (Exception $e) {
                return redirect()->route('employees')->with('statusFail', 'Ocurrio un error en la solicitud!');
            }
        } else {
            return redirect()->route('home')->with('statusFail', 'Usted no cuenta con permisos de administrador');
        }
    }
}
