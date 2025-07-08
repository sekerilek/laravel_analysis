<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'KodeSupplier';
    public $incrementing = false;
    protected $fillable = ['KodeSupplier', 'NamaSupplier', 'Kontak', 'Handphone', 'Alamat'];
}
