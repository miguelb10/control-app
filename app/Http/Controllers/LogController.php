<?php

namespace App\Http\Controllers;

use App\Log;
use App\NmLndocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
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

        $logs=DB::select('EXEC dbo.sp_Web_Consulta_Login @cruc = ?,
        @ccod_traba = ?, @ccod_eje = ?, @ccod_tpla = ?, @ctipo = ?',
        [session('rucSession'), '', '', '', 'I']);
        //$logs = null;
        $selectTipo = DB::select('Exec dbo.sp_Web_Consulta_Login @cruc=?
        ,@ctipo=?',[session('rucSession'), 'P']);

        Log::create([
            'user_id' => Auth::user()->id,
            'page' => '/invoices',
            'description' => 'Vista Facturas',
        ]);
        return view('logs', compact('logs', 'selectTipo'));
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
    public function show(Request $request)
    {
        /*        
        $getCode = $request->input('ccod_traba');
        if($getCode != null){
        $logs=DB::select('EXEC dbo.sp_Web_Consulta_Login @cruc = ?,
        @ccod_traba = ?, @ccod_eje = ?, @ccod_tpla = ?, @ctipo = ?',
        [session('rucSession'), $getCode,
        $request->input('anio'), $request->input('tipo'), 'I']);
        }
        else{
            $logs=DB::select('EXEC dbo.sp_Web_Consulta_Login @cruc = ?,
            @ccod_eje = ?, @ccod_tpla = ?, @ctipo = ?',
            [session('rucSession'),
            $request->input('anio'), $request->input('tipo'), 'I']);            
        }
        $selectTipo = DB::select('Exec dbo.sp_Web_Consulta_Login @cruc=?
        ,@ctipo=?',[session('rucSession'), 'P']);
        return view('logs', compact('logs', 'selectTipo'));*/

        $details = NmLndocumento::where('id_cbdocumentos', $request->input('id_doc'))->get();
        return view('downloads', compact('details'));
        //echo $request->input('id_doc');
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
        //
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
