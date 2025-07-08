<?php

namespace App\Http\Controllers;

// use App\Model\ekspedisi;
// use App\Model\supplier;
// use App\Model\pelanggan;
use Illuminate\Http\Request;
use DB;
use DataTables;

class BatasBawahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batas = DB::select("SELECT i.*, SUM(a.Qty) as saldo from keluarmasukbarangs a 
        inner join items i on a.KodeItem = i.KodeItem group by i.KodeItem
        having sum(a.Qty) < i.BatasBawah order by a.created_at desc ");

        return view('laporan.batasbawahstok.index', compact('batas'));
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
