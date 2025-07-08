<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class pemesananpembelian extends Model
{
    protected $table = 'pemesananpembelians';
    protected $primaryKey = 'KodePO';
    public $incrementing = false;
    protected $fillable = ['KodePO', 'KodeLokasi', 'KodeMataUang', 'PPN', 'Tanggal', 'Expired', 'Keterangan'];
}
