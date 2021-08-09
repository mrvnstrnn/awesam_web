<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\User;
use App\Models\ToweCoFile;
use App\Exports\TowerCoExport;

use Maatwebsite\Excel\Facades\Excel;


class TowerCoController extends Controller
{
    public function get_towerco()
    {
        $sites = \DB::connection('mysql2')
                    ->table("towerco")
                    ->where('TOWERCO', 'CREI')
                    ->get();

        $dt = DataTables::of($sites);
        return $dt->make(true);
    }

    public function get_towerco_all($actor)
    {

        switch($actor){
            case 'STS': 
                $sites = \DB::connection('mysql2')
                ->table("towerco")
                ->get();
                break;

            case 'RAM': 
                $sites = \DB::connection('mysql2')
                ->table("towerco")
                ->get();
                break;

            case 'TowerCo':
                $user_detail = \Auth::user()->getUserDetail()->first();
                $vendor = Vendor::where('vendor_id', $user_detail->vendor_id)->first();
                
                $sites = \DB::connection('mysql2')
                    ->table("towerco");
                
                    if(!is_null($vendor)){
                        $sites = $sites->where('TOWERCO', $vendor->vendor_acronym);
                    }

                    $sites->get();
                break;

            case 'AGILE': 
                $sites = \DB::connection('mysql2')
                ->table("towerco")
                ->get();
                break;
                
            default: 
                // $sites = \DB::connection('mysql2')
                // ->table("towerco")
                // ->get();        
        }

        $dt = DataTables::of($sites);
        return $dt->make(true);
    }


    public function get_towerco_serial($serial, $who)
    {
        $site = \DB::connection('mysql2')
                    ->table("towerco")
                    ->where('Serial Number', $serial)
                    ->get();

        if($who == 'towerco'){

            $allowed_fields = [
                ['field' => 'Serial Number', 'field_type' => 'text'],	
                ['field' => 'DATE ACCEPTED BY TOWERCO', 'field_type' => 'date'],	
                ['field' => 'MILESTONE STATUS', 'field_type' => 'select', 'selection' => ['', 'a.Accepted SR', 'b.Site Survey', 'c.TSSR Submitted', 'd.TSSR Approved', 'e.Signed Agreement with the Lessor', 'f.Site Acquired (with LGU permit)', 'g.Civil Works Started', 'h.Civil Works Completed', 'i.RFI (Tempo Power)', 'j.RFI (Permanent Power)']],	
                ['field' => 'ESTIMATED RFI DATE', 'field_type' => 'date'],	
                ['field' => 'TSSR SUBMIT DATE', 'field_type' => 'date'],	
                ['field' => 'SITE ACQUIRED FORECAST', 'field_type' => 'date'],
                ['field' => 'SITE DATE ACQUIRED', 'field_type' => 'date'],	
                ['field' => 'CW START DATE', 'field_type' => 'date'],	
                ['field' => 'CW COMPLETED DATE', 'field_type' => 'date'],	
                ['field' => 'RFI DATE SUBMITTED', 'field_type' => 'date'],	
            ];  

            $details_allowed = [
                ['field' => 'Serial Number', 'field_type' => 'text'],
                ['field' => 'Search Ring', 'field_type' => 'text'],
                ['field' => 'REGION', 'field_type' => 'text'],
                ['field' => 'TOWERCO', 'field_type' => 'text'],
                ['field' => 'DATE ENDORSED BY RAM', 'field_type' => 'text'],
                ['field' => 'MLA COMPLETION DATE', 'field_type' => 'date'],
                ['field' => 'MILESTONE STATUS', 'field_type' => 'select', 'selection' => ['', 'a.Accepted SR', 'b.Site Survey', 'c.TSSR Submitted', 'd.TSSR Approved', 'e.Signed Agreement with the Lessor', 'f.Site Acquired (with LGU permit)', 'g.Civil Works Started', 'h.Civil Works Completed', 'i.RFI (Tempo Power)', 'j.RFI (Permanent Power)']],	
                ['field' => 'TSSR SUBMIT DATE', 'field_type' => 'date'],
                ['field' => 'TSSR APPROVED DATE', 'field_type' => 'date'],
                ['field' => 'CW START DATE', 'field_type' => 'date'],
                ['field' => 'CW COMPLETED DATE', 'field_type' => 'date'],
                ['field' => 'RFI DATE SUBMITTED', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (TEMPO POWER)', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (PERMANENT POWER)', 'field_type' => 'date'],
                ['field' => 'PROVINCE', 'field_type' => 'text'],
                ['field' => 'TOWN', 'field_type' => 'text'],
                ['field' => '[NP]Latitude', 'field_type' => 'text'],
                ['field' => '[NP]Longitude', 'field_type' => 'text'],
                ['field' => 'SITE TYPE', 'field_type' => 'text'],
                ['field' => 'Tower Height', 'field_type' => 'text'],
                ['field' => 'FOC/ MW TAGGING', 'field_type' => 'text'],
                ['field' => 'Wind Speed', 'field_type' => 'text'],
                ['field' => 'OFF-GRID/GOOD GRID', 'field_type' => 'text'],
                ['field' => 'PRIO', 'field_type' => 'text'],
                ['field' => 'BATCH', 'field_type' => 'text'],
                ['field' => 'LOT SIZE (sq-m)', 'field_type' => 'text'],
                ['field' => 'ACCESS', 'field_type' => 'text'],
                ['field' => 'LINK TO DOCS FOR GLOBE-ACQUIRED SITES', 'field_type' => 'text'],
                ['field' => 'LANDLORD INFO', 'field_type' => 'text'],
                ['field' => 'LEASE AMOUNT', 'field_type' => 'text'],
                ['field' => 'LEASE ESCALATION', 'field_type' => 'text'],
                ['field' => 'LEASE TERM', 'field_type' => 'text'],
                ['field' => 'BASE LEASE FEE', 'field_type' => 'text'],
                ['field' => 'ESCALATION', 'field_type' => 'text'],
                ['field' => 'COMMENCEMENT', 'field_type' => 'text'],
                ['field' => 'REMARKS', 'field_type' => 'text'],
                ['field' => 'TSSR STATUS', 'field_type' => 'text'],
                ['field' => 'Tower Co TSSR Submission Date to GT', 'field_type' => 'text'],
                ['field' => 'VS TOWERCO', 'field_type' => 'text'],
                ['field' => 'update user', 'field_type' => 'text'],
                ['field' => 'update group', 'field_type' => 'text'],
            ];

        }
        elseif($who == 'ram'){
            $allowed_fields = [
                ['field' => 'DATE ENDORSED BY RAM', 'field_type' => 'date'],
                ['field' => 'LOT SIZE (sq-m)', 'field_type' => 'number'],
                ['field' => 'ACCESS', 'field_type' => 'text'],	
                ['field' => 'LINK TO DOCS FOR GLOBE-ACQUIRED SITES', 'field_type' => 'text'],
                ['field' => 'LANDLORD INFO', 'field_type' => 'text'],	
                ['field' => 'LEASE AMOUNT', 'field_type' => 'number'],	
                ['field' => 'LEASE ESCALATION', 'field_type' => 'number']

            ];
                
            $details_allowed = [
                ['field' => 'Serial Number', 'field_type' => 'text'],
                ['field' => 'Search Ring', 'field_type' => 'text'],
                ['field' => 'DATE ENDORSED BY RAM', 'field_type' => 'text'],
                ['field' => 'MLA COMPLETION DATE', 'field_type' => 'date'],
                ['field' => 'DATE ACCEPTED BY TOWERCO', 'field_type' => 'date'],
                ['field' => 'PROJECT TAG', 'field_type' => 'text'],
                ['field' => 'MILESTONE STATUS', 'field_type' => 'select', 'selection' => ['', 'a.Accepted SR', 'b.Site Survey', 'c.TSSR Submitted', 'd.TSSR Approved', 'e.Signed Agreement with the Lessor', 'f.Site Acquired (with LGU permit)', 'g.Civil Works Started', 'h.Civil Works Completed', 'i.RFI (Tempo Power)', 'j.RFI (Permanent Power)']],	
                ['field' => 'ESTIMATED RFI DATE', 'field_type' => 'date'],
                ['field' => 'TSSR SUBMIT DATE', 'field_type' => 'date'],
                ['field' => 'TSSR APPROVED DATE', 'field_type' => 'date'],
                ['field' => 'SITE DATE ACQUIRED', 'field_type' => 'date'],
                ['field' => 'CW START DATE', 'field_type' => 'date'],
                ['field' => 'CW COMPLETED DATE', 'field_type' => 'date'],
                ['field' => 'RFI DATE SUBMITTED', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (TEMPO POWER)', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (PERMANENT POWER)', 'field_type' => 'date'],
                ['field' => 'PROVINCE', 'field_type' => 'text'],
                ['field' => 'TOWN', 'field_type' => 'text'],
                ['field' => '[NP]Latitude', 'field_type' => 'text'],
                ['field' => '[NP]Longitude', 'field_type' => 'text'],
                ['field' => 'SITE TYPE', 'field_type' => 'text'],
                ['field' => 'Tower Height', 'field_type' => 'text'],
                ['field' => 'FOC/ MW TAGGING', 'field_type' => 'text'],
                ['field' => 'Wind Speed', 'field_type' => 'text'],
                ['field' => 'OFF-GRID/GOOD GRID', 'field_type' => 'text'],
                ['field' => 'PRIO', 'field_type' => 'text'],
                ['field' => 'BATCH', 'field_type' => 'text'],
                ['field' => 'LOT SIZE (sq-m)', 'field_type' => 'text'],
                ['field' => 'ACCESS', 'field_type' => 'text'],
                ['field' => 'LINK TO DOCS FOR GLOBE-ACQUIRED SITES', 'field_type' => 'text'],
                ['field' => 'LANDLORD INFO', 'field_type' => 'text'],
                ['field' => 'LEASE AMOUNT', 'field_type' => 'text'],
                ['field' => 'LEASE ESCALATION', 'field_type' => 'text'],
                ['field' => 'LEASE TERM', 'field_type' => 'text'],
                ['field' => 'BASE LEASE FEE', 'field_type' => 'text'],
                ['field' => 'ESCALATION', 'field_type' => 'text'],
                ['field' => 'COMMENCEMENT', 'field_type' => 'text'],
                ['field' => 'REMARKS', 'field_type' => 'text'],
                ['field' => 'TSSR STATUS', 'field_type' => 'text'],
                ['field' => 'Tower Co TSSR Submission Date to GT', 'field_type' => 'text'],
                ['field' => 'SITE ACQUIRED FORECAST', 'field_type' => 'text'],
                ['field' => 'VS TOWERCO', 'field_type' => 'text'],
                ['field' => 'update user', 'field_type' => 'text'],
                ['field' => 'update group', 'field_type' => 'text'],
            ];  
        }
        elseif($who == 'sts'){

            $allowed_fields = [
                ['field' => 'Serial Number','field_type' => 'text'],
                ['field' => 'Search Ring','field_type' => 'text'],
                ['field' => 'REGION','field_type' => 'text'],
                ['field' => 'TOWERCO','field_type' => 'text'],
                ['field' => 'PROVINCE','field_type' => 'text'],
                ['field' => 'TOWN','field_type' => 'text'],
                ['field' => 'MLA COMPLETION DATE', 'field_type' => 'date'],	
                ['field' => 'PROJECT TAG', 'field_type' => 'select', 'selection' => ['BUILD TO SUIT', 'BUILD GLOBE-ACQUIRED SITES']],	
                ['field' => '[NP] Latitude','field_type' => 'number'],
                ['field' => '[NP]Longitude','field_type' => 'number'],
                ['field' => 'SITE TYPE','field_type' => 'select', 'selection' => ['GREENFIELD', 'ROOFTOP']],
                ['field' => 'Tower Height','field_type' => 'number'],
                ['field' => 'FOC/ MW TAGGING','field_type' => 'select', 'selection' => ['FOC', 'MW']],
                ['field' => 'Wind Speed','field_type' => 'text'],
                ['field' => 'OFF-GRID/GOOD GRID','field_type' => 'select', 'selection' => ['G1', 'G2', 'G3', 'G4']],
                ['field' => 'PRIO', 'field_type' => 'select', 'selection' => ['P1', 'P2', 'P3', 'P4']],
                ['field' => 'BATCH', 'field_type' => 'text']       
            ];

            $details_allowed = [
                ['field' => 'Serial Number', 'field_type' => 'text'],
                ['field' => 'Search Ring', 'field_type' => 'text'],
                ['field' => 'DATE ENDORSED BY RAM', 'field_type' => 'text'],
                ['field' => 'MLA COMPLETION DATE', 'field_type' => 'date'],
                ['field' => 'DATE ACCEPTED BY TOWERCO', 'field_type' => 'date'],
                ['field' => 'PROJECT TAG', 'field_type' => 'text'],
                ['field' => 'MILESTONE STATUS', 'field_type' => 'select', 'selection' => ['', 'a.Accepted SR', 'b.Site Survey', 'c.TSSR Submitted', 'd.TSSR Approved', 'e.Signed Agreement with the Lessor', 'f.Site Acquired (with LGU permit)', 'g.Civil Works Started', 'h.Civil Works Completed', 'i.RFI (Tempo Power)', 'j.RFI (Permanent Power)']],	
                ['field' => 'ESTIMATED RFI DATE', 'field_type' => 'date'],
                ['field' => 'TSSR SUBMIT DATE', 'field_type' => 'date'],
                ['field' => 'TSSR APPROVED DATE', 'field_type' => 'date'],
                ['field' => 'SITE DATE ACQUIRED', 'field_type' => 'date'],
                ['field' => 'CW START DATE', 'field_type' => 'date'],
                ['field' => 'CW COMPLETED DATE', 'field_type' => 'date'],
                ['field' => 'RFI DATE SUBMITTED', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (TEMPO POWER)', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (PERMANENT POWER)', 'field_type' => 'date'],
                ['field' => 'PROVINCE', 'field_type' => 'text'],
                ['field' => 'TOWN', 'field_type' => 'text'],
                ['field' => '[NP]Latitude', 'field_type' => 'text'],
                ['field' => '[NP]Longitude', 'field_type' => 'text'],
                ['field' => 'SITE TYPE', 'field_type' => 'text'],
                ['field' => 'Tower Height', 'field_type' => 'text'],
                ['field' => 'FOC/ MW TAGGING', 'field_type' => 'text'],
                ['field' => 'Wind Speed', 'field_type' => 'text'],
                ['field' => 'OFF-GRID/GOOD GRID', 'field_type' => 'text'],
                ['field' => 'PRIO', 'field_type' => 'text'],
                ['field' => 'BATCH', 'field_type' => 'text'],
                ['field' => 'LOT SIZE (sq-m)', 'field_type' => 'text'],
                ['field' => 'ACCESS', 'field_type' => 'text'],
                ['field' => 'LINK TO DOCS FOR GLOBE-ACQUIRED SITES', 'field_type' => 'text'],
                ['field' => 'LANDLORD INFO', 'field_type' => 'text'],
                ['field' => 'LEASE AMOUNT', 'field_type' => 'text'],
                ['field' => 'LEASE ESCALATION', 'field_type' => 'text'],
                ['field' => 'LEASE TERM', 'field_type' => 'text'],
                ['field' => 'BASE LEASE FEE', 'field_type' => 'text'],
                ['field' => 'ESCALATION', 'field_type' => 'text'],
                ['field' => 'COMMENCEMENT', 'field_type' => 'text'],
                ['field' => 'REMARKS', 'field_type' => 'text'],
                ['field' => 'TSSR STATUS', 'field_type' => 'text'],
                ['field' => 'Tower Co TSSR Submission Date to GT', 'field_type' => 'text'],
                ['field' => 'SITE ACQUIRED FORECAST', 'field_type' => 'text'],
                ['field' => 'VS TOWERCO', 'field_type' => 'text'],
                ['field' => 'update user', 'field_type' => 'text'],
                ['field' => 'update group', 'field_type' => 'text'],

            ];  
        }
        elseif($who == 'agile'){

            $allowed_fields = [
                ['field' => 'Serial Number', 'field_type' => 'text'],
                ['field' => 'Search Ring', 'field_type' => 'text'],
                ['field' => 'TSSR STATUS', 'field_type' => 'select', 'selection' => ['SUBMITTED', 'NOT YET SUBMITTED']],
                ['field' => 'Tower Co TSSR Submission Date to GT', 'field_type' => 'date'],	
                ['field' => 'TSSR APPROVED DATE', 'field_type' => 'date'],	
                ['field' => 'RFI DATE APPROVED (TEMPO POWER)', 'field_type' => 'date'],	
                ['field' => 'RFI DATE APPROVED (PERMANENT POWER)', 'field_type' => 'date'],	
            ];

            $details_allowed = [
                // ['field' => 'Serial Number', 'field_type' => 'text'],
                // ['field' => 'Search Ring', 'field_type' => 'text'],
                // ['field' => 'REGION', 'field_type' => 'text'],
                // ['field' => 'TOWERCO', 'field_type' => 'text'],
                // ['field' => 'DATE ENDORSED BY RAM', 'field_type' => 'date'],
                // ['field' => 'MLA COMPLETION DATE', 'field_type' => 'date'],
                // ['field' => 'DATE ACCEPTED BY TOWERCO', 'field_type' => 'date'],
                // ['field' => 'TSSR SUBMIT DATE', 'field_type' => 'date'],
                // ['field' => 'TSSR APPROVED DATE', 'field_type' => 'date'],
                // ['field' => 'CW START DATE', 'field_type' => 'date'],
                // ['field' => 'CW COMPLETED DATE', 'field_type' => 'date'],
                // ['field' => 'RFI DATE SUBMITTED', 'field_type' => 'date'],
                // ['field' => 'RFI DATE APPROVED (TEMPO POWER)', 'field_type' => 'date'],
                // ['field' => 'RFI DATE APPROVED (PERMANENT POWER)', 'field_type' => 'date'],
                // ['field' => '[NP]Longitude', 'field_type' => 'text'],
                // ['field' => 'SITE TYPE', 'field_type' => 'text'],
                // ['field' => 'Tower Height', 'field_type' => 'text'],
                // ['field' => 'FOC/ MW TAGGING', 'field_type' => 'text'],
                // ['field' => 'Wind Speed', 'field_type' => 'text'],
                // ['field' => 'OFF-GRID/GOOD GRID', 'field_type' => 'text'],
                // ['field' => 'PRIO', 'field_type' => 'text'],
                // ['field' => 'BATCH', 'field_type' => 'text'],
                // ['field' => 'LOT SIZE (sq-m)', 'field_type' => 'text'],
                // ['field' => 'ACCESS', 'field_type' => 'text'],
                // ['field' => 'LINK TO DOCS FOR GLOBE-ACQUIRED SITES', 'field_type' => 'text'],
                // ['field' => 'LANDLORD INFO', 'field_type' => 'text'],
                // ['field' => 'LEASE AMOUNT', 'field_type' => 'text'],
                // ['field' => 'LEASE ESCALATION', 'field_type' => 'text'],
                // ['field' => 'LEASE TERM', 'field_type' => 'text'],
                // ['field' => 'BASE LEASE FEE', 'field_type' => 'text'],
                // ['field' => 'ESCALATION', 'field_type' => 'text'],
                // ['field' => 'COMMENCEMENT', 'field_type' => 'text'],
                // ['field' => 'REMARKS', 'field_type' => 'text'],
                // ['field' => 'TSSR STATUS', 'field_type' => 'text'],
                // ['field' => 'Tower Co TSSR Submission Date to GT', 'field_type' => 'text'],
                // ['field' => 'SITE ACQUIRED FORECAST', 'field_type' => 'text'],
                // ['field' => 'VS TOWERCO', 'field_type' => 'text'],
                // ['field' => 'update user', 'field_type' => 'text'],
                // ['field' => 'update group', 'field_type' => 'text'],
            ];
        }

        $details = '';
        $actor = '<form id="form-towerco-actor">
            <input type="hidden" name="update user" value="' .   \Auth::user()->id . '">
            <input type="hidden" name="update group" value="' . $who . '">
        ';

        foreach ($site[0] as $col => $value){

            if($col == 'Serial Number'){
                $actor .= '<input type="hidden" id="multi_serial" name="Serial Number" value="' . $value . '">';
            }

            foreach ($allowed_fields as $allowed_field){
                
                if($col == $allowed_field['field']){

                    $actor .= '
                        <div class="row border-bottom mb-1 pb-1">
                            <div class="col-md-4">
                                ' . $col . '
                            </div>
                            <div class="col-md-8">';

                    if($allowed_field['field_type']=='date'){
                        $actor .= '
                        <input type="text" name="'. $col . '" value="' . $value . '"  data-old="'. $value .'" class="form-control flatpicker">
                        ';
                    }
                    elseif($allowed_field['field_type']=='text'){
                        $actor .= '
                        <input type="text" name="'. $col . '" value="' . $value . '" data-old="'. $value .'" class="form-control">
                        ';
                    }
                    elseif($allowed_field['field_type']=='number'){
                        $actor .= '
                        <input type="number" name="'. $col . '" value="' . $value . '" data-old="'. $value .'" class="form-control">
                        ';
                    }
                    elseif($allowed_field['field_type']=='select'){
                        $actor .= '
                            <select class="form-control" name="' . $col . '" data-old="'. $value .'" >
                                <option value=""></option>
                        ';

                        foreach($allowed_field['selection'] as $option){

                            if($option == $value){
                                $actor .= '
                                    <option value="' . $option . '" selected>' . $option . '</option>
                                ';
                            }
                            else {
                                $actor .= '
                                    <option value="' . $option . '">' . $option . '</option>
                                ';
                            }
                        }

                        $actor .= '
                            </select>
                        ';                        
                    }
                    $actor .= '        
                            </div>
                        </div>
                    ';

                    // break;
                }
            }

            foreach ($details_allowed as $detail_allowed){
                if($col == $detail_allowed['field']){
                    $details .= '
                        <div class="row border-bottom mb-1 pb-1">
                            <div class="col-md-4">
                                ' . $col . '
                            </div>
                            <div class="col-md-8">
                                <input type="text" value="' . $value . '" class="form-control" readonly>
                            </div>
                        </div>';
                }
            }
            
        }

        $actor .="</form>";


        return response()->json([ 'error' => false, 'details' => $details, 'actor' => $actor ]);


    }

    public function get_towerco_multi($who)
    {
        if($who == 'towerco'){

            $allowed_fields = [
                // ['field' => 'DATE ACCEPTED BY TOWERCO', 'field_type' => 'date'],	
                // ['field' => 'MILESTONE STATUS', 'field_type' => 'select', 'selection' => ['', 'a.Accepted SR', 'b.Site Survey', 'c.TSSR Submitted', 'd.TSSR Approved', 'e.Signed Agreement with the Lessor', 'f.Site Acquired (with LGU permit)', 'g.Civil Works Started', 'h.Civil Works Completed', 'i.RFI (Tempo Power)', 'j.RFI (Permanent Power)']],	
                // ['field' => 'ESTIMATED RFI DATE', 'field_type' => 'date'],	
                // ['field' => 'TSSR SUBMIT DATE', 'field_type' => 'date'],	
                // ['field' => 'SITE ACQUIRED FORECAST', 'field_type' => 'date'],
                // ['field' => 'SITE DATE ACQUIRED', 'field_type' => 'date'],	
                // ['field' => 'CW START DATE', 'field_type' => 'date'],	
                // ['field' => 'CW COMPLETED DATE', 'field_type' => 'date'],	
                // ['field' => 'RFI DATE SUBMITTED', 'field_type' => 'date'],	

                ['field' => 'Serial Number', 'field_type' => 'text'],
                ['field' => 'Search Ring', 'field_type' => 'text'],
                ['field' => 'REGION', 'field_type' => 'text'],
                ['field' => 'TOWERCO', 'field_type' => 'text'],
                ['field' => 'DATE ENDORSED BY RAM', 'field_type' => 'text'],
                ['field' => 'MLA COMPLETION DATE', 'field_type' => 'date'],
                // ['field' => 'DATE ACCEPTED BY TOWERCO', 'field_type' => 'text'],
                // ['field' => 'PROJECT TAG', 'field_type' => 'text'],
                ['field' => 'MILESTONE STATUS', 'field_type' => 'select', 'selection' => ['', 'a.Accepted SR', 'b.Site Survey', 'c.TSSR Submitted', 'd.TSSR Approved', 'e.Signed Agreement with the Lessor', 'f.Site Acquired (with LGU permit)', 'g.Civil Works Started', 'h.Civil Works Completed', 'i.RFI (Tempo Power)', 'j.RFI (Permanent Power)']],	
                // ['field' => 'ESTIMATED RFI DATE', 'field_type' => 'text'],
                ['field' => 'TSSR SUBMIT DATE', 'field_type' => 'date'],
                ['field' => 'TSSR APPROVED DATE', 'field_type' => 'date'],
                // ['field' => 'SITE DATE ACQUIRED', 'field_type' => 'text'],
                ['field' => 'CW START DATE', 'field_type' => 'date'],
                ['field' => 'CW COMPLETED DATE', 'field_type' => 'date'],
                ['field' => 'RFI DATE SUBMITTED', 'field_type' => 'text'],
                ['field' => 'RFI DATE APPROVED (TEMPO POWER)', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (PERMANENT POWER)', 'field_type' => 'date'],
                ['field' => 'PROVINCE', 'field_type' => 'text'],
                ['field' => 'TOWN', 'field_type' => 'text'],
                ['field' => '[NP]Latitude', 'field_type' => 'text'],
                ['field' => '[NP]Longitude', 'field_type' => 'text'],
                ['field' => 'SITE TYPE', 'field_type' => 'text'],
                ['field' => 'Tower Height', 'field_type' => 'text'],
                ['field' => 'FOC/ MW TAGGING', 'field_type' => 'text'],
                ['field' => 'Wind Speed', 'field_type' => 'text'],
                ['field' => 'OFF-GRID/GOOD GRID', 'field_type' => 'text'],
                ['field' => 'PRIO', 'field_type' => 'text'],
                ['field' => 'BATCH', 'field_type' => 'text'],
                ['field' => 'LOT SIZE (sq-m)', 'field_type' => 'text'],
                ['field' => 'ACCESS', 'field_type' => 'text'],
                ['field' => 'LINK TO DOCS FOR GLOBE-ACQUIRED SITES', 'field_type' => 'text'],
                ['field' => 'LANDLORD INFO', 'field_type' => 'text'],
                ['field' => 'LEASE AMOUNT', 'field_type' => 'text'],
                ['field' => 'LEASE ESCALATION', 'field_type' => 'text'],
                ['field' => 'LEASE TERM', 'field_type' => 'text'],
                ['field' => 'BASE LEASE FEE', 'field_type' => 'text'],
                ['field' => 'ESCALATION', 'field_type' => 'text'],
                ['field' => 'COMMENCEMENT', 'field_type' => 'text'],
                ['field' => 'REMARKS', 'field_type' => 'text'],
                ['field' => 'TSSR STATUS', 'field_type' => 'text'],
                ['field' => 'Tower Co TSSR Submission Date to GT', 'field_type' => 'text'],
                // ['field' => 'SITE ACQUIRED FORECAST', 'field_type' => 'text'],
                ['field' => 'VS TOWERCO', 'field_type' => 'text'],
                ['field' => 'update user', 'field_type' => 'text'],
                ['field' => 'update group', 'field_type' => 'text'],
            ];  

        }
        elseif($who == 'ram'){
            $allowed_fields = [
                // ['field' => 'DATE ENDORSED BY RAM', 'field_type' => 'date'],
                // ['field' => 'LOT SIZE (sq-m)', 'field_type' => 'number'],
                // ['field' => 'ACCESS', 'field_type' => 'text'],	
                // ['field' => 'LINK TO DOCS FOR GLOBE-ACQUIRED SITES', 'field_type' => 'text'],
                // ['field' => 'LANDLORD INFO', 'field_type' => 'text'],	
                // ['field' => 'LEASE AMOUNT', 'field_type' => 'number'],	
                // ['field' => 'LEASE ESCALATION', 'field_type' => 'number']

                ['field' => 'Serial Number', 'field_type' => 'text'],
                ['field' => 'Search Ring', 'field_type' => 'text'],
                // ['field' => 'REGION', 'field_type' => 'text'],
                // ['field' => 'TOWERCO', 'field_type' => 'text'],
                ['field' => 'DATE ENDORSED BY RAM', 'field_type' => 'text'],
                ['field' => 'MLA COMPLETION DATE', 'field_type' => 'date'],
                ['field' => 'DATE ACCEPTED BY TOWERCO', 'field_type' => 'date'],
                ['field' => 'PROJECT TAG', 'field_type' => 'text'],
                ['field' => 'MILESTONE STATUS', 'field_type' => 'select', 'selection' => ['', 'a.Accepted SR', 'b.Site Survey', 'c.TSSR Submitted', 'd.TSSR Approved', 'e.Signed Agreement with the Lessor', 'f.Site Acquired (with LGU permit)', 'g.Civil Works Started', 'h.Civil Works Completed', 'i.RFI (Tempo Power)', 'j.RFI (Permanent Power)']],	
                ['field' => 'ESTIMATED RFI DATE', 'field_type' => 'date'],
                ['field' => 'TSSR SUBMIT DATE', 'field_type' => 'date'],
                ['field' => 'TSSR APPROVED DATE', 'field_type' => 'date'],
                ['field' => 'SITE DATE ACQUIRED', 'field_type' => 'date'],
                ['field' => 'CW START DATE', 'field_type' => 'date'],
                ['field' => 'CW COMPLETED DATE', 'field_type' => 'date'],
                ['field' => 'RFI DATE SUBMITTED', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (TEMPO POWER)', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (PERMANENT POWER)', 'field_type' => 'date'],
                ['field' => 'PROVINCE', 'field_type' => 'text'],
                ['field' => 'TOWN', 'field_type' => 'text'],
                ['field' => '[NP]Latitude', 'field_type' => 'text'],
                ['field' => '[NP]Longitude', 'field_type' => 'text'],
                ['field' => 'SITE TYPE', 'field_type' => 'text'],
                ['field' => 'Tower Height', 'field_type' => 'text'],
                ['field' => 'FOC/ MW TAGGING', 'field_type' => 'text'],
                ['field' => 'Wind Speed', 'field_type' => 'text'],
                ['field' => 'OFF-GRID/GOOD GRID', 'field_type' => 'text'],
                ['field' => 'PRIO', 'field_type' => 'text'],
                ['field' => 'BATCH', 'field_type' => 'text'],
                ['field' => 'LOT SIZE (sq-m)', 'field_type' => 'text'],
                ['field' => 'ACCESS', 'field_type' => 'text'],
                ['field' => 'LINK TO DOCS FOR GLOBE-ACQUIRED SITES', 'field_type' => 'text'],
                ['field' => 'LANDLORD INFO', 'field_type' => 'text'],
                ['field' => 'LEASE AMOUNT', 'field_type' => 'text'],
                ['field' => 'LEASE ESCALATION', 'field_type' => 'text'],
                ['field' => 'LEASE TERM', 'field_type' => 'text'],
                ['field' => 'BASE LEASE FEE', 'field_type' => 'text'],
                ['field' => 'ESCALATION', 'field_type' => 'text'],
                ['field' => 'COMMENCEMENT', 'field_type' => 'text'],
                ['field' => 'REMARKS', 'field_type' => 'text'],
                ['field' => 'TSSR STATUS', 'field_type' => 'text'],
                ['field' => 'Tower Co TSSR Submission Date to GT', 'field_type' => 'text'],
                ['field' => 'SITE ACQUIRED FORECAST', 'field_type' => 'text'],
                ['field' => 'VS TOWERCO', 'field_type' => 'text'],
                ['field' => 'update user', 'field_type' => 'text'],
                ['field' => 'update group', 'field_type' => 'text'],
            ];  
        }
        elseif($who == 'sts'){

            $allowed_fields = [
                // ['field' => 'Serial Number','field_type' => 'text'],
                // ['field' => 'Search Ring','field_type' => 'text'],
                // ['field' => 'REGION','field_type' => 'text'],
                // ['field' => 'TOWERCO','field_type' => 'text'],
                // ['field' => 'PROVINCE','field_type' => 'text'],
                // ['field' => 'TOWN','field_type' => 'text'],
                // ['field' => 'MLA COMPLETION DATE', 'field_type' => 'date'],	
                // ['field' => 'PROJECT TAG', 'field_type' => 'select', 'selection' => ['BUILD TO SUIT', 'BUILD GLOBE-ACQUIRED SITES']],	
                // ['field' => '[NP] Latitude','field_type' => 'number'],
                // ['field' => '[NP]Longitude','field_type' => 'number'],
                // ['field' => 'SITE TYPE','field_type' => 'select', 'selection' => ['GREENFIELD', 'ROOFTOP']],
                // ['field' => 'Tower Height','field_type' => 'number'],
                // ['field' => 'FOC/ MW TAGGING','field_type' => 'select', 'selection' => ['FOC', 'MW']],
                // ['field' => 'Wind Speed','field_type' => 'text'],
                // ['field' => 'OFF-GRID/GOOD GRID','field_type' => 'select', 'selection' => ['G1', 'G2', 'G3', 'G4']],
                // ['field' => 'PRIO', 'field_type' => 'select', 'selection' => ['P1', 'P2', 'P3', 'P4']],
                // ['field' => 'BATCH', 'field_type' => 'text']            
                
                ['field' => 'Serial Number', 'field_type' => 'text'],
                ['field' => 'Search Ring', 'field_type' => 'text'],
                // ['field' => 'REGION', 'field_type' => 'text'],
                // ['field' => 'TOWERCO', 'field_type' => 'text'],
                ['field' => 'DATE ENDORSED BY RAM', 'field_type' => 'text'],
                ['field' => 'MLA COMPLETION DATE', 'field_type' => 'date'],
                ['field' => 'DATE ACCEPTED BY TOWERCO', 'field_type' => 'date'],
                ['field' => 'PROJECT TAG', 'field_type' => 'text'],
                ['field' => 'MILESTONE STATUS', 'field_type' => 'select', 'selection' => ['', 'a.Accepted SR', 'b.Site Survey', 'c.TSSR Submitted', 'd.TSSR Approved', 'e.Signed Agreement with the Lessor', 'f.Site Acquired (with LGU permit)', 'g.Civil Works Started', 'h.Civil Works Completed', 'i.RFI (Tempo Power)', 'j.RFI (Permanent Power)']],	
                ['field' => 'ESTIMATED RFI DATE', 'field_type' => 'date'],
                ['field' => 'TSSR SUBMIT DATE', 'field_type' => 'date'],
                ['field' => 'TSSR APPROVED DATE', 'field_type' => 'date'],
                ['field' => 'SITE DATE ACQUIRED', 'field_type' => 'date'],
                ['field' => 'CW START DATE', 'field_type' => 'date'],
                ['field' => 'CW COMPLETED DATE', 'field_type' => 'date'],
                ['field' => 'RFI DATE SUBMITTED', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (TEMPO POWER)', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (PERMANENT POWER)', 'field_type' => 'date'],
                ['field' => 'PROVINCE', 'field_type' => 'text'],
                ['field' => 'TOWN', 'field_type' => 'text'],
                ['field' => '[NP]Latitude', 'field_type' => 'text'],
                ['field' => '[NP]Longitude', 'field_type' => 'text'],
                ['field' => 'SITE TYPE', 'field_type' => 'text'],
                ['field' => 'Tower Height', 'field_type' => 'text'],
                ['field' => 'FOC/ MW TAGGING', 'field_type' => 'text'],
                ['field' => 'Wind Speed', 'field_type' => 'text'],
                ['field' => 'OFF-GRID/GOOD GRID', 'field_type' => 'text'],
                ['field' => 'PRIO', 'field_type' => 'text'],
                ['field' => 'BATCH', 'field_type' => 'text'],
                ['field' => 'LOT SIZE (sq-m)', 'field_type' => 'text'],
                ['field' => 'ACCESS', 'field_type' => 'text'],
                ['field' => 'LINK TO DOCS FOR GLOBE-ACQUIRED SITES', 'field_type' => 'text'],
                ['field' => 'LANDLORD INFO', 'field_type' => 'text'],
                ['field' => 'LEASE AMOUNT', 'field_type' => 'text'],
                ['field' => 'LEASE ESCALATION', 'field_type' => 'text'],
                ['field' => 'LEASE TERM', 'field_type' => 'text'],
                ['field' => 'BASE LEASE FEE', 'field_type' => 'text'],
                ['field' => 'ESCALATION', 'field_type' => 'text'],
                ['field' => 'COMMENCEMENT', 'field_type' => 'text'],
                ['field' => 'REMARKS', 'field_type' => 'text'],
                ['field' => 'TSSR STATUS', 'field_type' => 'text'],
                ['field' => 'Tower Co TSSR Submission Date to GT', 'field_type' => 'text'],
                ['field' => 'SITE ACQUIRED FORECAST', 'field_type' => 'text'],
                ['field' => 'VS TOWERCO', 'field_type' => 'text'],
                ['field' => 'update user', 'field_type' => 'text'],
                ['field' => 'update group', 'field_type' => 'text'],
            ];  
        }
        elseif($who == 'agile'){

            $allowed_fields = [
                // ['field' => 'TSSR STATUS', 'field_type' => 'select', 'selection' => ['SUBMITTED', 'NOT YET SUBMITTED']],
                // ['field' => 'Tower Co TSSR Submission Date to GT', 'field_type' => 'date'],	
                // ['field' => 'TSSR APPROVED DATE', 'field_type' => 'date'],	
                // ['field' => 'RFI DATE APPROVED (TEMPO POWER)', 'field_type' => 'date'],	
                // ['field' => 'RFI DATE APPROVED (PERMANENT POWER)', 'field_type' => 'date'],	

                
                ['field' => 'Serial Number', 'field_type' => 'text'],
                ['field' => 'Search Ring', 'field_type' => 'text'],
                ['field' => 'REGION', 'field_type' => 'text'],
                ['field' => 'TOWERCO', 'field_type' => 'text'],
                ['field' => 'DATE ENDORSED BY RAM', 'field_type' => 'date'],
                ['field' => 'MLA COMPLETION DATE', 'field_type' => 'date'],
                ['field' => 'DATE ACCEPTED BY TOWERCO', 'field_type' => 'date'],
                // ['field' => 'PROJECT TAG', 'field_type' => 'text'],
                // ['field' => 'MILESTONE STATUS', 'field_type' => 'text'],
                // ['field' => 'ESTIMATED RFI DATE', 'field_type' => 'text'],
                ['field' => 'TSSR SUBMIT DATE', 'field_type' => 'date'],
                ['field' => 'TSSR APPROVED DATE', 'field_type' => 'date'],
                // ['field' => 'SITE DATE ACQUIRED', 'field_type' => 'text'],
                ['field' => 'CW START DATE', 'field_type' => 'date'],
                ['field' => 'CW COMPLETED DATE', 'field_type' => 'date'],
                ['field' => 'RFI DATE SUBMITTED', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (TEMPO POWER)', 'field_type' => 'date'],
                ['field' => 'RFI DATE APPROVED (PERMANENT POWER)', 'field_type' => 'date'],
                // ['field' => 'PROVINCE', 'field_type' => 'text'],
                // ['field' => 'TOWN', 'field_type' => 'text'],
                // ['field' => '[NP]Latitude', 'field_type' => 'text'],
                ['field' => '[NP]Longitude', 'field_type' => 'text'],
                ['field' => 'SITE TYPE', 'field_type' => 'text'],
                ['field' => 'Tower Height', 'field_type' => 'text'],
                ['field' => 'FOC/ MW TAGGING', 'field_type' => 'text'],
                ['field' => 'Wind Speed', 'field_type' => 'text'],
                ['field' => 'OFF-GRID/GOOD GRID', 'field_type' => 'text'],
                ['field' => 'PRIO', 'field_type' => 'text'],
                ['field' => 'BATCH', 'field_type' => 'text'],
                ['field' => 'LOT SIZE (sq-m)', 'field_type' => 'text'],
                ['field' => 'ACCESS', 'field_type' => 'text'],
                ['field' => 'LINK TO DOCS FOR GLOBE-ACQUIRED SITES', 'field_type' => 'text'],
                ['field' => 'LANDLORD INFO', 'field_type' => 'text'],
                ['field' => 'LEASE AMOUNT', 'field_type' => 'text'],
                ['field' => 'LEASE ESCALATION', 'field_type' => 'text'],
                ['field' => 'LEASE TERM', 'field_type' => 'text'],
                ['field' => 'BASE LEASE FEE', 'field_type' => 'text'],
                ['field' => 'ESCALATION', 'field_type' => 'text'],
                ['field' => 'COMMENCEMENT', 'field_type' => 'text'],
                ['field' => 'REMARKS', 'field_type' => 'text'],
                ['field' => 'TSSR STATUS', 'field_type' => 'text'],
                ['field' => 'Tower Co TSSR Submission Date to GT', 'field_type' => 'text'],
                ['field' => 'SITE ACQUIRED FORECAST', 'field_type' => 'text'],
                ['field' => 'VS TOWERCO', 'field_type' => 'text'],
                ['field' => 'update user', 'field_type' => 'text'],
                ['field' => 'update group', 'field_type' => 'text'],
            ];  
        }

        $actor = '<form id="form-towerco-actor-multi">
            <input type="hidden" name="update user" value="' .   \Auth::user()->id . '">
            <input type="hidden" name="update group" value="' . $who . '">
        ';

            $value='';

            foreach ($allowed_fields as $allowed_field){

                    $actor .= '
                        <div class="row border-bottom mb-1 pb-1">
                            <div class="col-md-4">
                                ' . $allowed_field['field'] . '
                            </div>
                            <div class="col-md-8">';

                    if($allowed_field['field_type']=='date'){
                        $actor .= '
                        <input type="text" name="'. $allowed_field['field'] . '" value="' . $value . '"  data-old="'. $value .'" class="form-control flatpicker">
                        ';
                    }
                    elseif($allowed_field['field_type']=='text'){
                        $actor .= '
                        <input type="text" name="'. $allowed_field['field'] . '" value="' . $value . '" data-old="'. $value .'" class="form-control">
                        ';
                    }
                    elseif($allowed_field['field_type']=='number'){
                        $actor .= '
                        <input type="number" name="'. $allowed_field['field'] . '" value="' . $value . '" data-old="'. $value .'" class="form-control">
                        ';
                    }
                    elseif($allowed_field['field_type']=='select'){
                        $actor .= '
                            <select class="form-control" name="' . $allowed_field['field'] . '" data-old="'. $value .'" >
                                <option value=""></option>
                        ';

                        foreach($allowed_field['selection'] as $option){

                            if($option == $value){
                                $actor .= '
                                    <option value="' . $option . '" selected>' . $option . '</option>
                                ';
                            }
                            else {
                                $actor .= '
                                    <option value="' . $option . '">' . $option . '</option>
                                ';
                            }
                        }

                        $actor .= '
                            </select>
                        ';                        
                    }
                    $actor .= '        
                            </div>
                        </div>
                    ';

            }

        $actor .="</form>";



        return response()->json([ 'error' => false, 'actor' => $actor ]);


    }

    public function get_towerco_logs($serial)
    {

        try {
            $logs = \DB::connection('mysql2')
            ->table("towerco_logs")
            ->join("users","users.id", "towerco_logs.user_id")
            ->where('Serial Number', $serial)
            ->orderBy('towerco_logs.add_timestamp', 'DESC')
            ->get();
    
            $dt = DataTables::of($logs);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    public function save_towerco_serial(Request $request)
    {
        try {

            $data = collect($request->all())->mapWithKeys(function($item, $key) {
                    return [str_replace("_", " ", $key) => $item];
            })->toArray();

            // return dd($data);
            unset($data['Serial Number']);


            \DB::enableQueryLog(); // Enable query log

            \DB::table('towerco')
                ->where('Serial Number', $request['Serial_Number'])
                ->update(array_filter($data));

            // return dd(\DB::getQueryLog()); // Show results of log

            return response()->json([ 'error' => false, 'message' => "Successfully updated site", 'db' => \DB::getQueryLog() ]);    



        } catch (\Throwable $th) {

            return response()->json(['error' => true, 'message' => $th->getMessage()]);

        }

    }

    public function save_towerco_multi(Request $request)
    {
        try {

            $data = collect($request->all())->mapWithKeys(function($item, $key) {
                    return [str_replace("_", " ", $key) => $item];
            })->toArray();
            unset($data['Serial Number']);


            \DB::enableQueryLog(); // Enable query log

            \DB::table('towerco')
                ->whereIn('Serial Number', $request['Serial_Number'])
                ->update(array_filter($data));

            // \DB::connection('mysql2')
            //     ->table('towerco_logs')
            //     ->insert([
            //     'Serial Number' => 'kayla@example.com',
            //     'field' => '',
            //     'old_value' => '',
            //     'new_value' => ''
            // ]);

            return response()->json([ 'error' => false, 'message' => "Successfully updated site", 'db' => \DB::getQueryLog() ]);    


        } catch (\Throwable $th) {

            return response()->json(['error' => true, 'message' => $th->getMessage()]);

        }

    }

    public function filter_towerco($towerco = null, $region, $tssr_status, $milestone_status, $actor)
    {
        // $base_sql = "select * from `towerco`";

        // if($towerco != '-' || $region != '-'|| $tssr_status != '-' || $milestone_status != '-'){
        //     $base_sql .= " WHERE ";
        // }

        // $conditions = [];

        // if($towerco != '-'){
        //     array_push($conditions, " `TOWERCO` = '" . $towerco . "'");
        // }

        // if($region != '-'){
        //     array_push($conditions, " `REGION` = '" . $region . "'");
        // }

        // if($tssr_status != '-'){
        //     array_push($conditions, " `TSSR STATUS` = '" . $tssr_status . "'");
        // }
        // if($milestone_status != '-'){
        //     array_push($conditions, " `MILESTONE STATUS` = '" . $milestone_status . "'");
        // }


        $sites = \DB::connection('mysql2')
                        ->table('towerco');

        if($towerco != '-' && $actor != 'TowerCo'){
            $sites = $sites->where('TOWERCO', $towerco != '-' ? $towerco : "");
        
        } else {
            $user_detail = \Auth::user()->getUserDetail()->first();
            $vendor = Vendor::where('vendor_id', $user_detail->vendor_id)->first();

            $sites = $sites->where('TOWERCO', $vendor->vendor_acronym);
        }

        if($region != '-'){
            $sites = $sites->where('REGION', $region != '-' ? $region : "");
        }

        if($tssr_status != '-'){
            $sites = $sites->where('TSSR STATUS', $tssr_status != '-' ? $tssr_status : "");
        }
        if($milestone_status != '-'){
            $sites = $sites->where('MILESTONE STATUS', $milestone_status != '-' ? $milestone_status : "");
        }

        $rows = $sites->get();

        $dt = DataTables::of($rows);
        return $dt->make(true);

    }


    public function TowerCoExport()
    {
        return Excel::download(new TowerCoExport, 'towerco.xlsx');
    }

    public function get_my_towerco_file ($serial_number, $type)
    {
        try {
            $towerco_files = \DB::connection('mysql2')
                        ->table("towerco_files")
                        ->join('users', 'users.id', 'towerco_files.user_id')
                        ->where('towerco_files.serial_number', $serial_number)
                        ->where('towerco_files.type', $type)
                        ->get();
    
            $dt = DataTables::of($towerco_files)
                    ->addColumn('uploaded_by', function($row){
                        return $row->name;                            
                    });
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function upload_my_file_towerco(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'file_name' => 'required',
            ));

            $new_file = $this->rename_file($request->input("file_name"), $request->input("activity_name"), $request->input("serial_number"));

            \Storage::move( $request->input("file_name"), $new_file );

            if($validate->passes()){

                ToweCoFile::create([
                    'serial_number' => $request->input("serial_number"),
                    'file_name' => $new_file,
                    'type' => $request->input("activity_name"),
                    'user_id' => \Auth::id(),
                ]);            
                
                return response()->json(['error' => false, 'message' => "Successfully uploaded a file."]);
            } else {
                return response()->json(['error' => true, 'message' => "Please upload a file."]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

}
