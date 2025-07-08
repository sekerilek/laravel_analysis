<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\penjualanLangsung;
use Carbon\Carbon;

class PenjualanLangsungController extends Controller
{
    public function index()
    {
        $penjualanlangsung = DB::table('penjualanlangsungs')
            ->join('matauangs', 'penjualanlangsungs.KodeMataUang', '=', 'matauangs.KodeMataUang')
            ->join('lokasis', 'penjualanlangsungs.KodeLokasi', '=', 'lokasis.KodeLokasi')
            ->join('pelanggans', 'penjualanlangsungs.KodePelanggan', '=', 'pelanggans.KodePelanggan')
            ->select('penjualanlangsungs.*', 'matauangs.NamaMataUang', 'lokasis.NamaLokasi', 'pelanggans.NamaPelanggan')
            ->get();
        return view('penjualan.penjualanLangsung.penjualanLangsung', compact('penjualanlangsung'));
    }

    public function create()
    {
        $pemesananpembelian = DB::table('pemesananpembelians')->get();
        $matauang = DB::table('matauangs')->get();
        $lokasi = DB::table('lokasis')->where('Status', 'OPN')->get();
        $pelanggan = DB::table('pelanggans')->get();
        $item = DB::select("SELECT i.KodeItem, i.NamaItem, i.Keterangan 
            FROM items i
            where i.jenisitem = 'bahanjadi'
            GROUP BY i.NamaItem
            ");
        $satuan = DB::table('satuans')->get();

        $last_id = DB::select('SELECT * FROM penjualanlangsungs ORDER BY KodePenjualanLangsung DESC LIMIT 1');
        $year_now = date('y');
        $month_now = date('m');
        $date_now = date('d');

        if ($last_id == null) {
            $newID = "DJB-" . $year_now . $month_now . "0001";
        } else {
            $string = $last_id[0]->KodePenjualanLangsung;
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
            $newID = "DJB-" . $year_now . $month_now . $newID;
        }

        foreach ($item as $key => $value) {
            $array_satuan = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->pluck('KodeSatuan')->toArray();
            $datasatuan[$value->KodeItem] = $array_satuan;
            foreach ($array_satuan as $sat) {
                $array_harga = DB::table('itemkonversis')->where('KodeItem', $value->KodeItem)->where('KodeSatuan', $sat)->pluck('HargaJual')->toArray();
                $dataharga[$value->KodeItem][$sat] = $array_harga[0];
            }
        }

        return view('penjualan.penjualanLangsung.add', [
            'newID' => $newID,
            'pemesananpembelian' => $pemesananpembelian,
            'matauang' => $matauang,
            'lokasi' => $lokasi,
            'pelanggan' => $pelanggan,
            'item' => $item,
            'satuan' => $satuan,
            'datasatuan' => $datasatuan,
            'dataharga' => $dataharga,
        ]);
    }

    public function store(Request $request)
    {
        DB::table('penjualanlangsungs')->insert([
            'KodePenjualanLangsung' => $request->KodeSO,
            'Tanggal' => \Carbon\Carbon::now(),
            'KodeLokasi' => $request->KodeLokasi,
            'KodeMataUang' => $request->KodeMataUang,
            'Status' => 'CFM',
            'KodeUser' => 'Admin',
            'Total' => $request->subtotal,
            'PPN' => $request->ppn,
            'NilaiPPN' => $request->ppnval,
            'Printed' => 0,
            'Diskon' => $request->diskon,
            'NilaiDiskon' => $request->diskonval,
            'Subtotal' => $request->subtotal - $request->ppnval,
            'KodePelanggan' => $request->KodePelanggan,
            'NoIndeks' => 0,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $pl = DB::table('penjualanlangsungs')->where('KodePenjualanLangsung', $request->KodeSO)->first();

        $items = $request->item;
        $satuans = $request->satuan;
        $qtys = $request->qty;
        $prices = $request->price;
        $totals = $request->total;
        $keterangans = $request->keterangan;
        foreach ($items as $key => $value) {
            DB::table('penjualanlangsungdetails')->insert([
                'KodePenjualanLangsung' => $request->KodeSO,
                'KodeItem' => $items[$key],
                'KodeSatuan' => $satuans[$key],
                'Qty' => $qtys[$key],
                'Harga' => $prices[$key],
                'Keterangan' => $keterangans[$key],
                'Diskon' => $request->diskon,
                'NilaiDiskon' => ($request->diskon * $prices[$key]) / 100,
                'NoUrut' => 0,
                'Subtotal' => $totals[$key],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        $nomer = 0;
        foreach ($items as $key => $value) {
            $nomer++;
            DB::table('keluarmasukbarangs')->insert([
                'Tanggal' => \Carbon\Carbon::now(),
                'KodeLokasi' => $pl->KodeLokasi,
                'KodeItem' => $items[$key],
                'JenisTransaksi' => 'DJB',
                'KodeTransaksi' => $pl->KodePenjualanLangsung,
                'Qty' => -$qtys[$key],
                'HargaRata' => 0,
                'KodeUser' => \Auth::user()->name,
                'idx' => 0,
                'indexmov' => $nomer,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        DB::table('eventlogs')->insert([
            'KodeUser' => \Auth::user()->name,
            'Tanggal' => \Carbon\Carbon::now(),
            'Jam' => \Carbon\Carbon::now()->format('H:i:s'),
            'Keterangan' => 'Tambah penjualan langsung ' . $pl->KodePenjualanLangsung,
            'Tipe' => 'OPN',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return redirect('/penjualanLangsung');
    }

    public function show($id)
    {
        $data = DB::select("SELECT a.KodePenjualanLangsung, a.Tanggal, b.NamaMataUang, c.NamaLokasi, d.NamaPelanggan, a.Diskon, a.PPN, a.Subtotal, a.Total, a.NilaiPPN from penjualanlangsungs a
            inner join matauangs b on b.KodeMataUang = a.KodeMataUang
            inner join lokasis c on c.KodeLokasi = a.KodeLokasi
            inner join pelanggans d on d.KodePelanggan = a.KodePelanggan
            where a.KodePenjualanLangsung ='" . $id . "' limit 1")[0];

        $items = DB::select("SELECT DISTINCT a.Qty,b.NamaItem,d.NamaSatuan,
            a.Harga, a.Subtotal, b.Keterangan  from penjualanlangsungdetails a
            inner join items b on a.KodeItem = b.KodeItem
            inner join itemkonversis c on c.KodeItem=a.KodeItem
            inner join satuans  d on d.KodeSatuan=a.KodeSatuan
            where a.KodePenjualanLangsung ='" . $id . "' ");

        $data->Tanggal = Carbon::parse($data->Tanggal)->format('d-m-Y');
        return view('penjualan.penjualanLangsung.show', compact('data', 'id', 'items'));
    }
}
