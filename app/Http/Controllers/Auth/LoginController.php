<?php

namespace App\Http\Controllers\Auth;

use App\Models\AdCtcia;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\NmCttraba;
use App\Providers\RouteServiceProvider;
use App\Models\WebConfig;
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
            $validateDate = NmCttraba::where('ccod_traba', $request->input('ccod_traba'))->first();
            if($validateDate->fdef10 < date('Y-m-d') && $validateDate->fdef10 != null){
                NmCttraba::where('ccod_traba', $request->input('ccod_traba'))->update(
                    array(
                        'acceso_web_traba' => false
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
                    'user_id' => Auth::user()->id_cttraba,
                    'page' => '/home',
                    'description' => 'Inicio sesión',
                ]);
                $webConfig = WebConfig::where('ccod_regtri', $request->input('ruc'))->first();
                session(['rucSession' => $request->input('ruc')]);
                $empresa = AdCtcia::where('ccod_regtri', $request->input('ruc'))->first();
                session(['empSession' => $empresa->cdsc_cia]);
                session(['imgRuta' => $webConfig->ruta]);
                session(['tema' => $webConfig->tema_color]);
                $user->update([
                    'ultimo_login' => Carbon::now()->toDateString(),
                    'ip' => $request->getClientIp()
                ]);
            }
        }
    }
}
