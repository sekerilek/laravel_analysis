<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class penerimaanbarang extends Model
{
    protected $table = 'penerimaanbarangs';

    public function sales()
    {
        return $this->belongsTo('App\Model\karyawan', 'KodeSales', 'KodeKaryawan');
    }

    public function uang()
    {
        return $this->belongsTo('App\Model\matauang', 'KodeMataUang', 'KodeMataUang');
    }

    public function gudang()
    {
        return $this->belongsTo('App\Model\lokasi', 'KodeLokasi', 'KodeLokasi');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Model\supplier', 'KodeSupplier', 'KodeSupplier');
    }
}
