<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\kasir;
use App\Model\karyawan;
use App\Model\matauang;
use App\Model\lokasi;
use App\Model\pelanggan;
use Carbon\Carbon;
use App\Model\kasirreturn;
use App\Model\kasbank;
use PDF;

class ReturnKasirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function return($id)
    {
        $kasir = DB::table('kasirs')->where('KodeKasir', $id)->first();
        $items = DB::select("SELECT a.KodeItem, i.NamaItem, i.Keterangan, s.KodeSatuan, s.NamaSatuan, a.Harga,
            COALESCE(a.qty,0)-COALESCE(SUM(ksrd.Qty),0) as jml
            FROM kasirdetails a inner join items i on a.KodeItem = i.KodeItem 
            inner join itemkonversis k on i.KodeItem = k.KodeItem 
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join kasirs ks on ks.KodeKasir = a.KodeKasir and ks.Status='CFM'
            left join kasirreturns ksr on ksr.KodeKasir = ks.KodeKasir and ksr.Status = 'CFM'
            left join kasirreturndetails ksrd on ksrd.KodeKasirReturn = ksr.KodeKasirReturn and ksrd.KodeItem = a.KodeItem and ksrd.KodeSatuan = k.KodeSatuan
            where ks.KodeKasir='" . $id . "' and a.KodeSatuan = k.KodeSatuan
            group by a.KodeItem, s.KodeSatuan
            having jml > 0");
        $matauang = matauang::where('KodeMataUang', $kasir->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $kasir->KodeLokasi)->first();
        $pelanggan = pelanggan::where('KodePelanggan', $kasir->KodePelanggan)->first();
        return view('penjualan.returnKasir.buat', compact('id', 'items', 'kasir', 'lokasi', 'pelanggan'));
    }

    public function store(Request $request, $id)
    {
        $last_id = DB::select('SELECT * FROM kasirreturns ORDER BY id DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "RKS-";
        if ($last_id == null) {
            $newID = $pref . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeKasirReturn;
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


        DB::table('kasirreturns')->insert([
            'KodeKasirReturn' => $newID,
            'KodeKasir' => $request->KodeKasir,
            'Tanggal' => $request->Tanggal,
            'Status' => 'CFM',
            'KodeUser' => \Auth::user()->name,
            'Keterangan' => $request->Keterangan,
            'Subtotal' => $request->total,
            'Total' => $request->subtotal,
            'PPN' => $request->ppn,
            'NilaiPPN' => $request->ppnval,
            'Diskon' => $request->diskon,
            'NilaiDiskon' => $request->diskonval,
            'Printed' => 0,
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
                DB::table('kasirreturndetails')->insert([
                    'KodeKasirReturn' => $newID,
                    'KodeItem' => $items[$key],
                    'Qty' => $qtys[$key],
                    'Harga' => $prices[$key],
                    'NoUrut' => $nomer,
                    'KodeKasir' => $request->KodeKasir,
                    'KodeSatuan' => $satuans[$key],
                    'Keterangan' => $keterangans[$key],
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        }

        $kasir = DB::table('kasirs')->where('KodeKasir', $request->KodeKasir)->first();
        $ksr = DB::table('kasirreturns')->where('KodeKasirReturn', $newID)->first();

        //cek apakah semua item sudah direturn
        $checkitem = DB::select("SELECT (a.qty-COALESCE(SUM(ksd.qty),0)) as jml
            FROM kasirdetails a 
            inner join items i on a.KodeItem = i.KodeItem
            inner join itemkonversis k on i.KodeItem = k.KodeItem
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join kasirreturns ks on ks.KodeKasir = a.KodeKasir
            left join kasirreturndetails ksd on ksd.KodeKasirReturn = ks.KodeKasirReturn and ksd.KodeItem = a.KodeItem and ksd.KodeSatuan = k.KodeSatuan
            where a.KodeKasir='" . $ksr->KodeKasir . "' and a.KodeSatuan = k.KodeSatuan and ks.Status = 'CFM'
            group by a.KodeItem, s.NamaSatuan
            having jml > 0");
		//dd($newID,$kasir,$ksr,$checkitem);
        if (empty($checkitem)) {
            $kasir->Status = "CLS";
        }

        //update kartustok
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, a.Harga, k.Konversi
            FROM kasirreturndetails a 
            inner join kasirreturns kr on a.KodeKasirReturn = kr.KodeKasirReturn 
            inner join items i on a.KodeItem = i.KodeItem 
            inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            where kr.KodeKasirReturn='" . $newID . "'
            group by a.KodeItem, s.NamaSatuan");

        $nomer = 0;
        foreach ($items as $key => $value) {
            $last_saldo[$key] = DB::table('keluarmasukbarangs')->where('KodeItem', $value->KodeItem)->orderBy('id', 'desc')->limit(1)->pluck('saldo')->toArray();

            if ($value->Konversi > 1) {
                $value->jml = $value->jml * $value->Konversi;
            }

            if (isset($last_saldo[$key][0])) {
                $saldo = (float) $last_saldo[$key][0] + (float) $value->jml;
            } else {
                $saldo = 0 + (float) $value->jml;
            }

            $nomer++;
            DB::table('keluarmasukbarangs')->insert([
                'Tanggal' => $ksr->Tanggal,
                'KodeLokasi' => $kasir->KodeLokasi,
                'KodeItem' => $value->KodeItem,
                'JenisTransaksi' => 'RKS',
                'KodeTransaksi' => $ksr->KodeKasirReturn,
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

        $last_id_kas = DB::select('SELECT * FROM kasbanks ORDER BY KodeKasBankID DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "KM";
        if ($last_id_kas == null) {
            $newID_kas = $pref . "-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id_kas[0]->KodeKasBank;
            $ids = substr($string, -4, 4);
            $month = substr($string, -6, 2);
            $year = substr($string, -8, 2);

            if ((int) $year_now > (int) $year) {
                $newID_kas = "0001";
            } else if ((int) $month_now > (int) $month) {
                $newID_kas = "0001";
            } else {
                $newID_kas = $ids + 1;
                $newID_kas = str_pad($newID_kas, 4, '0', STR_PAD_LEFT);
            }

            $newID_kas = $pref . "-" . $year_now . $month_now . $newID_kas;
        }

        $kas = new kasbank();
        $kas->KodeKasBank = $newID_kas;
        $kas->Tanggal = $request->Tanggal;
        $kas->Status = 'CFM';
        $kas->TanggalCheque = $request->Tanggal;
        $kas->KodeBayar = $request->metode;
        $kas->TipeBayar = '';
        $kas->NoLink = '';
        $kas->BayarDari = '';
        $kas->Untuk = $request->KodePelanggan;
        $kas->KodeInvoice = $newID;
        $kas->Keterangan = $request->Keterangan;
        $kas->KodeUser = \Auth::user()->name;
        $kas->Tipe = 'RKS';
        $kas->created_at = \Carbon\Carbon::now();
        $kas->updated_at = \Carbon\Carbon::now();
        $kas->Total = $request->subtotal;
        $kas->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah return kasir ' . $newID,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Return Kasir ' . $newID . ' berhasil ditambahkan';
        return redirect('/returnKasir')->with(['created' => $pesan]);
    }

    public function index()
    {
        $kasirreturns = DB::table('kasirreturns')->where('Status', 'CFM')->orderBy('id', 'desc')->get();
        return view('penjualan.returnKasir.index', compact('kasirreturns'));
    }

    public function filterData(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        $kasirreturns = DB::table('kasirreturns')->where('Status', 'CFM')->get();
        if ($start && $end) {
            $kasirreturns = $kasirreturns->whereBetween('Tanggal', [$start . ' 00:00:01', $end . ' 23:59:59']);
        } else {
            $kasirreturns->all();
        }
        return view('penjualan.returnKasir.index', compact('kasirreturns', 'start', 'end'));
    }

    public function show($id)
    {
        $kasirreturn = DB::table('kasirreturns')->where('KodeKasirReturn', $id)->first();
        $kasir = DB::table('kasirs')->where('KodeKasir', $kasirreturn->KodeKasir)->first();
        $matauang = DB::table('matauangs')->where('KodeMataUang', $kasir->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $kasir->KodeLokasi)->first();
        $pelanggan = pelanggan::where('KodePelanggan', $kasir->KodePelanggan)->first();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, a.Harga
            FROM kasirreturndetails a
            inner join kasirreturns b on a.KodeKasirReturn = b.KodeKasirReturn
            inner join items i on a.KodeItem = i.KodeItem 
            inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan
            inner join satuans s on s.KodeSatuan = k.KodeSatuan 
            where b.KodeKasirReturn='" . $id . "' 
            group by a.KodeItem, s.NamaSatuan");
        return view('penjualan.returnKasir.show', compact('id', 'kasirreturn', 'matauang', 'lokasi', 'pelanggan', 'items', 'kasir'));
    }

    public function print($id)
    {
        $returnkasir = DB::table('kasirreturns')->where('KodeKasirReturn', $id)->first();
        $kasir = kasir::where('KodeSuratJalan', $returnkasir->KodeSuratJalan)->first();
        $driver = karyawan::where('KodeKaryawan', $kasir->KodeSopir)->first();
        $matauang = matauang::where('KodeMataUang', $kasir->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $kasir->KodeLokasi)->first();
        $pelanggan = pelanggan::where('KodePelanggan', $kasir->KodePelanggan)->first();

        $items = DB::select(
            "SELECT a.KodeItem,i.NamaItem, a.Qty, i.Keterangan, s.NamaSatuan, s.KodeSatuan, a.Harga 
        FROM kasirreturndetails a 
        inner join items i on a.KodeItem = i.KodeItem 
        inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan 
        inner join satuans s on s.KodeSatuan = k.KodeSatuan
        where a.KodeSuratJalanReturn='" . $returnkasir->KodeSuratJalanReturn . "' group by a.KodeItem, s.NamaSatuan"
        );

        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->Qty;
        }
        $returnkasir->Tanggal = \Carbon\Carbon::parse($returnkasir->Tanggal)->format('d-m-Y');

        $pdf = PDF::loadview('penjualan.returnSuratJalan.print', compact('returnkasir', 'kasir', 'driver', 'matauang', 'lokasi', 'pelanggan', 'items', 'jml'));

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Print return surat jalan ' . $returnkasir->KodeSuratJalanReturn,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return $pdf->download('ReturnSuratJalan_' . $returnkasir->KodeSuratJalanReturn . '.pdf');
    }
}
