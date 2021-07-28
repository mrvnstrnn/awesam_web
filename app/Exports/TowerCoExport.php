<?php

namespace App\Exports;

use App\Models\TowerCo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class TowerCoExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TowerCo::select(
            "Serial Number", 
            "Search Ring",
            "REGION",
            "TOWERCO",
            "DATE ENDORSED BY RAM",
            "MLA COMPLETION DATE",
            "DATE ACCEPTED BY TOWERCO",
            "SITE ACQUIRED FORECAST",
            "SITE DATE ACQUIRED",
            "ESTIMATED RFI DATE",
            "PROJECT TAG",
            "MILESTONE STATUS",
            "PROVINCE",
            "TOWN",
            "[NP]Latitude",
            "[NP]Longitude",
            "SITE TYPE",
            "Tower Height",
            "FOC/ MW TAGGING",
            "Wind Speed",
            "OFF-GRID/GOOD GRID",
            "BATCH",
            "Tower Co TSSR Submission Date to GT",
            "TSSR STATUS",
            "TSSR APPROVED DATE",
            "TSSR SUBMIT DATE",
            "CW START DATE",
            "CW COMPLETED DATE",
            "RFI DATE SUBMITTED",
            "RFI DATE APPROVED (TEMPO POWER)",
            "RFI DATE APPROVED (PERMANENT POWER)",
            "PRIO",
            "LOT SIZE (sq-m)",
            "ACCESS",
            "LINK TO DOCS FOR GLOBE-ACQUIRED SITES",
            "LANDLORD INFO",
            "LEASE AMOUNT",
            "LEASE ESCALATION",
            "LEASE TERM",
            "BASE LEASE FEE",
            "ESCALATION",
            "COMMENCEMENT",
            "REMARKS"
                        )
                        ->get();
    }

    public function headings() :array
    {
        return [
            "Serial Number", 
            "Search Ring",
            "REGION",
            "TOWERCO",
            "DATE ENDORSED BY RAM",
            "MLA COMPLETION DATE",
            "DATE ACCEPTED BY TOWERCO",
            "SITE ACQUIRED FORECAST",
            "SITE DATE ACQUIRED",
            "ESTIMATED RFI DATE",
            "PROJECT TAG",
            "MILESTONE STATUS",
            "PROVINCE",
            "TOWN",
            "[NP]Latitude",
            "[NP]Longitude",
            "SITE TYPE",
            "Tower Height",
            "FOC/ MW TAGGING",
            "Wind Speed",
            "OFF-GRID/GOOD GRID",
            "BATCH",
            "Tower Co TSSR Submission Date to GT",
            "TSSR STATUS",
            "TSSR APPROVED DATE",
            "TSSR SUBMIT DATE",
            "CW START DATE",
            "CW COMPLETED DATE",
            "RFI DATE SUBMITTED",
            "RFI DATE APPROVED (TEMPO POWER)",
            "RFI DATE APPROVED (PERMANENT POWER)",
            "PRIO",
            "LOT SIZE (sq-m)",
            "ACCESS",
            "LINK TO DOCS FOR GLOBE-ACQUIRED SITES",
            "LANDLORD INFO",
            "LEASE AMOUNT",
            "LEASE ESCALATION",
            "LEASE TERM",
            "BASE LEASE FEE",
            "ESCALATION",
            "COMMENCEMENT",
            "REMARKS"
        ];
    }
 
}