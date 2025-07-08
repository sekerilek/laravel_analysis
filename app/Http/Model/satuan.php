<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class satuan extends Model
{
    protected $table = 'satuans';
    protected $primaryKey = 'KodeSatuan';
    public $incrementing = false;
    protected $fillable = ['KodeSatuan', 'NamaSatuan'];
}
