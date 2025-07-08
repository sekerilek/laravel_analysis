<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class absensi extends Model
{
    protected $table = 'absensis';
    protected $primaryKey = 'no';
    public $incrementing = false;
    protected $fillable = ['IDKaryawan', 'KodeKaryawan', 'StatusAbsen', 'TanggalAbsen'];
}
