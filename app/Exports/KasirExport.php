<?php

namespace App\Exports;

use App\kasirdetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class KasirExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $kasir = kasirdetail::select('KodeKasir','KodeItem','Qty','Harga','KodeSatuan','Subtotal','created_at','updated_at')
        ->get();
        return view('penjualan.kasir.export',compact('kasir'));
    }
}