<?php

namespace App\Exports;
use App\penerimaanbarang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
class PenerimaanExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $kasir = DB::table('penerimaanbarangs')
        ->join('penerimaanbarangdetails','penerimaanbarangdetails.KodePenerimaanBarang','=','penerimaanbarangs.KodePenerimaanBarang')
        ->join('pemesananpembelians','pemesananpembelians.KodePO','=','penerimaanbarangs.KodePO')
        ->join('suppliers','suppliers.KodeSupplier','=','penerimaanbarangs.KodeSupplier')
        ->select('penerimaanbarangs.KodePenerimaanBarang','penerimaanbarangs.KodePO','penerimaanbarangdetails.KodeItem',
        'penerimaanbarangdetails.Qty','penerimaanbarangdetails.KodeSatuan','penerimaanbarangdetails.Harga','penerimaanbarangdetails.KodeSatuan',
        'pemesananpembelians.Total','suppliers.NamaSupplier','suppliers.Alamat')
        ->get();
        return view('pembelian.penerimaanBarang.export',compact('kasir'));
    }
}
