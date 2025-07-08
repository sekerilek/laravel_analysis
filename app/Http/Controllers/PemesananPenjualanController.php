<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\pemesananpenjualan;
use App\Model\lokasi;
use App\Model\matauang;
use App\Model\pelanggan;
use App\Model\item;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use Exception;

class PemesananPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemesananpenjualan = pemesananpenjualan::join('pelanggans', 'pelanggans.KodePelanggan', '=', 'pemesananpenjualans.KodePelanggan')
            ->select('pemesananpenjualans.*', 'pelanggans.NamaPelanggan')
            ->orderBy('pemesananpenjualans.id', 'desc')
            ->get();
        /*$pemesananpenjualan = pemesananpenjualan::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpenjualans.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpenjualans.KodeMataUang')
            ->join('pelanggans', 'pelanggans.KodePelanggan', '=', 'pemesananpenjualans.KodePelanggan')
            ->select('pemesananpenjualans.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'pelanggans.NamaPelanggan')
            ->orderBy('pemesananpenjualans.id', 'desc')
            ->get();
        $pemesananpenjualan->all();*/
        return view('penjualan.pemesananPenjualan.index', compact('pemesananpenjualan'));
    }

    public function filterData(Request $request)
    {
        $search = $request->get('name');
        $start = $request->get('mulai');
        $end = $request->get('sampai');
        $mulai = $request->get('mulai');
        $sampai = $request->get('sampai');
        $pemesananpenjualan = pemesananpenjualan::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpenjualans.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpenjualans.KodeMataUang')
            ->join('pelanggans', 'pelanggans.KodePelanggan', '=', 'pemesananpenjualans.KodePelanggan')
            ->where('pemesananpenjualans.Status', 'OPN')
            ->where(function ($query) use ($search) {
                $query->Where('pelanggans.NamaPelanggan', 'LIKE', "%$search%")
                    ->orWhere('pemesananpenjualans.KodeSO', 'LIKE', "%$search%");
            })->get();
        if ($start && $end) {
            $pemesananpenjualan = $pemesananpenjualan->whereBetween('Tanggal', [$start . ' 00:00:00', $end . ' 23:59:59']);
        } else {
            $pemesananpenjualan->all();
        }
        return view('penjualan.pemesananPenjualan.index', compact('pemesananpenjualan', 'mulai', 'sampai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = \DB::table('rak')->where('status', 'OPN')->get();
        $pelanggan = \DB::table('pelanggans')->where('status', 'OPN')->get();

        return view('penjualan.pemesananPenjualan.buat', [
            'item' => $item,
            'pelanggan' => $pelanggan,
        ]);
        /*$pemesananpembelian = DB::table('pemesananpembelians')->get();
        $matauang = DB::table('matauangs')->where('Status', 'OPN')->get();
        $lokasi = DB::table('lokasis')->where('Status', 'OPN')->get();
        $pelanggan = DB::table('pelanggans')->where('Status', 'OPN')->get();
        $item = DB::select("SELECT i.KodeItem, i.NamaItem, i.Keterangan 
            FROM items i
            where i.jenisitem = 'bahanjadi' and i.Status = 'OPN'
            order by i.NamaItem ");
        $satuan = DB::table('satuans')->where('Status', 'OPN')->get();
        $sales = DB::table('karyawans')->where('Status', 'OPN')->whereRaw('KodeJabatan LIKE "%sales%"')->get();

        $last_id = DB::select("SELECT * FROM pemesananpenjualans WHERE KodeSO LIKE '%SO-0%' ORDER BY id DESC LIMIT 1");
        $last_id_tax = DB::select("SELECT * FROM pemesananpenjualans WHERE KodeSO LIKE '%SO-1%' ORDER BY id DESC LIMIT 1");
        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');

        if ($last_id_tax == null) {
            $newIDP = "SO-1" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id_tax[0]->KodeSO;
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
            $newIDP = "SO-1" . $year_now . $month_now . $newID;
        }

        if ($last_id == null) {
            $newID = "SO-0" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodeSO;
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
            $newID = "SO-0" . $year_now . $month_now . $newID;
        }

        foreach ($item as $key => $value) {
            $array_satuan = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->pluck('KodeSatuan')->toArray();
            $datasatuan[$value->KodeItem] = $array_satuan;
            foreach ($array_satuan as $sat) {
                $array_harga = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->where('KodeSatuan', $sat)->pluck('HargaJual')->toArray();
                $dataharga[$value->KodeItem][$sat] = $array_harga[0];
            }
        }

        return view('penjualan.pemesananPenjualan.buat', [
            'newID' => $newID,
            'newIDP' => $newIDP,
            'pemesananpembelian' => $pemesananpembelian,
            'matauang' => $matauang,
            'lokasi' => $lokasi,
            'pelanggan' => $pelanggan,
            'item' => $item,
            'satuan' => $satuan,
			'datasatuan' => $datasatuan,
			'dataharga' => $dataharga,
            'sales' => $sales,
        ]);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$checkppn = $request->ppn;
        $last_id = DB::select("SELECT * FROM pemesananpenjualans WHERE KodeSO LIKE '%SO-0%' ORDER BY id DESC LIMIT 1");
        $last_id_tax = DB::select("SELECT * FROM pemesananpenjualans WHERE KodeSO LIKE '%SO-1%' ORDER BY id DESC LIMIT 1");
        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');

        if ($checkppn == 'ya') {
            if ($last_id_tax == null) {
                $newID = "SO-1" . $year_now . $month_now . "0001";
            } else {
                $string = $last_id_tax[0]->KodeSO;
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
                $newID = "SO-1" . $year_now . $month_now . $newID;
            }
        } else {
            if ($last_id == null) {
                $newID = "SO-0" . $year_now . $month_now . "0001";
            } else {
                $string = $last_id[0]->KodeSO;
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
                $newID = "SO-0" . $year_now . $month_now . $newID;
            }
        }

        DB::table('pemesananpenjualans')->insert([
            'KodeSO' => $newID,
            'Tanggal' => $request->Tanggal,
            'tgl_kirim' => $request->TanggalKirim,
            'Expired' => $request->Expired,
            'KodeLokasi' => $request->KodeLokasi,
            'KodeMataUang' => $request->KodeMataUang,
            'KodePelanggan' => $request->KodePelanggan,
            'Term' => $request->Term,
            'Keterangan' => $request->Keterangan,
            'NoFaktur' => $request->NoFaktur,
            'Status' => 'OPN',
            'KodeUser' => \Auth::user()->name,
            'Total' => $request->subtotal,
            'PPN' => $request->ppn,
            'NilaiPPN' => $request->ppnval,
            'Printed' => 0,
            'Diskon' => $request->diskon,
            'NilaiDiskon' => $request->diskonval,
            'Subtotal' => $request->bef,
            'KodeSales' => 0,
            'POPelanggan' => 'PO',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $items = $request->item;
        $qtys = $request->qty;
        $prices = $request->price;
        $totals = $request->total;
        $satuans = $request->satuan;
        $nomer = 0;
        foreach ($items as $key => $value) {
            $nomer++;

            $last_harga_rata[$key] = DB::table('historihargarata')->where('KodeItem', $items[$key])->orderBy('Tanggal', 'desc')->limit(1)->pluck('HargaRata')->toArray();

            if (isset($last_harga_rata[$key][0])) {
                $harga_rata[$key] = $last_harga_rata[$key][0];
            } else {
                $harga_rata[$key] = $prices[$key];
            }

            DB::table('pemesanan_penjualan_detail')->insert([
                'KodeSO' => $newID,
                'KodeItem' => $items[$key],
                'Qty' => $qtys[$key],
                'Harga' => $prices[$key],
                'HargaRata' => $harga_rata[$key],
                'KodeSatuan' => $satuans[$key],
                'NoUrut' => $nomer,
                'Subtotal' => $totals[$key],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);


        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah pemesanan penjualan ' . $newID,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);*/

        try {
            \DB::transaction(function () use ($request) {
                $template = 'SO'.date('Ymd');
                $cek = \DB::table('pemesananpenjualans')->where('KodeSO','like',"%$template%")->count();

                $kode = $template . str_pad($cek+1, 3, '0', STR_PAD_LEFT);

                $data = array(
                    'KodeSO' => $kode,
                    'Tanggal' => $request->Tanggal,
                    'tgl_kirim' => $request->TanggalKirim,
                    'KodePelanggan' => $request->KodePelanggan,
                    'Status' => 'OPN',
                    'KodeUser' => \Auth::user()->name,
                    'Total' => $request->total,
                    'created_at' => \Carbon\Carbon::now(),
                );

                \DB::table('pemesananpenjualans')->insert($data);

                foreach ($request->item as $key => $value) {
                    $subdata = array(
                        'KodeSO' => $kode,
                        'KodeItem' => $request->item[$key],
                        'Qty' => $request->qty[$key],
                        'Harga' => $request->price[$key],
                        'KodeSatuan' => 'PCS',
                        'Subtotal' => $request->subtotal[$key],
                        'created_at' => \Carbon\Carbon::now(),
                    );

                    \DB::table('pemesanan_penjualan_detail')->insert($subdata);
                }
            });

            return redirect('/sopenjualan')->with(['created' => 'SO baru telah dibuat']);
        } catch (Exception $e) {
            return redirect('/sopenjualan')->with(['deleted' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::select("SELECT a.KodeSo, a.Tanggal, a.tgl_kirim,a.Expired,a.term, a.NoFaktur, a.POPelanggan, b.NamaMataUang, c.NamaLokasi, d.NamaPelanggan, a.Keterangan, a.Diskon, a.NilaiDiskon, a.PPN, a.Subtotal, a.Total, a.NilaiPPN, a.Status from pemesananpenjualans a
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join pelanggans d on d.KodePelanggan = a.KodePelanggan
            where a.KodeSO ='" . $id . "' limit 1")[0];

        $items = DB::select("SELECT DISTINCT a.Qty,b.NamaItem,d.NamaSatuan,
            a.Harga, a.Subtotal, b.Keterangan  from pemesanan_penjualan_detail a
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem=a.KodeItem
            inner join satuans  d on d.KodeSatuan=a.KodeSatuan
            where a.KodeSO ='" . $id . "' ");

        $OPN = true;
        $data->Tanggal = Carbon::parse($data->Tanggal)->format('d-m-Y');
        $data->tgl_kirim = Carbon::parse($data->tgl_kirim)->format('d-m-Y');
        return view('penjualan.pemesananPenjualan.lihat', compact('data', 'id', 'items', 'OPN'));
    }

    public function lihat($id)
    {
        $data = DB::select("SELECT a.KodeSo, a.Tanggal, a.tgl_kirim,a.Expired,a.term, a.NoFaktur, a.POPelanggan, b.NamaMataUang, c.NamaLokasi, d.NamaPelanggan, a.Keterangan, a.Diskon, a.NilaiDiskon, a.PPN, a.Subtotal, a.Total, a.NilaiPPN, a.Status from pemesananpenjualans a
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join pelanggans d on d.KodePelanggan = a.KodePelanggan
            where a.KodeSO ='" . $id . "' limit 1")[0];

        $items = DB::select("SELECT DISTINCT a.Qty,b.NamaItem,d.NamaSatuan,
            a.Harga, a.Subtotal, b.Keterangan  from pemesanan_penjualan_detail a
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem=a.KodeItem
            inner join satuans  d on d.KodeSatuan=a.KodeSatuan
            where a.KodeSO ='" . $id . "' ");

        $OPN = false;
        $data->Tanggal = Carbon::parse($data->Tanggal)->format('d-m-Y');
        $data->tgl_kirim = Carbon::parse($data->tgl_kirim)->format('d-m-Y');
        return view('penjualan.pemesananPenjualan.lihat', compact('data', 'id', 'items', 'OPN'));
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
        $pelanggan = DB::table('pelanggans')->where('Status', 'OPN')->get();
        $so = DB::select("SELECT a.KodeSO, a.Tanggal, a.tgl_kirim,a.Expired,a.term, a.POPelanggan, a.NoFaktur,
            b.NamaMataUang, c.NamaLokasi, d.NamaPelanggan, a.Keterangan, a.Diskon, a.PPN, a.Subtotal, a.NilaiPPN, c.KodeLokasi, d.KodePelanggan, b.KodeMataUang 
            from pemesananpenjualans a
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join pelanggans d on d.KodePelanggan = a.KodePelanggan
            where a.KodeSO ='" . $id . "' limit 1")[0];
        $itemlist = DB::select("SELECT i.KodeItem, i.NamaItem, i.Keterangan 
            FROM items i
            where i.jenisitem = 'bahanjadi'
            GROUP BY i.NamaItem
            ");
        $items = DB::select("SELECT DISTINCT a.Qty,a.KodeItem,a.KodeSatuan,b.NamaItem,d.NamaSatuan, a.Harga, a.Subtotal, b.Keterangan  
            from pemesanan_penjualan_detail a
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem=a.KodeItem
            inner join satuans  d on d.KodeSatuan=a.KodeSatuan
            where a.KodeSO ='" . $id . "' ");
        $itemcount = count($items);

        $satuan = DB::table('satuans')->where('Status', 'OPN')->get();
        foreach ($itemlist as $key => $value) {
            $array_satuan = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->pluck('KodeSatuan')->toArray();
            $datasatuan[$value->KodeItem] = $array_satuan;
            foreach ($array_satuan as $sat) {
                $array_harga = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->where('KodeSatuan', $sat)->pluck('HargaJual')->toArray();
                $dataharga[$value->KodeItem][$sat] = $array_harga[0];
            }
        }

        $so->Tanggal = Carbon::parse($so->Tanggal)->format('Y-m-d');
        $so->tgl_kirim = Carbon::parse($so->tgl_kirim)->format('Y-m-d');
        return view('penjualan.pemesananPenjualan.edit', compact('so', 'id', 'items', 'lokasi', 'pelanggan', 'matauang', 'satuan', 'dataharga', 'datasatuan', 'itemlist', 'itemcount'));
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
        DB::table('pemesananpenjualans')
            ->where('KodeSO', $request->KodeSO)
            ->update([
                'Tanggal' => $request->Tanggal,
                'tgl_kirim' => $request->TanggalKirim,
                'Expired' => $request->Expired,
                'KodeLokasi' => $request->KodeLokasi,
                'KodeMataUang' => $request->KodeMataUang,
                'KodePelanggan' => $request->KodePelanggan,
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
                DB::table('pemesanan_penjualan_detail')->insert([
                    'KodeSO' => $request->KodeSO,
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
                DB::table('pemesanan_penjualan_detail')
                    ->where('KodeSO', $request->KodeSO)
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
            'Keterangan' => 'Update pemesanan penjualan ' . $request->KodeSO,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'SO ' . $request->KodeSO . ' berhasil diupdate';
        return redirect('/sopenjualan')->with(['edited' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pemesananpenjualans')->where('KodeSO', $id)->update([
            'Status' => 'DEL'
        ]);

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Hapus pemesanan penjualan ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'SO ' . $id . ' berhasil dihapus';
        return redirect('/sopenjualan')->with(['deleted' => $pesan]);
    }

    public function confirm(Request $request, $id)
    {
        $data = pemesananpenjualan::find($id);
        $data->Status = "CFM";
        $data->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Konfirmasi pemesanan penjualan ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pesan = 'SO ' . $id . ' berhasil dikonfirmasi';
        return redirect('/konfirmasiPenjualan')->with(['created' => $pesan]);
    }

    public function cancel(Request $request, $id)
    {
        $data = pemesananpenjualan::find($id);
        $data->Status = "DEL";
        $data->save();

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Batal pemesanan penjualan ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return redirect('/sopenjualan');
    }

    public function konfirmasiPenjualan()
    {
        $pemesananpenjualan = pemesananpenjualan::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpenjualans.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpenjualans.KodeMataUang')
            ->join('pelanggans', 'pelanggans.KodePelanggan', '=', 'pemesananpenjualans.KodePelanggan')
            ->select('pemesananpenjualans.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'pelanggans.NamaPelanggan')
            ->orderBy('pemesananpenjualans.id', 'desc')
            ->get();
        $pemesananpenjualan = $pemesananpenjualan->where('Status', 'CFM');
        $pemesananpenjualan->all();
        $filter = false;
        return view('penjualan.pemesananPenjualan.konfirmasi', compact('pemesananpenjualan', 'filter'));
    }

    public function dikirimPenjualan()
    {
        $pemesananpenjualan = pemesananpenjualan::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpenjualans.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpenjualans.KodeMataUang')
            ->join('pelanggans', 'pelanggans.KodePelanggan', '=', 'pemesananpenjualans.KodePelanggan')
            ->select('pemesananpenjualans.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'pelanggans.NamaPelanggan')
            ->orderBy('pemesananpenjualans.id', 'desc')
            ->get();
        $pemesananpenjualan = $pemesananpenjualan->where('Status', 'CLS');
        $pemesananpenjualan->all();
        $filter = false;
        return view('penjualan.pemesananPenjualan.dikirim', compact('pemesananpenjualan', 'filter'));
    }

    public function batalPenjualan()
    {
        $pemesananpenjualan = pemesananpenjualan::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpenjualans.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpenjualans.KodeMataUang')
            ->join('pelanggans', 'pelanggans.KodePelanggan', '=', 'pemesananpenjualans.KodePelanggan')
            ->select('pemesananpenjualans.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'pelanggans.NamaPelanggan')
            ->orderBy('pemesananpenjualans.id', 'desc')
            ->get();
        $pemesananpenjualan = $pemesananpenjualan->where('Status', 'DEL');
        $pemesananpenjualan->all();
        $filter = false;
        return view('penjualan.pemesananPenjualan.batal', compact('pemesananpenjualan', 'filter'));
    }

    public function dikirimPenjualanFilter(Request $request)
    {
        $so = pemesananpenjualan::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpenjualans.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpenjualans.KodeMataUang')
            ->join('pelanggans', 'pelanggans.KodePelanggan', '=', 'pemesananpenjualans.KodePelanggan')
            ->select('pemesananpenjualans.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'pelanggans.NamaPelanggan')
            ->get();
        $hasil1 = $so->where('Status', 'CLS');
        $hasil1->all();
        $start = $request->get('start');
        $end = $request->get('end');
        $pemesananpenjualan = $hasil1->whereBetween('Tanggal', [$start . ' 00:00:01', $end . ' 23:59:59']);
        $pemesananpenjualan->all();
        return view('penjualan.pemesananPenjualan.dikirim', compact('pemesananpenjualan', 'filter', 'start', 'finish'));
    }

    public function batalPenjualanFilter(Request $request)
    {
        $so = pemesananpenjualan::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpenjualans.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpenjualans.KodeMataUang')
            ->join('pelanggans', 'pelanggans.KodePelanggan', '=', 'pemesananpenjualans.KodePelanggan')
            ->select('pemesananpenjualans.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'pelanggans.NamaPelanggan')
            ->get();
        $hasil1 = $so->where('Status', 'DEL');
        $hasil1->all();
        $start = $request->get('start');
        $end = $request->get('end');
        $pemesananpenjualan = $hasil1->whereBetween('Tanggal', [$start . ' 00:00:01', $end . ' 23:59:59']);
        $pemesananpenjualan->all();
        return view('penjualan.pemesananPenjualan.batal', compact('pemesananpenjualan', 'filter', 'start', 'finish'));
    }

    public function konfirmasiPenjualanFilter(Request $request)
    {
        $so = pemesananpenjualan::join('lokasis', 'lokasis.KodeLokasi', '=', 'pemesananpenjualans.KodeLokasi')
            ->join('matauangs', 'matauangs.KodeMataUang', '=', 'pemesananpenjualans.KodeMataUang')
            ->join('pelanggans', 'pelanggans.KodePelanggan', '=', 'pemesananpenjualans.KodePelanggan')
            ->select('pemesananpenjualans.*', 'lokasis.NamaLokasi', 'matauangs.NamaMataUang', 'pelanggans.NamaPelanggan')
            ->get();
        $hasil1 = $so->where('Status', 'CFM');
        $hasil1->all();
        $start = $request->get('start');
        $end = $request->get('end');
        $pemesananpenjualan = $hasil1->whereBetween('Tanggal', [$start . ' 00:00:01', $end . ' 23:59:59']);
        $pemesananpenjualan->all();
        return view('penjualan.pemesananPenjualan.konfirmasi', compact('pemesananpenjualan', 'filter', 'start', 'finish'));
    }

    public function print($id)
    {
        $data = DB::select("SELECT a.KodeSO, a.Tanggal, a.tgl_kirim,a.Expired,a.term, a.POPelanggan, b.NamaMataUang, c.NamaLokasi, d.NamaPelanggan, a.Keterangan, a.Diskon, a.NilaiDiskon, a.PPN, a.NilaiPPN, a.Subtotal, a.Total, a.NilaiPPN from pemesananpenjualans a
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join pelanggans d on d.KodePelanggan = a.KodePelanggan
            where a.KodeSO ='" . $id . "' limit 1");

        $items = DB::select("SELECT DISTINCT a.Qty, b.KodeItem, a.Harga, a.Subtotal, b.NamaItem, d.NamaSatuan, d.KodeSatuan
            ,b.Keterangan  from pemesanan_penjualan_detail a
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem=a.KodeItem
            inner join satuans d on d.KodeSatuan=a.KodeSatuan and d.KodeSatuan=c.KodeSatuan
            where a.KodeSO ='" . $id . "' ");
		//dd($items);
        $jml = 0;
        foreach ($items as $value) {
            $jml += $value->Qty;
        }
        $data[0]->Tanggal = Carbon::parse($data[0]->Tanggal)->format('d/m/Y');

        $pdf = PDF::loadview('penjualan.pemesananPenjualan.print', compact('data', 'id', 'items', 'jml'));
		
        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Print pemesanan penjualan ' . $id,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return $pdf->download('PemesananPenjualan_' . $id . '.pdf');
    }
}
