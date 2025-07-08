<?php

namespace App\Exports;

use App\pemesananpembelian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class PembelianExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $kasir = DB::table('pemesananpembelians')
        ->join('pemesananpembeliandetails','pemesananpembelians.KodeSupplier','=','pemesananpembelians.KodeSupplier')
        ->join('suppliers','suppliers.KodeSupplier','=','pemesananpembelians.KodeSupplier')
        ->select('pemesananpembeliandetails.KodePO','pemesananpembeliandetails.KodeItem','pemesananpembeliandetails.Qty',
        'pemesananpembeliandetails.Harga','pemesananpembeliandetails.KodeSatuan','pemesananpembeliandetails.Subtotal',
        'suppliers.NamaSupplier','suppliers.Alamat')
        ->get();
        return view('pembelian.pemesananPembelian.export',compact('kasir'));
    }
}
