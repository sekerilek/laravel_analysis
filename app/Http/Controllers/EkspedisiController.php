<?php

namespace App\Http\Controllers;

use App\Model\ekspedisi;
use App\Model\supplier;
use App\Model\pelanggan;
use Illuminate\Http\Request;
use DB;
use DataTables;

class EkspedisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eks = DB::select("SELECT * from ekspedisis where Status='OPN'");

        return view('ekspedisi.index', compact('eks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ekspedisi.buat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('ekspedisis')->insert([
            'KodeEkspedisi' => $request->KodeEkspedisi,
            'NamaEkspedisi' => $request->NamaEkspedisi,
            'Modal' => $request->Modal,
            'TarifPelanggan' => $request->TarifPelanggan,
            'Status' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah ekspedisi ' . $request->KodeEkspedisi,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        return redirect('/ekspedisi');
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
    public function edit($id)
    {
        $eks = DB::select("SELECT * from ekspedisis where ID=".$id."");

        return view('ekspedisi.edit', compact('eks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ekspedisi  $ekspedisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        DB::table('ekspedisis')->where('ID',$id)->update([
            'KodeEkspedisi' => $request->KodeEkspedisi,
            'NamaEkspedisi' => $request->NamaEkspedisi,
            'Modal' => $request->Modal,
            'TarifPelanggan' => $request->TarifPelanggan,
            'Status' => 'OPN',
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update ekspedisi ' . $request->KodeEkspedisi,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Karyawan ' . $request->NamaEkspedisi . ' berhasil diubah';
        return redirect('/ekspedisi')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ekspedisi  $ekspedisi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('ekspedisis')->where('ID',$id)->update([
            'Status'        =>  'DEL',
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        $ekspedisi = DB::table('ekspedisis')->get('NamaEkspedisi')->where('ID', $id);
        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus ekspedisi ' . $ekspedisi,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

            $pesan = 'ekspedisi ' . $ekspedisi . ' berhasil dihapus';
        
        return redirect('/ekspedisi')->with(['deleted' => $pesan]);
    }
}
