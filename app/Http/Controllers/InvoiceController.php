<?php

namespace App\Http\Controllers;

use App\Log;
use App\NmCbdocumento;
use App\NmLndocumento;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
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
        $invoices = DB::select(
            'EXEC dbo.sp_Web_Consulta_Boletas_Pago @cruc = ?,
        @ccod_traba = ?',
            [session('rucSession'), Auth::user()->ccod_traba]
        );

        Log::create([
            'user_id' => Auth::user()->id,
            'page' => '/invoices',
            'description' => 'Vista Facturas',
        ]);
        return view('invoices', compact('invoices'));
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
        /*    
        NmLndocumento::create([
            'id_cbdocumentos' => 1,
            'dfch_descarga' => 1,
            'cpc_descarga' => $request->getClientIp()
        ]);*/
        if ($request->input('id_doc') != null) {
            try {
                NmLndocumento::create([
                    'id_cbdocumentos' => $request->input('id_doc'),
                    'dfch_descarga' => date("d-m-Y H:i:s"),
                    'cpc_descarga' => $this->get_client_ip()
                ]);

                $documento = NmCbdocumento::where('id_cbdocumentos', $request->input('id_doc'))->first();
                //$file = public_path() . "/img/Logo.png";
                $file = $documento->cruta_file."\\".$documento->cname_file;
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
                return response()->download($file, $documento->cname_file, $headers);
            } catch (Exception $e) {
                return redirect()->route('invoices.filter')->with('statusFail', 'El documento no se encuentra disponible');
            }
        } else {
            return redirect()->route('invoices.filter')->with('statusFail', 'El documento no se encuentra disponible');
        }
    }

    function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
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
