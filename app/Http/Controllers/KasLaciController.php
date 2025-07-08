<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;

class KasLaciController extends Controller
{
    public function index() {
    	$data = DB::table('kaslacis')
    	->orderBy('id')
    	->get();

    	return view('operasional.kaslaci.index', compact('data'));
    }
    public function create()
    {
        $matauang = DB::table('matauangs')->where('Status', 'OPN')->get();
        $lokasi = DB::table('lokasis')->where('Status', 'OPN')->get();

        return view('operasional.pengeluaranTambahan.buat', [
            'matauang' => $matauang,
            'lokasi' => $lokasi
        ]);
    }
    public function store(Request $request)
    {
        $last_id = DB::select('SELECT * FROM pengeluarantambahans WHERE KodePengeluaran LIKE "BO%" ORDER BY id DESC LIMIT 1');
        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "BO";
        if ($last_id == null) {
            $newID_bo = $pref . "-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodePengeluaran;
            $ids = substr($string, -4, 4);
            $month = substr($string, -6, 2);
            $year = substr($string, -8, 2);

            if ((int) $year_now > (int) $year) {
                $newID = "0001";
            } else if ((int) $month_now > (int) $month) {
                $newID = "0001";
            } else {
                $newID = $ids + 1;
                $newID = str_pad($newID, 4, '0', STR_PAD_LEFT);
            }

            $newID_bo = $pref . "-" . $year_now . $month_now . $newID;
        }

        $sisasaldo = true;
        $saldoakhir = DB::table('saldos')
            ->orderBy('saldos.id', 'desc')
            ->first();

        if (isset($saldoakhir)) {
            $saldocash      = $saldoakhir->SaldoCash;
            $saldorekening  = $saldoakhir->SaldoRekening;
        } else {
            $saldocash      = 0;
            $saldorekening  = 0;
        }

        // if ($request->Metode == 'Cash') {
        //     $jenissaldo = "SaldoCash";
        // } else if ($request->Metode == 'Transfer') {
        //     $jenissaldo = "SaldoRekening";
        // }

        if ($request->Transaksi == 'Keluar') {
            $tipe = "BOK";
            $pref = "KK";

            if ($request->Metode == 'Cash') {
                if (($saldocash - $request->Total) < 0) {
                    $sisasaldo = false;
                } else {
                    DB::table('saldos')->insert([
                        'KodeTransaksi' => $newID_bo,
                        'Transaksi' => $newID_bo,
                        'Jumlah' => $request->Total,
                        'Tanggal' => $request->Tanggal,
                        'Tipe' => $request->Metode,
                        'SaldoCash' => $saldocash - $request->Total,
                        'SaldoRekening' => $saldorekening,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);

                    if ($request->Nama == "Kas laci" || $request->Nama == "Kas Laci" || $request->Nama == "kas laci") {
                        $datalaci  = DB::select('SELECT * FROM kaslacis ORDER BY id DESC LIMIT 1');
                        $statuslaci = $datalaci[0]->Status;

                        if ($statuslaci == 'OPN') {
                            $saldolaci = $datalaci[0]->SaldoLaci;
                            
                            if ($request->Total <= $saldolaci) {
                                DB::table('kaslacis')
                                ->insert([
                                    'Tanggal'       => $request->Tanggal,
                                    'Nominal'       => $request->Total,
                                    'Transaksi'     => $request->Transaksi,
                                    'SaldoLaci'     => $saldolaci - $request->Total,
                                    'Status'        => 'OPN',
                                    'updated_at'    => \Carbon\Carbon::now(),
                                    'KodeUser'      => \Auth::user()->name,
                                ]);
                            }
                        } else {
                            $pesanlaci = '<br>Kas Laci tidak dapat diambil karena saldo tidak mencukupi atau kas laci telah ditutup';
                        }
                    }
                }
            } else if ($request->Metode == 'Transfer') {
                if (($saldorekening - $request->Total) < 0) {
                    $sisasaldo = false;
                } else {
                    DB::table('saldos')->insert([
                        'KodeTransaksi' => $newID_bo,
                        'Transaksi' => $newID_bo,
                        'Jumlah' => $request->Total,
                        'Tanggal' => $request->Tanggal,
                        'Tipe' => $request->Metode,
                        'SaldoCash' => $saldocash,
                        'SaldoRekening' => $saldorekening - $request->Total,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                }
            }
        } else if ($request->Transaksi == 'Masuk') {
            $tipe = "BOM";
            $pref = "KM";

            if ($request->Metode == 'Cash') {
                DB::table('saldos')->insert([
                    'KodeTransaksi' => $newID_bo,
                    'Transaksi' => $newID_bo,
                    'Jumlah' => $request->Total,
                    'Tanggal' => $request->Tanggal,
                    'Tipe' => $request->Metode,
                    'SaldoCash' => $saldocash + $request->Total,
                    'SaldoRekening' => $saldorekening,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);

                if ($request->Nama == "Kas laci" || $request->Nama == "Kas Laci" || $request->Nama == "kas laci") {
                        $datalaci  = DB::select('SELECT * FROM kaslacis ORDER BY id DESC LIMIT 1');
                        $statuslaci = isset($datalaci[0]->Status) ? $datalaci[0]->Status : 'OPN';

                        if ($statuslaci == 'OPN') {
                            $saldolaci = isset($dataLaci[0]->SaldoLaci) ? $dataLaci[0]->SaldoLaci : 0;
                            
                            DB::table('kaslacis')
                            ->insert([
                                'Tanggal'       => $request->Tanggal,
                                'Nominal'       => $request->Total,
                                'Transaksi'     => $request->Transaksi,
                                'SaldoLaci'     => $saldolaci + $request->Total,
                                'Status'        => 'OPN',
                                'updated_at'    => \Carbon\Carbon::now(),
                                'KodeUser'      => \Auth::user()->name,
                            ]);
                        } else {
                            DB::table('kaslacis')
                            ->insert([
                                'Tanggal'       => $request->Tanggal,
                                'Nominal'       => $request->Total,
                                'Transaksi'     => $request->Transaksi,
                                'SaldoLaci'     => $request->Total,
                                'Status'        => 'OPN',
                                'updated_at'    => \Carbon\Carbon::now(),
                                'KodeUser'      => \Auth::user()->name,
                            ]);
                        }
                    }
            } else if ($request->Metode == 'Transfer') {
                DB::table('saldos')->insert([
                    'KodeTransaksi' => $newID_bo,
                    'Transaksi' => $newID_bo,
                    'Jumlah' => $request->Total,
                    'Tanggal' => $request->Tanggal,
                    'Tipe' => $request->Metode,
                    'SaldoCash' => $saldocash,
                    'SaldoRekening' => $saldorekening + $request->Total,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        }

        if ($sisasaldo) {
            DB::table('pengeluarantambahans')->insert([
                'KodePengeluaran' => $newID_bo,
                'Nama' => $request->Nama,
                'Karyawan' => $request->Karyawan,
                'Tanggal' => $request->Tanggal,
                'KodeLokasi' => $request->KodeLokasi,
                'KodeMataUang' => $request->KodeMataUang,
                'Keterangan' => $request->Keterangan,
                'Metode' => $request->Metode,
                'Transaksi' => $request->Transaksi,
                'Status' => 'OPN',
                'KodeUser' => \Auth::user()->name,
                'Total' => $request->Total,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            $last_id = DB::select('SELECT * FROM kasbanks ORDER BY KodeKasBankID DESC LIMIT 1');
            $year_now = date('y');
            $month_now = date('m');
            $date_now = date('d');
            if ($last_id == null) {
                $newID = $pref . "-" . $year_now . $month_now . "0001";
            } else {
                $string = $last_id[0]->KodeKasBank;
                $ids = substr($string, -4, 4);
                $month = substr($string, -6, 2);
                $year = substr($string, -8, 2);

                if ((int) $year_now > (int) $year) {
                    $newID = "0001";
                } else if ((int) $month_now > (int) $month) {
                    $newID = "0001";
                } else {
                    $newID = $ids + 1;
                    $newID = str_pad($newID, 4, '0', STR_PAD_LEFT);
                }

                $newID = $pref . "-" . $year_now . $month_now . $newID;
            }

            DB::table('kasbanks')->insert([
                'KodeKasBank' => $newID,
                'Tanggal' => $request->Tanggal,
                'TanggalCheque' => $request->Tanggal,
                'KodeBayar' => $request->Metode,
                'TipeBayar' => '',
                'NoLink' => '',
                'KodeInvoice' => $newID_bo,
                'BayarDari' => '',
                'Untuk' => $request->Karyawan,
                'Keterangan' => $request->Keterangan,
                'Tipe' => $tipe,
                'Status' => 'CFM',
                'KodeUser' => \Auth::user()->name,
                'Total' => $request->Total,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            DB::table('eventlogs')->insert([
                'KodeUser' => \Auth::user()->name,
                'Tanggal' => \Carbon\Carbon::now(),
                'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
                'Keterangan' => 'Tambah biaya operasional ' . $newID_bo,
                'Tipe' => 'OPN',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            $pesan = 'Biaya operasional ' . $newID_bo . ' berhasil ditambahkan';
            return redirect('/pengeluarantambahan')->with(['created' => $pesan]);
        }
        // 
        else {
            $pesan = 'Biaya operasional tidak disimpan karena saldo tidak mencukupi, mohon periksa kembali jumlah saldo atau menambah saldo terlebih dahulu';
            return redirect('/pengeluarantambahan')->with(['error' => $pesan]);
        }
    }

    public function closing($id, $tanggal) {
        DB::table('kaslacis')
        ->where([
            ['id', '=', $id],
            ['Status', '=', 'OPN']
        ])
        ->update([
            'Status'        => 'CLS',
            'updated_at'    => \Carbon\Carbon::now(),
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tutup kas laci tanggal ' . date('d-m-Y', strtotime($tanggal)),
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Kas laci tanggal ' . date('d-m-Y', strtotime($tanggal)) . ' telah ditutup';
        return redirect('/laci')->with(['edited' => $pesan]);
    }
}
