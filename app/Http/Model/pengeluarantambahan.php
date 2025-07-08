<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class pengeluarantambahan extends Model
{
    protected $table = 'pengeluarantambahans';
    protected $fillable = ['Nama', 'Tanggal', 'KodeLokasi', 'KodeMataUang', 'Total', 'KodeUser', 'Status', 'Keterangan'];
}
