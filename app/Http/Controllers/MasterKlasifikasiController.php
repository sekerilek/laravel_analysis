<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\kategori;
use DB;
use Datatables;

class MasterKlasifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.klasifikasi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_id = DB::select('SELECT * FROM kategoris ORDER BY KodeKategori DESC LIMIT 1');

        //Auto generate ID
        if ($last_id == null) {
            $newID = "KLA-001";
        } else {
            $string = $last_id[0]->KodeKategori;
            $id = substr($string, -3, 3);
            $new = $id + 1;
            $new = str_pad($new, 3, '0', STR_PAD_LEFT);
            $newID = "KLA-" . $new;
        }

        return view('master.klasifikasi.create', ['newID' => $newID]);
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
            'KodeKategori' => 'required',
            'NamaKategori' => 'required',
            'KodeItemAwal' => 'required'
        ]);

        DB::table('kategoris')->insert([
            'KodeKategori' => $request->KodeKategori,
            'NamaKategori' => $request->NamaKategori,
            'KodeItemAwal' => $request->KodeItemAwal,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah klasifikasi ' . $request->KodeKategori,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Klasifikasi ' . $request->NamaKategori . ' berhasil ditambahkan';
        return redirect('/masterklasifikasi')->with(['created' => $pesan]);
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
        $kategori = DB::table('kategoris')->get()->where('KodeKategori', $id);
        return view('master.klasifikasi.edit', ['kategori' => $kategori]);
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
            'NamaKategori' => 'required',
            'KodeItemAwal' => 'required',
        ]);

        DB::table('kategoris')->where('KodeKategori', $request->KodeKategori)->update([
            'NamaKategori' => $request->NamaKategori,
            'KodeItemAwal' => $request->KodeItemAwal,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update klasifikasi ' . $request->KodeKategori,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Klasifikasi ' . $request->NamaKategori . ' berhasil diubah';
        return redirect('/masterklasifikasi')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = kategori::find($id);
        $kategori->Status = 'DEL';
        $kategori->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus klasifikasi ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $kategori = DB::table('kategoris')->get()->where('KodeKategori', $id);
        foreach ($kategori as $kat) {
            $pesan = 'Klasifikasi ' . $kat->NamaKategori . ' berhasil dihapus';
        }
        return redirect('/masterklasifikasi')->with(['deleted' => $pesan]);
    }

    public function apiOPN()
    {
        $kategori = DB::table('kategoris')
            ->where('kategoris.Status', 'OPN')
            ->get();

        return Datatables::of($kategori)
            ->addColumn('action', function ($kategori) {
                return
                    '<form style="display:inline-block;" type="submit" action="/masterklasifikasi/' . $kategori->KodeKategori . '/edit" method="get">' .
                    '<button class="btn btn-primary btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/masterklasifikasi/delete/' . $kategori->KodeKategori . '" method="get" onsubmit="return showConfirm()">' .
                    '<button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }
}
