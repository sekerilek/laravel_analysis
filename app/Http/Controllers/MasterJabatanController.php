<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;

class MasterJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.jabatan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('jabatans')->insert([
            "KodeJabatan"       => $request->kode,
            "KeteranganJabatan" => $request->keterangan,
            "Status"            => 'OPN',
            "created_at"        => \Carbon\Carbon::now(),
            "updated_at"        => \Carbon\Carbon::now(),
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah jabatan ' . $request->keterangan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Jabatan ' . $request->keterangan . ' berhasil ditambahkan';
        return redirect('/masterjabatan')->with(['created' => $pesan]);
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
        $jabatan = DB::table('jabatans')
            ->where('KodeJabatan', $id)
            ->get();

        return view('master.jabatan.edit', compact('jabatan'));
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
        DB::table('jabatans')
            ->where('KodeJabatan', $id)
            ->update([
                "KodeJabatan"       => $request->kode,
                "KeteranganJabatan" => $request->keterangan,
                "updated_at"        => \Carbon\Carbon::now(),
            ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Ubah data jabatan ' . $request->keterangan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Jabatan ' . $request->keterangan . ' berhasil diperbarui';
        return redirect('/masterjabatan')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('jabatans')
            ->where('KodeJabatan', $id)
            ->update([
                "Status"    => 'DEL',
            ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus data jabatan ' . $request->keterangan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Jabatan ' . $request->keterangan . ' telah dihapus';
        return redirect('/masterjabatan')->with(['deleted' => $pesan]);
    }

    public function apiOPN()
    {
        $jabatan = DB::table('jabatans')
            ->where('Status', 'OPN')
            ->get();

        return Datatables::of($jabatan)
            ->addColumn('action', function ($jabatan) {
                return
                    '<form style="display:inline-block;" type="submit" action="/masterjabatan/' . $jabatan->KodeJabatan . '/edit" method="get">' .
                    '<button class="btn btn-primary btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/masterjabatan/delete/' . $jabatan->KodeJabatan . '" method="get" onsubmit="return showConfirm()">' .
                    '<button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }
}
