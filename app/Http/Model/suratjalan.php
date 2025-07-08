<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class suratjalan extends Model
{
    protected $table = 'suratjalans';
    protected $primaryKey = 'KodeSuratJalanID';

    public function sopir()
    {
        return $this->belongsTo('App\Model\karyawan', 'KodeSopir', 'IDKaryawan');
    }

    public function uang()
    {
        return $this->belongsTo('App\Model\matauang', 'KodeMataUang');
    }

    public function gudang()
    {
        return $this->belongsTo('App\Model\lokasi', 'KodeLokasi', 'KodeLokasi');
    }

    public function pelanggan()
    {
        return $this->belongsTo('App\Model\pelanggan', 'KodePelanggan', 'KodePelanggan');
    }
}
