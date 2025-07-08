<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;

class MasterGolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('master.golongan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $golongan = DB::select(
            "
            SELECT * FROM golongans 
            WHERE Status = 'OPN'
            ORDER BY KodeGolongan DESC
            LIMIT 1
            "
        );

        if ($golongan == null) {
            $idgol = 'GOL-01';
            $numgol = +(substr($idgol, 4));
        }
        else {
            //print_r($golongan);
            foreach($golongan as $key => $value) {
              $string = $value->KodeGolongan;
              $id = substr($string, 4);
              $idgol = $id + 1;
              if ($idgol < 10) {
                  $idgol = str_pad($idgol, 2, '0', STR_PAD_LEFT);
                  $idgol = 'GOL-' . $idgol;
              }
              else {
                  $idgol = 'GOL-' . $idgol;
              }
            }

            $numgol = +(substr($idgol, 4));
        }

        return view('master.golongan.create', compact('idgol', 'numgol'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('golongans')->insert([
            'KodeGolongan'    => $request->KodeGolongan,
            'NamaGolongan'    => $request->NamaGolongan,
            'UangHadir'       => $request->UangHadir,
            'LemburHarian'    => $request->LemburHarian,
            'LemburMinggu'    => $request->LemburMinggu,
            'Status'          => 'OPN',
            'created_at'      => \Carbon\Carbon::now(),
            'updated_at'      => \Carbon\Carbon::now(),
        ]);

        $golitem = $request->golItem;
        $hargaitem = $request->hargaItem;
        $kodegol = substr($request->KodeGolongan, 4);
        if ((int)$kodegol < 10) {
            $kodegol = '0' . $kodegol;
        }
        $nomor = 0;
        foreach ($golitem as $key => $value) {
            $nomor++;
            $urut = $nomor;
            if ($urut < 10) {
                $urut = '0' . $urut;
            }
            $kodegolitem = 'GI-'.$kodegol.'-'.$urut;
            DB::table('detailgolongans')->insert([
                'KodeGolongan'  => $request->KodeGolongan,
                'KodeGolItem'   => $kodegolitem,
                'NamaGolItem'   => $golitem[$key],
                'HargaGolItem'  => $hargaitem[$key],
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now(),
            ]);
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah data golongan ' . $request->KodeGolongan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Data Golongan ' . $request->KodeGolongan . ' berhasil ditambahkan';
        return redirect('/mastergolongan')->with(['created' => $pesan]);
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
        $idgol = $id;
        $numgol = +(substr($idgol, 4));
        $gol = DB::table('golongans')->where('KodeGolongan', $id)->get();
        $detailgol = DB::table('detailgolongans')->where('KodeGolongan', $id)->get();
        $countdetail = count($detailgol);

        return view('master.golongan.edit', compact('idgol', 'numgol', 'gol', 'detailgol', 'countdetail'));
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
        //
        DB::table('golongans')
            ->where('KodeGolongan', $id)
            ->where('Status', 'OPN')
            ->update([
                'NamaGolongan'  => $request->NamaGolongan,
                'UangHadir'     => $request->UangHadir,
                'LemburHarian'  => $request->LemburHarian,
                'LemburMinggu'  => $request->LemburMinggu,
                'updated_at'    => \Carbon\Carbon::now(),
            ]);

        $kode = $request->kodeGolItem;
        $nama = $request->golItem;
        $harga = $request->hargaItem;
        $kodegol = substr($request->KodeGolongan, 4);
        foreach ($kode as $key => $value) {
            DB::table('detailgolongans')
              ->updateOrInsert(
                [ 'KodeGolongan' => $request->KodeGolongan, 'KodeGolItem' => $kode[$key] ],

                [
                  'NamaGolItem'   => $nama[$key],
                  'HargaGolItem'  => $harga[$key],
                  'created_at'    => \Carbon\Carbon::now(),
                  'updated_at'    => \Carbon\Carbon::now(),
                ]
              );
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update data golongan ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Data Golongan ' . $request->KodeGolongan . ' berhasil diperbarui';
        return redirect('/mastergolongan')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DB::table('golongans')
          ->where('KodeGolongan', $id)
          ->update([
            'Status'  => 'DEL'
          ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus data golongan ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Data Golongan ' . $request->KodeGolongan . ' telah dihapus';
        return redirect('/mastergolongan')->with(['deleted' => $pesan]);
    }

    public function apiOPN()
    {
        $golongan = DB::table('golongans')->where('Status', 'OPN')->get();
        // dd($golongan);

        return Datatables::of($golongan)
            ->addColumn('action', function ($golongan) {
                return
                    '<form style="display:inline-block;" type="submit" action="/mastergolongan/' . $golongan->KodeGolongan . '/edit" method="get">' .
                    '<button class="btn btn-primary btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/mastergolongan/delete/' . $golongan->KodeGolongan . '" method="get" onsubmit="return showConfirm()">' .
                    '<button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }
}
