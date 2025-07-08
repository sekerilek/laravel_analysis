<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('payroll.absensi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payroll.absensi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('absensis')->insert([
            "KodeKaryawan"      => $request->kode,
            "TanggalAbsen"      => $request->tanggal,
            "WaktuAbsen"      => $request->waktu,
            "StatusAbsen"       => $request->status,
            "created_at"        => \Carbon\Carbon::now(),
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Karyawan ' . $request->KodeKaryawan . ' ' . $request->status,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = array(
            "message"   => 'data absen karyawan '.$request->kode.' telah disimpan',
        );

        return response()->json($pesan);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        
    }

    /**
     * Show the form for history.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $absen = DB::table('absensis')
            ->join('karyawans', 'absensis.KodeKaryawan', '=', 'karyawans.KodeKaryawan')
            ->select('absensis.TanggalAbsen', 'absensis.KodeKaryawan', 'karyawans.Nama', 'absensis.StatusAbsen', 'absensis.WaktuAbsen')
            ->get();

        // echo($absen);
        return view('payroll.absensi.history', compact('absen'));
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
    }

    public function dataAbsen($id) {
        $absen = DB::select("
            SELECT *
            FROM absensis
            INNER JOIN karyawans ON absensis.KodeKaryawan = karyawans.KodeKaryawan
            WHERE TanggalAbsen = '". date('Y-m-d') ."'
            AND absensis.KodeKaryawan = '".$id."'
            ORDER BY StatusAbsen DESC
            LIMIT 1
        ");

        if ($absen != null) {
            $res = array();
            foreach ($absen as $value) {
                if ($value->StatusAbsen == 'IN') {
                    $hari       = date('N');
                    $waktu      = date('H:i:s');
                    if ($hari == '6' || $hari == '7') {
                        $batas = strtotime('12:00:00');
                        $status     = (strtotime($waktu) >= $batas) ? 'OUT' : 'IN';
                    }
                    else {
                        $batas = strtotime('15:00:00');
                        $status     = (strtotime($waktu) >= $batas) ? 'OUT' : 'IN';
                    }

                    if ($status == 'IN') {
                        $res = array([
                            "warning"       => 'true',
                            "message"       => 'Karyawan '.$value->KodeKaryawan.' sudah absen MASUK',
                        ]);
                    }
                    else {
                        $res = array([
                            "KodeKaryawan"      => $id,
                            "Nama"              => $value->Nama,
                            "StatusAbsen"       => 'OUT',
                            "TanggalAbsen"      => date('Y-m-d'),
                            "WaktuAbsen"        => date('H:i:s'),
                            "warning"           => 'false',
                        ]);
                    }
                }
                else {
                    $res = array([
                        "warning"       => 'true',
                        "message"       => 'Karyawan '.$value->KodeKaryawan.' sudah absen KELUAR',
                    ]);
                }
            }
            return response()->json($res);
        }
        else {
            $hari       = date('N');
            $tanggal    = date('Y-m-d');
            $waktu      = date('H:i:s');
            if ($hari == '6' || $hari == '7') {
                $batas = strtotime('12:00:00');
                $status     = (strtotime($waktu) >= $batas) ? 'OUT' : 'IN';
            }
            else {
                $batas = strtotime('15:00:00');
                $status     = (strtotime($waktu) >= $batas) ? 'OUT' : 'IN';
            }

            $res = array();
            $karyawan = DB::table('karyawans')
                ->where('KodeKaryawan', $id)
                ->get();

            foreach ($karyawan as $data) {
                $res = array([
                    "KodeKaryawan"      => $id,
                    "Nama"              => $data->Nama,
                    "StatusAbsen"       => $status,
                    "TanggalAbsen"      => $tanggal,
                    "WaktuAbsen"      	=> $waktu,
                    "warning"           => 'false',
                ]);
            }
            return response()->json($res);
        }
    }
}
