<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;

class LaporanRugiLabaController extends Controller
{
    public function index() {
      return view('laporan.rugilaba.index');
    }

    public function buatLaporan(Request $request) {
        $jenislaporan = $request->laporan;
        if ($jenislaporan == 'suratjalan') {
            $laporan = DB::table('suratjalans')
                ->selectRaw(
                    'suratjalans.KodeSuratJalan as Nota, suratjalans.Tanggal, pelanggans.NamaPelanggan as Pelanggan, suratjalans.Subtotal as Total, sum(suratjalandetails.Qty*itemkonversis.HargaJual - suratjalandetails.Qty*itemkonversis.HargaBeli) as Profit'
                )
                ->join('suratjalandetails', 'suratjalans.KodeSuratJalan', '=', 'suratjalandetails.KodeSuratJalan')
                ->join('itemkonversis', 'suratjalandetails.KodeItem', '=' , 'itemkonversis.KodeItem')
                ->join('pelanggans', 'suratjalans.KodePelanggan', '=', 'pelanggans.KodePelanggan')
                ->where('suratjalans.Status', 'CFM')
                ->groupBy('suratjalans.KodeSuratJalan')
                ->get();
//                 select
//     suratjalans.KodeSuratJalan as `No. Nota`,
//     suratjalans.Tanggal as `Tgl Transaksi`,
//     pelanggans.NamaPelanggan as `Pelanggan`,
//     suratjalans.Subtotal as `Total`,
//     sum(
//         suratjalandetails.Qty*itemkonversis.HargaJual - suratjalandetails.Qty*itemkonversis.HargaBeli
//     ) as `Total Profit`
// from suratjalans
// join suratjalandetails on suratjalans.KodeSuratJalan = suratjalandetails.KodeSuratJalan
// join pelanggans on suratjalans.KodePelanggan = pelanggans.KodePelanggan
// JOIN itemkonversis on suratjalandetails.KodeItem = itemkonversis.KodeItem
// where suratjalans.Status = 'CFM'
// group by suratjalans.KodeSuratJalan
        }

        if ($jenislaporan == 'kasir') {
            $laporan = DB::table('kasirs')
                ->selectRaw(
                    'kasirs.KodeKasir as Nota, kasirs.Tanggal, pelanggans.NamaPelanggan as Pelanggan, kasirs.Subtotal as Total, sum(kasirdetails.Qty*itemkonversis.HargaJual - kasirdetails.Qty*itemkonversis.HargaBeli) as Profit'
                )
                ->join('kasirdetails', 'kasirs.KodeKasir', '=', 'kasirdetails.KodeKasir')
                ->join('itemkonversis', 'kasirdetails.KodeItem', '=' , 'itemkonversis.KodeItem')
                ->join('pelanggans', 'kasirs.KodePelanggan', '=', 'pelanggans.KodePelanggan')
                ->where('kasirs.Status', 'CFM')
                ->groupBy('kasirs.KodeKasir')
                ->get();
        }
        

        return Datatables::of($laporan)
        ->addColumn('action', function($laporan) {
            return
                '<button class="btn-xs btn btn-primary" style="display:inline-block;" onclick="detailLaporan(\''.$laporan->Nota.'\')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat</button>';
        })
        ->make(true);
    }

    public function detailLaporan(Request $request) {
        $jenislaporan = $request->laporan;
        if ($jenislaporan == 'suratjalan') {
            $detail = DB::table('suratjalandetails')
                ->selectRaw(
                    'items.NamaItem as Barang, suratjalandetails.Qty as Jumlah, satuans.NamaSatuan as Satuan, itemkonversis.HargaJual, itemkonversis.HargaBeli, (suratjalandetails.Qty*itemkonversis.HargaJual) as Subtotal, (suratjalandetails.Qty*itemkonversis.HargaJual - suratjalandetails.Qty*itemkonversis.HargaBeli) as Profit'
                )
                ->join('items', 'suratjalandetails.KodeItem', '=', 'items.KodeItem')
                ->join('itemkonversis', 'suratjalandetails.KodeItem', '=' , 'itemkonversis.KodeItem')
                ->join('satuans', 'itemkonversis.KodeSatuan', '=', 'satuans.KodeSatuan')
                ->where('suratjalandetails.KodeSuratJalan', $request->kode)
                ->get();
        }

        if ($jenislaporan == 'kasir') {
            $detail = DB::table('kasirdetails')
                ->selectRaw(
                    'items.NamaItem as Barang, kasirdetails.Qty as Jumlah, satuans.NamaSatuan as Satuan, itemkonversis.HargaJual, itemkonversis.HargaBeli, (kasirdetails.Qty*itemkonversis.HargaJual) as Subtotal, (kasirdetails.Qty*itemkonversis.HargaJual - kasirdetails.Qty*itemkonversis.HargaBeli) as Profit'
                )
                ->join('items', 'kasirdetails.KodeItem', '=', 'items.KodeItem')
                ->join('itemkonversis', 'kasirdetails.KodeItem', '=' , 'itemkonversis.KodeItem')
                ->join('satuans', 'itemkonversis.KodeSatuan', '=', 'satuans.KodeSatuan')
                ->where('kasirdetails.KodeKasir', $request->kode)
                ->get();
        }
        

        return Datatables::of($detail)->make(true);
    }
}
