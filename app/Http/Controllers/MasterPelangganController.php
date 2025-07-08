<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\pelanggan;
use DB;
use Datatables;

class MasterPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.pelanggan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_id = DB::select('SELECT * FROM pelanggans ORDER BY KodePelanggan DESC LIMIT 1');

        //Auto generate ID
        if ($last_id == null) {
            $newID = "PLG-001";
        } else {
            $string = $last_id[0]->KodePelanggan;
            $id = substr($string, -3, 3);
            $new = $id + 1;
            $new = str_pad($new, 3, '0', STR_PAD_LEFT);
            $newID = "PLG-" . $new;
        }

        return view('master.pelanggan.create', compact('newID'));
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
            'KodePelanggan' => 'required',
            'NamaPelanggan' => 'required',
            'Kontak' => 'required',
        ]);

        DB::table('pelanggans')->insert([
            'KodePelanggan' => $request->KodePelanggan,
            'NamaPelanggan' => $request->NamaPelanggan,
            'Kontak' => $request->Kontak,
            'NIK' => $request->NIK,
            'NPWP' => $request->NPWP,
            'KodeUser' => \Auth::user()->name,
            'Status' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah pelanggan ' . $request->KodePelanggan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $alamats = $request->alamat;
        $kotas = $request->kota;
        $noindeks = 0;

        foreach ($alamats as $key => $value) {
            $noindeks++;
            DB::table('alamatpelanggans')->insert([
                'KodePelanggan' => $request->KodePelanggan,
                'Alamat' => $alamats[$key],
                'Kota' => $kotas[$key],
                'NoIndeks' => $noindeks,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        $pesan = 'Pelanggan ' . $request->NamaPelanggan . ' berhasil ditambahkan';
        return redirect('/masterpelanggan')->with(['created' => $pesan]);
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
        $pelanggan = DB::table('pelanggans')->get()->where('KodePelanggan', $id);
        $alamats = DB::table('alamatpelanggans')->get()->where('KodePelanggan', $id);
        return view('master.pelanggan.edit', compact('pelanggan', 'alamats'));
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
            'KodePelanggan' => 'required',
            'NamaPelanggan' => 'required',
            'Kontak' => 'required',
        ]);

        DB::table('pelanggans')->where('KodePelanggan', $request->KodePelanggan)->update([
            'KodePelanggan' => $request->KodePelanggan,
            'NamaPelanggan' => $request->NamaPelanggan,
            'Kontak' => $request->Kontak,
            'NIK' => $request->NIK,
            'NPWP' => $request->NPWP,
            'KodeUser' => \Auth::user()->name,
            'Status' => 'OPN',
            'updated_at' => \Carbon\Carbon::now()
        ]);

        $alamats = $request->alamat;
        $kotas = $request->kota;
        $noindeks = 0;

        // foreach ($alamats as $key => $value) {
        //     $noindeks++;
        //     $checkalamat = DB::table('alamatpelanggans')->where('KodePelanggan', $request->KodePelanggan)->where('NoIndeks', $noindeks)->first();

        //     if (!empty($checkalamat)) {
        //         DB::table('alamatpelanggans')->where('KodePelanggan', $request->KodePelanggan)->where('NoIndeks', $noindeks)->update([
        //             'KodePelanggan' => $request->KodePelanggan,
        //             'Alamat' => $alamats[$key],
        //             'Kota' => $kotas[$key],
        //             'NoIndeks' => $noindeks,
        //             'updated_at' => \Carbon\Carbon::now()
        //         ]);
        //     } else {
        //         DB::table('alamatpelanggans')->insert([
        //             'KodePelanggan' => $request->KodePelanggan,
        //             'Alamat' => $alamats[$key],
        //             'Kota' => $kotas[$key],
        //             'NoIndeks' => $noindeks,
        //             'created_at' => \Carbon\Carbon::now(),
        //             'updated_at' => \Carbon\Carbon::now()
        //         ]);
        //     }
        // }

        DB::table('alamatpelanggans')->where('KodePelanggan', $request->KodePelanggan)->delete();

        foreach ($alamats as $key => $value) {
            $noindeks++;
            DB::table('alamatpelanggans')->insert([
                'KodePelanggan' => $request->KodePelanggan,
                'Alamat' => $alamats[$key],
                'Kota' => $kotas[$key],
                'NoIndeks' => $noindeks,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update pelanggan ' . $request->KodePelanggan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Pelanggan ' . $request->NamaPelanggan . ' berhasil diubah';
        return redirect('/masterpelanggan')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pelanggan = pelanggan::find($id);
        $pelanggan->Status = 'DEL';
        $pelanggan->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus pelanggan ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pelanggan = DB::table('pelanggans')->get()->where('KodePelanggan', $id);
        foreach ($pelanggan as $pel) {
            $pesan = 'pelanggan ' . $pel->NamaPelanggan . ' berhasil dihapus';
        }
        return redirect('/masterpelanggan')->with(['deleted' => $pesan]);
    }

    public function apiOPN()
    {
        $pelanggan = DB::table('pelanggans')
            ->where('Status', 'OPN')
            ->get();

        return Datatables::of($pelanggan)
            ->addColumn('action', function ($pelanggan) {
                return
                    '<form style="display:inline-block;" type="submit" action="/masterpelanggan/' . $pelanggan->KodePelanggan . '/edit" method="get">' .
                    '<button class="btn btn-primary btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/masterpelanggan/delete/' . $pelanggan->KodePelanggan . '" method="get" onsubmit="return showConfirm()">' .
                    '<button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }
}
