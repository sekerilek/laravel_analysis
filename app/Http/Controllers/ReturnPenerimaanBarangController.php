<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use DB;
use PDF;
use Carbon\Carbon;
use App\Model\penerimaanbarangreturn;
use App\Model\penerimaanbarang;
use App\Model\lokasi;
use App\Model\supplier;
use App\Model\karyawan;
use App\Model\matauang;
use App\Model\invoicehutang;
use App\Model\invoicehutangdetail;
use App\Model\pelunasanhutang;

class ReturnPenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penerimaanbarangreturns = penerimaanbarangreturn::where('Status', 'OPN')->orderBy('id', 'desc')->get();
        return view('pembelian.returnPenerimaanBarang.index', compact('penerimaanbarangreturns'));
    }

    public function konfirmasi()
    {
        $penerimaanbarangreturns = penerimaanbarangreturn::where('Status', 'CFM')->orderBy('id', 'desc')->get();
        return view('pembelian.returnPenerimaanBarang.konfirmasi', compact('penerimaanbarangreturns'));
    }

    public function batal()
    {
        $penerimaanbarangreturns = penerimaanbarangreturn::where('Status', 'DEL')->orderBy('id', 'desc')->get();
        return view('pembelian.returnPenerimaanBarang.batal', compact('penerimaanbarangreturns'));
    }

    public function filterData(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        $penerimaanbarangreturns = penerimaanbarangreturn::where('Status', 'OPN')->get();
        if ($start && $end) {
            $penerimaanbarangreturns = $penerimaanbarangreturns->whereBetween('Tanggal', [$start . ' 00:00:01', $end . ' 23:59:59']);
        } else {
            $penerimaanbarangreturns->all();
        }
        return view('pembelian.returnPenerimaanBarang.index', compact('penerimaanbarangreturns', 'start', 'end'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pb = DB::select("SELECT DISTINCT a.KodePenerimaanBarang from (
            SELECT a.KodePenerimaanBarang, a.KodeItem, 
            COALESCE(SUM(a.qty))-COALESCE(SUM(pbrd.Qty),0) as jml
            FROM penerimaanbarangdetails a 
            inner join items i on a.KodeItem = i.KodeItem
            inner join itemkonversis k on i.KodeItem = k.KodeItem
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            inner join penerimaanbarangs pb on pb.KodePenerimaanBarang = a.KodePenerimaanBarang and pb.Status='CFM'
            inner join invoicehutangdetails ihd on ihd.KodeLPB = pb.KodePenerimaanBarang
            inner join invoicehutangs ih on ih.KodeInvoiceHutang = ihd.KodeInvoiceHutang and ih.Status='OPN'
            left join penerimaanbarangreturns pbr on pbr.KodePenerimaanBarang = pb.KodePenerimaanBarang
            left join penerimaanbarangreturndetails pbrd on pbrd.KodePenerimaanBarangReturn = pbr.KodePenerimaanBarangReturn and pbrd.KodeItem = a.KodeItem and pbrd.KodeSatuan = k.KodeSatuan
            where pb.Status = 'CFM' and a.KodeSatuan = k.KodeSatuan
            group by a.KodeItem, a.KodeSatuan, a.KodePenerimaanBarang
            having jml > 0) as a");

        if ($id == "0") {
            if (count($pb) <= 0) {
                return redirect('/penerimaanBarang/create/0');
            }
            $id = $pb[0]->KodePenerimaanBarang;
        }

        $items = DB::select("SELECT a.KodeItem, i.NamaItem, i.Keterangan, s.KodeSatuan, s.NamaSatuan, a.Harga,
            COALESCE(a.qty,0)-COALESCE(SUM(pbrd.Qty),0) as jml
            FROM penerimaanbarangdetails a inner join items i on a.KodeItem = i.KodeItem 
            inner join itemkonversis k on i.KodeItem = k.KodeItem 
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join penerimaanbarangs pb on pb.KodePenerimaanBarang = a.KodePenerimaanBarang and pb.Status='CFM'
            left join penerimaanbarangreturns pbr on pbr.KodePenerimaanBarang = pb.KodePenerimaanBarang and pbr.Status = 'CFM'
            left join penerimaanbarangreturndetails pbrd on pbrd.KodePenerimaanBarangReturn = pbr.KodePenerimaanBarangReturn and pbrd.KodeItem = a.KodeItem and pbrd.KodeSatuan = k.KodeSatuan
            where pb.KodePenerimaanBarang='" . $id . "' and a.KodeSatuan = k.KodeSatuan
            group by a.KodeItem, s.KodeSatuan
            having jml > 0");
        $po = DB::select("select po.* from penerimaanbarangs pb inner join pemesananpembelians po on po.KodePO 
            = pb.KodePO where pb.KodePenerimaanBarang='" . $id . "'")[0];
        $pbDet = penerimaanbarang::where('KodePenerimaanBarang', $id)->first();
        $sales = karyawan::where('KodeKaryawan', $pbDet->KodeSales)->first();
        return view('pembelian.returnPenerimaanBarang.buat', compact('pb', 'id', 'items', 'po', 'sales', 'pbDet'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $last_id = DB::select('SELECT * FROM penerimaanbarangreturns WHERE KodePenerimaanBarangReturn LIKE "%RPB-0%" ORDER BY id DESC LIMIT 1');
        $last_id_tax = DB::select('SELECT * FROM penerimaanbarangreturns WHERE KodePenerimaanBarangReturn LIKE "%RPB-1%" ORDER BY id DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "RPB-0";
        if ($request->ppn == 'ya') {
            $pref = "RPB-1";

            if ($last_id_tax == null) {
                $newID = $pref . $year_now . $month_now . "0001";
            } else {
                $string = $last_id_tax[0]->KodePenerimaanBarangReturn;
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
                $string = $last_id[0]->KodePenerimaanBarangReturn;
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

        DB::table('penerimaanbarangreturns')->insert([
            'KodePenerimaanBarangReturn' => $newID,
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
            'KodePenerimaanBarang' => $request->KodePB,
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
                DB::table('penerimaanbarangreturndetails')->insert([
                    'KodePenerimaanBarangReturn' => $newID,
                    'KodeItem' => $items[$key],
                    'Qty' => $qtys[$key],
                    'Harga' => $prices[$key],
                    'NoUrut' => $nomer,
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
            'Keterangan' => 'Tambah return penerimaan barang ' . $newID,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Return Penerimaan Barang ' . $newID . ' berhasil ditambahkan';
        return redirect('/returnPenerimaanBarang')->with(['created' => $pesan]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penerimaanbarangreturn = penerimaanbarangreturn::where('KodePenerimaanBarangReturn', $id)->first();
        $penerimaanbarang = penerimaanbarang::where('KodePenerimaanBarang', $penerimaanbarangreturn->KodePenerimaanBarang)->first();
        $sales = karyawan::where('KodeKaryawan', $penerimaanbarang->KodeSales)->first();
        $matauang = matauang::where('KodeMataUang', $penerimaanbarang->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $penerimaanbarang->KodeLokasi)->first();
        $supplier = supplier::where('KodeSupplier', $penerimaanbarang->KodeSupplier)->first();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, a.Harga
            FROM penerimaanbarangreturndetails a
            inner join penerimaanbarangreturns b on a.KodePenerimaanBarangReturn = b.KodePenerimaanBarangReturn
            inner join items i on a.KodeItem = i.KodeItem 
            inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan
            inner join satuans s on s.KodeSatuan = k.KodeSatuan 
            where b.KodePenerimaanBarangReturn='" . $id . "' 
            group by a.KodeItem, s.NamaSatuan");
        return view('pembelian.returnPenerimaanBarang.show', compact('id', 'penerimaanbarangreturn', 'sales', 'matauang', 'lokasi', 'supplier', 'items', 'penerimaanbarang'));
    }

    public function lihat($id)
    {
        $penerimaanbarangreturn = penerimaanbarangreturn::where('KodePenerimaanBarangReturn', $id)->first();
        $penerimaanbarang = penerimaanbarang::where('KodePenerimaanBarang', $penerimaanbarangreturn->KodePenerimaanBarang)->first();
        $sales = karyawan::where('KodeKaryawan', $penerimaanbarang->KodeSales)->first();
        $matauang = matauang::where('KodeMataUang', $penerimaanbarang->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $penerimaanbarang->KodeLokasi)->first();
        $supplier = supplier::where('KodeSupplier', $penerimaanbarang->KodeSupplier)->first();
        $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, a.Harga
            FROM penerimaanbarangreturndetails a
            inner join penerimaanbarangreturns b on a.KodePenerimaanBarangReturn = b.KodePenerimaanBarangReturn
            inner join items i on a.KodeItem = i.KodeItem 
            inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan
            inner join satuans s on s.KodeSatuan = k.KodeSatuan 
            where b.KodePenerimaanBarangReturn='" . $id . "' 
            group by a.KodeItem, s.NamaSatuan");
        return view('pembelian.returnPenerimaanBarang.lihat', compact('id', 'penerimaanbarangreturn', 'sales', 'matauang', 'lokasi', 'supplier', 'items', 'penerimaanbarang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        DB::table('penerimaanbarangreturns')->where('KodePenerimaanBarangReturn', $id)->update([
            'Status' => 'DEL'
        ]);

        $pbr = DB::table('penerimaanbarangreturns')->where('KodePenerimaanBarangReturn', $id)->first();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus return penerimaan barang ' . $pbr->KodePenerimaanBarangReturn,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return redirect('/returnPenerimaanBarang');
    }

    public function confirm($id)
    {
        $pbr = penerimaanbarangreturn::where('KodePenerimaanBarangReturn', $id)->first();

        $checkresult = DB::select("SELECT (a.qty-COALESCE(SUM(pbd.qty),0)-COALESCE(pbdc.qty,0)) as jml
            FROM penerimaanbarangdetails a 
            inner join items i on a.KodeItem = i.KodeItem
            inner join itemkonversis k on i.KodeItem = k.KodeItem
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join penerimaanbarangreturns pb on pb.KodePenerimaanBarang = a.KodePenerimaanBarang and pb.Status = 'CFM'
            left join penerimaanbarangreturndetails pbd on pbd.KodePenerimaanBarangReturn = pb.KodePenerimaanBarangReturn and pbd.KodeItem = a.KodeItem and pbd.KodeSatuan = k.KodeSatuan
            left join penerimaanbarangreturndetails pbdc on pbdc.KodePenerimaanBarangReturn = '" . $pbr['KodePenerimaanBarangReturn'] . "' and pbdc.KodeItem = a.KodeItem and pbdc.KodeSatuan = k.KodeSatuan
            where a.KodePenerimaanBarang='" . $pbr['KodePenerimaanBarang'] . "' and a.KodeSatuan = k.KodeSatuan
            group by a.KodeItem, s.NamaSatuan
            having jml < 0");

        if (empty($checkresult)) {
            $penerimaanbarangreturn = penerimaanbarangreturn::where('KodePenerimaanBarangReturn', $id)->first();
            $ppn = $penerimaanbarangreturn->PPN;
            $diskon = $penerimaanbarangreturn->Diskon;
            $totalreturn = $penerimaanbarangreturn->Total;
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

            //cek hasil invoice apakah setelah return menjadi minus
            $penerimaanbarang = penerimaanbarang::where('KodePenerimaanBarang', $penerimaanbarangreturn->KodePenerimaanBarang)->first();
            $invoice = invoicehutangdetail::where('KodeLPB', $penerimaanbarangreturn->KodePenerimaanBarang)->first();
            $hutang = invoicehutang::where('KodeInvoiceHutangShow', $invoice->KodeHutang)->first();
            $payments = pelunasanhutang::where('KodeInvoice', $hutang->KodeInvoiceHutang)->get();

            $tot = 0;
            foreach ($payments as $bill) {
                $tot += $bill->Jumlah;
            }

            $sisa = $invoice->Subtotal - $tot - $invoice->TotalReturn - $totalreturn;
            if ($sisa < 0) {
                $pesan = 'Return Penerimaan Barang tidak dikonfirmasi karena hasil Invoive menjadi minus, mohon periksa kembali jumlah item pada Penerimaan Barang yang dapat direturn';
                return redirect('/returnPenerimaanBarang')->with(['error' => $pesan]);
            } else {
                //update totalreturn
                if (!empty($invoice)) {
                    $invoice->TotalReturn += $totalreturn;
                    $invoice->save();
                }

                //update status jika sudah lunas
                if ($sisa == 0) {
                    DB::table('invoicehutangs')->where('KodeInvoiceHutang', $hutang->KodeInvoiceHutang)->update([
                        'Status' => 'CLS'
                    ]);
                }

                //update status penerimaanbarangreturn
                $penerimaanbarangreturn->Status = "CFM";
                $penerimaanbarangreturn->save();

                //cek apakah semua item sudah direturn
                $checkitem = DB::select("SELECT (a.qty-COALESCE(SUM(pbd.qty),0)) as jml
                FROM penerimaanbarangdetails a 
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis k on i.KodeItem = k.KodeItem
                inner join satuans s on s.KodeSatuan = k.KodeSatuan
                left join penerimaanbarangreturns pb on pb.KodePenerimaanBarang = a.KodePenerimaanBarang
                left join penerimaanbarangreturndetails pbd on pbd.KodePenerimaanBarangReturn = pb.KodePenerimaanBarangReturn and pbd.KodeItem = a.KodeItem and pbd.KodeSatuan = k.KodeSatuan
                where a.KodePenerimaanBarang='" . $pbr['KodePenerimaanBarang'] . "' and a.KodeSatuan = k.KodeSatuan and pb.Status = 'CFM'
                group by a.KodeItem, s.NamaSatuan
                having jml > 0");

                if (empty($checkitem)) {
                    $penerimaanbarang->Status = "CLS";
                    $penerimaanbarang->save();
                }

                //update kartustok
                $items = DB::select("SELECT a.KodeItem,i.NamaItem, SUM(a.Qty) as jml, i.Keterangan, s.NamaSatuan, a.Harga, k.Konversi
                    FROM penerimaanbarangreturndetails a 
                    inner join penerimaanbarangreturns pb on a.KodePenerimaanBarangReturn = pb.KodePenerimaanBarangReturn 
                    inner join items i on a.KodeItem = i.KodeItem 
                    inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan
                    inner join satuans s on s.KodeSatuan = k.KodeSatuan
                    where pb.KodePenerimaanBarangReturn='" . $id . "'
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
                        $saldo = (float) $last_saldo[$key][0] - (float) $value->jml;
                    } else {
                        $saldo = 0 - (float) $value->jml;
                    }
                    $nomer++;
                    DB::table('keluarmasukbarangs')->insert([
                        'Tanggal' => $penerimaanbarangreturn->Tanggal,
                        'KodeLokasi' => $penerimaanbarang->KodeLokasi,
                        'KodeItem' => $value->KodeItem,
                        'JenisTransaksi' => 'RPB',
                        'KodeTransaksi' => $penerimaanbarangreturn->KodePenerimaanBarangReturn,
                        'Qty' => -$value->jml,
                        'HargaRata' => 0,
                        'KodeUser' => \Auth::user()->name,
                        'idx' => $nomer,
                        'indexmov' => $nomer,
                        'saldo' => $saldo,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()
                    ]);
                }

                DB::table('eventlogs')->insert([
                    'KodeUser' => \Auth::user()->name,
                    'Tanggal' => \Carbon\Carbon::now(),
                    'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
                    'Keterangan' => 'Konfirmasi return penerimaan barang ' . $penerimaanbarangreturn->KodePenerimaanBarangReturn,
                    'Tipe' => 'OPN',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);

                $pesan = 'Return Penerimaan Barang ' . $penerimaanbarangreturn->KodePenerimaanBarangReturn . ' berhasil dikonfirmasi';
                return redirect('/konfirmasiReturnPenerimaanBarang')->with(['created' => $pesan]);
            }
        } else {
            $pesan = 'Return Penerimaan Barang tidak dikonfirmasi karena hasil item menjadi minus, mohon periksa kembali jumlah item pada Penerimaan Barang yang dapat direturn';
            return redirect('/returnPenerimaanBarang')->with(['error' => $pesan]);
        }
    }

    public function print($id)
    {
        $returnpenerimaanbarang = penerimaanbarangreturn::where('KodePenerimaanBarangReturn', $id)->first();
        $penerimaanbarang = penerimaanbarang::where('KodePenerimaanBarang', $returnpenerimaanbarang->KodePenerimaanBarang)->first();
        $sales = karyawan::where('KodeKaryawan', $penerimaanbarang->KodeSales)->first();
        $matauang = matauang::where('KodeMataUang', $penerimaanbarang->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $penerimaanbarang->KodeLokasi)->first();
        $supplier = supplier::where('KodeSupplier', $penerimaanbarang->KodeSupplier)->first();

        $items = DB::select(
            "SELECT a.KodeItem,i.NamaItem, a.Qty, i.Keterangan, s.NamaSatuan, a.Harga, s.KodeSatuan
        FROM penerimaanbarangreturndetails a 
        inner join items i on a.KodeItem = i.KodeItem 
        inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan 
        inner join satuans s on s.KodeSatuan = k.KodeSatuan
        where a.KodePenerimaanBarangReturn='" . $id . "' group by a.KodeItem, s.NamaSatuan"
        );

        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->Qty;
        }
        $penerimaanbarang->Tanggal = \Carbon\Carbon::parse($penerimaanbarang->Tanggal)->format('d-m-Y');

        $pdf = PDF::loadview('pembelian.returnPenerimaanBarang.print', compact('returnpenerimaanbarang', 'penerimaanbarang', 'sales', 'matauang', 'lokasi', 'supplier', 'items', 'jml'));

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Print return penerimaan barang ' . $returnpenerimaanbarang->KodePenerimaanBarangReturn,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return $pdf->download('ReturnPenerimaanBarang_' . $returnpenerimaanbarang->KodePenerimaanBarangReturn . '.pdf');
    }
}
