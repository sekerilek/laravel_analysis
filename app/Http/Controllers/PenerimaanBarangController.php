<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use DB;
use PDF;
use App\Model\penerimaanbarang;
use App\Model\pemesananpembelian;
use App\Model\lokasi;
use App\Model\supplier;
use App\Model\karyawan;
use App\Model\matauang;
use App\Model\invoicehutang;
use Carbon\Carbon;

class PenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penerimaanbarangs = DB::table('penerimaanbarangs')
            ->join('lokasis', 'penerimaanbarangs.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('suppliers', 'penerimaanbarangs.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('penerimaanbarangs.*', 'lokasis.NamaLokasi', 'suppliers.NamaSupplier')
            // ->where('penerimaanbarangs.Status', 'CFM')
            ->orderBy('penerimaanbarangs.id', 'desc')
            ->get();

        return view('pembelian.penerimaanBarang.index', compact('penerimaanbarangs'));
    }

    public function filterData(Request $request)
    {
        $search = $request->get('name');
        $start = $request->get('start');
        $end = $request->get('end');
        $penerimaanbarangs = penerimaanbarang::join('suppliers', 'suppliers.KodeSupplier', '=', 'penerimaanbarangs.KodeSupplier')
            ->Where('penerimaanbarangs.Status', 'OPN')
            ->Where(function ($query) use ($search) {
                $query->Where('suppliers.NamaSupplier', 'LIKE', "%$search%")
                    ->orWhere('penerimaanbarangs.KodePenerimaanBarang', 'LIKE', "%$search%")
                    ->orWhere('penerimaanbarangs.KodePO', 'LIKE', "%$search%");
            })->get();
        if ($start && $end) {
            $penerimaanbarangs = $penerimaanbarangs->whereBetween('Tanggal', [$start . ' 00:00:01', $end . ' 23:59:59']);
        } else {
            $penerimaanbarangs->all();
        }
        return view('pembelian.penerimaanBarang.index', compact('penerimaanbarangs', 'start', 'end'));
    }

    public function konfirmasiPenerimaanBarang()
    {
        $penerimaanbarangs = DB::table('penerimaanbarangs')
            ->join('lokasis', 'penerimaanbarangs.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('suppliers', 'penerimaanbarangs.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('penerimaanbarangs.*', 'lokasis.NamaLokasi', 'suppliers.NamaSupplier')
            ->where('penerimaanbarangs.Status', 'CFM')
            ->orderBy('penerimaanbarangs.id', 'desc')
            ->get();

        return view('pembelian.penerimaanBarang.konfirmasi', compact('penerimaanbarangs'));
    }

    public function filterKonfirmasiPenerimaanBarang(Request $request)
    {
        $search = $request->get('name');
        $start = $request->get('start');
        $end = $request->get('end');
        $penerimaanbarangs = penerimaanbarang::join('suppliers', 'suppliers.KodeSupplier', '=', 'penerimaanbarangs.KodeSupplier')
            ->Where('penerimaanbarangs.Status', 'OPN')
            ->Where(function ($query) use ($search) {
                $query->Where('suppliers.NamaSupplier', 'LIKE', "%$search%")
                    ->orWhere('penerimaanbarangs.KodePenerimaanBarang', 'LIKE', "%$search%")
                    ->orWhere('penerimaanbarangs.KodePO', 'LIKE', "%$search%");
            })->get();
        if ($start && $end) {
            $penerimaanbarangs = $penerimaanbarangs->whereBetween('Tanggal', [$start . ' 00:00:01', $end . ' 23:59:59']);
        } else {
            $penerimaanbarangs->all();
        }
        return view('pembelian.penerimaanBarang.index', compact('penerimaanbarangs', 'start', 'end'));
    }

    public function createBySup()
    {
        $suppliers = DB::table('suppliers')->where('Status', 'OPN')->get();
        return view('pembelian.penerimaanBarang.buat', compact('suppliers'));
    }

    public function batalPenerimaanBarang()
    {
        $penerimaanbarangs = DB::table('penerimaanbarangs')
            ->join('lokasis', 'penerimaanbarangs.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('suppliers', 'penerimaanbarangs.KodeSupplier', '=', 'suppliers.KodeSupplier')
            ->select('penerimaanbarangs.*', 'lokasis.NamaLokasi', 'suppliers.NamaSupplier')
            ->where('penerimaanbarangs.Status', 'DEL')
            ->get();

        return view('pembelian.penerimaanBarang.batal', compact('penerimaanbarangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createBasedPO($id)
    {
        $sales = DB::table('karyawans')->where('Status', 'OPN')->where('KodeJabatan', 'sales')->get();
        $pemesananpembelian = DB::select("SELECT DISTINCT a.KodePO from (
            SELECT DISTINCT a.KodePO,
            COALESCE(a.qty,0)-COALESCE(SUM(pbd.qty),0) as jml
            FROM pemesananpembeliandetails a 
            inner join items i on a.KodeItem = i.KodeItem
            inner join itemkonversis k on i.KodeItem = k.KodeItem
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join penerimaanbarangs pb on pb.KodePO = a.KodePO
            left join penerimaanbarangdetails pbd on pbd.KodePenerimaanBarang = pb.KodePenerimaanBarang and pbd.KodeItem = a.KodeItem and pbd.KodeSatuan = k.KodeSatuan
            inner join pemesananpembelians p on p.KodePO = a.KodePO
            where p.Status = 'CFM' and a.KodeSatuan = k.KodeSatuan
            group by a.KodeItem, a.KodeSatuan, a.KodePO
            having jml > 0) as a");
        if ($id == "0") {
            if (count($pemesananpembelian) <= 0) {
                return redirect('/popembelian/create');
            }
            $id = $pemesananpembelian[0]->KodePO;
        }
        $suppliers = DB::table('suppliers')->where('Status', 'OPN')->get();
        $lokasis = DB::table('lokasis')->where('Status', 'OPN')->get();
        $items = DB::select("SELECT a.KodeItem, i.NamaItem, i.Keterangan, s.KodeSatuan, s.NamaSatuan, a.Harga,
            COALESCE(a.qty,0)-COALESCE(SUM(pbd.qty),0) as jml
            FROM pemesananpembeliandetails a 
            inner join items i on a.KodeItem = i.KodeItem
            inner join itemkonversis k on i.KodeItem = k.KodeItem
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join penerimaanbarangs pb on pb.KodePO = a.KodePO and pb.Status = 'CFM'
            left join penerimaanbarangdetails pbd on pbd.KodePenerimaanBarang = pb.KodePenerimaanBarang and pbd.KodeItem = a.KodeItem and pbd.KodeSatuan = k.KodeSatuan
            where a.KodePO='" . $id . "' and a.KodeSatuan = k.KodeSatuan
            group by a.KodeItem, s.NamaSatuan
            having jml > 0");
        $po = pemesananpembelian::where('KodePO', $id)->first();
        $matauang = DB::table('matauangs')->where('Status', 'OPN')->get();

        return view('pembelian.penerimaanBarang.buatAjax', compact(
            'pemesananpembelian',
            'id',
            'suppliers',
            'lokasis',
            'sales',
            'items',
            'po',
            'matauang'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $last_id = DB::select('SELECT * FROM penerimaanbarangs WHERE KodePenerimaanBarang LIKE "%LPB-0%" ORDER BY id DESC LIMIT 1');
        $last_id_tax = DB::select('SELECT * FROM penerimaanbarangs WHERE KodePenerimaanBarang LIKE "%LPB-1%" ORDER BY id DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "LPB-0";
        if ($request->ppn == 'ya') {
            $pref = "LPB-1";

            if ($last_id_tax == null) {
                $newID = $pref . $year_now . $month_now . "0001";
            } else {
                $string = $last_id_tax[0]->KodePenerimaanBarang;
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
                $string = $last_id[0]->KodePenerimaanBarang;
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

        DB::table('penerimaanbarangs')->insert([
            'KodePenerimaanBarang' => $newID,
            'Tanggal' => $request->Tanggal,
            'KodeLokasi' => $request->KodeLokasi,
            'KodeMataUang' => $request->KodeMataUang,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'Total' => 0,
            'PPN' => $request->ppn,
            'NilaiPPN' => $request->ppnval,
            'KodeSupplier' => $request->KodeSupplier,
            'Printed' => 0,
            'Diskon' => $request->diskon,
            'NilaiDiskon' => $request->diskonval,
            'Subtotal' => $request->subtotal,
            'KodePO' => $request->KodePO,
            'NoFaktur' => $request->NoFaktur,
            'KodeSales' => $request->KodeSales,
            'KodeSJ' => $request->KodeSJ,
            'TotalItem' => $request->TotalItem,
            'Keterangan' => $request->InputKeterangan,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $items = $request->item;
        $qtys = $request->qty;
        $prices = $request->price;
        $keterangans = $request->keterangan;
        $satuans = $request->satuan;
        $nomer = 0;
        foreach ($items as $key => $value) {
            if ($qtys[$key] != 0) {
                $nomer++;
                DB::table('penerimaanbarangdetails')->insert([
                    'KodePenerimaanBarang' => $newID,
                    'KodeItem' => $items[$key],
                    'Qty' => $qtys[$key],
                    'Harga' => $prices[$key],
                    'Keterangan' => $keterangans[$key],
                    'KodeSatuan' => $satuans[$key],
                    'NoUrut' => $nomer,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Buat penerimaan barang ' . $newID,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return redirect('/penerimaanBarang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penerimaanbarang = penerimaanbarang::where('KodePenerimaanBarang', $id)->first();
        $sales = karyawan::where('KodeKaryawan', $penerimaanbarang->KodeSales)->first();
        $matauang = matauang::where('KodeMataUang', $penerimaanbarang->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $penerimaanbarang->KodeLokasi)->first();
        $supplier = supplier::where('KodeSupplier', $penerimaanbarang->KodeSupplier)->first();
        $items = DB::select(
            "SELECT a.KodeItem,i.NamaItem, a.Qty as jml, i.Keterangan, s.NamaSatuan, a.Harga 
              FROM penerimaanbarangdetails a 
              inner join items i on a.KodeItem = i.KodeItem 
              inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan
              inner join satuans s on s.KodeSatuan = k.KodeSatuan 
              where a.KodePenerimaanBarang='" . $penerimaanbarang->KodePenerimaanBarang . "' 
              group by a.KodeItem, s.NamaSatuan"
        );
        return view('pembelian.penerimaanBarang.show', compact('id', 'penerimaanbarang', 'lokasi', 'supplier', 'items', 'sales', 'matauang'));
    }

    public function lihat($id)
    {
        $penerimaanbarang = penerimaanbarang::where('KodePenerimaanBarang', $id)->first();
        $sales = karyawan::where('KodeKaryawan', $penerimaanbarang->KodeSales)->first();
        $matauang = matauang::where('KodeMataUang', $penerimaanbarang->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $penerimaanbarang->KodeLokasi)->first();
        $supplier = supplier::where('KodeSupplier', $penerimaanbarang->KodeSupplier)->first();
        $items = DB::select(
            "SELECT a.KodeItem,i.NamaItem, a.Qty as jml, i.Keterangan, s.NamaSatuan, a.Harga 
              FROM penerimaanbarangdetails a 
              inner join items i on a.KodeItem = i.KodeItem 
              inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan
              inner join satuans s on s.KodeSatuan = k.KodeSatuan 
              where a.KodePenerimaanBarang='" . $penerimaanbarang->KodePenerimaanBarang . "' 
              group by a.KodeItem, s.NamaSatuan"
        );
        return view('pembelian.penerimaanBarang.lihat', compact('id', 'penerimaanbarang', 'lokasi', 'supplier', 'items', 'sales', 'matauang'));
    }

    public function searchPOBySupId($id)
    {
        $po = DB::table('pemesananpembelians')->where('KodeSupplier', $id)->where('Status', 'CFM')->get();
        if ($po != null) {
            $kodePO = array();
            foreach ($po as $poItem) {
                array_push($kodePO, $poItem->KodePO);
            }
            return response()->json($kodePO);
        } else {
            return response()->json([]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penerimaanbarang = penerimaanbarang::where('KodePenerimaanBarang', $id)->first();
        $sales = DB::table('karyawans')->where('Status', 'OPN')->where('KodeJabatan', 'Sales')->get();
        $matauang = DB::table('matauangs')->where('Status', 'OPN')->get();
        $lokasi = DB::table('lokasis')->where('Status', 'OPN')->get();
        $supplier = supplier::where('KodeSupplier', $penerimaanbarang->KodeSupplier)->first();
        $items = DB::select("SELECT a.KodeItem, i.NamaItem, i.Keterangan, s.KodeSatuan, s.NamaSatuan, a.Harga, pbd.Qty as jml,
        COALESCE(a.qty,0)-COALESCE(SUM(pbdt.qty),0) as max
        FROM pemesananpembeliandetails a 
        inner join items i on a.KodeItem = i.KodeItem
        inner join itemkonversis k on i.KodeItem = k.KodeItem
        inner join satuans s on s.KodeSatuan = k.KodeSatuan
        left join penerimaanbarangs pb on pb.KodePO = a.KodePO and pb.Status = 'CFM'
        left join penerimaanbarangdetails pbdt on pbdt.KodePenerimaanBarang = pb.KodePenerimaanBarang and pbdt.KodeItem = a.KodeItem and pbdt.KodeSatuan = k.KodeSatuan
        left join penerimaanbarangdetails pbd on pbd.KodePenerimaanBarang='" . $penerimaanbarang->KodePenerimaanBarang . "' and pbd.KodeItem = a.KodeItem and pbd.KodeSatuan = k.KodeSatuan
        where a.KodePO='" . $penerimaanbarang->KodePO . "' and a.KodeSatuan = k.KodeSatuan
        group by a.KodeItem, s.NamaSatuan
        having max > 0
    ");

        return view('pembelian.penerimaanBarang.edit', compact('id', 'penerimaanbarang', 'sales', 'matauang', 'lokasi', 'supplier', 'items'));
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
        DB::table('penerimaanbarangs')
            ->where('KodePenerimaanBarang', $request->KodePB)
            ->update([
                'Tanggal' => $request->Tanggal,
                'KodeLokasi' => $request->KodeLokasi,
                'KodeMataUang' => $request->KodeMataUang,
                'KodeUser' => \Auth::user()->name,
                'PPN' => $request->ppn,
                'NilaiPPN' => $request->ppnval,
                'Diskon' => $request->diskon,
                'NilaiDiskon' => $request->diskonval,
                'Subtotal' => $request->subtotal,
                'NoFaktur' => $request->NoFaktur,
                'KodeSales' => $request->KodeSales,
                'KodeSJ' => $request->KodeSJ,
                'TotalItem' => $request->TotalItem,
                'Keterangan' => $request->InputKeterangan,
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        $items = $request->item;
        $qtys = $request->qty;
        $prices = $request->price;
        $keterangans = $request->keterangan;
        $satuans = $request->satuan;
        $nomer = 0;
        foreach ($items as $key => $value) {
            $nomer++;
            DB::table('penerimaanbarangdetails')
                ->where('KodePenerimaanBarang', $request->KodePB)
                ->where('NoUrut', $nomer)
                ->update([
                    'KodeItem' => $items[$key],
                    'Qty' => $qtys[$key],
                    'Harga' => $prices[$key],
                    'Keterangan' => $keterangans[$key],
                    'KodeSatuan' => $satuans[$key],
                    'NoUrut' => $nomer,
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update penerimaan barang ' . $request->KodePB,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Penerimaan barang ' . $request->KodePB . ' berhasil diupdate';
        return redirect('/penerimaanBarang')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('penerimaanbarangs')->where('KodePenerimaanBarang', $id)->update([
            'Status' => 'DEL'
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus penerimaan barang ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Penerimaan barang ' . $id . ' berhasil dihapus';
        return redirect('/penerimaanBarang')->with(['deleted' => $pesan]);
    }

    public function confirm($id)
    {
        $pb = penerimaanbarang::where('KodePenerimaanBarang', $id)->first();
        $checkresult = DB::select("SELECT (a.qty-COALESCE(SUM(pbd.qty),0)-COALESCE(pbdc.qty,0)) as jml
            FROM pemesananpembeliandetails a 
            inner join items i on a.KodeItem = i.KodeItem
            inner join itemkonversis k on i.KodeItem = k.KodeItem
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join penerimaanbarangs pb on pb.KodePO = a.KodePO and pb.Status = 'CFM'
            left join penerimaanbarangdetails pbd on pbd.KodePenerimaanBarang = pb.KodePenerimaanBarang and pbd.KodeItem = a.KodeItem and pbd.KodeSatuan = k.KodeSatuan
            left join penerimaanbarangdetails pbdc on pbdc.KodeItem = a.KodeItem and pbdc.KodeSatuan = k.KodeSatuan and pbdc.KodePenerimaanBarang ='" . $pb['KodePenerimaanBarang'] . "'
            where a.KodePO='" . $pb['KodePO'] . "' and a.KodeSatuan = k.KodeSatuan
            group by a.KodeItem, s.NamaSatuan
            having jml < 0");

        if (empty($checkresult)) {
            $data = penerimaanbarang::where('KodePenerimaanBarang', $id)->first();
            $data->Status = "CFM";
            $data->save();
            $po = pemesananpembelian::find($data->KodePO);
            $items = DB::select(
                "SELECT a.KodeItem,i.NamaItem, a.Qty as jml, i.Keterangan, s.NamaSatuan, a.Harga, k.Konversi
                FROM penerimaanbarangdetails a 
                inner join items i on a.KodeItem = i.KodeItem 
                inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan 
                inner join satuans s on s.KodeSatuan = k.KodeSatuan
                where a.KodePenerimaanBarang='" . $data->KodePenerimaanBarang . "' group by a.KodeItem, s.NamaSatuan"
            );

            $checkitem = DB::select("SELECT (a.qty-COALESCE(SUM(pbd.qty),0)) as jml
                FROM pemesananpembeliandetails a 
                inner join items i on a.KodeItem = i.KodeItem
                inner join itemkonversis k on i.KodeItem = k.KodeItem
                inner join satuans s on s.KodeSatuan = k.KodeSatuan
                left join penerimaanbarangs pb on pb.KodePO = a.KodePO and pb.Status = 'CFM'
                left join penerimaanbarangdetails pbd on pbd.KodePenerimaanBarang = pb.KodePenerimaanBarang and pbd.KodeItem = a.KodeItem and pbd.KodeSatuan = k.KodeSatuan
                where a.KodePO='" . $pb['KodePO'] . "' and a.KodeSatuan = k.KodeSatuan
                group by a.KodeItem, s.NamaSatuan
                having jml > 0");

            if (empty($checkitem)) {
                $po->Status = "CLS";
                $po->save();
            }

            $last_id = DB::select('SELECT * FROM invoicehutangs WHERE KodeInvoiceHutangShow LIKE "%IVH-0%" ORDER BY KodeInvoiceHutangShow DESC LIMIT 1');
            $last_id_tax = DB::select('SELECT * FROM invoicehutangs WHERE KodeInvoiceHutangShow LIKE "%IVH-1%" ORDER BY KodeInvoiceHutangShow DESC LIMIT 1');

            $year_now = date('y');
            $month_now = date('m');
            $date_now = date('d');
            $pref = "IVH-0";
            if ($pb->PPN == "ya") {
                $pref = "IVH-1";

                if ($last_id_tax == null) {
                    $newID = $pref . $year_now . $month_now . "0001";
                } else {
                    $string = $last_id_tax[0]->KodeInvoiceHutangShow;
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
                    $string = $last_id[0]->KodeInvoiceHutangShow;
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

            DB::table('invoicehutangs')->insert([
                'KodeInvoiceHutangShow' => $newID,
                'Tanggal' => $data->Tanggal,
                'KodeSupplier' => $data->KodeSupplier,
                'Status' => 'OPN',
                'Total' => $data->Subtotal,
                'Keterangan' => $po->Keterangan,
                'KodeMataUang' => $data->KodeMataUang,
                'KodeUser' => \Auth::user()->name,
                'Term' => $po->term,
                'KodeLokasi' => $data->KodeLokasi,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            $inv = DB::table('invoicehutangs')->where('KodeInvoiceHutangShow', $newID)->first();

            DB::table('invoicehutangdetails')->insert([
                'KodeHutang' => $newID,
                'KodeLPB' => $data->KodePenerimaanBarang,
                'Subtotal' => $data->Subtotal,
                'KodeInvoiceHutang' => $inv->KodeInvoiceHutang,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            foreach ($items as $key => $value) {
                $last_saldo[$key] = DB::table('keluarmasukbarangs')->where('KodeItem', $value->KodeItem)->orderBy('id', 'desc')->limit(1)->pluck('saldo')->toArray();
            }

            $nomer = 0;
            foreach ($items as $key => $value) {
                if ($value->Konversi > 0) {
                    $value->jml = $value->jml * $value->Konversi;
                }
                if (isset($last_saldo[$key][0])) {
                    $saldo = (float) $last_saldo[$key][0] + (float) $value->jml;
                } else {
                    $saldo = 0 + (float) $value->jml;
                }
                $nomer++;
                DB::table('keluarmasukbarangs')->insert([
                    'Tanggal' => $data->Tanggal,
                    'KodeLokasi' => $data->KodeLokasi,
                    'KodeItem' => $value->KodeItem,
                    'JenisTransaksi' => 'LPB',
                    'KodeTransaksi' => $data->KodePenerimaanBarang,
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

            DB::table('eventlogs')->insert([
                'KodeUser' => \Auth::user()->name,
                'Tanggal' => \Carbon\Carbon::now(),
                'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
                'Keterangan' => 'Konfirmasi penerimaan barang ' . $data->KodePenerimaanBarang,
                'Tipe' => 'OPN',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            $pesan = 'Penerimaan Barang ' . $data->KodePenerimaanBarang . ' berhasil dikonfirmasi';
            return redirect('/konfirmasiPenerimaanBarang')->with(['created' => $pesan]);
        } else {
            $pesan = 'Penerimaan Barang tidak dikonfirmasi karena hasil item menjadi minus, mohon periksa kembali jumlah item pada PO yang dapat dikirimkan';
            return redirect('/penerimaanBarang')->with(['error' => $pesan]);
        }
    }

    public function fixInvoiceID()
    {
        $i = invoicehutang::where('KodeInvoiceHutangShow', '')->get();
        $last_id = null;
        foreach ($i as $is) {
            $year_now = Carbon::parse($is->Tanggal)->format('y');
            $month_now = Carbon::parse($is->Tanggal)->format('m');
            $date_now = Carbon::parse($is->Tanggal)->format('d');
            if ($last_id == null) {
                $newID = "IVP-" . $year_now . $month_now . "0001";
                $is->KodeInvoiceHutangShow = $newID;
                $is->save();
            } else {
                $string = $last_id;
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

                $newID = "IVH-0" . $year_now . $month_now . $newID;
                $is->KodeInvoiceHutangShow = $newID;
                $is->save();
            }
            $last_id = $newID;
        }
    }

    public function print($id)
    {
        $penerimaanbarang = penerimaanbarang::where('KodePenerimaanBarang', $id)->first();
        $sales = karyawan::where('KodeKaryawan', $penerimaanbarang->KodeSales)->first();
        $matauang = matauang::where('KodeMataUang', $penerimaanbarang->KodeMataUang)->first();
        $lokasi = lokasi::where('KodeLokasi', $penerimaanbarang->KodeLokasi)->first();
        $supplier = supplier::where('KodeSupplier', $penerimaanbarang->KodeSupplier)->first();

        $items = DB::select(
            "SELECT a.KodeItem,i.NamaItem, a.Qty, i.Keterangan, s.NamaSatuan, s.KodeSatuan, a.Harga
            FROM penerimaanbarangdetails a 
            inner join items i on a.KodeItem = i.KodeItem 
            inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan 
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            where a.KodePenerimaanBarang='" . $penerimaanbarang->KodePenerimaanBarang . "' group by a.KodeItem, s.NamaSatuan"
        );

        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->Qty;
        }
        $penerimaanbarang->Tanggal = \Carbon\Carbon::parse($penerimaanbarang->Tanggal)->format('d-m-Y');

        $pdf = PDF::loadview('pembelian.penerimaanBarang.print', compact('penerimaanbarang', 'sales', 'matauang', 'lokasi', 'supplier', 'items', 'jml'));

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Print penerimaan barang ' . $penerimaanbarang->KodePenerimaanBarang,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return $pdf->download('PenerimaanBarang_' . $penerimaanbarang->KodePenerimaanBarang . '.pdf');
    }
}
