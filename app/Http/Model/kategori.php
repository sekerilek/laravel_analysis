<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $table = 'kategoris';
    protected $primaryKey = 'KodeKategori';
    public $incrementing = false;
    protected $fillable = ['KodeKategori', 'NamaKategori', 'KodeItemAwal'];
}
