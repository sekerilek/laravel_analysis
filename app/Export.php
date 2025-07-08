<?php
namespace App;

use App\Model\kasir;
use Maatwebsite\Excel\Concerns\FromCollection;

class Export implements FromCollection
{
    public function collection()
    {
        return kasir::all();
    }
}