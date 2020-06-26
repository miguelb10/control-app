<?php

namespace App\Http\Controllers;

use App\Log;
use App\NmLndocumento;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $invoices = DB::select('EXEC dbo.sp_Web_Consulta_Boletas_Pago @cruc = ?,
        @ccod_traba = ?, @ccod_eje = ?, @ccod_tpla =? ',
        [session('rucSession'), Auth::user()->ccod_traba, 2019, 10]);

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
    public function update(Request $request, $id)
    {    
        /*    
        NmLndocumento::create([
            'id_cbdocumentos' => 1,
            'dfch_descarga' => 1,
            'cpc_descarga' => $request->getClientIp()
        ]);*/       
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
