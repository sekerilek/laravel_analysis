<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class pelanggan extends Model
{
    protected $table = 'pelanggans';
    //protected $primaryKey = 'KodePelanggan';
    protected $fillable = ['KodePelanggan','NamaPelanggan','Kontak','Handphone','Email','NIK','NPWP'];

    public function alamat()
    {
        return $this->hasMany('App\Model\alamatpelanggan','KodePelanggan');
    }
}
