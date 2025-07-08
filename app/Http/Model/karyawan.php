<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    protected $table = 'karyawans';
    protected $primaryKey = 'KodeKaryawan';
    public $incrementing = false;
    protected $fillable = ['KodeKaryawan', 'Nama', 'JenisKelamin', 'Jabatan', 'Alamat', 'Kota', 'Telepon', 'GajiPokok', 'KodeUser', 'Status', 'KodeGolongan'];
}
