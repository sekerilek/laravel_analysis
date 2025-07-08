<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;

class RugiLabaBulanController extends Controller
{
    public function index() {
      return view('laporan.rugilababulan.index');
    }

    public function buatLaporanbulanan(Request $request) {

        $jenislaporan = $request->laporan;
        $bulan = $request->month;
        $tahun = $request->year;
        //dd($jenislaporan,$bulan,$tahun);
        // $tanggal = date('Y-m-d',strtotime($request->tanggal));
        if ($jenislaporan == 'suratjalan') {
            $laporan = DB::table('suratjalans')
                ->selectRaw(
                    'suratjalans.KodeSuratJalan as Nota, suratjalans.Tanggal, pelanggans.NamaPelanggan as Pelanggan, suratjalans.Subtotal as Total, sum(suratjalandetails.Qty*itemkonversis.HargaJual - suratjalandetails.Qty*itemkonversis.HargaBeli) as Profit'
                )
                // ->selectRaw('sum(kasirdetails.Qty*kasirdetails.Harga - kasirdetails.Qty*itemkonversis.HargaBeli) as TotalSemua')
                ->leftjoin('suratjalandetails', 'suratjalans.KodeSuratJalan', '=', 'suratjalandetails.KodeSuratJalan')
                ->leftjoin('itemkonversis', 'suratjalandetails.KodeItem', '=' , 'itemkonversis.KodeItem')
                ->leftjoin('pelanggans', 'suratjalans.KodePelanggan', '=', 'pelanggans.KodePelanggan')
                ->where('suratjalans.Status', 'CFM')
                ->wheremonth('suratjalans.Tanggal',$bulan)
                ->whereyear('suratjalans.Tanggal',$tahun)
                ->groupBy('suratjalans.KodeSuratJalan')
                ->get();
        }

        if ($jenislaporan == 'kasir') {
            $laporan = DB::table('kasirdetails')
                ->selectraw('kasirdetails.created_at,sum(kasirdetails.Qty * kasirdetails.Harga) as Jual,sum(kasirdetails.Qty * kasirdetails.HargaRata) as Profit')
                ->wheremonth('kasirdetails.created_at',$bulan)
                ->whereyear('kasirdetails.created_at',$tahun)
                ->groupBy('kasirdetails.created_at')
                ->get();
                //dd($laporan);
                $total = DB::table('kasirs')
                ->selectRaw(
                 'sum(kasirdetails.Qty*kasirdetails.Harga - kasirdetails.Qty*kasirdetails.HargaRata) as totalprofit')
                ->leftjoin('kasirdetails', 'kasirs.KodeKasir', '=', 'kasirdetails.KodeKasir')
                ->leftjoin('itemkonversis', 'kasirdetails.KodeItem', '=' , 'itemkonversis.KodeItem')
                ->leftjoin('pelanggans', 'kasirs.KodePelanggan', '=', 'pelanggans.KodePelanggan')
                ->where('kasirs.Status', 'CFM')
                ->wheremonth('kasirs.Tanggal',$bulan)
                ->whereyear('kasirs.Tanggal',$tahun)
                ->get();
                //dd($total);
                $retur = DB::table('kasirreturndetails')
                ->selectRaw(
                 'sum(kasirreturndetails.Qty * kasirreturndetails.Harga) as totalretur,kasirreturndetails.created_at,
                 sum(kasirreturndetails.Qty) as hpp,
                 sum(kasirreturndetails.Qty) as QtyRetur')
                ->wheremonth('kasirreturndetails.created_at',$bulan)
                ->whereyear('kasirreturndetails.created_at',$tahun)
                ->addSelect([
                    'SisaStok' => DB::table('kasirdetails')
                    ->whereColumn('KodeKasir', 'kasirreturndetails.KodeKasir')
                    ->selectraw('sum(Qty) as Qtya')
                    ->groupby('created_at')
                    ->get()
                ])
                ->addSelect([
                    'HargaRata' => DB::table('kasirdetails')
                    ->whereColumn('KodeKasir', 'kasirreturndetails.KodeKasir')
                    ->selectraw('HargaRata')
                    ->groupby('created_at')
                    ->get()
                ])
                ->groupby('kasirreturndetails.created_at')
                ->get();
                dd($retur);
                return view('laporan.rugilababulan.filter',compact('laporan','total','retur'));
    }
}

    public function detailLaporan(Request $request) {
        $jenislaporan = $request->laporan;
        if ($jenislaporan == 'suratjalan') {
            $detail = DB::table('suratjalandetails')
                ->selectRaw(
                    'items.NamaItem as Barang, suratjalandetails.Qty as Jumlah, satuans.NamaSatuan as Satuan, itemkonversis.HargaJual, itemkonversis.HargaBeli, (suratjalandetails.Qty*itemkonversis.HargaJual) as Subtotal, (suratjalandetails.Qty*itemkonversis.HargaJual - suratjalandetails.Qty*itemkonversis.HargaBeli) as Profit'
                )
                ->leftjoin('items', 'suratjalandetails.KodeItem', '=', 'items.KodeItem')
                ->leftjoin('itemkonversis', 'suratjalandetails.KodeItem', '=' , 'itemkonversis.KodeItem')
                ->leftjoin('satuans', 'itemkonversis.KodeSatuan', '=', 'satuans.KodeSatuan')
                ->where('suratjalandetails.KodeSuratJalan', $request->kode)
                ->get();
        }

        if ($jenislaporan == 'kasir') {
            $detail = DB::table('kasirdetails')
                ->selectRaw(
                    'items.NamaItem as Barang, kasirdetails.Qty as Jumlah, satuans.NamaSatuan as Satuan, itemkonversis.HargaJual, itemkonversis.HargaBeli, (kasirdetails.Qty*kasirdetails.Harga) as Subtotal, (kasirdetails.Qty*kasirdetails.Harga - kasirdetails.Qty*kasirdetails.HargaRata) as Profit'
                )
                ->leftjoin('items', 'kasirdetails.KodeItem', '=', 'items.KodeItem')
                ->leftjoin('itemkonversis', 'kasirdetails.KodeItem', '=' , 'itemkonversis.KodeItem')
                ->leftjoin('satuans', 'itemkonversis.KodeSatuan', '=', 'satuans.KodeSatuan')
                ->where('kasirdetails.KodeKasir', $request->kode)
                ->get();
        }
        

        return Datatables::of($detail)->make(true);
    }
    public function index_costumer(){
        $pelanggan = DB::table('pelanggans')->get();
        return view('laporan.rugilabacostumer.index',compact('pelanggan',$pelanggan));
    }
    public function filtercostumer(Request $request){
        $namapelanggan  = $request->namapelanggan;
        $tanggal = date('Y-m-d',strtotime($request->start));
        $jenislaporan = $request->jenislaporan;
        $pelanggan = DB::table('pelanggans')->get();
        if($jenislaporan == 'kasir'){
            $lapor = DB::table('pelanggans')
            ->leftjoin('kasirs','kasirs.KodePelanggan','=','pelanggans.KodePelanggan')
            ->leftjoin('kasirdetails','kasirdetails.KodeKasir','=','kasirs.KodeKasir')
            ->leftjoin('itemkonversis','itemkonversis.KodeItem','=','kasirdetails.KodeItem')
            ->SelectRaw('kasirs.KodeKasir as Nota ,kasirs.Tanggal, pelanggans.NamaPelanggan, kasirs.Subtotal as Total, (kasirdetails.Qty*kasirdetails.Harga - kasirdetails.Qty*kasirdetails.HargaRata) as Profit')
            ->where('pelanggans.KodePelanggan','=',$request->namapelanggan)
            ->wheredate('kasirs.created_at',$tanggal)
            ->get();
            //dd($lapor);
            $profit = DB::table('pelanggans')
            ->leftjoin('kasirs','kasirs.KodePelanggan','=','pelanggans.KodePelanggan')
            ->leftjoin('kasirdetails','kasirdetails.KodeKasir','=','kasirs.KodeKasir')
            ->leftjoin('itemkonversis','itemkonversis.KodeItem','=','kasirdetails.KodeItem')
            ->SelectRaw(' sum(kasirdetails.Qty*itemkonversis.HargaJual - kasirdetails.Qty*kasirdetails.HargaRata) as tot')
            ->where('pelanggans.KodePelanggan','=',$request->namapelanggan)
            ->wheredate('kasirs.created_at',$tanggal)
            ->first();
        }else if($jenislaporan =='suratjalan'){
            $lapor = DB::table('pelanggans')
            ->leftjoin('suratjalans','suratjalans.KodePelanggan','=','pelanggans.KodePelanggan')
            ->leftjoin('suratjalandetails','suratjalandetails.KodeSuratJalan','=','suratjalans.KodeSuratJalan')
            ->leftjoin('itemkonversis','itemkonversis.KodeItem','=','suratjalandetails.KodeItem')
            ->SelectRaw('suratjalans.KodeSuratJalan as Nota ,suratjalans.Tanggal, pelanggans.NamaPelanggan, suratjalans.Subtotal as Total, (suratjalandetails.Qty*itemkonversis.HargaJual - suratjalandetails.Qty*itemkonversis.HargaBeli) as Profit')
            ->where('pelanggans.KodePelanggan','=',$request->namapelanggan)
            ->wheredate('suratjalans.created_at',$tanggal)
            ->get();
            $profit = DB::table('pelanggans')
            ->leftjoin('suratjalans','suratjalans.KodePelanggan','=','pelanggans.KodePelanggan')
            ->leftjoin('suratjalandetails','suratjalandetails.KodeSuratJalan','=','suratjalans.KodeSuratJalan')
            ->leftjoin('itemkonversis','itemkonversis.KodeItem','=','suratjalandetails.KodeItem')
            ->SelectRaw(' sum(suratjalandetails.Qty*itemkonversis.HargaJual - suratjalandetails.Qty*itemkonversis.HargaBeli) as tot')
            ->where('pelanggans.KodePelanggan','=',$request->namapelanggan)
            ->wheredate('suratjalans.created_at',$tanggal)
            ->first();
            //dd($lapor);
        }
       
        
        //dd($lapor);
        
        
        return view('laporan.rugilabacostumer.laporan',['pelanggan'=>$pelanggan,'lapor'=>$lapor,'profit'=>$profit]);
    }
}
