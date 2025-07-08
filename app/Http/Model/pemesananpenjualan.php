<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class pemesananpenjualan extends Model
{
    protected $table = 'pemesananpenjualans';
    protected $primaryKey = 'KodeSO';
    public $incrementing = false;
    protected $fillable = ['KodeSO', 'Tanggal', 'TanggalKirim', 'Expired', 'KodeMataUang', 'KodeLokasi', 'KodePelanggan', 'Term', 'Keterangan'];

    public function lokasi()
    {
        return $this->belongsTo('App\Model\lokasi','KodeLokasi');
    }

    public function matauang()
    {
        return $this->belongsTo('App\Model\matauang','KodeMataUang');
    }

    public function pelanggan()
    {
        return $this->belongsTo('App\Model\pelanggan','KodePelanggan');
    }
}
