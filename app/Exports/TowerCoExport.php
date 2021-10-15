<?php

namespace App\Exports;

use App\Models\TowerCo;
use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class TowerCoExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $towerco = \DB::table('towerco');

        
        if (\Auth::user()->profile_id == 21) {
            $user_detail = \Auth::user()->getUserDetail()->first();
            $vendor = Vendor::where('vendor_id', $user_detail->vendor_id)->first();

            $towerco->where('TOWERCO', $vendor->vendor_acronym);
        }

        return $towerco->get();
    }

    public function headings() :array
    {

        $x = \DB::getSchemaBuilder()->getColumnListing('towerco');

        return $x;


    }
 
}
