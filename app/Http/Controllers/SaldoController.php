<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class SaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saldo = DB::table('saldos')
            ->orderBy('saldos.id', 'desc')
            ->first();

        return view('operasional.saldo.index', compact('saldo'));
    }

    public function history()
    {
        $saldo = DB::select("SELECT s.KodeTransaksi, s.Transaksi, s.Tanggal, s.Jumlah, s.Tipe, s.SaldoCash, s.SaldoRekening, pt.Nama, pt.Karyawan, pt.Transaksi as trans
        from saldos s
        left join pengeluarantambahans pt on pt.KodePengeluaran = s.Transaksi
        order by s.id desc");

        return view('operasional.saldo.history', compact('saldo'));
    }

    public function filter(Request $request)
    {
        $saldo = DB::select("SELECT s.KodeTransaksi, s.Transaksi, s.Tanggal, s.Jumlah, s.Tipe, s.SaldoCash, s.SaldoRekening, pt.Nama, pt.Karyawan, pt.Transaksi as trans
        from saldos s
        left join pengeluarantambahans pt on pt.KodePengeluaran = s.Transaksi
        where MONTH(s.Tanggal) = '" . $request->month . "' AND YEAR(s.Tanggal) = '" . $request->year . "'
        order by s.id desc");

        return view('operasional.saldo.history', compact('saldo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showkonversi()
    {
        $saldo = DB::table('saldos')
            ->orderBy('saldos.id', 'desc')
            ->first();

        return view('operasional.saldo.konversi', compact('saldo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storekonversi(Request $request)
    {
        $last_id = DB::select('SELECT * FROM saldos where KodeTransaksi like "KS%" ORDER BY id DESC LIMIT 1');
        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "KS";
        if ($last_id == null) {
            $newID_ks = $pref . "-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeTransaksi;
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

            $newID_ks = $pref . "-" . $year_now . $month_now . $newID;
        }

        $sisasaldo = true;
        $saldoakhir = DB::table('saldos')
            ->orderBy('saldos.id', 'desc')
            ->first();

        if ($request->Tipe == 'CR') {
            $tipe = "Setor Tunai";

            if (($saldoakhir->SaldoCash - $request->Jumlah) < 0) {
                $sisasaldo = false;
            } else {
                DB::table('saldos')->insert([
                    'KodeTransaksi' => $newID_ks,
                    'Transaksi' => $newID_ks,
                    'Jumlah' => $request->Jumlah,
                    'Tanggal' => $request->Tanggal,
                    'Tipe' => $request->Tipe,
                    'SaldoCash' => $saldoakhir->SaldoCash - $request->Jumlah,
                    'SaldoRekening' => $saldoakhir->SaldoRekening + $request->Jumlah,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        } else if ($request->Tipe == 'RC') {
            $tipe = "Tarik Tunai";

            if (($saldoakhir->SaldoRekening - $request->Jumlah) < 0) {
                $sisasaldo = false;
            } else {
                DB::table('saldos')->insert([
                    'KodeTransaksi' => $newID_ks,
                    'Transaksi' => $newID_ks,
                    'Jumlah' => $request->Jumlah,
                    'Tanggal' => $request->Tanggal,
                    'Tipe' => $request->Tipe,
                    'SaldoCash' => $saldoakhir->SaldoCash + $request->Jumlah,
                    'SaldoRekening' => $saldoakhir->SaldoRekening - $request->Jumlah,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        }

        if ($sisasaldo) {
            DB::table('pengeluarantambahans')->insert([
                'KodePengeluaran' => $newID_ks,
                'Nama' => $tipe,
                'Karyawan' => '',
                'Tanggal' => $request->Tanggal,
                'KodeLokasi' => '',
                'KodeMataUang' => '',
                'Keterangan' => '',
                'Metode' => '',
                'Transaksi' => '',
                'Status' => 'OPN',
                'KodeUser' => \Auth::user()->name,
                'Total' => $request->Jumlah,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            $last_id = DB::select('SELECT * FROM kasbanks ORDER BY KodeKasBankID DESC LIMIT 1');
            $year_now = date('y');
            $month_now = date('m');
            $date_now = date('d');
            $pref = "KL";
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
                'KodeBayar' => $tipe,
                'TipeBayar' => $tipe,
                'NoLink' => '',
                'KodeInvoice' => $newID_ks,
                'BayarDari' => '',
                'Untuk' => '',
                'Keterangan' => '',
                'Tipe' => 'KS',
                'Status' => 'CFM',
                'KodeUser' => \Auth::user()->name,
                'Total' => $request->Jumlah,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            DB::table('eventlogs')->insert([
                'KodeUser' => \Auth::user()->name,
                'Tanggal' => \Carbon\Carbon::now(),
                'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
                'Keterangan' => $tipe . ' ' . $newID_ks,
                'Tipe' => 'OPN',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            $pesan = $tipe . ' ' . $newID_ks . ' berhasil';
            return redirect('/saldo')->with(['created' => $pesan]);
        }
        //
        else {
            $pesan = $tipe . ' gagal karena sisa saldo tidak mencukupi, mohon periksa kembali jumlah saldo yang dapat dikonversi';
            return redirect('/saldo')->with(['error' => $pesan]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pengeluarantambahans')->where('id', $id)->update([
            'Status' => 'DEL'
        ]);

        $pt = DB::table('pengeluarantambahans')->where('id', $id)->first();

        DB::table('kasbanks')->where('KodeInvoice', $pt->KodePengeluaran)->update([
            'Status' => 'DEL'
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus biaya operasional ' . $pt->KodePengeluaran,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Biaya operasional ' . $pt->KodePengeluaran . ' berhasil dihapus';
        return redirect('/pengeluarantambahan')->with(['deleted' => $pesan]);
    }
}
