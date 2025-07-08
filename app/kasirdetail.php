<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kasirdetail extends Model
{
    protected $table = 'kasirdetails';
    protected $primaryKey = 'KodeKasir';
    public $incrementing = false;
    protected $fillable = ['id','KodeKasir','KodeItem','Qty', 'Harga', 'HargaRata', 'KodeSatuan','NoUrut','Subtotal','created_at','updated_at'];
}
