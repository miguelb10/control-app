<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\NmLndocumento;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $logs = DB::select(
                'EXEC dbo.sp_Web_Consulta_Login @cruc = ?,
        @ccod_traba = ?, @ccod_eje = ?, @ccod_tpla = ?, @ctipo = ?',
                [session('rucSession'), '', '', '', 'I']
            );
            Log::create([
                'ccod_traba' => Auth::user()->ccod_traba,
                'page' => '/invoices',
                'description' => 'Vista Facturas',
            ]);
            return view('logs', compact('logs'));
        } catch (Exception $e) {
            $logs = null;
            return view('logs', compact('logs'));
        }
    }

    public function show(Request $request)
    {
        try {
            $details = NmLndocumento::where('id_cbdocumentos', $request->input('id_doc'))->get();
            return view('downloads', compact('details'));
        } catch (Exception $e) {
            $details = null;
            return view('downloads', compact('details'));
        }
    }
}
