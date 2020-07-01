<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\NmCbdocumento;
use App\Models\NmLndocumento;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        try {
            $invoices = DB::select(
                'EXEC dbo.sp_Web_Consulta_Boletas_Pago @cruc = ?, @ccod_traba = ?',
                [session('rucSession'), Auth::user()->ccod_traba]
            );

            Log::create([
                'ccod_traba' => Auth::user()->ccod_traba,
                'page' => '/invoices',
                'description' => 'Vista Facturas',
            ]);
            return view('invoices', compact('invoices'));
        } catch (Exception $e) {
            $invoices = null;
            return view('invoices', compact('invoices'));
        }
    }

    public function update(Request $request)
    {
        if ($request->input('id_doc') != null) {
            try {
                $documento = NmCbdocumento::where('id_cbdocumentos', $request->input('id_doc'))->first();
                $file = $documento->cruta_file . "\\" . $documento->cname_file;
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
                NmLndocumento::create([
                    'id_cbdocumentos' => $request->input('id_doc'),
                    'dfch_descarga' => date("d-m-Y H:i:s"),
                    'cpc_descarga' => $this->get_client_ip()
                ]);
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
}
