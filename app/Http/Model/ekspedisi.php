<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ekspedisi extends Model
{
    protected $table = 'ekspedisis';
    protected $fillable = ['KodeEkspedisi','NamaEkspedisi','Modal','TarifPelanggan','Status'];

 
}
