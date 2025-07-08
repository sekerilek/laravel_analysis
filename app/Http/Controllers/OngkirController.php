<?php

namespace App\Http\Controllers;

use App\Model\ongkir;
use App\Model\supplier;
use App\Model\pelanggan;
use Illuminate\Http\Request;
use DB;
use DataTables;

class OngkirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eks = DB::table('ongkirs')
        ->selectRaw('ID,Kode,Modal,TarifPelanggan,TarifPelanggan-Modal as Profit')
        ->where('Modal','<>',null)
        ->get();
        $total = DB::table('ongkirs')
        ->selectRaw('sum(TarifPelanggan-Modal) as tot')
        ->where('Modal','<>',null)
        ->first();
        return view('laporan.ongkir.index', compact('eks','total'));
    }
    public function filter(Request $request){
        // $tanggal = date('Y-m-d',strtotime($request->start));
        if (isset($request->start)) {
            $eks = DB::table('ongkirs')
            ->whereDate('created_at',$tanggal)
            ->where('TarifPelanggan','<>',0)
            ->selectRaw('ID,Kode,Modal,TarifPelanggan,TarifPelanggan-Modal as Profit')
            ->get();
            $total = DB::table('ongkirs')
            ->whereDate('created_at',$tanggal)
            ->where('TarifPelanggan','<>',0)
            ->selectRaw('sum(TarifPelanggan-Modal) as tot')
            ->first();
        }

        if (isset($request->bulan)) {
            // code...
        }
        
        $eks = DB::table('ongkirs')
        ->wheredate('created_at',$tanggal)
        ->selectRaw('ID,Kode,Modal,TarifPelanggan,TarifPelanggan-Modal as Profit')
        ->where('TarifPelanggan','<>',0)
        ->get();
        $total = DB::table('ongkirs')
        ->wheredate('created_at',$tanggal)
        ->selectRaw('sum(TarifPelanggan-Modal) as tot')
        ->where('TarifPelanggan','<>',0)
        ->first();
        //dd($tanggal,$eks);
        return view('laporan.ongkir.filter', compact('eks','total'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ongkir  $ongkir
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ongkir  $ongkir
     * @return \Illuminate\Http\Response
     */
    public function edit(ongkir $ongkir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ongkir  $ongkir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ongkir $ongkir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ongkir  $ongkir
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
