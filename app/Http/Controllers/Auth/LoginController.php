<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Log;
use App\NmCttraba;
use App\Providers\RouteServiceProvider;
use App\User;
use App\WebConfig;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(){
        return 'ccod_traba';
    }

    public function authenticated(Request $request, $user)
    {
        $data = DB::select('EXEC dbo.sp_Web_Consulta_Login @cruc = ?, @ccod_traba = ?,
        @ctipo = ?', [$request->input('ruc'), $request->input('ccod_traba'), "c"]);
        if ($data == null) {
            Auth::logout();
            $rules = [
                'ruc' =>  'required|numeric|max:1'
            ];

            $messages = [
                'ruc.max' => 'Usuario no registrado en la empresa'
            ];

            $this->validate($request, $rules, $messages);
        } else {
            $validateDate = User::where('ccod_traba', $request->input('ccod_traba'))->first();
            if($validateDate->access_end_at < date('Y-m-d') && $validateDate->access_end_at != null){
                NmCttraba::where('ccod_traba', $request->input('ccod_traba'))->update(
                    array(
                        'acceso_web_traba' => false
                    )
                );
                User::where('ccod_traba', $request->input('ccod_traba'))->update(
                    array(
                        'access' => false
                    )
                );
                Auth::logout();
                $rules = [
                    'ruc' =>  'required|numeric|max:1'
                ];
    
                $messages = [
                    'ruc.max' => 'Usuario no cuenta con acceso a la web'
                ];
    
                $this->validate($request, $rules, $messages);
            }else{
                    
                Log::create([
                    'user_id' => Auth::user()->id,
                    'page' => '/home',
                    'description' => 'Inicio sesión',
                ]);
                $imgRuta = WebConfig::where('ccod_regtri', $request->input('ruc'))->first();
                session(['rucSession' => $request->input('ruc')]);
                session(['imgRuta' => $imgRuta->ruta]);
                $user->update([
                    'ultimo_login' => Carbon::now()->toDateString(),
                    'ip' => $request->getClientIp()
                ]);
            }
        }
    }
}
