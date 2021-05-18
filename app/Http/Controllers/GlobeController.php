<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\SiteAgent;


class GlobeController extends Controller
{
    public function getDataNewEndorsement($profile_id, $program_id, $activity_id, $what_to_load)
    {
        try {
            // vendor_id, program_id, profile_id
            $stored_procs = $this->getNewEndorsement($profile_id, $program_id, $activity_id, $what_to_load);
            
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

    public function getNewEndorsement($profile_id, $program_id, $activity_id, $what_to_load)
    {
        try {


            // TEMPORARY BRACKETING OF ACTIVITY PER PROGRAM
            // SHOULD BE MIGRATED TO TABLE BASED LOGIC 

            // switch($program_id){
            //     case 1:
                    // switch($profile_id){
                    //     case 12: 
                    //         $activity_id = 1;
                    //         $what_to_load = "New Endorsement - pmo";
                    //         break;

                    //     case 6: 
                    //         $activity_id = 2;
                    //         $what_to_load = "New Endorsement - sts staff";
                    //         break;

                    //     case 7: 
                    //         $activity_id = 3;
                    //         $what_to_load = "New Endorsement - sts head";
                    //         break;

                    //     case 8: 
                    //         $activity_id = 4;
                    //         $what_to_load = "New Endorsement - program staff";
                    //         break;

                    //     case 3: 
                    //         $activity_id = 5;
                    //         $what_to_load = "New Endorsement - vendor admin";
                    //         break;

                    //     case 3: 
                    //         $activity_id = 6;
                    //         $what_to_load = "Vendor assign to agent";
                    //         break;

                    //     default:
                    //         $activity_id = "";   
                    //         $what_to_load = "";

                    //     break;
                    // }
                    
                    // $profile = \DB::connection('mysql2')->table('profiles')->where('id', $profile_id);

                    // $what_to_load = "New Endorsement - ".strtolower($profile->profile)

            // $new_endorsements = \DB::connection('mysql2')->select('call `z_pull_data`(1, ' .  $program_id . ', "' . $activity_id .'")');

            // a_pull_data(VENDOR_ID, PROGRAM_ID, PROFILE_ID, STAGE_ID, WHAT_TO_LOAD)
            $new_endorsements = \DB::connection('mysql2')->select('call `a_pull_data`(1, ' .  $program_id . ', ' .  $profile_id . ', "' . $activity_id .'", "' . $what_to_load .'")');

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

                // $new_endorsements = \DB::connection('mysql2')->select('call z_update_data("'.$request->input('sam_id')[$i].'", '.$request->input('data_complete').')');

                // a_update_data(SAM_ID, PROFILE_ID, USER_ID, true/false)
                $new_endorsements = \DB::connection('mysql2')->select('call `a_update_data`("'.$request->input('sam_id')[$i].'", '.$profile_id.', '.$id.', "'.$request->input('data_complete').'")');
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

    public function unassignedSites($profile_id, $program_id, $activity_id, $what_to_load)
    {
        try {
            $stored_procs = $this->getNewEndorsement($profile_id, $program_id, $activity_id, $what_to_load);
            $dt = DataTables::of($stored_procs)
                        ->addColumn('checkbox', function($row){
                            $checkbox = "<div class='avatar-icon-wrapper avatar-icon-sm avatar-icon-add assign-agent' data-id='".$row['sam_id']."'>";
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

    public function assign_agent(Request $request)
    {
        try {
            $profile_id = \Auth::user()->profile_id;
            $id = \Auth::user()->id;
            SiteAgent::create($request->all());
            \DB::connection('mysql2')->select('call `a_update_data`("'.$request->input('sam_id').'", '.$profile_id.', '.$id.', "true")');
            return response()->json(['error' => false, 'message' => "Successfuly assigned agent."]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

}
