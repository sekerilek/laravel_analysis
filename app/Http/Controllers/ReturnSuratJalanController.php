<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\suratjalan;
use App\Model\karyawan;
use App\Model\pemesananpenjualan;
use App\Model\matauang;
use App\Model\lokasi;
use App\Model\driver;
use App\Model\pelanggan;
use Carbon\Carbon;
use App\Model\suratjalanreturn;
use App\Model\invoicepiutang;
use App\Model\pelunasanpiutang;
use App\Model\invoicepiutangdetail;
use PDF;

class ReturnSuratJalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function add($id)
    {
        $sj = DB::select("SELECT DISTINCT a.KodeSuratJalan, a.KodeSuratJalanID from (
            SELECT sj.KodeSuratJalanID,a.KodeSuratJalan,a.KodeItem, 
            COALESCE(SUM(a.qty))-COALESCE(SUM(sjrd.Qty),0) as jml
            FROM suratjalandetails a 
            inner join items i on a.KodeItem = i.KodeItem
            inner join itemkonversis k on i.KodeItem = k.KodeItem
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            inner join suratjalans sj on sj.KodeSuratJalan = a.KodeSuratJalan and sj.Status='CFM'
    		inner join invoicepiutangdetails ipd on ipd.KodeSuratJalan = sj.KodeSuratJalan
    		inner join invoicepiutangs ip on ip.KodeInvoicePiutang = ipd.KodeInvoicePiutang and ip.Status='OPN'
            left join suratjalanreturns sjr on sjr.KodeSuratJalanID = sj.KodeSuratJalanID
            left join suratjalanreturndetails sjrd on sjrd.KodeSuratJalanReturn = sjr.KodeSuratJalanReturn and sjrd.KodeItem = a.KodeItem and sjrd.KodeSatuan = k.KodeSatuan
            where sj.Status = 'CFM' and a.KodeSatuan = k.KodeSatuan
            group by a.KodeItem, a.KodeSatuan, a.KodeSuratJalan
            having jml > 0) as a");
		
        if ($id == "0") {
            if (count($sj) <= 0) {
                return redirect('/suratJalan/create/0');
            }
            $id = $sj[0]->KodeSuratJalanID;
        }

        $items = DB::select("SELECT a.KodeItem, i.NamaItem, i.Keterangan, s.KodeSatuan, s.NamaSatuan, a.Harga,
            COALESCE(a.qty,0)-COALESCE(SUM(sjrd.Qty),0) as jml
            FROM suratjalandetails a inner join items i on a.KodeItem = i.KodeItem 
            inner join itemkonversis k on i.KodeItem = k.KodeItem 
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join suratjalans sj on sj.KodeSuratJalan = a.KodeSuratJalan and sj.Status='CFM'
            left join suratjalanreturns sjr on sjr.KodeSuratJalanID = sj.KodeSuratJalanID and sjr.Status = 'CFM'
            left join suratjalanreturndetails sjrd on sjrd.KodeSuratJalanReturn = sjr.KodeSuratJalanReturn and sjrd.KodeItem = a.KodeItem and sjrd.KodeSatuan = k.KodeSatuan
            where sj.KodeSuratJalanID='" . $id . "' and a.KodeSatuan = k.KodeSatuan
            group by a.KodeItem, s.KodeSatuan
            having jml > 0");
        $so = DB::select("select so.* from suratjalans sj inner join pemesananpenjualans so on so.KodeSO 
            = sj.KodeSO where sj.KodeSuratJalanID='" . $id . "'")[0];
        $sjDet = suratjalan::where('KodeSuratJalanID', $id)->first();
        $sopir = driver::where('KodeDriver', $sjDet->KodeSopir)->first();
		//dd($items);
        return view('penjualan.returnSuratJalan.buat', compact('sj', 'id', 'items', 'so', 'sopir', 'sjDet'));
    }

    public function store(Request $request, $id)
    {
        $last_id = DB::select('SELECT * FROM suratjalanreturns WHERE KodeSuratJalanReturn LIKE "%RSJ-0%" ORDER BY KodeSuratJalanReturnID DESC LIMIT 1');
        $last_id_tax = DB::select('SELECT * FROM suratjalanreturns WHERE KodeSuratJalanReturn LIKE "%RSJ-1%" ORDER BY KodeSuratJalanReturnID DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "RSJ-0";
        if ($request->ppn == 'ya') {
            $pref = "RSJ-1";

            if ($last_id_tax == null) {
                $newID = $pref . $year_now . $month_now . "0001";
            } else {
                $string = $last_id_tax[0]->KodeSuratJalanReturn;
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

                $newID = $pref . $year_now . $month_now . $newID;
            }
        } else {
            if ($last_id == null) {
                $newID = $pref . $year_now . $month_now . "0001";
            } else {
                $string = $last_id[0]->KodeSuratJalanReturn;
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

                $newID = $pref . $year_now . $month_now . $newID;
            }
        }

        $sj = suratjalan::where('KodeSuratJalanID', $request->KodeSJ)->first();

        DB::table('suratjalanreturns')->insert([
            'KodeSuratJalanReturn' => $newID,
            'Tanggal' => $request->Tanggal,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'Total' => $request->total,
            'PPN' => $request->ppn,
            'NilaiPPN' => $request->ppnval,
            'Printed' => 0,
            'Diskon' => $request->diskon,
            'NilaiDiskon' => $request->diskonval,
            'Subtotal' => $request->subtotal,
            'Keterangan' => $request->Keterangan,
            'KodeSuratJalanID' => $request->KodeSJ,
            'KodeSuratJalan' => $sj->KodeSuratJalan,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $items = $request->item;
        $qtys = $request->qty;
        $prices = $request->price;
        $satuans = $request->satuan;
        $keterangans = $request->keterangan;
        $nomer = 0;
        foreach ($items as $key => $value) {
            if ($qtys[$key] != 0) {
                $nomer++;
                DB::table('suratjalanreturndetails')->insert([
                    'KodeSuratJalanReturn' => $newID,
                    'KodeItem' => $items[$key],
                    'Qty' => $qtys[$key],
                    'Harga' => $prices[$key],
                    'NoUrut' => $nomer,
                    'KodeSuratJalan' => $request->KodeSJ,
                    'KodeSatuan' => $satuans[$key],
                    'Keterangan' => $keterangans[$key],
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah return surat jalan ' . $newID,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Return Surat Jalan ' . $newID . ' berhasil ditambahkan';
        return redirect('/returnSuratJalan')->with(['created' => $pesan]);
    }

    public function index()
    {
        $suratjalanreturns = suratjalanreturn::orderBy('KodeSuratJalanReturnID', 'desc')->get();
        return view('penjualan.returnSuratJalan.index', compact('suratjalanreturns'));
    }

    public function filterData(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        $suratjalanreturns = suratjalanreturn::where('Status', 'OPN')->get();
        if ($start && $end) {
            $suratjalanreturns = $suratjalanreturns->whereBetween('Tanggal', [$start . ' 00:00:01', $end . ' 23:59:59']);
        } else {
            $suratjalanreturns->all();
        }
        return view('penjualan.returnSuratJalan.index', compact('suratjalanreturns', 'start', 'end'));
    }

    public function show($id)
    {
        $suratjalanreturn = suratjalanreturn::where('KodeSuratJalanReturnID', $id)->first();
        $suratjalan = suratjalan::where('KodeSuratJalanID', $suratjalanreturn->KodeSuratJalanID)->first();
        $driver = driver::where('KodeDriver', $suratjalan->KodeSopir)->first();
        $matauang = matauang::where('KodeMataUang', $suratjalan->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $suratjalan->KodeLokasi)->first();
        $pelanggan = pelanggan::where('KodePelanggan', $suratjalan->KodePelanggan)->first();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, a.Harga
            FROM suratjalanreturndetails a
            inner join suratjalanreturns b on a.KodeSuratJalanReturn = b.KodeSuratJalanReturn
            inner join items i on a.KodeItem = i.KodeItem 
            inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan
            inner join satuans s on s.KodeSatuan = k.KodeSatuan 
            where b.KodeSuratJalanReturnID='" . $id . "' 
            group by a.KodeItem, s.NamaSatuan");
        return view('penjualan.returnSuratJalan.show', compact('id', 'suratjalanreturn', 'driver', 'matauang', 'lokasi', 'pelanggan', 'items', 'suratjalan'));
    }

    public function confirm($id)
    {
        $sjr = suratjalanreturn::where('KodeSuratJalanReturnID', $id)->first();

        //cek apakah item yg direturn tidak melebihi jumlah awal
        $checkresult = DB::select("SELECT (a.qty-COALESCE(SUM(sjd.qty),0)-COALESCE(sjdc.qty,0)) as jml
            FROM suratjalandetails a 
            inner join items i on a.KodeItem = i.KodeItem
            inner join itemkonversis k on i.KodeItem = k.KodeItem
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join suratjalanreturns sj on sj.KodeSuratJalan = a.KodeSuratJalan and sj.Status = 'CFM'
            left join suratjalanreturndetails sjd on sjd.KodeSuratJalanReturn = sj.KodeSuratJalanReturn and sjd.KodeItem = a.KodeItem and sjd.KodeSatuan = k.KodeSatuan
            left join suratjalanreturndetails sjdc on sjdc.KodeSuratJalanReturn = '" . $sjr['KodeSuratJalanReturn'] . "' and sjdc.KodeItem = a.KodeItem and sjdc.KodeSatuan = k.KodeSatuan
            where a.KodeSuratJalan='" . $sjr['KodeSuratJalan'] . "' and a.KodeSatuan = k.KodeSatuan
            group by a.KodeItem, s.NamaSatuan
            having jml < 0");

        if (empty($checkresult)) {
            $suratjalanreturn = suratjalanreturn::where('KodeSuratJalanReturnID', $id)->first();
            $ppn = $suratjalanreturn->PPN;
            $diskon = $suratjalanreturn->Diskon;
            $totalreturn = $suratjalanreturn->Total;
            if ($ppn == 'ya') {
                if ($diskon > 0) {
                    $totalreturn = $totalreturn + (0.1 * $totalreturn) - ($diskon / 100 * $totalreturn);
                } else {
                    $totalreturn = $totalreturn + (0.1 * $totalreturn);
                }
            } else {
                if ($diskon > 0) {
                    $totalreturn = $totalreturn - ($diskon / 100 * $totalreturn);
                }
            }

            //update invoicepiutang
            $suratjalan = suratjalan::where('KodeSuratJalanID', $suratjalanreturn->KodeSuratJalanID)->first();
            $invoice = invoicepiutangdetail::where('KodeSuratJalan', $suratjalanreturn->KodeSuratJalan)->first();
            $piutang = invoicepiutang::where('KodeInvoicePiutangShow', $invoice->KodePiutang)->first();
            $payments = pelunasanpiutang::where('KodeInvoice', $piutang->KodeInvoicePiutang)->get();

            $tot = 0;
            foreach ($payments as $bill) {
                $tot += $bill->Jumlah;
            }

            $sisa = $invoice->Subtotal - $tot - $invoice->TotalReturn - $totalreturn;
            if ($sisa < 0) {
                $pesan = 'Return Surat Jalan tidak dikonfirmasi karena hasil Invoive menjadi minus, mohon periksa kembali jumlah item pada Surat Jalan yang dapat direturn';
                return redirect('/returnSuratJalan')->with(['error' => $pesan]);
            } else {
                if (!empty($invoice)) {
                    $invoice->TotalReturn += $totalreturn;
                    $invoice->save();
                }

                //update status jika sudah lunas
                if ($sisa == 0) {
                    DB::table('invoicepiutangs')->where('KodeInvoicePiutang', $piutang->KodeInvoicePiutang)->update([
                        'Status' => 'CLS'
                    ]);
                }

                //update status suratjalan
                $suratjalanreturn->Status = "CFM";
                $suratjalanreturn->save();

                //cek apakah semua item sudah direturn
                $checkitem = DB::select("SELECT (a.qty-COALESCE(SUM(sjd.qty),0)) as jml
                    FROM suratjalandetails a 
                    inner join items i on a.KodeItem = i.KodeItem
                    inner join itemkonversis k on i.KodeItem = k.KodeItem
                    inner join satuans s on s.KodeSatuan = k.KodeSatuan
                    left join suratjalanreturns sj on sj.KodeSuratJalan = a.KodeSuratJalan
                    left join suratjalanreturndetails sjd on sjd.KodeSuratJalanReturn = sj.KodeSuratJalanReturn and sjd.KodeItem = a.KodeItem and sjd.KodeSatuan = k.KodeSatuan
                    where a.KodeSuratJalan='" . $sjr['KodeSuratJalan'] . "' and a.KodeSatuan = k.KodeSatuan and sj.Status = 'CFM'
                    group by a.KodeItem, s.NamaSatuan
                    having jml > 0");

                if (empty($checkitem)) {
                    $suratjalan->Status = "CLS";
                    $suratjalan->save();
                }

                //update kartustok
                $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, a.Harga, k.Konversi
                FROM suratjalanreturndetails a 
                inner join suratjalanreturns sj on a.KodeSuratJalanReturn = sj.KodeSuratJalanReturn 
                inner join items i on a.KodeItem = i.KodeItem 
                inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan
                inner join satuans s on s.KodeSatuan = k.KodeSatuan
                where sj.KodeSuratJalanReturnID='" . $id . "'
                group by a.KodeItem, s.NamaSatuan");

                $tot = 0;
                foreach ($items as $key => $value) {
                    $last_saldo[$key] = DB::table('keluarmasukbarangs')->where('KodeItem', $value->KodeItem)->orderBy('id', 'desc')->limit(1)->pluck('saldo')->toArray();
                    $tot += $value->jml;
                }
                $nomer = 0;

                foreach ($items as $key => $value) {
                    if ($value->Konversi > 0) {
                        $value->jml = $value->jml * $value->Konversi;
                    }
                    if (isset($last_saldo[$key][0])) {
                        $saldo = (float) $last_saldo[$key][0] + (float) $value->jml;
                    }
                    $nomer++;
                    DB::table('keluarmasukbarangs')->insert([
                        'Tanggal' => $suratjalanreturn->Tanggal,
                        'KodeLokasi' => $suratjalan->KodeLokasi,
                        'KodeItem' => $value->KodeItem,
                        'JenisTransaksi' => 'RJB',
                        'KodeTransaksi' => $suratjalanreturn->KodeSuratJalanReturn,
                        'Qty' => $value->jml,
                        'HargaRata' => 0,
                        'KodeUser' => \Auth::user()->name,
                        'idx' => $nomer,
                        'indexmov' => $nomer,
                        'saldo' => $saldo,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()
                    ]);
                }

                //update eventlogs
                DB::table('eventlogs')->insert([
                    'KodeUser' => \Auth::user()->name,
                    'Tanggal' => \Carbon\Carbon::now(),
                    'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
                    'Keterangan' => 'Konfirmasi return surat jalan ' . $suratjalanreturn->KodeSuratJalanReturn,
                    'Tipe' => 'OPN',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);

                $pesan = 'Return Surat Jalan ' . $suratjalanreturn->KodeSuratJalanReturn . ' berhasil dikonfirmasi';
                return redirect('/konfirmasiReturnSuratJalan')->with(['created' => $pesan]);
            }
        } else {
            $pesan = 'Return Surat Jalan tidak dikonfirmasi karena hasil item menjadi minus, mohon periksa kembali jumlah item pada Surat Jalan yang dapat direturn';
            return redirect('/returnSuratJalan')->with(['error' => $pesan]);
        }
    }

    public function konfirmasiSuratJalanReturn()
    {
        $suratjalanreturns = suratjalanreturn::where('Status', 'CFM')->orderBy('KodeSuratJalanID', 'desc')->get();
        return view('penjualan.returnSuratJalan.konfirmasi', compact('suratjalanreturns'));
    }

    public function filterKonfirmasiSuratJalanReturn(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        $suratjalanreturns = suratjalanreturn::where('Status', 'CFM')->get();
        if ($start && $end) {
            $suratjalanreturns = $suratjalanreturns->whereBetween('Tanggal', [$start . ' 00:00:01', $end . ' 23:59:59']);
        } else {
            $suratjalanreturns->all();
        }
        return view('penjualan.returnSuratJalan.konfirmasi', compact('suratjalanreturns', 'start', 'end'));
    }

    public function view($id)
    {
        $suratjalanreturn = suratjalanreturn::where('KodeSuratJalanReturnID', $id)->first();
        $suratjalan = suratjalan::where('KodeSuratJalanID', $suratjalanreturn->KodeSuratJalanID)->first();
        $driver = karyawan::where('KodeKaryawan', $suratjalan->KodeSopir)->first();
        $matauang = matauang::where('KodeMataUang', $suratjalan->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $suratjalan->KodeLokasi)->first();
        $pelanggan = pelanggan::where('KodePelanggan', $suratjalan->KodePelanggan)->first();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, a.Harga
            FROM suratjalanreturndetails a
            inner join suratjalanreturns b on a.KodeSuratJalanReturn = b.KodeSuratJalanReturn
            inner join items i on a.KodeItem = i.KodeItem 
            inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan
            inner join satuans s on s.KodeSatuan = k.KodeSatuan 
            where b.KodeSuratJalanReturnID='" . $id . "' 
            group by a.KodeItem, s.NamaSatuan");
        return view('penjualan.returnSuratJalan.view', compact('id', 'suratjalanreturn', 'driver', 'matauang', 'lokasi', 'pelanggan', 'items', 'suratjalan'));
    }

    public function print($id)
    {
        $returnsuratjalan = suratjalanreturn::where('KodeSuratJalanReturnID', $id)->first();
        $suratjalan = suratjalan::where('KodeSuratJalan', $returnsuratjalan->KodeSuratJalan)->first();
        $driver = karyawan::where('KodeKaryawan', $suratjalan->KodeSopir)->first();
        $matauang = matauang::where('KodeMataUang', $suratjalan->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $suratjalan->KodeLokasi)->first();
        $pelanggan = pelanggan::where('KodePelanggan', $suratjalan->KodePelanggan)->first();

        $items = DB::select(
            "SELECT a.KodeItem,i.NamaItem, a.Qty, i.Keterangan, s.NamaSatuan, s.KodeSatuan, a.Harga 
        FROM suratjalanreturndetails a 
        inner join items i on a.KodeItem = i.KodeItem 
        inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan 
        inner join satuans s on s.KodeSatuan = k.KodeSatuan
        where a.KodeSuratJalanReturn='" . $returnsuratjalan->KodeSuratJalanReturn . "' group by a.KodeItem, s.NamaSatuan"
        );

        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->Qty;
        }
        $returnsuratjalan->Tanggal = \Carbon\Carbon::parse($returnsuratjalan->Tanggal)->format('d-m-Y');

        $pdf = PDF::loadview('penjualan.returnSuratJalan.print', compact('returnsuratjalan', 'suratjalan', 'driver', 'matauang', 'lokasi', 'pelanggan', 'items', 'jml'));

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Print return surat jalan ' . $returnsuratjalan->KodeSuratJalanReturn,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return $pdf->download('ReturnSuratJalan_' . $returnsuratjalan->KodeSuratJalanReturn . '.pdf');
    }

    public function edit($id)
    {
        //
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
        DB::table('suratjalanreturns')->where('KodeSuratJalanReturnID', $id)->update([
            'Status' => 'DEL'
        ]);

        $sjr = DB::table('suratjalanreturns')->where('KodeSuratJalanReturnID', $id)->first();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus return surat jalan ' . $sjr->KodeSuratJalanReturn,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return redirect('/returnSuratJalan');
    }
}
