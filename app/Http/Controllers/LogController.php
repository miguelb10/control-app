<?php

namespace App\Http\Controllers;

use App\Log;
use App\NmLndocumento;
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

        $logs=DB::select('EXEC dbo.sp_Web_Consulta_Login @cruc = ?,
        @ccod_traba = ?, @ccod_eje = ?, @ccod_tpla = ?, @ctipo = ?',
        [session('rucSession'), '', '', '', 'I']);
        $selectTipo = DB::select('Exec dbo.sp_Web_Consulta_Login @cruc=?
        ,@ctipo=?',[session('rucSession'), 'P']);

        Log::create([
            'user_id' => Auth::user()->id_cttraba,
            'page' => '/invoices',
            'description' => 'Vista Facturas',
        ]);
        return view('logs', compact('logs', 'selectTipo'));
    }

    public function show(Request $request)
    {

        $details = NmLndocumento::where('id_cbdocumentos', $request->input('id_doc'))->get();
        return view('downloads', compact('details'));
    }

}
