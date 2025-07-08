<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $year_now = date('Y');
        $list_karyawan = DB::table('karyawans')
            ->where('Status','OPN')
            ->get();
        return view('payroll.gaji.index', compact('year_now','list_karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data_golongan = DB::table('golongans')->where('Status', 'OPN')->get();
        return view('payroll.gaji.create', compact('data_golongan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //simpan data gaji pokok ke tabel `gajians`
        DB::table('gajians')->insert([
            'KodeGaji'          =>  'GAJI-'.substr($request->KodeKaryawan, 4).'-'.str_replace('-', '',$request->TanggalGajian),
            'KodeKaryawan'      =>  $request->KodeKaryawan,
            'TotalHariKerja'    =>  $request->HariKerja,
            'SubtotalGaji'      =>  $request->SubtotalGajiPokok,
            'Bonus'             =>  $request->BonusKaryawan,
            'TotalGaji'         =>  $request->TotalGajiKaryawan,
            'TanggalGaji'       =>  $request->TanggalGajian,
            'Status'            =>  'OPN',
            'created_at'        =>  \Carbon\Carbon::now(),
            'updated_at'        =>  \Carbon\Carbon::now(), 
        ]);

		//simpan detail gaji (data item yang dikerjakan + tambahan lainnya) ke tabel `detailgajians`
        $item = $request->item;
        $harga = $request->harga;
        $qty = $request->qty;
        $price = $request->price;
        foreach ($item as $key => $value) {
            # code...
            DB::table('detailgajians')->insert([
                'KodeGaji'                  =>  'GAJI-'.substr($request->KodeKaryawan, 4).'-'.str_replace('-', '',$request->TanggalGajian),
                'KodeGolItem'               =>  $item[$key],
                'HargaItem'                 =>  $harga[$key],
                'QtyItem'                   =>  $qty[$key],
                'SubtotalItem'              =>  $price[$key],
                'created_at'                =>  \Carbon\Carbon::now(),
                'updated_at'                =>  \Carbon\Carbon::now(),
            ]);
        }


        // `tambahangajians`
        $tag_lembur                 = $request->tag_lembur;
        $nominal_lembur             = $request->nominal;
        $qty_lembur                 = $request->qty_lembur;
        $subtotal_lembur            = $request->subtotal_lembur;
        foreach ($tag_lembur as $key => $value) {
            DB::table('tambahangajians')->insert([
                'KodeGaji'                  =>  'GAJI-'.substr($request->KodeKaryawan, 4).'-'.str_replace('-', '',$request->TanggalGajian),
                'KodeKaryawan'              =>  $request->KodeKaryawan,
                'KeteranganTambahan'        =>  $tag_lembur[$key],
                'Nominal'                   =>  $nominal_lembur[$key],
                'QtyTambahan'               =>  $qty_lembur[$key],
                'SubtotalTambahan'          =>  $subtotal_lembur[$key],
                'created_at'                =>  \Carbon\Carbon::now(),
                'updated_at'                =>  \Carbon\Carbon::now(),
            ]);
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah data gaji karyawan' . $request->KodeKaryawan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Data Gaji Karyawan ' . $request->KodeKaryawan . ' berhasil ditambahkan';
        return redirect('/gaji')->with(['created' => $pesan]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $year_now = date('Y');
        $list_karyawan = DB::table('karyawans')
            ->where('Status','OPN')
            ->get();

        $gaji = DB::table('gajians')
            ->join('karyawans', 'gajians.KodeKaryawan', '=', 'karyawans.KodeKaryawan')
            ->whereRaw('karyawans.Status="OPN" AND gajians.Status = "OPN" AND YEAR(gajians.TanggalGaji) = "'.date('Y').'"')
            ->orderBy('gajians.TanggalGaji', 'DESC')
            ->get();

        return view('payroll.gaji.show', compact('gaji', 'year_now', 'list_karyawan'));
    }

    /**
     * Filter gaji berdasarkan kodekaryawan, tahun, bulan
     */
    public function filter(Request $request) {
        $year_now = date('Y');
        $list_karyawan = DB::table('karyawans')
            ->where('Status','OPN')
            ->get();

        $karyawan   = $request->karyawan;
        $tahun      = $request->tahun;
        $bulan      = $request->bulan;

        if ($karyawan == 'KAR-000') {
            if ($bulan == '0') {
                $gaji = DB::table('gajians')
                    ->join('karyawans', 'gajians.KodeKaryawan', '=', 'karyawans.KodeKaryawan')
                    ->whereRaw('gajians.Status = "OPN" AND YEAR(gajians.TanggalGaji) = "'.$tahun.'"')
                    ->orderBy('gajians.TanggalGaji', 'DESC')
                    ->get();
            }
            else {
                $gaji = DB::table('gajians')
                    ->join('karyawans', 'gajians.KodeKaryawan', '=', 'karyawans.KodeKaryawan')
                    ->whereRaw('gajians.Status = "OPN" AND YEAR(gajians.TanggalGaji) = "'.$tahun.'" AND MONTH(gajians.TanggalGaji) = "'.$bulan.'"')
                    ->orderBy('gajians.TanggalGaji', 'DESC')
                    ->get();
            }
        }
        else {
            if ($bulan == '0') {
                $gaji = DB::table('gajians')
                    ->join('karyawans', 'gajians.KodeKaryawan', '=', 'karyawans.KodeKaryawan')
                    ->whereRaw('gajians.Status = "OPN" AND YEAR(gajians.TanggalGaji) = "'.$tahun.'" AND gajians.KodeKaryawan = "'.$karyawan.'"')
                    ->orderBy('gajians.TanggalGaji', 'DESC')
                    ->get();
            }
            else {
                $gaji = DB::table('gajians')
                    ->join('karyawans', 'gajians.KodeKaryawan', '=', 'karyawans.KodeKaryawan')
                    ->whereRaw('gajians.Status = "OPN" AND YEAR(gajians.TanggalGaji) = "'.$tahun.'" AND MONTH(gajians.TanggalGaji) = "'.$bulan.'" AND gajians.KodeKaryawan = "'.$karyawan.'"')
                    ->orderBy('gajians.TanggalGaji', 'DESC')
                    ->get();
            }
        }

        return view('payroll.gaji.show', compact('gaji', 'year_now', 'list_karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gaji = DB::select("
                SELECT * FROM gajians g
                INNER JOIN karyawans k ON g.KodeKaryawan = k.KodeKaryawan
                INNER JOIN golongans gl ON k.KodeGolongan = gl.KodeGolongan
                WHERE g.KodeGaji = '".$id."'
                AND k.Status = 'OPN'
            ");

        $detailgaji = DB::select("
                SELECT * FROM detailgajians
                INNER JOIN detailgolongans ON detailgajians.KodeGolItem = detailgolongans.KodeGolItem
                WHERE KodeGaji = '".$id."'
            ");

        $hariangaji = DB::select("
                SELECT * FROM tambahangajians
                WHERE KodeGaji = '".$id."'
                AND KeteranganTambahan = 'Lembur Harian'
            ");

        $jamgaji = DB::select("
                SELECT * FROM tambahangajians
                WHERE KodeGaji = '".$id."'
                AND KeteranganTambahan = 'Lembur Jam'
            ");

        $minggugaji = DB::select("
                SELECT * FROM tambahangajians
                WHERE KodeGaji = '".$id."'
                AND KeteranganTambahan = 'Lembur Minggu'
            ");

        $bonusgaji = DB::select("
                SELECT * FROM tambahangajians
                WHERE KodeGaji = '".$id."'
                AND KeteranganTambahan = 'Bonus Karyawan'
            ");

        $totalItem = 0;
        foreach ($detailgaji as $detail) {
            $totalItem++;
        }
        
        return view('payroll.gaji.edit', compact('id', 'gaji', 'detailgaji', 'hariangaji', 'jamgaji', 'minggugaji', 'bonusgaji', 'totalItem'));
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
        //update data gaji pokok ke tabel `gajians`
        DB::table('gajians')
            ->where('KodeGaji', $id)
            ->update([
                'TotalHariKerja'    =>  $request->HariKerja,
                'SubtotalGaji'      =>  $request->SubtotalGajiPokok,
                'Bonus'             =>  $request->BonusKaryawan,
                'TotalGaji'         =>  $request->TotalGajiKaryawan,
                'updated_at'        =>  \Carbon\Carbon::now(), 
            ]);

        //update detail gaji (data item yang dikerjakan + tambahan lainnya) ke tabel `detailgajians`
        $item       = $request->item;
        $harga      = $request->harga;
        $qty        = $request->qty;
        $price      = $request->price;
        foreach ($item as $key => $value) {
            DB::table('detailgajians')
                ->where('KodeGaji', $id)
                ->where('KodeGolItem', $item[$key])
                ->update([
                    'HargaItem'                 =>  $harga[$key],
                    'QtyItem'                   =>  $qty[$key],
                    'SubtotalItem'              =>  $price[$key],
                    'updated_at'                =>  \Carbon\Carbon::now(),
                ]);
        }

        // `tambahangajians`
        $tag_lembur                 = $request->tag_lembur;
        $nominal_lembur             = $request->nominal;
        $qty_lembur                 = $request->qty_lembur;
        $subtotal_lembur            = $request->subtotal_lembur;
        foreach ($tag_lembur as $key => $value) {
            DB::table('tambahangajians')
                ->where('KodeGaji', $id)
                ->where('KeteranganTambahan', $tag_lembur[$key])
                ->update([
                'Nominal'                   =>  $nominal_lembur[$key],
                'QtyTambahan'               =>  $qty_lembur[$key],
                'SubtotalTambahan'          =>  $subtotal_lembur[$key],
                'updated_at'                =>  \Carbon\Carbon::now(),
            ]);
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update data gaji ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Data Gaji Karyawan ' . $request->KodeKaryawan . ' berhasil diperbarui';
        return redirect('/gaji/show')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('gajians')
            ->where('KodeGaji', $id)
            ->update([
                'Status'        =>  'DEL'
            ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus data gaji ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Data gaji ' . $id . ' berhasil dihapus';
        return redirect('/gaji/show')->with(['deleted' => $pesan]);
    }

    /* filter nama karyawan berdasarkan kode Golongan */
    public function filterByGolongan($kode) {
        $karyawan = DB::table('karyawans')
            ->join('golongans', function ($join) {
                    $join->on('karyawans.KodeGolongan', '=', 'golongans.KodeGolongan');
                })
            ->where('karyawans.KodeGolongan', $kode)
            ->where('karyawans.Status', 'OPN')
            ->get();

        $res = json_decode($karyawan, true);
        if ($res != null) {
            return response()->json($res);
        } else {
            return response()->json([]);
        }
    }

    /* Search data karyawan berdasarkan kode karyawan */
    public function searchByKode($kode) {
        $karyawan = DB::table('karyawans')
            ->join('golongans', function ($join) {
                    $join->on('karyawans.KodeGolongan', '=', 'golongans.KodeGolongan');
                })
            ->where('KodeKaryawan', $kode)
            ->where('karyawans.Status', 'OPN')
            ->get();

        // $absen_masuk = DB::table('absensis')
        //     ->selectRaw('COUNT(*) as total_absen_masuk')
        //     ->where('KodeKaryawan', $kode)
        //     ->where('StatusAbsen', 'IN')
        //     ->whereRaw('TanggalAbsen BETWEEN date_sub(NOW(), INTERVAL 5 day) AND NOW()')
        //     ->get();

        // $absen_keluar = DB::table('absensis')
        //     ->selectRaw('COUNT(*) as total_absen_keluar')
        //     ->where('KodeKaryawan', $kode)
        //     ->where('StatusAbsen', 'OUT')
        //     ->whereRaw('TanggalAbsen BETWEEN date_sub(NOW(), INTERVAL 5 day) AND NOW()')
        //     ->get();

        $lembur_masuk = DB::table('absensis')
            ->selectRaw('COUNT(*) as lembur_masuk')
            ->where('KodeKaryawan', $kode)
            ->where('StatusAbsen', 'IN')
            ->whereRaw('TanggalAbsen = date_sub(NOW(), INTERVAL 6 day)')
            ->get();

        $lembur_keluar = DB::table('absensis')
            ->selectRaw('COUNT(*) as lembur_keluar')
            ->where('KodeKaryawan', $kode)
            ->where('StatusAbsen', 'OUT')
            ->whereRaw('TanggalAbsen = date_sub(NOW(), INTERVAL 6 day)')
            ->get();

        $arr = json_decode($karyawan, true);
        // $abs_masuk = json_decode($absen_masuk, true);
        // $abs_keluar = json_decode($absen_keluar, true);
        $lmb_masuk = json_decode($lembur_masuk, true);
        $lmb_keluar = json_decode($lembur_keluar, true);
        // $res = array(array_merge($arr[0], $abs_masuk[0], $abs_keluar[0], $lmb_masuk[0], $lmb_keluar[0]));
        $res = array(array_merge($arr[0], $lmb_masuk[0], $lmb_keluar[0]));

        if ($res != null) {
            return response()->json($res);
        } else {
            return response()->json([]);
        }
    }

    public function searchItemByKode($kodegol) {
        $detail_item = DB::table('detailgolongans')
            ->where('KodeGolongan', $kodegol)
            ->get();
        if ($detail_item != null) {
            return response()->json($detail_item);
        } else {
            return response()->json([]);
        }
    }
}
