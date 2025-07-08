<?php

namespace App\Model;
use App\Model\kasir;

use Illuminate\Database\Eloquent\Model;

class kasirreturn extends Model
{
    protected $table = 'kasirreturns';
    protected $primaryKey = 'KodeKasirReturn';
    public $incrementing = false;
    protected $fillable = ['KodeKasirReturn', 'KodeKasir', 'Tanggal', 'Status', 'KodeMataUang', 'KodeLokasi', 'KodePelanggan', 'Keterangan', 'KodeUser', 'PPN', 'NilaiPPN', 'Diskon', 'NilaiDiskon', 'Subtotal', 'Total'];

    public function lokasi()
    {
        return $this->belongsTo('App\Model\lokasi', 'KodeLokasi');
    }

    public function matauang()
    {
        return $this->belongsTo('App\Model\matauang', 'KodeMataUang');
    }

    public function pelanggan()
    {
        return $this->belongsTo('App\Model\pelanggan', 'KodePelanggan');
    }
}
