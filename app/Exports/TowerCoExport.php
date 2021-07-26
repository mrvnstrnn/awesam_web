<?php

namespace App\Exports;

use App\Models\TowerCo;
use Maatwebsite\Excel\Concerns\FromCollection;

class TowerCoExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TowerCo::all();
    }
}
