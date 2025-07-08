<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class alamatpelanggan extends Model
{
    protected $table = 'alamatpelanggans';
    protected $fillable = ['KodePelanggan','Alamat'];

    protected $casts = [
        'alamat' => 'array'
    ];

    public function pelanggan()
    {
        return $this->belongsTo('App\Model\pelanggan','KodePelanggan');
    }
}
