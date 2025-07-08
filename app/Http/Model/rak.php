<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class rak extends Model
{
    protected $table = 'rak_item';
    protected $primaryKey = 'ID';
    protected $keyType = 'string';
    protected $fillable = ['nama_rak', 'created_at', 'updated_at'];

}
