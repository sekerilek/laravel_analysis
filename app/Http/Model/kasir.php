<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class kasir extends Model
{
    protected $table = 'kasirs';
    protected $primaryKey = 'KodeKasir';
    public $incrementing = false;
    protected $fillable = ['KodeKasir', 'Tanggal', 'KodeMataUang', 'KodeLokasi', 'KodePelanggan', 'Keterangan'];

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
