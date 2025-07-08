<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'KodeItem';
    protected $keyType = 'string';
    protected $fillable = ['KodeItem', 'KodeKategori', 'NamaItem', 'Status'];

    public function kategori()
    {
        return $this->belongsTo('App\kategori','KodeKategori');
    }

    public function satuan()
    {
        return $this->belongsTo('App\satuan','KodeSatuan');
    }

    public function itemkonversi()
    {
        return $this->belongsToMany('App\itemkonversi','KodeSatuan');
    }
}
