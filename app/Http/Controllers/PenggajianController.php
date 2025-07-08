<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;

class PenggajianController extends Controller
{
    public function index()
    {
    	$list_golongan = DB::table('golongans')
            ->where('Status','OPN')
            ->get();
    	// return view('penggajian.index2', compact('list_golongan'));
        return view('penggajian.index', compact('list_golongan'));
    }

    /*fungsi-fungsi untuk absen*/
    public function absensi()
    {
        $daftarGolongan     = DB::table('golongans')
                            ->select('KodeGolongan', 'NamaGolongan')
                            ->where('Status', 'OPN')
                            ->get();
        return view('penggajian.absensi', compact('daftarGolongan'));
    }

    public function absensiSimpan(Request $request) {
    	$awal       = date_format(date_create($request->tanggalAbsen1), 'Y-m-d');
        $akhir      = date_format(date_create($request->tanggalAbsen2), 'Y-m-d');
        $status     = $request->statusAbsen;
        $jumlah     = $request->jumlahKaryawan;
        $karyawan   = $request->kodeKaryawan;
        $namaGolongan   = $request->namaGolongan;

        $tgl1       = substr($awal, -2);
        $tgl2       = substr($akhir, -2);
        $bulan      = substr($awal, 5, 2);
        $tahun      = substr($awal, 0, 4);

        // dd($request->tanggalAbsen1);

        foreach ($karyawan as $key => $value) {
            $x = 0;
            for ($i=$tgl1; $i <= $tgl2 ; $i++) { 
                $tanggalAbsen = date_create($tahun.'-'.$bulan.'-'.$i);
                DB::table('absensis')
                ->updateOrInsert([
                    "KodeKaryawan"      => $karyawan[$key],
                    "TanggalAbsen"      => $tanggalAbsen,
                ], [
                    "StatusAbsen"       => $status[$key][$x],
                    "created_at"        => date('Y-m-d H:i:s'),
                ]);
                $x++;
            }
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Absensi tanggal ' . $awal . ' s/d ' . $akhir . ' golongan ' . $namaGolongan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

    	return redirect('/penggajian')->with(['created' => 'Absensi tanggal ' . $awal . ' s/d ' . $akhir . ' golongan ' . $namaGolongan.' berhasil diinput']);
    }

    /*fungsi-fungsi untuk gaji*/
    public function gaji() {
    	$daftarGolongan 	= DB::table('golongans')->where('Status', 'OPN')->get();
    	//return view('penggajian.gaji', compact('daftarGolongan'));
        return view('penggajian.gaji', compact('daftarGolongan'));
    }

    public function gajiSimpan(Request $request) {
        $namaKaryawan           = $request->namaKaryawan;
        $kodeKaryawan           = $request->kodeKaryawan;
        $gajiKaryawan           = $request->gajiKaryawan;
        $jumlahHariKerja        = $request->jumlahHariKerja;
        $subtotalGaji           = $request->subtotalGaji;
        $lemburHarian           = $request->lemburHarian;
        $jumlahLemburHarian     = $request->jumlahLemburHarian;
        $subtotalLemburHarian   = $request->subtotalLemburHarian;
        $subtotalLemburMinggu   = $request->subtotalLemburMinggu;
        $lemburJam              = $request->lemburJam;
        $jumlahLemburJam        = $request->jumlahLemburJam;
        $subtotalLemburJam      = $request->subtotalLemburJam;
        $subtotalHargaBarang    = $request->subtotalHargaBarang;
        $bonus                  = $request->bonus;
        $jumlahBonus            = $request->jumlahBonus;
        $subtotalBonus          = $request->subtotalBonus;
        $totalGaji              = $request->totalGaji;
        
        $jumlahBarang           = $request->jumlahBarang;
        $kodeBarang             = $request->kodeBarang;
        $hargaBarang            = $request->hargaBarang;
        for ($i=0; $i < $jumlahBarang; $i++) { 
            $barangKaryawan[$i] = $request->barangKaryawan[$i+1];
        }

        foreach ($namaKaryawan as $key => $value) {
            DB::table('gajians')
            ->updateOrInsert([
                'KodeGaji'                  => 'GAJI'.str_replace('-', '', $request->tanggalGaji).'-'.substr($kodeKaryawan[$key], -3),
                'TanggalGaji'               => date('Y-m-d', strtotime($request->tanggalGaji)),
            ], [
                'KodeKaryawan'              => $kodeKaryawan[$key],
                'NamaKaryawan'              => $namaKaryawan[$key],
                'SubtotalGaji'              => $subtotalGaji[$key],
                'SubtotalLemburHarian'      => $subtotalLemburHarian[$key],
                'SubtotalLemburJam'         => $subtotalLemburJam[$key],
                'SubtotalLemburMinggu'      => $subtotalLemburMinggu[$key],
                'SubtotalBonus'             => $subtotalBonus[$key],
                'SubtotalHargaBarang'       => $subtotalHargaBarang[$key],
                'TotalGaji'                 => $totalGaji[$key],
                'Status'                    => 'OPN',
                'EnkripsiKodeGaji'          => md5('GAJI'.str_replace('-', '', $request->tanggalGaji).'-'.substr($kodeKaryawan[$key], -3)),
                'updated_at'                => date('Y-m-d H:i:s'),
            ]);

            for ($i=0; $i < $jumlahBarang; $i++) { 
                DB::table('detailgajians')
                ->updateOrInsert([
                    'KodeGaji'                  => 'GAJI'.str_replace('-', '', $request->tanggalGaji).'-'.substr($kodeKaryawan[$key], -3),
                    'KodeBarang'                => $kodeBarang[$i],
                ], [
                    'HargaBarang'               => $hargaBarang[$i],
                    'JumlahBarang'              => $barangKaryawan[$i][$key],
                    'SubtotalHargaBarang'       => (int)$hargaBarang[$i] * (int)$barangKaryawan[$i][$key],
                    'EnkripsiKodeGaji'          => md5('GAJI'.str_replace('-', '', $request->tanggalGaji).'-'.substr($kodeKaryawan[$key], -3)),
                    'updated_at'                => date('Y-m-d H:i:s'),
                ]);
            }

            DB::table('tambahangajians')
            ->updateOrInsert([
                'KodeGaji'                  => 'GAJI'.str_replace('-', '', $request->tanggalGaji).'-'.substr($kodeKaryawan[$key], -3),
            ], [
                'Gaji'                      => $gajiKaryawan[$key],
                'JumlahHariKerja'           => $jumlahHariKerja[$key],
                'LemburHarian'              => $lemburHarian[$key],
                'JumlahLemburHarian'        => $jumlahLemburHarian[$key],
                'LemburJam'                 => $lemburJam[$key],
                'JumlahLemburJam'           => $jumlahLemburJam[$key],
                'Bonus'                     => $bonus[$key],
                'JumlahBonus'               => $jumlahBonus[$key],
                'EnkripsiKodeGaji'          => md5('GAJI'.str_replace('-', '', $request->tanggalGaji).'-'.substr($kodeKaryawan[$key], -3)),
                'updated_at'                => date('Y-m-d H:i:s'),
            ]);
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Gaji tanggal ' . $request->tanggalGaji . ' untuk golongan ' . $request->golonganKaryawan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return redirect('/penggajian')->with(['created' => 'Gaji tanggal ' . $request->tanggalGaji . ' untuk golongan ' . $request->golonganKaryawan . ' berhasil dibuat']);
    }

    public function gajiSimpanDev(Request $request) {
        $tanggalGaji            = $request->tanggalGaji;
        $namaKaryawan           = $request->namaKaryawan;
        $kodeKaryawan           = $request->kodeKaryawan;
        $gajiKaryawan           = $request->gajiKaryawan;
        $jumlahHariKerja        = $request->jumlahHariKerja;
        $subtotalGaji           = $request->subtotalGaji;
        $lemburHarian           = $request->lemburHarian;
        $jumlahLemburHarian     = $request->jumlahLemburHarian;
        $subtotalLemburHarian   = $request->subtotalLemburHarian;
        $subtotalLemburMinggu   = $request->subtotalLemburMinggu;
        $lemburJam              = $request->lemburJam;
        $jumlahLemburJam        = $request->jumlahLemburJam;
        $subtotalLemburJam      = $request->subtotalLemburJam;
        $subtotalHargaBarang    = $request->subtotalHargaBarang;
        $bonus                  = $request->bonus;
        $jumlahBonus            = $request->jumlahBonus;
        $subtotalBonus          = $request->subtotalBonus;
        $totalGaji              = $request->totalGaji;
        
        $jumlahBarang           = $request->jumlahBarang;
        $kodeBarang             = $request->kodeBarang;
        $hargaBarang            = $request->hargaBarang;
        for ($i=0; $i < $jumlahBarang; $i++) { 
            $barangKaryawan[$i] = $request->barangKaryawan[$i+1];
        }

        $status = $request->statusDataGaji;

        foreach ($namaKaryawan as $key => $value) {
            if ($status == 'insert') {
                DB::table('gajians')
                ->insert([
                    'KodeGaji'                  => 'GAJI'.str_replace('-', '', $tanggalGaji).'-'.substr($kodeKaryawan[$key], -3),
                    'TanggalGaji'               => date('Y-m-d', strtotime($tanggalGaji)),
                    'KodeKaryawan'              => $kodeKaryawan[$key],
                    'NamaKaryawan'              => $namaKaryawan[$key],
                    'SubtotalGaji'              => $subtotalGaji[$key],
                    'SubtotalLemburHarian'      => $subtotalLemburHarian[$key],
                    'SubtotalLemburJam'         => $subtotalLemburJam[$key],
                    'SubtotalLemburMinggu'      => $subtotalLemburMinggu[$key],
                    'SubtotalBonus'             => $subtotalBonus[$key],
                    'SubtotalHargaBarang'       => $subtotalHargaBarang[$key],
                    'TotalGaji'                 => $totalGaji[$key],
                    'Status'                    => 'OPN',
                    'EnkripsiKodeGaji'          => md5('GAJI'.str_replace('-', '', $tanggalGaji).'-'.substr($kodeKaryawan[$key], -3)),
                    'created_at'                => date('Y-m-d H:i:s'),
                    'updated_at'                => date('Y-m-d H:i:s'),
                ]);

                DB::table('tambahangajians')
                ->insert([
                    'KodeGaji'                  => 'GAJI'.str_replace('-', '', $tanggalGaji).'-'.substr($kodeKaryawan[$key], -3),
                    'Gaji'                      => $gajiKaryawan[$key],
                    'JumlahHariKerja'           => $jumlahHariKerja[$key],
                    'LemburHarian'              => $lemburHarian[$key],
                    'JumlahLemburHarian'        => $jumlahLemburHarian[$key],
                    'LemburJam'                 => $lemburJam[$key],
                    'JumlahLemburJam'           => $jumlahLemburJam[$key],
                    'Bonus'                     => $bonus[$key],
                    'JumlahBonus'               => $jumlahBonus[$key],
                    'EnkripsiKodeGaji'          => md5('GAJI'.str_replace('-', '', $tanggalGaji).'-'.substr($kodeKaryawan[$key], -3)),
                    'created_at'                => date('Y-m-d H:i:s'),
                    'updated_at'                => date('Y-m-d H:i:s'),
                ]);

                for ($i=0; $i < $jumlahBarang; $i++) { 
                    DB::table('detailgajians')
                    ->insert([
                        'KodeGaji'                  => 'GAJI'.str_replace('-', '', $tanggalGaji).'-'.substr($kodeKaryawan[$key], -3),
                        'KodeBarang'                => $kodeBarang[$i],
                        'HargaBarang'               => $hargaBarang[$i],
                        'JumlahBarang'              => $barangKaryawan[$i][$key],
                        'SubtotalHargaBarang'       => (int)$hargaBarang[$i] * (int)$barangKaryawan[$i][$key],
                        'EnkripsiKodeGaji'          => md5('GAJI'.str_replace('-', '', $tanggalGaji).'-'.substr($kodeKaryawan[$key], -3)),
                        'created_at'                => date('Y-m-d H:i:s'),
                        'updated_at'                => date('Y-m-d H:i:s'),
                    ]);
                }
            }
            else {
                DB::table('gajians')
                ->where([
                    ['TanggalGaji', date('Y-m-d', strtotime($tanggalGaji))],
                    ['KodeKaryawan', $kodeKaryawan],
                ])
                ->update([
                    'NamaKaryawan'              => $namaKaryawan[$key],
                    'SubtotalGaji'              => $subtotalGaji[$key],
                    'SubtotalLemburHarian'      => $subtotalLemburHarian[$key],
                    'SubtotalLemburJam'         => $subtotalLemburJam[$key],
                    'SubtotalLemburMinggu'      => $subtotalLemburMinggu[$key],
                    'SubtotalBonus'             => $subtotalBonus[$key],
                    'SubtotalHargaBarang'       => $subtotalHargaBarang[$key],
                    'TotalGaji'                 => $totalGaji[$key],
                    'updated_at'                => date('Y-m-d H:i:s'),
                ]);

                DB::table('tambahangajians')
                ->where('KodeGaji', 'GAJI'.str_replace('-', '', $tanggalGaji.'-'.substr($kodeKaryawan[$key], -3)))
                ->udpate([
                    'Gaji'                      => $gajiKaryawan[$key],
                    'JumlahHariKerja'           => $jumlahHariKerja[$key],
                    'LemburHarian'              => $lemburHarian[$key],
                    'JumlahLemburHarian'        => $jumlahLemburHarian[$key],
                    'LemburJam'                 => $lemburJam[$key],
                    'JumlahLemburJam'           => $jumlahLemburJam[$key],
                    'Bonus'                     => $bonus[$key],
                    'JumlahBonus'               => $jumlahBonus[$key],
                    'updated_at'                => date('Y-m-d H:i:s'),
                ]);

                $jmlBarangSebelum = DB::table('detailgajians')
                                    ->join('gajians', 'detailgajians.KodeGaji', '=', 'gajians.KodeGaji')
                                    ->where([
                                        ['gajians.TanggalGaji', $tanggalGaji],
                                        ['gajians.KodeKaryawan', $kodeKaryawan]
                                    ])
                                    ->select('detailgajians.*')
                                    ->toArray();

                for ($i=0; $i < $jumlahBarang; $i++) { 
                    if ($barangKaryawan[$i] != $jmlBarangSebelum[$i]['JumlahBarang']) {
                        $selisih = $barangKaryawan[$i] - $jmlBarangSebelum[$i]['JumlahBarang'];
                        DB::table('koreksigajians')
                        ->updateOrInsert([
                            'KodeGaji'      => 'GAJI'.str_replace('-', '', $tanggalGaji).'-'.substr($kodeKaryawan[$key], -3),
                            'KodeBarang'    => $kodeBarang[$i]
                        ], [
                            'Kekurangan'    => ($selisih > 0) ? $selisih : '0',
                            'Kelebihan'     => ($selisih < 0) ? $selisih : '0',
                            'updated_at'    => date('Y-m-d H:i:s'),
                        ]);
                    }

                    DB::table('detailgajians')
                    ->where([
                        ['KodeGaji', 'GAJI'.str_replace('-', '', $tanggalGaji).'-'.substr($kodeKaryawan[$key], -3)],
                        ['KodeBarang', $kodeBarang[$i]]
                    ])
                    ->update([
                        'HargaBarang'               => $hargaBarang[$i],
                        'JumlahBarang'              => $barangKaryawan[$i][$key],
                        'SubtotalHargaBarang'       => (int)$hargaBarang[$i] * (int)$barangKaryawan[$i][$key],
                        'EnkripsiKodeGaji'          => md5('GAJI'.str_replace('-', '', $tanggalGaji).'-'.substr($kodeKaryawan[$key], -3)),
                        'created_at'                => date('Y-m-d H:i:s'),
                        'updated_at'                => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Gaji tanggal ' . $tanggalGaji . ' untuk golongan ' . $request->golonganKaryawan,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return redirect('/penggajian')->with(['created' => 'Gaji tanggal ' . $tanggalGaji . ' untuk golongan ' . $request->golonganKaryawan . ' berhasil dibuat']);
    }

    /*fungsi ambil data karyawan berdasarkan golongan*/
    public function apiKaryawan($kodeGolongan) {
        $karyawan           = DB::table('karyawans')
                ->join('golongans', function($join) {
                    $join->on('karyawans.KodeGolongan', '=', 'golongans.KodeGolongan');
                })
                ->where('karyawans.KodeGolongan', $kodeGolongan)
                ->where('karyawans.Status', 'OPN')
                ->get();

    	$result 		= json_decode($karyawan);
    	if ($result != null) { return response()->json($result); }
    	else { return response()->json([]); }
    }

    public function apiGaji($kodeKaryawan, $tanggalGaji) {
        $tanggal = date_format(date_create($tanggalGaji), 'Y-m-d');
        $karyawan           = DB::table('karyawans')
            ->selectRaw('*, count(absensis.StatusAbsen) as JumlahAbsen')
            ->join('golongans', function($join) {
                $join->on('karyawans.KodeGolongan', '=', 'golongans.KodeGolongan');
            })
            ->join('absensis', function($join) {
                $join->on('karyawans.KodeKaryawan', '=', 'absensis.KodeKaryawan');
            })
            ->where('karyawans.KodeKaryawan', $kodeKaryawan)
            ->where('karyawans.Status', 'OPN')
            ->where('absensis.StatusAbsen', '1')
            ->whereRaw('absensis.TanggalAbsen BETWEEN (SELECT DATE_SUB("'.$tanggal.'", INTERVAL (DAYOFWEEK("'.$tanggal.'")-1) DAY)) AND "'.$tanggal.'"')
            ->groupBy('karyawans.KodeKaryawan')
            ->get();

        $result         = json_decode($karyawan);
        if ($result != null) { return response()->json($result); }
        else { return response()->json([]); }
    }

    /*fungsi ambil daftar barang berdasarkan golongan*/
    public function apiBarang($kodeGolongan) {
    	$barang 			= DB::table('detailgolongans')
            ->select('KodeGolItem', 'NamaGolItem', 'HargaGolItem')
    		->where('KodeGolongan', $kodeGolongan)
    		->get();

    	$barang 		= json_decode($barang);
    	if ($barang != null) { return response()->json($barang); }
    	else { return response()->json([]); }
    }

    /*fungsi ambil data absen saat Tanggal Absen diubah*/
    public function apiAbsen($tanggal1, $tanggal2, $golongan) {
        $awal   = date_format(date_create($tanggal1), 'Y-m-d');
        $akhir  = date_format(date_create($tanggal2), 'Y-m-d');

        $date1  = substr($awal, 8);
        $date2  = substr($akhir, 8);
        $month  = substr($awal, 5, 2);
        $year   = substr($awal, 0, 4);

        $karyawans = DB::table('karyawans')
                    ->select('KodeKaryawan', 'Nama')
                    ->where('KodeGolongan', $golongan)
                    ->where('Status', 'OPN')
                    ->get();
        
        $htmlabsen = '';
        $htmlabsen = $htmlabsen
                    .'<tr>'
                    .'<th id="header">No</th>'
                    .'<th id="header">Nama</th>';

        for ($i=$date1; $i <= $date2 ; $i++) { 
            $format = date_create($year.'-'.$month.'-'.$i);
            $htmlabsen = $htmlabsen
                        .'<th id="header">'.date_format($format, 'd-m-Y').'</th>';
        }

        $htmlabsen = $htmlabsen
                    .'<th id="header"><input type="checkbox" id="semuaMasuk"> Masuk Semua?</th>'
                    .'</tr>';

        $nomor = 0;
        foreach ($karyawans as $key => $value) {
            $nomor++;
            $htmlabsen = $htmlabsen
                    .'<tr>'
                    .'<td>'.$nomor.'</td>'
                    .'<td>'.$value->Nama.'<input type="hidden" name="kodeKaryawan[]" value="'.$value->KodeKaryawan.'" id="karyawan'.$nomor.'"></td>';

            $noabsen = 0;
            for ($i=$date1; $i <= $date2 ; $i++) {
                $noabsen++;
                $htmlabsen = $htmlabsen
                    .'<td>'
                    .'<div class="form-inline">'
                    .'<input type="hidden" class="statusAbsen '.$value->KodeKaryawan.' '.$nomor.'" name="statusAbsen['.$key.'][]" value="0">'
                    .'<input type="checkbox" class="statusAbsen '.$value->KodeKaryawan.' '.$nomor.'" id="'.$nomor.'_'.$noabsen.'" value="0">'
                    .'</div>'
                    .'</td>';
            }

            $htmlabsen = $htmlabsen
                    .'<td>'
                    .'<div class="form-inline">'
                    .'<input type="checkbox" class="absenSemua '.$nomor.'" id="'.$value->KodeKaryawan.'" value="0">'
                    .'</div>'
                    .'</td>';

            $htmlabsen = $htmlabsen . '</tr>';
        }

        $htmlabsen = $htmlabsen . '<input type="hidden" name="jumlahKaryawan" value="'.$nomor.'">';

        return $htmlabsen;
    }

    /*fungsi untuk ambil data total gaji per tanggal dan total gaji semuanya*/
    public function apiLaporan($tanggal1, $tanggal2) {
        $awal   = date_format(date_create($tanggal1), 'Y-m-d');
        $akhir  = date_format(date_create($tanggal2), 'Y-m-d');
        $tglAwal    = substr($awal, -2);
        $tglAkhir   = substr($akhir, -2);
        $month      = substr($awal, 5, 2);
        $year       = substr($awal, 0, 4);

        $golongan   = DB::table('golongans')
                    ->select('NamaGolongan', 'KodeGolongan')
                    ->orderBy('KodeGolongan')
                    ->get();

        $golongan       = json_decode($golongan);
        $countGolongan  = count($golongan);
        $query          = '';
        $nomor          = 0;
        foreach ($golongan as $key => $value) {
            $nomor++;
            $query      = $query . "sum(case when (golongans.NamaGolongan='".$value->NamaGolongan."') then gajians.TotalGaji else '0' end) as '".$value->NamaGolongan."'";
            if ($nomor < $countGolongan) {
                $query  = $query . ", ";
            }
        }

        $data = DB::select("SELECT gajians.TanggalGaji, ".$query." FROM gajians
                            JOIN karyawans ON gajians.KodeKaryawan = karyawans.KodeKaryawan
                            JOIN golongans ON karyawans.KodeGolongan = golongans.KodeGolongan
                            WHERE gajians.TanggalGaji BETWEEN '".$awal."' AND '".$akhir."'
                            GROUP BY golongans.KodeGolongan, gajians.TanggalGaji");
        

        $laporan = '';
        $laporan = $laporan . '<table class="table table-hover table-striped tabelLaporan">'
                    .'<tr>';

        $laporan = $laporan . '<th>No</th>';
        $laporan = $laporan . '<th>Tanggal Gaji</th>';
        foreach ($golongan as $key => $value) {
            $laporan = $laporan . '<th>' . $value->NamaGolongan . '</th>';
        }
        $laporan = $laporan . '</tr>';
        $count = 0;
        if (count($data) > 0) {
            $i = $tglAwal;
            foreach ($data as $key => $value) {
                $count++;
                if ($i <= $tglAkhir) {
                    $format = date_format(date_create($year.'-'.$month.'-'.$i), 'd-m-Y');
                    $laporan = $laporan . '<tr>';
                    $laporan = $laporan . '<td>' . $count . '</td>';
                    $laporan = $laporan . '<td>' . $format . '</td>';
                    foreach ($golongan as $k => $v) {
                        $obj = $v->NamaGolongan;
                        $laporan = $laporan . '<td>' . ($value->$obj != null ? number_format($value->$obj, 0, "", ".") : '0') . '</td>';
                    }
                    $laporan = $laporan . '</tr>';

                    $i++;
                }
            }
        } else {
            for ($i=$tglAwal; $i <= $tglAkhir; $i++) { 
                $count++;
                $format = date_format(date_create($year.'-'.$month.'-'.$i), 'd-m-Y');
                $laporan = $laporan . '<tr>';
                $laporan = $laporan . '<td>' . $count . '</td>';
                $laporan = $laporan . '<td>' . $format . '</td>';
                foreach ($golongan as $k => $v) {
                    $laporan = $laporan . '<td>0</td>';
                }
                $laporan = $laporan . '</tr>';
            }
        }

        $dataTotal = DB::select("SELECT ".$query." FROM gajians
                   JOIN karyawans ON gajians.KodeKaryawan = karyawans.KodeKaryawan
                   JOIN golongans ON karyawans.KodeGolongan = golongans.KodeGolongan
                   WHERE gajians.TanggalGaji BETWEEN '".$awal."' AND '".$akhir."'");

        $gajiSemua = 0;
        $laporan = $laporan . '<tr><td><b>Subtotal Gaji</b></td>';

        if (count($dataTotal) > 0) {
            foreach ($dataTotal[0] as $key => $value) {
                $gajiSemua = $gajiSemua + $value;
                $laporan = $laporan . '<td>' . number_format($value, 0, "", ".") . '</td>';
            }
        } else {
            foreach ($golongan as $k => $v) {
                $laporan = $laporan . '<td>0</td>';
            }
        }
        
        $laporan = $laporan . '</tr>';

        $laporan = $laporan . '</table>';

        $laporan = $laporan . '<br><h3>Total Pengeluaran Gaji : <b>'.number_format($gajiSemua, 0, "", ".").'</b></h3>';

        return $laporan;
    }
}
