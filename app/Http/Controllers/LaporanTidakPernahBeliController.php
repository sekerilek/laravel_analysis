<?php

namespace App\Http\Controllers;

// use App\Model\ekspedisi;
// use App\Model\supplier;
// use App\Model\pelanggan;
use Illuminate\Http\Request;
use DB;
use DataTables;

class LaporanTidakPernahBeliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tpb = DB::select("SELECT DISTINCT p.KodePelanggan, p.NamaPelanggan, p.Kontak, p.Handphone from pelanggans p 
        LEFT JOIN pemesananpenjualans pl ON pl.KodePelanggan=p.KodePelanggan
        LEFT JOIN suratjalans s ON s.KodePelanggan=p.KodePelanggan     
        WHERE NOT EXISTS (SELECT * FROM pemesananpenjualans pl WHERE pl.KodePelanggan=p.KodePelanggan)");

        return view('laporan.tidakpernahbeli.index', compact('tpb'));
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
     * @param  \App\ekspedisi  $ekspedisi
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ekspedisi  $ekspedisi
     * @return \Illuminate\Http\Response
     */
    public function edit(ekspedisi $ekspedisi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ekspedisi  $ekspedisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ekspedisi $ekspedisi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ekspedisi  $ekspedisi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
