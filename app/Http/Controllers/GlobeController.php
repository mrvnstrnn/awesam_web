<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

class GlobeController extends Controller
{
    public function getDataNewEndorsement($profile_id)
    {
        try {
            // vendor_id, program_id, profile_id
            $stored_procs = \DB::connection('mysql2')->select('call test_pull_new_endorsement(1, 1, ' .  $profile_id . ')');
            
            $dt = DataTables::of($stored_procs)
                        ->addColumn('checkbox', function($row){
                            $checkbox = "<div class='custom-checkbox custom-control'>";
                            $checkbox .= "<input type='checkbox' name='checkbox' id='checkbox_".$row->sam_id."' class='custom-control-input checkbox-new-endorsement'>";
                            $checkbox .= "<label class='custom-control-label' for='checkbox_".$row->sam_id."'></label>";
                            $checkbox .= "</div>";
    
                            return $checkbox;
                        })
                        ->addColumn('technology', function($row){
                            $technology = collect();
                            foreach (json_decode($row->site_fields, true) as $technologys){
                                $technology->push($technologys);
                            }
                            return "<div class='badge badge-success'>".$technology[13]."</div>";
                            
                        })
                        ->addColumn('pla_id', function($row){
                            $pla_id = collect();
                            foreach (json_decode($row->site_fields) as $plaid){
                                $pla_id->push($plaid);
                            }
                            return $pla_id[1];
                            
                        });
            
            $dt->rawColumns(['checkbox', 'technology']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getNewEndorsement($profile_id)
    {
        try {
            $new_endorsements = \DB::connection('mysql2')->select('call `test_pull_new_endorsement`(1, 1, ' .  $profile_id . ')');

            $json_output = [];

            for($i=0; $i < count($new_endorsements); $i++ ){


                // DECLARE JSON FIELDS AND SKIP
                $json_fields = array("site_fields", "stage_activities");            

                foreach($new_endorsements[$i] as $xfield => $object){
                    if(in_array($xfield, $json_fields)===FALSE){
                        $json[$xfield] = $object;
                    }
                }

                // Process JSON FIELDS and add to JSON 
                $site_fields = json_decode($new_endorsements[$i]->site_fields, TRUE);
                $stage_activities = json_decode($new_endorsements[$i]->stage_activities, TRUE);

                $json["site_fields"] = $site_fields;           
                $json["stage_activities"] = $stage_activities;

                $json_output[] = $json;

            }
            
            return $json_output;


        } catch (\Throwable $th) {
            throw $th;
        }

    }

}
