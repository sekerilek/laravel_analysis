<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pemesananpenjualan extends Model
{
    protected $table = 'pemesananpenjualans';
    protected $primaryKey = 'KodeSO';
    public $incrementing = false;
    protected $fillable = ['KodeSO', 'Tanggal', 'TanggalKirim', 'Expired', 'KodeMataUang', 'KodeLokasi', 'KodePelanggan', 'Term', 'Keterangan'];
}
