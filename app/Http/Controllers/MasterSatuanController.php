<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\satuan;
use DB;
use Datatables;

class MasterSatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.satuan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.satuan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'KodeSatuan' => 'required',
            'NamaSatuan' => 'required'
        ]);

        DB::table('satuans')->insert([
            'KodeSatuan' => $request->KodeSatuan,
            'NamaSatuan' => $request->NamaSatuan,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah satuan ' . $request->KodeSatuan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Satuan ' . $request->NamaSatuan . ' berhasil ditambahkan';
        return redirect('/mastersatuan')->with(['created' => $pesan]);
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
        $satuan = DB::table('satuans')->get()->where('KodeSatuan', $id);
        return view('master.satuan.edit', ['satuan' => $satuan]);
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
        $this->validate($request, [
            'KodeSatuan' => 'required',
            'NamaSatuan' => 'required'
        ]);

        DB::table('satuans')->where('KodeSatuan', $request->KodeSatuan)->update([
            'KodeSatuan' => $request->KodeSatuan,
            'NamaSatuan' => $request->NamaSatuan,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update satuan ' . $request->KodeSatuan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Satuan ' . $request->NamaSatuan . ' berhasil diubah';
        return redirect('/mastersatuan')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $satuan = satuan::find($id);
        $satuan->Status = 'DEL';
        $satuan->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus satuan ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $satuan = DB::table('satuans')->get()->where('KodeSatuan', $id);
        foreach ($satuan as $sat) {
            $pesan = 'Satuan ' . $sat->NamaSatuan . ' berhasil dihapus';
        }
        return redirect('/mastersatuan')->with(['deleted' => $pesan]);
    }

    public function apiOPN()
    {
        $satuan = DB::table('satuans')
            ->where('satuans.Status', 'OPN')
            ->get();

        return Datatables::of($satuan)
            ->addColumn('action', function ($satuan) {
                return
                    '<form style="display:inline-block;" type="submit" action="/mastersatuan/' . $satuan->KodeSatuan . '/edit" method="get">' .
                    '<button class="btn btn-primary btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/mastersatuan/delete/' . $satuan->KodeSatuan . '" method="get" onsubmit="return showConfirm()">' .
                    '<button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }
}
