<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\rak;
use DB;
use Datatables;

class MasterRakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.rak.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_id = DB::select('SELECT * FROM rak_item ORDER BY KodeRak DESC LIMIT 1');

        //Auto generate ID
        if ($last_id == null) {
            $newID = "Rak-001";
        } else {
            $string = $last_id[0]->KodeRak;
            $id = substr($string, -3, 3);
            $new = $id + 1;
            $new = str_pad($new, 3, '0', STR_PAD_LEFT);
            $newID = "Rak-" . $new;
        }

        return view('master.rak.create', compact('newID'));
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
            'NamaRak' => 'required'
        ]);

        DB::table('rak_item')->insert([
            'KodeRak' => $request->KodeRak,
            'nama_rak' => $request->NamaRak,
            'status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah rak ' . $request->NamaRak,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Rak ' . $request->NamaRak . ' berhasil ditambahkan';
        return redirect('/masterrak')->with(['created' => $pesan]);
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
        $satuan = DB::table('rak_item')->get()->where('KodeRak', $id);
        return view('master.rak.edit', ['satuan' => $satuan]);
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
            'NamaRak' => 'required'
        ]);

        DB::table('rak_item')->where('nama_rak', $request->NamaRak)->update([
            'nama_rak' => $request->NamaRak,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update rak ' . $request->KodeSatuan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Rak ' . $request->NamaRak . ' berhasil diubah';
        return redirect('/masterrak')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $satuan = rak::find($id);
        $satuan->Status = 'DEL';
        $satuan->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus rak ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $satuan = DB::table('rak_item')->get()->where('ID', $id);
        foreach ($satuan as $sat) {
            $pesan =  $sat->nama_rak . ' berhasil dihapus';
        }
        return redirect('/masterrak')->with(['deleted' => $pesan]);
    }

    public function apiOPN()
    {
        $satuan = DB::table('rak_item')
            ->where('rak_item.Status', 'OPN')
            ->get();

        return Datatables::of($satuan)
            ->addColumn('action', function ($satuan) {
                return
                    '<form style="display:inline-block;" type="submit" action="/masterrak/' . $satuan->KodeRak . '/edit" method="get">' .
                    '<button class="btn btn-primary btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/masterrak/delete/' . $satuan->KodeRak . '" method="get" onsubmit="return showConfirm()">' .
                    '<button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }
}
