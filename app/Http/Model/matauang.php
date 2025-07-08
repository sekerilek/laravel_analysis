<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class matauang extends Model
{
    protected $table = 'matauangs';
    protected $primaryKey = 'KodeMataUang';
    public $incrementing = false;
    protected $fillable = ['KodeMataUang', 'NamaMataUang', 'Nilai', 'created_at'];

    public function pemesananpenjualan()
    {
        return $this->hasMany('App\Model\pemesananpenjualan');
    }
}
