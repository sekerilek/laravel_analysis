<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\matauang;
use DB;
use Datatables;

class MasterMataUangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.matauang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.matauang.create');
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
            'KodeMataUang' => 'required',
            'NamaMataUang' => 'required',
            'Nilai' => 'required'
        ]);

        DB::table('matauangs')->insert([
            'KodeMataUang' => $request->KodeMataUang,
            'NamaMataUang' => $request->NamaMataUang,
            'Nilai' => $request->Nilai,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah mata uang ' . $request->KodeMataUang,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Mata Uang ' . $request->NamaMataUang . ' berhasil ditambahkan';
        return redirect('/mastermatauang')->with(['created' => $pesan]);
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
        $matauang = DB::table('matauangs')->get()->where('KodeMataUang', $id);
        return view('master.matauang.edit', ['matauang' => $matauang]);
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
            'KodeMataUang' => 'required',
            'NamaMataUang' => 'required',
            'Nilai' => 'required',
        ]);

        DB::table('matauangs')->where('KodeMataUang', $request->KodeMataUang)->update([
            'KodeMataUang' => $request->KodeMataUang,
            'NamaMataUang' => $request->NamaMataUang,
            'Nilai' => $request->Nilai,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update mata uang ' . $request->KodeMataUang,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Mata Uang ' . $request->NamaMataUang . ' berhasil diubah';
        return redirect('/mastermatauang')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $matauang = matauang::find($id);
        $matauang->Status = 'DEL';
        $matauang->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus mata uang ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $matauang = DB::table('matauangs')->get()->where('KodeMataUang', $id);
        foreach ($matauang as $kat) {
            $pesan = 'MataUang ' . $kat->NamaMataUang . ' berhasil dihapus';
        }
        return redirect('/mastermatauang')->with(['deleted' => $pesan]);
    }

    public function apiOPN()
    {
        $matauang = DB::table('matauangs')
            ->where('matauangs.Status', 'OPN')
            ->get();

        return Datatables::of($matauang)
            ->addColumn('action', function ($matauang) {
                return
                    '<form style="display:inline-block;" type="submit" action="/mastermatauang/' . $matauang->KodeMataUang . '/edit" method="get">' .
                    '<button class="btn btn-primary btn-xs" data-function="ubah"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/mastermatauang/delete/' . $matauang->KodeMataUang . '" method="get" onsubmit="return showConfirm()">' .
                    '<button class="btn btn-danger btn-xs" data-function="hapus"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }
}
