<?php

namespace App\Exports;

use App\pemesananpenjualan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class PemesananPenjualanExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $kasir = DB::table('pemesananpenjualans')
        ->join('pemesanan_penjualan_detail','pemesanan_penjualan_detail.KodeSO','=','pemesananpenjualans.KodeSO')
        ->join('pelanggans','pelanggans.KodePelanggan','=','pemesananpenjualans.KodePelanggan')
        ->select('pemesananpenjualans.KodeSO','pemesanan_penjualan_detail.KodeItem','pemesanan_penjualan_detail.Qty',
        'pemesanan_penjualan_detail.KodeSatuan','pemesanan_penjualan_detail.Harga','pemesanan_penjualan_detail.Subtotal',
        'pelanggans.NamaPelanggan')
        ->get();
        return view('penjualan.pemesananPenjualan.export',compact('kasir'));
    }
}
