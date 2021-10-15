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

        // $allowed_fields = \DB::connection('mysql2')
        //             ->table("tower_fields_map")
        //             ->join('tower_fields_map_profile', 'tower_fields_map_profile.column_id', 'tower_fields_map.id')
        //             // ->where('tower_fields_map_profile.edit_profile', 'TOWERCO')
        //             ->get();

        //             $select_collect = collect();

        //             foreach ($allowed_fields as $allowed_field) {
        //                 $select_collect->push($allowed_field->towerco_fields);
        //             }

        //             $towerco = TowerCo::select(
        //                 $select_collect->all()
        //             );

        // $towerco = TowerCo::select(
        //     "Serial Number", 
        //     "Search Ring",
        //     "REGION",
        //     "TOWERCO",
        //     // "DATE ENDORSED BY RAM",
        //     "MLA COMPLETION DATE",
        //     "DATE ACCEPTED BY TOWERCO",
        //     // "SITE ACQUIRED FORECAST",
        //     // "SITE DATE ACQUIRED",
        //     // "ESTIMATED RFI DATE",
        //     "PROJECT TAG",
        //     "MILESTONE STATUS",
        //     "PROVINCE",
        //     "TOWN",
        //     "[NP]Latitude",
        //     "[NP]Longitude",
        //     "SITE TYPE",
        //     "Tower Height",
        //     "FOC/ MW TAGGING",
        //     "Wind Speed",
        //     "OFF-GRID/GOOD GRID",
        //     // "BATCH",
        //     "Tower Co TSSR Submission Date to GT",
        //     "TSSR STATUS",
        //     "TSSR APPROVED DATE",
        //     "TSSR SUBMIT DATE",
        //     "CW START DATE",
        //     "CW COMPLETED DATE",
        //     "RFI DATE SUBMITTED",
        //     // "RFI DATE APPROVED (TEMPO POWER)",
        //     "RFI DATE APPROVED (PERMANENT POWER)",
        //     "PRIO",
        //     "LOT SIZE (sq-m)",
        //     "ACCESS",
        //     "LINK TO DOCS FOR GLOBE-ACQUIRED SITES",
        //     "LANDLORD INFO",
        //     "LEASE AMOUNT",
        //     "LEASE ESCALATION",
        //     "LEASE TERM",
        //     // "BASE LEASE FEE",
        //     // "ESCALATION",
        //     // "COMMENCEMENT",
        //     "REMARKS"
        // );

        // if (\Auth::user()->profile_id == 21) {
        //     $user_detail = \Auth::user()->getUserDetail()->first();
        //     $vendor = Vendor::where('vendor_id', $user_detail->vendor_id)->first();

        //     $towerco->where('TOWERCO', $vendor->vendor_acronym);
        // }

        return $towerco = TowerCo::get();
    }

    // public function headings() :array
    // {
    //     return [
    //         "Serial Number", 
    //         "Search Ring",
    //         "REGION",
    //         "TOWERCO",
    //         // "DATE ENDORSED BY RAM",
    //         "MLA COMPLETION DATE",
    //         "DATE ACCEPTED BY TOWERCO",
    //         // "SITE ACQUIRED FORECAST",
    //         // "SITE DATE ACQUIRED",
    //         // "ESTIMATED RFI DATE",
    //         "PROJECT TAG",
    //         "MILESTONE STATUS",
    //         "PROVINCE",
    //         "TOWN",
    //         "[NP]Latitude",
    //         "[NP]Longitude",
    //         "SITE TYPE",
    //         "Tower Height",
    //         "FOC/ MW TAGGING",
    //         "Wind Speed",
    //         "OFF-GRID/GOOD GRID",
    //         // "BATCH",
    //         "Tower Co TSSR Submission Date to GT",
    //         "TSSR STATUS",
    //         "TSSR APPROVED DATE",
    //         "TSSR SUBMIT DATE",
    //         "CW START DATE",
    //         "CW COMPLETED DATE",
    //         "RFI DATE SUBMITTED",
    //         // "RFI DATE APPROVED (TEMPO POWER)",
    //         "RFI DATE APPROVED (PERMANENT POWER)",
    //         "PRIO",
    //         "LOT SIZE (sq-m)",
    //         "ACCESS",
    //         "LINK TO DOCS FOR GLOBE-ACQUIRED SITES",
    //         "LANDLORD INFO",
    //         "LEASE AMOUNT",
    //         "LEASE ESCALATION",
    //         "LEASE TERM",
    //         // "BASE LEASE FEE",
    //         // "ESCALATION",
    //         // "COMMENCEMENT",
    //         "REMARKS"
    //     ];
    // }

    public function headings() :array
    {

        $x = \DB::getSchemaBuilder()->getColumnListing('towerco');

        return $x;


    }
 
}
