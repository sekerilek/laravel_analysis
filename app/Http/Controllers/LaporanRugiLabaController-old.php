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
        $tanggal = date('Y-m-d',strtotime($request->tanggal));
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
                ->wheredate('suratjalans.created_at',$tanggal)
                ->groupBy('suratjalans.KodeSuratJalan')
                ->get();
        }

        if ($jenislaporan == 'kasir') {
            $laporan = DB::table('kasirs')
            ->leftJoin('pelanggans', 'kasirs.KodePelanggan', '=', 'pelanggans.KodePelanggan')
            ->leftJoin('rugilaba', 'kasirs.KodeKasir', '=', 'rugilaba.KodeTransaksi')
            ->whereDate('kasirs.Tanggal', $tanggal)
            ->select(
                'kasirs.KodeKasir as Nota',
                'kasirs.Tanggal as Tanggal',
                'pelanggans.NamaPelanggan as Pelanggan',
                'kasirs.Total as Total',
                'rugilaba.TotalLaba as Profit'
            )
            ->get();
            /*$laporan = DB::table('kasirs')
                ->selectRaw(
                    'kasirs.KodeKasir as Nota, kasirs.Tanggal, pelanggans.NamaPelanggan as Pelanggan, kasirs.Subtotal as Total, sum(kasirdetails.Qty*kasirdetails.Harga - kasirdetails.Qty*itemkonversis.HargaBeli) as Profit'
                )
                ->leftjoin('kasirdetails', 'kasirs.KodeKasir', '=', 'kasirdetails.KodeKasir')
                ->leftjoin('itemkonversis', 'kasirdetails.KodeItem', '=' , 'itemkonversis.KodeItem')
                ->leftjoin('pelanggans', 'kasirs.KodePelanggan', '=', 'pelanggans.KodePelanggan')
                ->where('kasirs.Status', 'CFM')
                ->wheredate('kasirs.created_at',$tanggal)
                ->groupBy('kasirs.KodeKasir')
                ->get();*/
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
                ->leftjoin('items', 'suratjalandetails.KodeItem', '=', 'items.KodeItem')
                ->leftjoin('itemkonversis', 'suratjalandetails.KodeItem', '=' , 'itemkonversis.KodeItem')
                ->leftjoin('satuans', 'itemkonversis.KodeSatuan', '=', 'satuans.KodeSatuan')
                ->where('suratjalandetails.KodeSuratJalan', $request->kode)
                ->get();
        }

        if ($jenislaporan == 'kasir') {
            $detail = DB::table('kasirdetails')
            ->leftJoin('items', 'kasirdetails.KodeItem', '=', 'items.Kode')
            ->leftJoin('itemkonversis','kasirdetails.KodeItem', '=', 'itemkonversis.KodeItem')
            ->leftJoin('rugilaba_details', 'kasirdetails.KodeItem', '=', 'rugilaba_details.KodeItem')
            ->where('kasirdetails.KodeKasir', $request->kode)
            ->select(
                'items.NamaItem as Barang',
                'kasirdetails.Qty as Jumlah',
                'kasirdetails.KodeSatuan as Satuan',
                'kasirdetails.Harga as HargaJual',
                'kasirdetails.HargaRata as HargaBeli',
                'kasirdetails.Subtotal as Subtotal',
                'rugilaba_details.Laba as Profit'
            )
            ->get();
            /*$detail = DB::table('kasirdetails')
                ->selectRaw(
                    'items.NamaItem as Barang, kasirdetails.Qty as Jumlah, satuans.NamaSatuan as Satuan, itemkonversis.HargaJual, itemkonversis.HargaBeli, (kasirdetails.Qty*itemkonversis.HargaJual) as Subtotal, (kasirdetails.Qty*kasirdetails.Harga - kasirdetails.Qty*itemkonversis.HargaBeli) as Profit'
                )
                ->leftjoin('items', 'kasirdetails.KodeItem', '=', 'items.KodeItem')
                ->leftjoin('itemkonversis', 'kasirdetails.KodeItem', '=' , 'itemkonversis.KodeItem')
                ->leftjoin('satuans', 'itemkonversis.KodeSatuan', '=', 'satuans.KodeSatuan')
                ->where('kasirdetails.KodeKasir', $request->kode)
                ->get();*/
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
            ->SelectRaw('kasirs.KodeKasir as Nota ,kasirs.Tanggal, pelanggans.NamaPelanggan, kasirs.Subtotal as Total, (kasirdetails.Qty*itemkonversis.HargaJual - kasirdetails.Qty*itemkonversis.HargaBeli) as Profit')
            ->where('pelanggans.KodePelanggan','=',$request->namapelanggan)
            ->wheredate('kasirs.created_at',$tanggal)
            ->get();
            //dd($lapor);
            $profit = DB::table('pelanggans')
            ->leftjoin('kasirs','kasirs.KodePelanggan','=','pelanggans.KodePelanggan')
            ->leftjoin('kasirdetails','kasirdetails.KodeKasir','=','kasirs.KodeKasir')
            ->leftjoin('itemkonversis','itemkonversis.KodeItem','=','kasirdetails.KodeItem')
            ->SelectRaw(' sum(kasirdetails.Qty*itemkonversis.HargaJual - kasirdetails.Qty*itemkonversis.HargaBeli) as tot')
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
