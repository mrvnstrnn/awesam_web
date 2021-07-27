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
                            "PROJECT TAG",
                            "MILESTONE STATUS",
                            "ESTIMATED RFI DATE",
                            "TSSR SUBMIT DATE",
                            "TSSR APPROVED DATE",
                            "SITE DATE ACQUIRED",
                            "CW START DATE",
                            "CW COMPLETED DATE",
                            "RFI DATE SUBMITTED",
                            "RFI DATE APPROVED (TEMPO POWER)",
                            "RFI DATE APPROVED (PERMANENT POWER)",
                            "PROVINCE",
                            "TOWN",
                            "[NP]Latitude",
                            "[NP]Longitude",
                            "SITE TYPE",
                            "Tower Height",
                            "FOC/ MW TAGGING",
                            "Wind Speed",
                            "OFF-GRID/GOOD GRID",
                            "PRIO",
                            "BATCH",
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
                            "REMARKS",
                            "TSSR STATUS",
                            "Tower Co TSSR Submission Date to GT",
                            "SITE ACQUIRED FORECAST",
                            "VS TOWERCO"
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
            "PROJECT TAG",
            "MILESTONE STATUS",
            "ESTIMATED RFI DATE",
            "TSSR SUBMIT DATE",
            "TSSR APPROVED DATE",
            "SITE DATE ACQUIRED",
            "CW START DATE",
            "CW COMPLETED DATE",
            "RFI DATE SUBMITTED",
            "RFI DATE APPROVED (TEMPO POWER)",
            "RFI DATE APPROVED (PERMANENT POWER)",
            "PROVINCE",
            "TOWN",
            "[NP]Latitude",
            "[NP]Longitude",
            "SITE TYPE",
            "Tower Height",
            "FOC/ MW TAGGING",
            "Wind Speed",
            "OFF-GRID/GOOD GRID",
            "PRIO",
            "BATCH",
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
            "REMARKS",
            "TSSR STATUS",
            "Tower Co TSSR Submission Date to GT",
            "SITE ACQUIRED FORECAST",
            "VS TOWERCO"
        ];
    }
 
}
