<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\lokasi;
use DB;
use Datatables;

class MasterGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.gudang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_id = DB::select('SELECT * FROM lokasis ORDER BY KodeLokasi DESC LIMIT 1');

        //Auto generate ID
        if ($last_id == null) {
            $newID = "GUD-001";
        } else {
            $string = $last_id[0]->KodeLokasi;
            $id = substr($string, -3, 3);
            $new = $id + 1;
            $new = str_pad($new, 3, '0', STR_PAD_LEFT);
            $newID = "GUD-" . $new;
        }

        return view('master.gudang.create', ['newID' => $newID]);
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
            'KodeLokasi' => 'required',
            'NamaLokasi' => 'required',
            'Tipe' => 'required'
        ]);

        DB::table('lokasis')->insert([
            'KodeLokasi' => $request->KodeLokasi,
            'NamaLokasi' => $request->NamaLokasi,
            'Tipe' => $request->Tipe,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah gudang ' . $request->KodeLokasi,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Gudang ' . $request->NamaLokasi . ' berhasil ditambahkan';
        return redirect('/mastergudang')->with(['created' => $pesan]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $lokasi = DB::table('lokasis')->get()->where('KodeLokasi', $id);
        // return view('master.gudang.detail', ['lokasi' => $lokasi]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lokasi = DB::table('lokasis')->get()->where('KodeLokasi', $id);
        return view('master.gudang.edit', ['lokasi' => $lokasi]);
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
            'NamaLokasi' => 'required',
            'Tipe' => 'required',
        ]);

        DB::table('lokasis')->where('KodeLokasi', $request->KodeLokasi)->update([
            'NamaLokasi' => $request->NamaLokasi,
            'Tipe' => $request->Tipe,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update gudang ' . $request->KodeLokasi,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Gudang ' . $request->NamaLokasi . ' berhasil diubah';
        return redirect('/mastergudang')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lokasi = lokasi::find($id);
        $lokasi->Status = 'DEL';
        $lokasi->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus gudang ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $lokasi = DB::table('lokasis')->get()->where('KodeLokasi', $id);
        foreach ($lokasi as $lok) {
            $pesan = 'Gudang ' . $lok->NamaLokasi . ' berhasil dihapus';
        }
        return redirect('/mastergudang')->with(['deleted' => $pesan]);
    }

    public function apiOPN()
    {
        $lokasi = DB::table('lokasis')
            ->where('lokasis.Status', 'OPN')
            ->get();

        return Datatables::of($lokasi)
            ->addColumn('action', function ($lokasi) {
                return
                    '<form style="display:inline-block;" type="submit" action="/mastergudang/' . $lokasi->KodeLokasi . '/edit" method="get">' .
                    '<button class="btn btn-primary btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/mastergudang/delete/' . $lokasi->KodeLokasi . '" method="get" onsubmit="return showConfirm()">' .
                    '<button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }
}
