<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\item;
use App\Model\kategori;
use App\Model\satuan;
use App\Model\itemkonversi;
use DB;
use Datatables;

class MasterItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.item.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan = satuan::where('Status', 'OPN')->get();
        $kategori = kategori::where('Status', 'OPN')->get();
        $itemk = itemkonversi::all();
        return view('master.item.create', ['kategori' => $kategori, 'satuan' => $satuan, 'itemk' => $itemk]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lastID = DB::select("SELECT count(1) as jml FROM items where KodeKategori='" . $request->KodeKategori . "' ")[0]->jml;
        $lastID += 1;
        $kodeAwal = DB::select("SELECT KodeItemAwal as jml FROM kategoris where KodeKategori='" . $request->KodeKategori . "' group by KodeItemAwal")[0]->jml;
        $kodeAwal .= "-";

        if ($lastID > 100) {
            $kodeAwal .= $lastID;
        } else if ($lastID > 10) {
            $kodeAwal .= "0" . $lastID;
        } else {
            $kodeAwal .= "00" . $lastID;
        }

        // $this->validate($request, [
        //     'KodeItem' => 'required',
        //     'KodeKategori' => 'required',
        //     'NamaItem' => 'required',
        //     'jenisitem' => 'required'
        // ]);

        DB::table('items')->insert([
            'KodeItem' => $kodeAwal,
            'KodeKategori' => $request->KodeKategori,
            'NamaItem' => $request->NamaItem,
            'jenisitem' => $request->jenisitem,
            'Alias' => $request->Alias,
            'Keterangan' => $request->Keterangan,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $satuans = $request->satuan;
        $konversis = $request->konversi;
        $hargabelis = $request->hargabeli;
        $hargajuals = $request->hargajual;
        $hargagrosirs = $request->hargagrosir;
        foreach ($satuans as $key => $value) {
            DB::table('itemkonversis')->insert([
                'KodeItem' => $kodeAwal,
                'KodeSatuan' => $satuans[$key],
                'Konversi' => $konversis[$key],
                'HargaJual' => $hargajuals[$key],
                'HargaBeli' => $hargabelis[$key],
                'HargaGrosir' => $hargagrosirs[$key],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah item ' . $kodeAwal,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Item ' . $request->NamaItem . ' berhasil ditambahkan';
        return redirect('/masteritem')->with(['created' => $pesan]);
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
        $item = DB::table('items')->get()->where('KodeItem', $id);
        $itemk = DB::table('itemkonversis')->get()->where('KodeItem', $id);
        return view('master.item.edit', ['item' => $item, 'itemk' => $itemk]);
    }

    public function editkonversi($idItem, $idSatuan)
    {
        $item = DB::table('items')->get()->where('KodeItem', $idItem);
        $itemk = DB::table('itemkonversis')->get()->where('KodeItem', $idItem)->where('KodeSatuan', $idSatuan);
        return view('master.item.edit', ['item' => $item, 'itemk' => $itemk]);
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
            'KodeKategori' => 'required',
            'NamaItem' => 'required',
            'jenisitem' => 'required',
            'KodeSatuan' => 'required',
            'Konversi' => 'required',
            'HargaJual' => 'required',
            'HargaBeli' => 'required',
            'HargaGrosir' => 'required'
        ]);

        DB::table('items')->where('KodeItem', $request->KodeItem)
            ->update([
                'NamaItem' => $request->NamaItem,
                'Alias' => $request->Alias,
                'Keterangan' => $request->Keterangan,
                'Status' => 'OPN',
                'KodeUser' => \Auth::user()->name,
                'updated_at' => \Carbon\Carbon::now()
            ]);

        DB::table('itemkonversis')
            ->where('KodeItem', $request->KodeItem)
            ->where('KodeSatuan', $request->KodeSatuan)
            ->update([
                'Konversi' => $request->Konversi,
                'HargaJual' => $request->HargaJual,
                'HargaBeli' => $request->HargaBeli,
                'HargaGrosir' => $request->HargaGrosir,
                'updated_at' => \Carbon\Carbon::now()
            ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update item ' . $request->KodeItem,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Item ' . $request->NamaItem . ' berhasil diubah';
        return redirect('/masteritem')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = item::find($id);
        $item->Status = 'DEL';
        $item->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus item ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $item = DB::table('items')->get()->where('KodeItem', $id);
        foreach ($item as $itm) {
            $pesan = 'Item ' . $itm->NamaItem . ' berhasil dihapus';
        }
        return redirect('/masteritem')->with(['deleted' => $pesan]);
    }

    public function apiOPN()
    {
        $item = DB::table('items')
            ->where('Status', 'OPN')
            ->leftJoin('itemkonversis', 'itemkonversis.KodeItem', '=', 'items.KodeItem')
            ->get();

        return Datatables::of($item)
            ->addColumn('action', function ($item) {
                return
                    '<form style="display:inline-block;" type="submit" action="/masteritem/editkonversi/' . $item->KodeItem . '/' . $item->KodeSatuan . '" method="get">' .
                    '<button class="btn btn-primary btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/masteritem/delete/' . $item->KodeItem . '" method="get" onsubmit="return showConfirm()">' .
                    '<button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }
}
