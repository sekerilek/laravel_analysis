<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\kasir;
use App\Model\kasirreturn;
use App\Model\matauang;
use App\Model\lokasi;
use App\Model\pelanggan;
use App\Model\kasbank;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use Exception;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kasir = DB::table('kasirs')->join('lokasis', 'lokasis.KodeLokasi', '=', 'kasirs.KodeLokasi')
            ->join('pelanggans', 'pelanggans.KodePelanggan', '=', 'kasirs.KodePelanggan')
            ->select('kasirs.*', 'lokasis.NamaLokasi', 'pelanggans.NamaPelanggan')
            ->orderBy('kasirs.KodeKasir', 'desc')
            ->get();
        $kasir = $kasir->where('Status', 'CFM');
        $kasir->all();
        return view('penjualan.kasir.index', compact('kasir'));
    }

    public function filterData(Request $request)
    {
        $search = $request->get('name');
        $start = $request->get('mulai');
        $end = $request->get('sampai');
        $mulai = $request->get('mulai');
        $sampai = $request->get('sampai');
        $kasir = DB::table('kasirs')->join('lokasis', 'lokasis.KodeLokasi', '=', 'kasirs.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'kasirs.KodeMataUang')
            ->join('pelanggans', 'pelanggans.KodePelanggan', '=', 'kasirs.KodePelanggan')
            ->where('kasirs.Status', 'CFM')
            ->where(function ($query) use ($search) {
                $query->Where('kasirs.KodeKasir', 'LIKE', "%$search%");
            })->get();
        if ($start && $end) {
            $kasir = $kasir->whereBetween('Tanggal', [$start . ' 00:00:00', $end . ' 23:59:59']);
        } else {
            $kasir->all();
        }
        return view('penjualan.kasir.index', compact('kasir', 'mulai', 'sampai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasi = DB::table('lokasis')->where('Status', 'OPN')->get();
        $matauang = DB::table('matauangs')->where('Status', 'OPN')->get();
        $pelanggan = DB::table('pelanggans')->where('Status', 'OPN')->get();
        $item = DB::select("SELECT i.KodeItem, i.NamaItem, i.Keterangan 
            FROM items i
            where i.jenisitem = 'bahanjadi' and i.Status = 'OPN'
            order by i.NamaItem ");
        $satuan = DB::table('satuans')->where('Status', 'OPN')->get();

        $last_id = DB::select("SELECT * FROM kasirs WHERE KodeKasir LIKE '%KSR-%' ORDER BY KodeKasir DESC LIMIT 1");
        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');

        if ($last_id == null) {
            $newID = "KSR-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeKasir;
            $id = substr($string, -4, 4);
            $month = substr($string, -6, 2);
            $year = substr($string, -8, 2);

            if ((int) $year_now > (int) $year) {
                $newID = "0001";
            } else if ((int) $month_now > (int) $month) {
                $newID = "0001";
            } else {
                $newID = $id + 1;
                $newID = str_pad($newID, 4, '0', STR_PAD_LEFT);
            }
            $newID = "KSR-" . $year_now . $month_now . $newID;
        }

        $datasatuan = array();
        $dataharga = array();

        // dd($item);

        foreach ($item as $key => $value) {
            $array_satuan = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->pluck('KodeSatuan')->toArray();
            $datasatuan[$value->KodeItem] = $array_satuan;
            foreach ($array_satuan as $sat) {
                $array_harga = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->where('KodeSatuan', $sat)->pluck('HargaJual')->toArray();
                $dataharga[$value->KodeItem][$sat] = $array_harga[0];
            }
        }

        // dd($datasatuan);

        return view('penjualan.kasir.buat', [
            'newID' => $newID,
            'lokasi' => $lokasi,
            'matauang' => $matauang,
            'pelanggan' => $pelanggan,
            'item' => $item,
            'satuan' => $satuan,
            'datasatuan' => $datasatuan,
            'dataharga' => $dataharga,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $last_id = DB::select("SELECT * FROM kasirs WHERE KodeKasir LIKE '%KSR%' ORDER BY KodeKasir DESC LIMIT 1");
        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
		//dd($year_now,$month_now,$date_now);
        if ($last_id == null) {
            $newID = "KSR-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeKasir;
            $id = substr($string, -4, 4);
            $month = substr($string, -6, 2);
            $year = substr($string, -8, 2);
			//dd($string,$id,$month,$year);
            if ((int) $year_now > (int) $year) {
                $newID = "0001";
            } else if ((int) $month_now > (int) $month) {
                $newID = "0001";
            } else {
                $newID = $id + 1;
                $newID = str_pad($newID, 4, '0', STR_PAD_LEFT);
            }
            $newID = "KSR-" . $year_now . $month_now . $newID;
        }

        DB::table('kasirs')->insert([
            'KodeKasir' => $newID,
            'Tanggal' => $request->Tanggal,
            'KodeLokasi' => $request->KodeLokasi,
            'KodeMataUang' => $request->KodeMataUang,
            'KodePelanggan' => $request->KodePelanggan,
            'Keterangan' => $request->Keterangan,
            'Status' => 'CFM',
            'KodeUser' => \Auth::user()->name,
            'Total' => $request->subtotal,
            'PPN' => $request->ppn,
            'NilaiPPN' => $request->ppnval,
            'Printed' => 0,
            'Diskon' => $request->diskon,
            'NilaiDiskon' => $request->diskonval,
            'Subtotal' => $request->bef,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $items = $request->item;
        $qtys = $request->qty;
        $prices = $request->price;
        $totals = $request->total;
        $satuans = $request->satuan;
        $nomer = 0;
        $laba_total = 0;
        $rugi_total = 0;
        foreach ($items as $key => $value) {
            $nomer++;
            $last_harga_rata[$key] = DB::table('historihargarata')->where('KodeItem', $items[$key])->orderBy('Tanggal', 'desc')->limit(1)->pluck('HargaRata')->toArray();

            if (isset($last_harga_rata[$key][0])) {
                $harga_rata[$key] = $last_harga_rata[$key][0];
            } else {
                $harga_rata[$key] = $prices[$key];
            }
            
            $laba[$key] = 0;
            $rugi[$key] = 0;
            if($prices[$key] > $harga_rata[$key]) {
                $laba[$key] = $prices[$key] > $harga_rata[$key];
            } else {
                $rugi[$key] = $harga_rata[$key] - $prices[$key];
            }
            DB::table('rugilaba_details')->insert([
                'KodeTransaksi'      => $newID,
                'KodeItem'          => $items[$key],
                'Laba'              => $laba[$key],
                'Rugi'              => $rugi[$key],
                'created_at'        => \Carbon\Carbon::now(),
            ]);
            
            $laba_total = $laba_total + $laba[$key];
            $rugi_total = $rugi_total + $rugi[$key];

            DB::table('kasirdetails')->insert([
                'KodeKasir' => $newID,
                'KodeItem' => $items[$key],
                'Qty' => $qtys[$key],
                'Harga' => $prices[$key],
                'HargaRata' => $prices[$key],
                'KodeSatuan' => $satuans[$key],
                'NoUrut' => $nomer,
                'Subtotal' => $totals[$key],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
        
        DB::table('rugilaba')->insert([
            'KodeTransaksi'      => $newID,
            'TotalLaba'          => $laba_total,
            'TotalRugi'          => $rugi_total,
            'created_at'        => \Carbon\Carbon::now(),
        ]);

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

        $items = DB::select(
            "SELECT a.KodeItem, i.NamaItem, a.Qty, i.Keterangan, s.KodeSatuan, s.NamaSatuan, a.Harga, k.Konversi
              FROM kasirdetails a 
              inner join items i on a.KodeItem = i.KodeItem 
              inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan 
              inner join satuans s on s.KodeSatuan = k.KodeSatuan
              where a.KodeKasir='" . $newID . "' group by a.KodeItem, s.NamaSatuan"
        );

        $nomer = 0;
        foreach ($items as $key => $value) {
            $last_saldo[$key] = DB::table('keluarmasukbarangs')->where('KodeItem', $value->KodeItem)->orderBy('id', 'desc')->limit(1)->pluck('saldo')->toArray();

            $konversi = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->where('KodeSatuan', $value->KodeSatuan)->first()->Konversi;
            if ($konversi > 1) {
                $value->Qty *= $konversi;
            };

            $nomer++;
            if (isset($last_saldo[$key][0])) {
                $saldo = (float) $last_saldo[$key][0] - (float) $value->Qty;
            } else {
                $saldo = 0 - (float) $value->Qty;
            }

            DB::table('keluarmasukbarangs')->insert([
                'Tanggal' => $request->Tanggal,
                'KodeLokasi' => $request->KodeLokasi,
                'KodeItem' => $value->KodeItem,
                'JenisTransaksi' => 'KS',
                'KodeTransaksi' => $newID,
                'Qty' => -$value->Qty,
                'HargaRata' => 0,
                'KodeUser' => \Auth::user()->name,
                'idx' => $nomer,
                'indexmov' => $nomer,
                'saldo' => $saldo,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
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
        $kas->Tipe = 'KS';
        $kas->created_at = \Carbon\Carbon::now();
        $kas->updated_at = \Carbon\Carbon::now();
        $kas->Total = $request->subtotal;
        $kas->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah penjualan kasir ' . $newID,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Penjualan kasir ' . $newID . ' berhasil ditambahkan';
        return redirect('/kasir')->with(['created' => $pesan]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::select("SELECT a.KodeKasir, a.Tanggal, b.NamaMataUang, c.NamaLokasi, d.NamaPelanggan, a.Keterangan, a.Diskon, a.NilaiDiskon, a.PPN, a.Subtotal, a.Total, a.NilaiPPN from kasirs a
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join pelanggans d on d.KodePelanggan = a.KodePelanggan
            where a.KodeKasir ='" . $id .  " ' limit 1")[0];

        $items = DB::select("SELECT a.Qty, b.NamaItem,d.NamaSatuan,
            a.Harga, a.Subtotal, b.Keterangan from kasirdetails a
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem=a.KodeItem
            inner join satuans  d on d.KodeSatuan=a.KodeSatuan
            where a.KodeKasir ='" . $id . "'");
		//dd($data,$items);
        $data->Tanggal = Carbon::parse($data->Tanggal)->format('d-m-Y');
		
        return view('penjualan.kasir.show', compact('data', 'id', 'items'));
    }

    public function print($id)
    {
        $kasir = DB::table('kasirs')->where('KodeKasir', $id)->first();
        $kasirreturn = DB::table('kasirreturns')->where('KodeKasir', $id)->where('Status', 'CFM')->get();
        $matauang = matauang::where('KodeMataUang', $kasir->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $kasir->KodeLokasi)->first();
        $pelanggan = pelanggan::where('KodePelanggan', $kasir->KodePelanggan)->first();

        $items = DB::select(
            "SELECT a.KodeItem, i.NamaItem, i.Keterangan, s.KodeSatuan, s.NamaSatuan, a.Harga,
            COALESCE(a.qty,0)-COALESCE(SUM(ksrd.Qty),0) as Qty
            FROM kasirdetails a inner join items i on a.KodeItem = i.KodeItem 
            inner join itemkonversis k on i.KodeItem = k.KodeItem
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join kasirs ks on ks.KodeKasir = a.KodeKasir and ks.Status='CFM'
            left join kasirreturns ksr on ksr.KodeKasir = ks.KodeKasir and ksr.Status = 'CFM'
            left join kasirreturndetails ksrd on ksrd.KodeKasirReturn = ksr.KodeKasirReturn and ksrd.KodeItem = a.KodeItem and ksrd.KodeSatuan = k.KodeSatuan
            where ks.KodeKasir='" . $kasir->KodeKasir . "' and a.KodeSatuan = k.KodeSatuan
            group by a.KodeItem, s.KodeSatuan"
        );
        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->Qty;
        }
        $kasir->Tanggal = Carbon::parse($kasir->Tanggal)->format('d/m/Y');

        $pdf = PDF::loadview('penjualan.kasir.print', compact('kasir', 'kasirreturn', 'matauang', 'lokasi', 'pelanggan', 'id', 'items', 'jml'));

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Print penjualan kasir ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return $pdf->download('Kasir_' . $id . '.pdf');
    }
}
