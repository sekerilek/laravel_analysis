<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\karyawan;
use DB;
use Datatables;
use PDF;
use PhpParser\Node\Expr\Cast\Double;

class MasterKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('master.karyawan.index');
        $karyawan   = DB::table('karyawans')->where('Status', 'OPN')->get();
        return view('master.karyawan.index', compact('karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_id = DB::select('SELECT * FROM karyawans WHERE Status = "OPN" ORDER BY KodeKaryawan DESC LIMIT 1');
        $golongan = DB::table('golongans')->get();

        //Auto generate ID
        if ($last_id == null) {
            $newID = "KAR-001";
        } else {
            $string = $last_id[0]->KodeKaryawan;
            $id = substr($string, 4, 3);
            $new = $id + 1;
            $new = str_pad($new, 3, '0', STR_PAD_LEFT);
            $newID = "KAR-" . $new;
        }

        $jabatan = DB::table('jabatans')
            ->where('Status', 'OPN')
            ->get();

        return view('master.karyawan.create', compact('newID', 'golongan', 'jabatan'));
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
            'KodeKaryawan' => 'required',
            'Nama' => 'required',
            'Alamat' => 'required',
            'Jabatan' => 'required',
        ]);

        DB::table('karyawans')->insert([
            'KodeKaryawan' => $request->KodeKaryawan,
            'Nama' => $request->Nama,
            'Alamat' => $request->Alamat,
            'Kota' => $request->Kota,
            'Telepon' => $request->Telepon,
            'JenisKelamin' => $request->JenisKelamin,
            'GajiPokok' => $request->GajiPokok,
            'KodeUser' => \Auth::user()->name,
            'Status' => 'OPN',
            'KodeJabatan' => $request->Jabatan,
            'KodeGolongan' => $request->Golongan,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        if ($request->Jabatan == 'Driver') {
            $last_driver = DB::select('SELECT * FROM drivers WHERE Status = "OPN" ORDER BY KodeDriver DESC LIMIT 1');
            //Auto generate ID
            if ($last_driver == null) {
                $newIDDriver = "DRV-001";
            } else {
                $string = $last_driver[0]->KodeDriver;
                $id = substr($string, 4, 3);
                $new = $id + 1;
                $new = str_pad($new, 3, '0', STR_PAD_LEFT);
                $newIDDriver = "DRV-" . $new;
            }

            DB::table('drivers')->insert([
                'KodeDriver'    => $newIDDriver,
                'NamaDriver'    => $request->Nama,
                'Kontak'        => $request->Telepon,
                'Status'        => 'OPN',
                'KodeKaryawan'  => $request->KodeKaryawan,
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now(),
            ]);
        }

        if ($request->Jabatan == 'Sales') {
            $last_sales = DB::select('SELECT * FROM sales WHERE Status = "OPN" ORDER BY KodeSales DESC LIMIT 1');
            //Auto generate ID
            if ($last_sales == null) {
                $newIDSales = "SAL-001";
            } else {
                $string = $last_sales[0]->KodeSales;
                $id = substr($string, 4, 3);
                $new = $id + 1;
                $new = str_pad($new, 3, '0', STR_PAD_LEFT);
                $newIDSales = "SAL-" . $new;
            }

            DB::table('sales')->insert([
                'KodeSales'     => $newIDSales,
                'NamaSales'     => $request->Nama,
                'Kontak'        => $request->Telepon,
                'Status'        => 'OPN',
                'KodeKaryawan'  => $request->KodeKaryawan,
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now(),
            ]);
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah karyawan ' . $request->KodeKaryawan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Karyawan ' . $request->Nama . ' berhasil ditambahkan';
        return redirect('/masterkaryawan')->with(['created' => $pesan]);
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
        $karyawan = DB::table('karyawans')
        	->where('KodeKaryawan',$id)
            ->where('Status', 'OPN')
        	->get();
        
        $golongan = DB::table('golongans')->get();

        $jabatan = DB::table('jabatans')
            ->where('Status','OPN')
            ->get();

        return view('master.karyawan.edit', compact('karyawan', 'golongan', 'jabatan'));
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
            'KodeKaryawan' => 'required',
            'Nama' => 'required',
            'Alamat' => 'required',
            'Jabatan' => 'required',
        ]);

        DB::table('karyawans')->where('KodeKaryawan', $request->KodeKaryawan)->update([
            'KodeKaryawan' => $request->KodeKaryawan,
            'Nama' => $request->Nama,
            'Alamat' => $request->Alamat,
            'Kota' => $request->Kota,
            'Telepon' => $request->Telepon,
            'GajiPokok' => $request->GajiPokok,
            'KodeUser' => \Auth::user()->name,
            'Status' => 'OPN',
            'KodeJabatan' => $request->Jabatan,
            'KodeGolongan' => $request->Golongan,
            'JenisKelamin' => $request->JenisKelamin,
            'updated_at' => \Carbon\Carbon::now()
        ]);

        if ($request->Jabatan == 'Driver') {
            DB::table('drivers')
            ->where('KodeDriver', 'DRV-'.substr($request->KodeKaryawan, 4, 3))
            ->update([
                'NamaDriver'    => $request->Nama,
                'Kontak'        => $request->Telepon,
                'Status'        => 'OPN',
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        if ($request->Jabatan == 'Sales') {
            DB::table('sales')
            ->where('KodeSales', 'SAL-'.substr($request->KodeKaryawan, 4, 3))
            ->update([
                'NamaSales'    => $request->Nama,
                'Kontak'        => $request->Telepon,
                'Status'        => 'OPN',
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update karyawan ' . $request->KodeKaryawan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Karyawan ' . $request->Nama . ' berhasil diubah';
        return redirect('/masterkaryawan')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $karyawan = karyawan::where('Status', 'OPN')->find($id);
        $karyawan->Status = 'DEL';

        if ($karyawan->KodeJabatan == 'Driver') {
            DB::table('drivers')
            ->where('KodeDriver', 'DRV-'.substr($karyawan->KodeKaryawan, 4, 3))
            ->update([
                'Status'        => 'DEL',
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        if ($karyawan->KodeJabatan == 'Sales') {
            DB::table('sales')
            ->where('KodeSales', 'SAL-'.substr($karyawan->KodeKaryawan, 4, 3))
            ->update([
                'Status'        => 'DEL',
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        $karyawan->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus karyawan ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $karyawan = DB::table('karyawans')->get()->where('KodeKaryawan', $id);
        foreach ($karyawan as $kar) {
            $pesan = 'karyawan ' . $kar->Nama . ' berhasil dihapus';
        }
        return redirect('/masterkaryawan')->with(['deleted' => $pesan]);
    }
    
    public function print($id) {
    	$data      = DB::table('karyawans')->where('KodeKaryawan', $id)->get();
    	$pdf       = PDF::loadview('master.karyawan.membercard', compact('data'));
    	
        foreach ($data as $value) {
            return $pdf->download('Kartu Karyawan '.$value->Nama.'.pdf');
        }
        // return view('master.karyawan.membercard', compact('data'));
    }

    public function apiOPN()
    {
        $karyawan = DB::table('karyawans')
            ->where('Status', 'OPN')
            ->get();

        return Datatables::of($karyawan)
            ->addColumn('action', function ($karyawan) {
                return
                    '<form style="display:inline-block;" type="submit" action="/masterkaryawan/' . $karyawan->KodeKaryawan . '/edit" method="get">' .
                    '<button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>&nbsp;Ubah</button></form>' .

                    '<form style="display:inline-block;" action="/masterkaryawan/delete/' . $karyawan->KodeKaryawan . '" method="get" onsubmit="return showConfirm()">' .
                    '<button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;Hapus</button></form>';
            })
            ->make(true);
    }
}
