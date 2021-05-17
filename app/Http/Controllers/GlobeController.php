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
                            $checkbox .= "<input type='checkbox' name='sam_id_checkbox[]' id='checkbox_".$row['sam_id']."' value='".$row['sam_id']."' class='custom-control-input checkbox-new-endorsement'>";
                            $checkbox .= "<label class='custom-control-label' for='checkbox_".$row['sam_id']."'></label>";
                            $checkbox .= "</div>";
    
                            return $checkbox;
                        })
                        ->addColumn('technology', function($row){
                            $technology = array_key_exists('TECHNOLOGY', $row['site_fields'][0]) ? $row['site_fields'][0]['TECHNOLOGY'] : '';
                            return "<div class='badge badge-success'>".$technology."</div>";                            
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

            // switch($program_id){
            //     case 1:
                    switch($profile_id){
                        case 12: 
                            $activity_id = 1;
                            break;

                        case 6: 
                            $activity_id = 2;
                            break;

                        case 7: 
                            $activity_id = 3;
                            break;

                        case 8: 
                            $activity_id = 4;
                            break;

                        case 3: 
                            $activity_id = 5;
                            break;

                        default:
                            $activity_id = "";     

                        break;
                    }

            $new_endorsements = \DB::connection('mysql2')->select('call `z_pull_data`(1, ' .  $program_id . ', "' . $activity_id .'")');

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

    public function acceptRejectEndorsement(Request $request)
    {
        try {
            if(is_null($request->input('sam_id'))){
                return response()->json(['error' => true, 'message' => "No data selected."]);
            }
            $profile_id = \Auth::user()->profile_id;
            $id = \Auth::user()->id;
            
            $message = $request->input('data_complete') == 'false' ? 'rejected' : 'accepted';

            for ($i=0; $i < count($request->input('sam_id')); $i++) { 

                $new_endorsements = \DB::connection('mysql2')->select('call z_update_data("'.$request->input('sam_id')[$i].'", '.$request->input('data_complete').')');
            }

            return response()->json(['error' => false, 'message' => "Successfully " .$message. " endorsement."]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function getDataWorkflow($program_id)
    {
        try {
            $stored_procs = $this->getWorkflow($program_id);
            
            $dt = DataTables::of($stored_procs);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getWorkflow($program_id)
    {
        return \DB::connection('mysql2')->select('call `stage_activites`('.$program_id. ')');
    }

    public function unassignedSites($profile_id, $program_id)
    {
        try {
            $stored_procs = $this->getNewEndorsement($profile_id, $program_id);
            $dt = DataTables::of($stored_procs)
                        ->addColumn('checkbox', function($row){
                            $checkbox = "<div class='avatar-icon-wrapper avatar-icon-sm avatar-icon-add'>";
                            $checkbox .= "<div class='avatar-icon'><i>+</i></div>";
                            $checkbox .= "</div>";

                            return $checkbox;
                        })
                        ->addColumn('technology', function($row){
                            $technology = array_key_exists('TECHNOLOGY', $row['site_fields'][0]) ? $row['site_fields'][0]['TECHNOLOGY'] : '';
                            return "<div class='badge badge-success'>".$technology."</div>";                            
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


}
