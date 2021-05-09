<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;


class GlobeController extends Controller
{
    public function getDataNewEndorsement($profile_id, $program_id)
    {
        try {
            // vendor_id, program_id, profile_id
            $stored_procs = $this->getNewEndorsement($profile_id, $program_id);
            
            $dt = DataTables::of($stored_procs)
                        ->addColumn('checkbox', function($row){
                            $checkbox = "<div class='custom-checkbox custom-control'>";
                            $checkbox .= "<input type='checkbox' name='checkbox' id='checkbox_".$row['sam_id']."' class='custom-control-input checkbox-new-endorsement'>";
                            $checkbox .= "<label class='custom-control-label' for='checkbox_".$row['sam_id']."'></label>";
                            $checkbox .= "</div>";
    
                            return $checkbox;
                        })
                        ->addColumn('technology', function($row){
                            return "<div class='badge badge-success'>".$row['site_fields'][0]['TECHNOLOGY']."</div>";                            
                        })
                        ->addColumn('pla_id', function($row){
                            return $row['site_fields'][0]['PLA_ID'];
                            
                        });
            
            $dt->rawColumns(['checkbox', 'technology']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getNewEndorsement($profile_id, $program_id)
    {
        try {


            // TEMPORARY BRACKETING OF ACTIVITY PER PROGRAM
            // SHOULD BE MIGRATED TO TABLE BASED LOGIC 

            switch($program_id){

                case 3:
                    switch($profile_id){
                        case 6: 
                                $activity_name = "New Endorsement";
                                break;
                        case 7: 
                                $activity_name = "STS Approval of Endorsement";
                                break;
                        default:
                                $activity_name = "";     
                    }
                    break;

                case 4:
                    switch($profile_id){
                        case 6: 
                                $activity_name = "New Endorsement";
                                break;
                        case 7: 
                                $activity_name = "STS Approval of Endorsement";
                                break;
                        default:
                                $activity_name = "";     
                    }
                    break;

                default:

            }

            $new_endorsements = \DB::connection('mysql2')->select('call `pull_new_endorsement_1`(1, ' .  $program_id . ', ' .  $profile_id . ', "' . $activity_name .'")');

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

    public function acceptEndorsement(Request $request)
    {
        try {
            $new_endorsements = \DB::connection('mysql2')->select('call set_new_endorsement("'.$request->input('sam_id').'", true)');
            return response()->json(['error' => false, 'message' => "Successfully accept endorsement."]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }


}
