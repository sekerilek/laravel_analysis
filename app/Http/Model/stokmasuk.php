<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class stokmasuk extends Model
{
    protected $table = 'stokmasuks';

    public function lokasi()
    {
        return $this->hasMany('App\lokasi');
    }
}
