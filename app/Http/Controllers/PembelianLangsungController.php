<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Model\pemesananpembelian;
use App\Model\penerimaanbarang;
use App\Model\lokasi;
use App\Model\matauang;
use App\Model\item;
use App\Model\supplier;
use PDF;
use DB;
use Carbon\Carbon;
use Exception;
use App\Exports\PembelianExport;
use Maatwebsite\Excel\Facades\Excel;

class PembelianLangsungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemesananpembelian = pemesananpembelian::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpembelians.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpembelians.KodeMataUang')
            ->join('suppliers', 'suppliers.KodeSupplier', '=', 'pemesananpembelians.KodeSupplier')
            ->join('penerimaanbarangs','penerimaanbarangs.KodePO','=','pemesananpembelians.KodePO')
            ->select('pemesananpembelians.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'suppliers.NamaSupplier','penerimaanbarangs.KodePenerimaanBarang')
            ->orderBy('pemesananpembelians.id', 'desc')
            ->where('pemesananpembelians.Status','!=','DEL')
            ->get();
            //dd($pemesananpembelian);
        $pemesananpembelian->all();
        return view('pembelian.pembelianLangsung.index', compact('pemesananpembelian'));
    }

    public function filterData(Request $request)
    {
        $search = $request->get('name');
        $start = $request->get('mulai');
        $end = $request->get('sampai');
        $mulai = $request->get('mulai');
        $sampai = $request->get('sampai');
        $pemesananpembelian = pemesananpembelian::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpembelians.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpembelians.KodeMataUang')
            ->join('suppliers', 'suppliers.KodeSupplier', '=', 'pemesananpembelians.KodeSupplier')
            ->where('pemesananpembelians.Status', 'OPN')
            ->where(function ($query) use ($search) {
                $query->Where('suppliers.NamaSupplier', 'LIKE', "%$search%")
                    ->orWhere('pemesananpembelians.KodePO', 'LIKE', "%$search%");
            })->get();
        if ($start && $end) {
            $pemesananpembelian = $pemesananpembelian->whereBetween('Tanggal', [$start . ' 00:00:00', $end . ' 23:59:59']);
        } else {
            $pemesananpembelian->all();
        }
        return view('pembelian.pembelianLangsung.index', compact('pemesananpembelian', 'mulai', 'sampai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $matauang = DB::table('matauangs')->where('Status', 'OPN')->get();
        $lokasi = DB::table('lokasis')->where('Status', 'OPN')->get();
        $supplier = DB::table('suppliers')->where('Status', 'OPN')->get();
        $item = DB::table('items')
        ->join('itemkonversis', 'items.KodeItem', '=', 'itemkonversis.KodeItem')
        ->join('satuans', 'itemkonversis.KodeSatuan', '=', 'satuans.KodeSatuan')
        ->where('jenisitem', 'bahanjadi')
        ->where('items.Status', 'OPN')
        ->select(
            'items.KodeItem', 
            'items.NamaItem', 
            'items.Keterangan',
            'itemkonversis.KodeSatuan',
            'itemkonversis.HargaBeli',
            'itemkonversis.HargaJual',
            'itemkonversis.HargaMember',
            'itemkonversis.HargaGrosir',
            'itemkonversis.Grab',
            'itemkonversis.Shopee',
            'satuans.NamaSatuan'
        )
        ->addSelect([
            'SisaStok' => DB::table('keluarmasukbarangs')
            ->whereColumn('KodeItem', 'items.KodeItem')
            ->select('saldo')
            ->orderByDesc('id')
            ->limit(1)
        ])
        ->orderBy('NamaItem', 'asc')
        ->get();
        $satuan = DB::table('satuans')->where('Status', 'OPN')->get();
        $last_id = DB::select('SELECT * FROM pemesananpembelians WHERE KodePO LIKE "%PO-0%" ORDER BY id DESC LIMIT 1');
        $last_id_tax = DB::select('SELECT * FROM pemesananpembelians WHERE KodePO LIKE "%PO-1%"  ORDER BY id DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');

        if ($last_id_tax == null) {
            $newIDP = "PO-1" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id_tax[0]->KodePO;
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
            $newIDP = "PO-1" . $year_now . $month_now . $newID;
        }

        if ($last_id == null) {
            $newID = "PO-0" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodePO;
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
            $newID = "PO-0" . $year_now . $month_now . $newID;
        }
        

        foreach ($item as $key => $value) {
            $array_satuan = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->pluck('KodeSatuan')->toArray();
            $datasatuan[$value->KodeItem] = $array_satuan;
            foreach ($array_satuan as $sat) {
                $array_harga = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->where('KodeSatuan', $sat)->pluck('HargaBeli')->toArray();
                $dataharga[$value->KodeItem][$sat] = $array_harga[0];
            }
        }

        return view('pembelian.pembelianLangsung.buat', [
            'newID' => $newID,
            'newIDP' => $newIDP,
            'matauang' => $matauang,
            'lokasi' => $lokasi,
            'supplier' => $supplier,
            'item' => $item,
			'datasatuan' => $datasatuan,
			'dataharga' => $dataharga,
            'satuan' => $satuan,
        ]);
    }

    public function generateIdPenerimaanBarang($ppn)
    {
        $last_id = DB::select('SELECT * FROM penerimaanbarangs WHERE KodePenerimaanBarang LIKE "%LPB-0%" ORDER BY id DESC LIMIT 1');
        $last_id_tax = DB::select('SELECT * FROM penerimaanbarangs WHERE KodePenerimaanBarang LIKE "%LPB-1%" ORDER BY id DESC LIMIT 1');

        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');
        $pref = "LPB-0";
        if ($ppn == 'ya') {
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
                return $newID;
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
                return $newID;
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checkppn = $request->ppn;
        $last_id = DB::select('SELECT * FROM pemesananpembelians WHERE KodePO LIKE "%PO-0%" ORDER BY id DESC LIMIT 1');
        $last_id_tax = DB::select('SELECT * FROM pemesananpembelians WHERE KodePO LIKE "%PO-1%" ORDER BY id DESC LIMIT 1');
        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');

        if ($checkppn == 'ya') {
            if ($last_id_tax == null) {
                $newID = "PO-1" . $year_now . $month_now . "0001";
            } else {
                $string = $last_id_tax[0]->KodePO;
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
                $newID = "PO-1" . $year_now . $month_now . $newID;
            }
        } else {
            if ($last_id == null) {
                $newID = "PO-0" . $year_now . $month_now . "0001";
            } else {
                $string = $last_id[0]->KodePO;
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
                $newID = "PO-0" . $year_now . $month_now . $newID;
            }
        }
        $last_id1 = DB::select('SELECT * FROM penerimaanbarangs WHERE KodePenerimaanBarang LIKE "%LPB-0%" ORDER BY id DESC LIMIT 1');
        $last_id_tax1 = DB::select('SELECT * FROM penerimaanbarangs WHERE KodePenerimaanBarang LIKE "%LPB-1%" ORDER BY id DESC LIMIT 1');

        $year_now1 = date('y');
        $month_now1 = date('m');
        $date_now1 = date('d');
        $pref1 = "LPB-0";
        if ($request->ppn == 'ya') {
            $pref1 = "LPB-1";

            if ($last_id_tax1 == null) {
                $newID1 = $pref1 . $year_now1 . $month_now1 . "0001";
            } else {
                $string1 = $last_id_tax1[0]->KodePenerimaanBarang;
                $ids1 = substr($string1, -4, 4);
                $month1 = substr($string1, -6, 2);
                $year1 = substr($string1, -8, 2);

                if ((int) $year_now1 > (int) $year1) {
                    $newID1 = "0001";
                } else if ((int) $month_now1 > (int) $month1) {
                    $newID1 = "0001";
                } else {
                    $newID1 = $ids1 + 1;
                    $newID1 = str_pad($newID1, 4, '0', STR_PAD_LEFT);
                }
                $newID1 = $pref1 . $year_now1 . $month_now1 . $newID1;
            }
        } else {
            if ($last_id1 == null) {
                $newID1 = $pref1 . $year_now1 . $month_now1 . "0001";
            } else {
                $string1 = $last_id1[0]->KodePenerimaanBarang;
                $ids1 = substr($string1, -4, 4);
                $month1 = substr($string1, -6, 2);
                $year1 = substr($string1, -8, 2);

                if ((int) $year_now1 > (int) $year1) {
                    $newID1 = "0001";
                } else if ((int) $month_now1 > (int) $month1) {
                    $newID1 = "0001";
                } else {
                    $newID1 = $ids1 + 1;
                    $newID1 = str_pad($newID1, 4, '0', STR_PAD_LEFT);
                }
                $newID1 = $pref1 . $year_now1 . $month_now1 . $newID1;
            }
        }
        $idPenerimaanBarang = $this->generateIdPenerimaanBarang($request->all());
        DB::beginTransaction();
        try {
                DB::table('pemesananpembelians')->insert([
                    'KodePO' => $newID,
                    'KodeLokasi' => $request->KodeLokasi,
                    'KodeMataUang' => $request->KodeMataUang,
                    'KodeSupplier' => $request->KodeSupplier,
                    'Term' => $request->Term,
                    'NoFaktur' => $request->NoFaktur,
                    'Status' => 'OPN',
                    'KodeUser' => \Auth::user()->name,
                    'PPN' => $request->ppn,
                    'NilaiPPN' => $request->ppnval,
                    'Diskon' => $request->diskon,
                    'NilaiDiskon' => $request->diskonval,
                    'Subtotal' => $request->bef,
                    'Total' => $request->subtotal,
                    'Tanggal' => $request->Tanggal,
                    'Expired' => $request->Expired,
                    'Keterangan' => $request->Keterangan,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
        
                DB::table('penerimaanbarangs')->insert([
                    'KodePenerimaanBarang' => $idPenerimaanBarang,
                    'Tanggal' => $request->Tanggal,
                    'KodeLokasi' => $request->KodeLokasi,
                    'KodeMataUang' => $request->KodeMataUang,
                    'Status' => 'CFM',
                    'KodeUser' => \Auth::user()->name,
                    'Total' => 0,
                    'PPN' => $request->ppn,
                    'NilaiPPN' => $request->ppnval,
                    'KodeSupplier' => $request->KodeSupplier,
                    'Printed' => 0,
                    'Diskon' => $request->diskon,
                    'NilaiDiskon' => $request->diskonval,
                    'Subtotal' => $request->subtotal,
                    'KodePO' => $newID,
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
                $totals = $request->total;
                $keterangans = $request->keterangan;
                $satuans = $request->satuan;
                $nomer = 0;
                foreach ($items as $key => $value) {
                    $nomer++;
                    DB::table('pemesananpembeliandetails')->insert([
                        'KodePO' => $newID,
                        'KodeItem' => $items[$key],
                        'Qty' => $qtys[$key],
                        'Harga' => $prices[$key],
                        'KodeSatuan' => $satuans[$key],
                        'NoUrut' => $nomer,
                        'Subtotal' => $totals[$key],
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                    DB::table('penerimaanbarangdetails')->insert([
                        'KodePenerimaanBarang' => $newID1,
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
        
                DB::table('eventlogs')->insert([
                    'KodeUser' => \Auth::user()->name,
                    'Tanggal' => \Carbon\Carbon::now(),
                    'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
                    'Keterangan' => 'Tambah pemesanan pembelian ' . $newID,
                    'Tipe' => 'OPN',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
                DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }


        $pesan = 'Pembelian N' . $newID . ' berhasil ditambahkan';
        return redirect('/pembelian-langsung')->with(['created' => $pesan]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::select("SELECT a.KodePO, a.Tanggal, a.Expired, b.NamaMataUang, c.NamaLokasi, d.NamaSupplier, a.Keterangan, a.term, a.NoFaktur, a.Diskon, a.NilaiDiskon, a.PPN, a.NilaiPPN, a.Subtotal, a.Total, a.Status from pemesananpembelians a 
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join suppliers d on d.KodeSupplier = a.KodeSupplier
            where a.KodePO ='" . $id . "' limit 1")[0];
        
        $items = DB::select("SELECT a.Qty, b.NamaItem, d.NamaSatuan, a.Harga, a.Subtotal, b.Keterangan  from pemesananpembeliandetails a 
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem = a.KodeItem 
            inner join satuans d on c.KodeSatuan = d.KodeSatuan
            where a.KodePO ='" . $id . "' ");

        $OPN = true;
        $data->Tanggal = Carbon::parse($data->Tanggal)->format('d-m-Y');
        return view('pembelian.pembelianLangsung.lihat', compact('data', 'id', 'items', 'OPN'));
    }

    public function lihat($id)
    {
        $data = DB::select("SELECT a.KodePO, a.Tanggal, a.Expired, b.NamaMataUang, c.NamaLokasi, d.NamaSupplier, a.Keterangan, a.term, a.NoFaktur, a.Diskon, a.NilaiDiskon, a.PPN, a.NilaiPPN, a.Subtotal, a.Total from pemesananpembelians a 
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join suppliers d on d.KodeSupplier = a.KodeSupplier
            where a.KodePO ='" . $id . "' limit 1")[0];

        $items = DB::select("SELECT a.Qty, b.NamaItem, d.NamaSatuan, a.Harga, a.Subtotal, b.Keterangan  from pemesananpembeliandetails a 
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem = a.KodeItem 
            inner join satuans d on c.KodeSatuan = d.KodeSatuan
            where a.KodePO ='" . $id . "' ");

        $OPN = false;
        $data->Tanggal = Carbon::parse($data->Tanggal)->format('d-m-Y');
        return view('pembelian.pembelianLangsung.lihat', compact('data', 'id', 'items', 'OPN'));
    }

    public function print($id)
    {
        $data = DB::select("SELECT a.KodePO, a.Tanggal, a.Expired, b.NamaMataUang, c.NamaLokasi, d.NamaSupplier, a.Keterangan, a.term, a.NoFaktur, a.Diskon, a.NilaiDiskon, a.PPN, a.NilaiPPN, a.Subtotal, a.Total from pemesananpembelians a 
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join suppliers d on d.KodeSupplier = a.KodeSupplier
            where a.KodePO ='" . $id . "' limit 1");

        $items = DB::select("SELECT a.KodeItem, a.Qty, b.NamaItem, d.NamaSatuan, a.Harga, a.Subtotal, b.Keterangan, d.KodeSatuan
            from pemesananpembeliandetails a 
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem = a.KodeItem 
            inner join satuans d on c.KodeSatuan = d.KodeSatuan
            where a.KodePO ='" . $id . "' ");

        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->Qty;
        }
        $data[0]->Tanggal = Carbon::parse($data[0]->Tanggal)->format('d/m/Y');

        $pdf = PDF::loadview('pembelian.pembelianLangsung.print', compact('data', 'id', 'items', 'jml'));

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Print pemesanan pembelian ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return $pdf->download('PemesananPembelian_' . $id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matauang = DB::table('matauangs')->where('Status', 'OPN')->get();
        $lokasi = DB::table('lokasis')->where('Status', 'OPN')->get();
        $supplier = DB::table('suppliers')->where('Status', 'OPN')->get();
        $po = DB::select("SELECT a.KodePO, a.Tanggal, a.Expired, a.KodeMataUang, a.KodeLokasi, a.KodeSupplier, b.NamaMataUang, c.NamaLokasi, d.NamaSupplier, a.Keterangan, a.term, a.NoFaktur, a.Diskon, a.NilaiDiskon, a.PPN, a.NilaiPPN, a.Subtotal, a.Total
            from pemesananpembelians a 
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join suppliers d on d.KodeSupplier = a.KodeSupplier
            where a.KodePO ='" . $id . "' limit 1")[0];
        $itemlist = DB::select("SELECT i.KodeItem, i.NamaItem, i.Keterangan 
            FROM items i
            where i.jenisitem = 'bahanjadi'
            GROUP BY i.NamaItem
        ");
        $items = DB::select("SELECT DISTINCT a.Qty,a.KodeItem,a.KodeSatuan,b.NamaItem,d.NamaSatuan, a.Harga, a.Subtotal, b.Keterangan  
            from pemesananpembeliandetails a
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem=a.KodeItem
            inner join satuans  d on d.KodeSatuan=a.KodeSatuan
            where a.KodePO ='" . $id . "' ");
        $itemcount = count($items);

        $satuan = DB::table('satuans')->where('Status', 'OPN')->get();
        foreach ($itemlist as $key => $value) {
            $array_satuan = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->pluck('KodeSatuan')->toArray();
            $datasatuan[$value->KodeItem] = $array_satuan;
            foreach ($array_satuan as $sat) {
                $array_harga = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->where('KodeSatuan', $sat)->pluck('HargaBeli')->toArray();
                $dataharga[$value->KodeItem][$sat] = $array_harga[0];
            }
        }
        $po->Tanggal = Carbon::parse($po->Tanggal)->format('Y-m-d');
        return view('pembelian.pembelianLangsung.edit', compact('po', 'id', 'items', 'lokasi', 'supplier', 'matauang', 'satuan', 'dataharga', 'datasatuan', 'itemlist', 'itemcount'));
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
        DB::table('pemesananpembelians')
            ->where('KodePO', $request->KodePO)
            ->update([
                'Tanggal' => $request->Tanggal,
                'Expired' => $request->Expired,
                'KodeLokasi' => $request->KodeLokasi,
                'KodeMataUang' => $request->KodeMataUang,
                'KodeSupplier' => $request->KodeSupplier,
                'Term' => $request->Term,
                'Keterangan' => $request->Keterangan,
                'NoFaktur' => $request->NoFaktur,
                'KodeUser' => \Auth::user()->name,
                'Total' => $request->subtotal,
                'PPN' => $request->ppn,
                'NilaiPPN' => $request->ppnval,
                'Diskon' => $request->diskon,
                'NilaiDiskon' => $request->diskonval,
                'Subtotal' => $request->bef,
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        $items = $request->item;
        $qtys = $request->qty;
        $prices = $request->price;
        $totals = $request->total;
        $satuans = $request->satuan;
        $itemcount = $request->itemcount;
        $nomer = 0;
        foreach ($items as $key => $value) {
            $nomer++;
            if ($nomer > $itemcount) {
                DB::table('pemesananpembeliandetails')->insert([
                    'KodePO' => $request->KodePO,
                    'KodeItem' => $items[$key],
                    'Qty' => $qtys[$key],
                    'Harga' => $prices[$key],
                    'KodeSatuan' => $satuans[$key],
                    'NoUrut' => $nomer,
                    'Subtotal' => $totals[$key],
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            } else {
                DB::table('pemesananpembeliandetails')
                    ->where('KodePO', $request->KodePO)
                    ->where('NoUrut', $nomer)
                    ->update([
                        'KodeItem' => $items[$key],
                        'Qty' => $qtys[$key],
                        'Harga' => $prices[$key],
                        'KodeSatuan' => $satuans[$key],
                        'NoUrut' => $nomer,
                        'Subtotal' => $totals[$key],
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
            }
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Update pemesanan pembelian ' . $request->KodePO,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Pembelian N' . $request->KodePO . ' berhasil diupdate';
        return redirect('/pembelian-langsung')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pemesananpembelians')->where('KodePO', $id)->update([
            'Status' => 'DEL'
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus pemesanan pembelian ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Pembelian N' . $id . ' berhasil dihapus';
        return redirect('/pembelian-langsung')->with(['deleted' => $pesan]);
    }

    public function confirm(Request $request, $id)
    {
      
        $pb = penerimaanbarang::where('KodePO', $id)->first();
        //dd($id,$pb);
        $checkresult = DB::select("SELECT (a.qty-COALESCE(SUM(pbd.qty),0)-COALESCE(pbdc.qty,0)) as jml
            FROM pemesananpembeliandetails a 
            inner join items i on a.KodeItem = i.KodeItem
            inner join itemkonversis k on i.KodeItem = k.KodeItem
            inner join satuans s on s.KodeSatuan = k.KodeSatuan
            left join penerimaanbarangs pb on pb.KodePO = a.KodePO and pb.Status = 'OPN'
            left join penerimaanbarangdetails pbd on pbd.KodePenerimaanBarang = pb.KodePenerimaanBarang and pbd.KodeItem = a.KodeItem and pbd.KodeSatuan = k.KodeSatuan
            left join penerimaanbarangdetails pbdc on pbdc.KodeItem = a.KodeItem and pbdc.KodeSatuan = k.KodeSatuan and pbdc.KodePenerimaanBarang ='" . $pb['KodePenerimaanBarang'] . "'
            where a.KodePO='" . $pb['KodePO'] . "' and a.KodeSatuan = k.KodeSatuan
            group by a.KodeItem, s.NamaSatuan
            having jml < 0");

        if (empty($checkresult)) {
            $data = penerimaanbarang::where('KodePO', $id)->first();
            $data->Status = "CFM";
            $data->save();
            //dd($data);
            $po = pemesananpembelian::find($data->KodePO);
            $items = DB::select(
                "SELECT a.KodeItem,i.NamaItem, a.Qty as jml, i.Keterangan, s.NamaSatuan, a.Harga, k.Konversi
                FROM pemesananpembeliandetails a 
                inner join items i on a.KodeItem = i.KodeItem 
                inner join itemkonversis k on i.KodeItem = k.KodeItem and a.KodeSatuan = k.KodeSatuan 
                inner join satuans s on s.KodeSatuan = k.KodeSatuan
                where a.KodePO='" . $data->KodePO . "' group by a.KodeItem, s.NamaSatuan"
            );
            //dd($items);

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
                $last_harga_rata[$key] = DB::table('historihargarata')->where('KodeItem', $value->KodeItem)->orderBy('id', 'desc')->limit(1)->pluck('HargaRata')->toArray();
            }
            //dd($last_saldo[$key]);

            $nomer = 0;
            foreach ($items as $key => $value) {
                if ($value->Konversi > 0) {
                    $value->jml = $value->jml * $value->Konversi;
                }
                if (isset($last_saldo[$key][0])) {
                    $saldo = (float) $last_saldo[$key][0] + (float) $value->jml;
                    $new_harga_rata = (($last_saldo[$key][0] * $last_harga_rata[$key][0]) + ($value->jml * $value->Harga)) / ($last_saldo[$key][0] + $value->jml);
                } else {
                    $saldo = 0 + (float) $value->jml;
                    $new_harga_rata = ((0 * $last_harga_rata[$key][0]) + ($value->jml * $value->Harga)) / (0 + $value->jml);
                }

                
                $new_harga_rata = ceil($new_harga_rata);

                $nomer++;
                DB::table('keluarmasukbarangs')->insert([
                    'Tanggal' => $data->Tanggal,
                    'KodeLokasi' => $data->KodeLokasi,
                    'KodeItem' => $value->KodeItem,
                    'JenisTransaksi' => 'LPB',
                    'KodeTransaksi' => $data->KodePenerimaanBarang,
                    'Qty' => $value->jml,
                    'HargaRata' => $new_harga_rata,
                    'KodeUser' => \Auth::user()->name,
                    'idx' => $nomer,
                    'indexmov' => $nomer,
                    'saldo' => $saldo,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]);

                DB::table('historihargarata')->insert([
                    'KodeItem' => $value->KodeItem,
                    'HargaRata' => $new_harga_rata,
                    'KodeTransaksi' => $data->KodePenerimaanBarang,
                    'created_at' => \Carbon\Carbon::now(),
                ]);
            }
      
            DB::table('pemesananpembelians')
            ->where('KodePO', $id)
            ->update(['Status' => "CFM"]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Konfirmasi pemesanan pembelian ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'Pembelian N' . $id . ' berhasil dikonfirmasi';
        return redirect('/pembelian-langsung')->with(['created' => $pesan]);
    }
    }
    public function cancel(Request $request, $id)
    {
        DB::table('pemesananpembelians')
            ->where('KodePO', $id)
            ->update(['Status' => "DEL"]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Batal pemesanan pembelian ' . $id,
            'Tipe' => 'OPN',
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

        return redirect('/pembelian-langsung');
    }

    public function konfirmasiPembelian()
    {
        $pemesananpembelian = pemesananpembelian::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpembelians.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpembelians.KodeMataUang')
            ->join('suppliers', 'suppliers.KodeSupplier', '=', 'pemesananpembelians.KodeSupplier')
            ->select('pemesananpembelians.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'suppliers.NamaSupplier')
            ->orderBy('pemesananpembelians.id', 'desc')
            ->get();
        $pemesananpembelian = $pemesananpembelian->where('Status', 'CFM');
        $pemesananpembelian->all();
        $filter = false;
        return view('pembelian.pembelianLangsung.konfirmasi', compact('pemesananpembelian', 'filter'));
    }

    public function batalPembelian()
    {
        $pemesananpembelian = pemesananpembelian::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpembelians.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpembelians.KodeMataUang')
            ->join('suppliers', 'suppliers.KodeSupplier', '=', 'pemesananpembelians.KodeSupplier')
            ->select('pemesananpembelians.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'suppliers.NamaSupplier')
            ->orderBy('pemesananpembelians.id', 'desc')
            ->get();
        $pemesananpembelian = $pemesananpembelian->where('Status', 'DEL');
        $pemesananpembelian->all();
        $filter = false;
        return view('pembelian.pembelianLangsung.konfirmasi', compact('pemesananpembelian', 'filter'));
    }

    public function diterimaPembelian()
    {
        $pemesananpembelian = pemesananpembelian::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpembelians.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpembelians.KodeMataUang')
            ->join('suppliers', 'suppliers.KodeSupplier', '=', 'pemesananpembelians.KodeSupplier')
            ->select('pemesananpembelians.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'suppliers.NamaSupplier')
            ->orderBy('pemesananpembelians.id', 'desc')
            ->get();
        $pemesananpembelian = $pemesananpembelian->where('Status', 'CLS');
        $pemesananpembelian->all();
        $filter = false;
        return view('pembelian.pembelianLangsung.konfirmasi', compact('pemesananpembelian', 'filter'));
    }

    public function konfirmasiPembelianFilter(Request $request)
    {
        $po = pemesananpembelian::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpembelians.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpembelians.KodeMataUang')
            ->join('suppliers', 'suppliers.KodeSupplier', '=', 'pemesananpembelians.KodeSupplier')
            ->select('pemesananpembelians.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'suppliers.NamaSupplier')
            ->orderBy('pemesananpembelians.id', 'desc')
            ->get();
        $hasil1 = $po->where('Status', 'CFM');
        $hasil1->all();
        $start = $request->get('start');
        $end = $request->get('end');
        $pemesananpembelian = $hasil1->whereBetween('Tanggal', [$start . ' 00:00:01', $end . ' 23:59:59']);
        $pemesananpembelian->all();
        return view('pembelian.pembelianLangsung.konfirmasi', compact('pemesananpembelian', 'filter', 'start', 'finish'));
    }

    public function diterimaPembelianFilter(Request $request)
    {
        $po = pemesananpembelian::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpembelians.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpembelians.KodeMataUang')
            ->join('suppliers', 'suppliers.KodeSupplier', '=', 'pemesananpembelians.KodeSupplier')
            ->select('pemesananpembelians.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'suppliers.NamaSupplier')
            ->orderBy('pemesananpembelians.id', 'desc')
            ->get();
        $hasil1 = $po->where('Status', 'CLS');
        $hasil1->all();
        $start = $request->get('start');
        $end = $request->get('end');
        $pemesananpembelian = $hasil1->whereBetween('Tanggal', [$start . ' 00:00:01', $end . ' 23:59:59']);
        $pemesananpembelian->all();
        return view('pembelian.pembelianLangsung.diterima', compact('pemesananpembelian', 'filter', 'start', 'finish'));
    }

    public function batalPembelianFilter(Request $request)
    {
        $po = pemesananpembelian::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpembelians.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpembelians.KodeMataUang')
            ->join('suppliers', 'suppliers.KodeSupplier', '=', 'pemesananpembelians.KodeSupplier')
            ->select('pemesananpembelians.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'suppliers.NamaSupplier')
            ->orderBy('pemesananpembelians.id', 'desc')
            ->get();
        $hasil1 = $po->where('Status', 'CLS');
        $hasil1->all();
        $start = $request->get('start');
        $end = $request->get('end');
        $pemesananpembelian = $hasil1->whereBetween('Tanggal', [$start . ' 00:00:01', $end . ' 23:59:59']);
        $pemesananpembelian->all();
        return view('pembelian.pembelianLangsung.batal', compact('pemesananpembelian', 'filter', 'start', 'finish'));
    }
    public function exportPembelian() {
        $filename = 'Laporan-Pembelian-barang-'.date('Y-m-d_H-i-s').'.xlsx';
        return Excel::download(new PembelianExport, $filename);
    }

    
}
