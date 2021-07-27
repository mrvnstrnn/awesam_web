<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\SiteAgent;
use App\Models\UsersArea;
use App\Models\Program;
use App\Models\UserDetail;
use App\Models\SubActivityValue;
use App\Models\IssueType;
use App\Models\Issue;
use App\Models\Chat;
use App\Models\User;
use App\Models\RTBDeclaration;
use App\Models\VendorProgram;
use App\Models\UserProgram;
use App\Models\LocalCoopValue;
use App\Models\IssueRemark;

use App\Exports\TowerCoExport;
use Maatwebsite\Excel\Facades\Excel;


use Illuminate\Support\Facades\Schema;
use Validator;
use PDF;
use Carbon;
use Illuminate\Support\Facades\Notification;


use App\Events\SiteEndorsementEvent;
use App\Listeners\SiteEndorsementListener;
use App\Notifications\SiteEndorsementNotification;


class GlobeController extends Controller
{
    public function getDataNewEndorsement($profile_id, $program_id, $activity_id, $what_to_load)
    {
        try {
            // $stored_procs = $this->getNewEndorsement($profile_id, $program_id, $activity_id, $what_to_load);

            $vendor = !is_null(\Auth::user()->getUserDetail()->first()) ? \Auth::user()->getUserDetail()->first()->vendor_id : 1 ;

            $stored_procs = \DB::connection('mysql2')->select('call `a_pull_data`('.$vendor.', ' .  $program_id . ', ' .  $profile_id . ', "' . $activity_id .'", "' . $what_to_load .'", "' . \Auth::user()->id .'")');

            // $program = Program::where('program_id', $program_id)->first();
            
            $dt = DataTables::of($stored_procs)
                        ->addColumn('checkbox', function($row) use($program_id) {
                            $checkbox = "<div class='custom-checkbox custom-control'>";
                            $checkbox .= "<input type='checkbox' name='program".$program_id."' id='checkbox_".$row->sam_id."' value='".$row->sam_id."' class='custom-control-input checkbox-new-endorsement' data-site_vendor_id='".$row->site_vendor_id."'>";
                            $checkbox .= "<label class='custom-control-label' for='checkbox_".$row->sam_id."'></label>";
                            $checkbox .= "</div>";
    
                            return $checkbox;
                        })
                        ->addColumn('technology', function($row){
                            // $technology = array_key_exists('TECHNOLOGY', $row['site_fields'][0]) ? $row['site_fields'][0]['TECHNOLOGY'] : '';
                            if(isset($row->technology)){
                                $technology = $row->technology;
                            } else {
                                $technology = "";
                            }
                            // $technology = array_key_exists('TECHNOLOGY', $row['site_fields'][0]) ? $row['site_fields'][0]['TECHNOLOGY'] : '';
                            return "<div class='badge badge-success'>".$technology."</div>";                            
                        });
                        // ->addColumn('pla_id', function($row){
                        //     return $row['site_fields'][0]['PLA_ID'];
                            
                        // });
            
            $dt->rawColumns(['checkbox', 'technology']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getNewEndorsement($profile_id, $program_id, $activity_id, $what_to_load)
    {
        try {

            // a_pull_data(VENDOR_ID,  PROGRAM_ID, PROFILE_ID, STAGE_ID , WHAT_TO_LOAD, USER_ID)
            $new_endorsements = \DB::connection('mysql2')->select('call `a_pull_data`(1, ' .  $program_id . ', ' .  $profile_id . ', "' . $activity_id .'", "' . $what_to_load .'", "' . \Auth::user()->id .'")');

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
                $stage_activities = json_decode($new_endorsements[$i]->stage_activities ? $new_endorsements[$i]->stage_activities  : "", TRUE);

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
            
            if ($request->input('activity_name') == "Vendor Awarding") {
                $validate = Validator::make($request->all(), array(
                    'po_number' => 'required',
                ));

                if (!$validate->passes()) {
                    return response()->json(['error' => true, 'message' => $validate->errors() ]);
                } else {
                    \DB::connection('mysql2')->table("site")
                                                ->where("sam_id", $request->input("sam_id"))
                                                ->update([
                                                    'site_po' => $request->input('po_number'),
                                                ]);
                }
            }

            $profile_id = \Auth::user()->profile_id;
            $id = \Auth::user()->id;

            $message = $request->input('data_complete') == 'false' ? 'rejected' : 'accepted';
            if ($request->input('activity_name') == "endorse_site") {
                $notification = "Successfully " .$message. " endorsement.";
            } else if ($request->input('activity_name') == "pac_approval" || $request->input('activity_name') == "pac_director_approval" || $request->input('activity_name') == "pac_vp_approval" || $request->input('activity_name') == "fac_approval" || $request->input('activity_name') == "fac_director_approval" || $request->input('activity_name') == "fac_vp_approval") {
                $notification = "Site successfully " .$message;
            } else if ($request->input('activity_name') == "rtb_docs_approval") {
                $notification = "RTB Docs successfully approved";
            } else if ($request->input('activity_name') == "Vendor Awarding") {
                $notification = "Successfully awarded.";
            } else {
                $notification = "Success";
            }
            
            if ($request->input('activity_name') == "Vendor Awarding") {
                $vendor = $request->input('vendor');
                $action = $request->input('data_action');
            } else {
                $vendor = $request->input('site_vendor_id');
                $action = $request->input('data_complete');
            }
            for ($i=0; $i < count($request->input('sam_id')); $i++) { 

                SiteEndorsementEvent::dispatch($request->input('sam_id')[$i]);

                // if (!is_null($vendor) || !is_null(\Auth::user()->getUserDetail()->first() )) {
                    
                //     if ( !is_null(\Auth::user()->getUserDetail()->first()) ) {
                //         $vendor = [ \Auth::user()->getUserDetail()->first()->vendor_id ];
                //     } else {
                //         $vendor = $vendor; 
                //     }
                //     for ($k=0; $k < count($vendor); $k++) {
                //         $email_receiver = User::select('users.*')
                //                         ->join('user_details', 'users.id', 'user_details.user_id')
                //                         ->join('user_programs', 'user_programs.user_id', 'users.id')
                //                         ->join('program', 'program.program_id', 'user_programs.program_id')
                //                         ->where('user_details.vendor_id', $vendor[$k])
                //                         ->where('user_programs.program_id', $request->input('data_program'))
                //                         ->get();
                        
                //         for ($j=0; $j < count($email_receiver); $j++) { 
                //             $email_receiver[$j]->notify( new SiteEndorsementNotification($request->input('sam_id')[$i], $request->input('activity_name'), $action) );
                //         }
                //     }
                // }

                // a_update_data(SAM_ID, PROFILE_ID, USER_ID, true/false)
                $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id')[$i].'", '.$profile_id.', '.$id.', "'.$action.'")');
            }

            return response()->json(['error' => false, 'message' => $notification ]);
        } catch (\Throwable  $th) {
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
            // $stored_procs = $this->getNewEndorsement($profile_id, $program_id, $activity_id, $what_to_load);

            $vendor = \Auth::user()->getUserDetail()->first()->vendor_id;

            $stored_procs = \DB::connection('mysql2')->select('call `a_pull_data`('.$vendor.', ' .  $program_id . ', ' .  $profile_id . ', "' . $activity_id .'", "' . $what_to_load .'", "' . \Auth::user()->id .'")');

            $dt = DataTables::of($stored_procs)
                            ->addColumn('photo', function($row){
                                $photo = "<div class='avatar-icon-wrapper avatar-icon-sm avatar-icon-add'>";
                                $photo .= "<div class='avatar-icon'>";
                                $photo .= "<i>+</i>";

                                $photo .= "</div></div>";

                                return $photo;
                            })
                            ->addColumn('technology', function($row){
                                // $technology = array_key_exists('TECHNOLOGY', $row['site_fields'][0]) ? $row['site_fields'][0]['TECHNOLOGY'] : '';
                                if(isset($row->technology)){
                                    $technology = $row->technology;
                                } else {
                                    $technology = "";
                                }
                                // $technology = array_key_exists('TECHNOLOGY', $row['site_fields'][0]) ? $row['site_fields'][0]['TECHNOLOGY'] : '';
                                return "<div class='badge badge-success'>".$technology."</div>";                            
                            });
            
            $dt->rawColumns(['photo', 'technology']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function assign_agent(Request $request)
    {
        try {
            $checkAgent = \DB::connection('mysql2')->table('site_users')->where('sam_id', $request->input('sam_id'))->where('agent_id', $request->input('agent_id'))->first();

            $user = User::find($request->input('agent_id'));

            $profile_id = \Auth::user()->profile_id;
            $id = \Auth::user()->id;

            

            $email_receiver = User::find($request->input('agent_id'));

            SiteEndorsementEvent::dispatch($request->input('sam_id'));

            $email_receiver->notify( new SiteEndorsementNotification($request->input('sam_id'), $request->input('activity_name'), "true", $request->input('site_name')) );

            if(is_null($checkAgent)) {
                
                SiteAgent::create([
                    'agent_id' => $request->input('agent_id'),
                    'sam_id' => $request->input('sam_id'),
                ]);

                \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.$profile_id.', '.$id.', "true")');
                
                return response()->json(['error' => false, 'message' => "Successfuly assigned agent."]);
            } else {

                \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.$profile_id.', '.$id.', "true")');
                
                return response()->json(['error' => false, 'message' => "Successfuly assigned agent."]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function vendor_assigned_sites($program_id, $mode)
    {   
        if($mode == "vendor"){
            if((\Auth::user()->profile_id)==2){
                $sites = \DB::connection('mysql2')->table('site')
                            ->join('site_users', 'site_users.sam_id', 'site.sam_id')
                            ->where('program_id', "=", $program_id)
                            ->where('site_users.agent_id', "=", \Auth::user()->id)
                            ->get();
            } else {
                $sites = \DB::connection('mysql2')->table('site')
                            ->join('site_users', 'site_users.sam_id', 'site.sam_id')
                            ->join('user_details', 'user_details.user_id', 'site_users.agent_id')
                            ->where('program_id', "=", $program_id)
                            ->where('IS_id', "=", \Auth::user()->id)
                            ->get();
            } 
        } else {

            $sites = \DB::connection('mysql2')->table('site')
            ->join('site_users', 'site_users.sam_id', 'site.sam_id')
            ->join('user_details', 'user_details.user_id', 'site_users.agent_id')
            ->where('program_id', "=", $program_id)
            ->get();

        }


        // dd($sites);


        $dt = DataTables::of($sites);
        return $dt->make(true);
    }

    public function agent_assigned_sites_columns()
    {
        $sites = \Schema::connection('mysql2')->getColumnListing('site');
        return $sites;
    }

    public function agents($program_id)
    {

        try {
            $checkAgent = \DB::connection('mysql2')
                                    ->table('users')
                                    ->select('users.id', 'users.firstname', 'users.lastname', 'users.email', 'users_areas.region', 'users_areas.province')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
                                    ->join('user_programs', 'user_programs.user_id', 'users.id')
                                    ->join('users_areas', 'users_areas.user_id', 'users.id')
                                    ->where('user_details.IS_id', \Auth::user()->id)
                                    ->where('user_programs.program_id', $program_id)
                                    ->get();
                                                        
            $dt = DataTables::of($checkAgent)
                    ->addColumn('photo', function($row){
                        $photo = "<div class=avatar-icon-wrapper avatar-icon-sm'>";
                        $photo .= "<div class='avatar-icon'>";
                        $photo .= "<img src='data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkExQjJCNTVFRUNGMDExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkExQjJCNTVERUNGMDExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJGQTNDMzBENTkxNUNENDY3Qjg0REZERUVBM0VDRkYwMyIgc3RSZWY6ZG9jdW1lbnRJRD0iRkEzQzMwRDU5MTVDRDQ2N0I4NERGREVFQTNFQ0ZGMDMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwMDAwMDBAMDg8QDw4MExMUFBMTHBsbGxwfHx8fHx8fHx8fAQcHBw0MDRgQEBgaFREVGh8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx//wAARCABAAEADAREAAhEBAxEB/8QAlQAAAgMAAwEAAAAAAAAAAAAABQYEBwgBAgMAAQADAQEBAQAAAAAAAAAAAAADBAUBAgAGEAACAQMDAQUDCgYDAAAAAAABAgMRBAUAEgYhMWEiEwdBUXKBscEyQlIjFBYIkWIzQ2MVcaGyEQACAQIFAQYGAwAAAAAAAAAAAQIRAyExQRIEcVGBkTMkBWEiMlIjNMGSE//aAAwDAQACEQMRAD8AZ+RYq3TBu9OoAoffrjlW0rKfQ5tSrMnel1hH/pR09p1C5EcR628Dy9SuU5LAR4/F4KJZs1lGfZRRK0MKDq/l+9iaAt0HbrOHx1cbcvpQST7MypORr6p5lqSS5R0XogZ3jSlaHwqVXs1VhatxWCRw4zYJxnOPVTgk6zNNcy2aEGTGZNGubKRPutvqyfErCmulC3LSL7gc4ySxL0w3qrxr1B9N7y4t7OPHZ6xZFv8AGoAfKLN4ZY3AXdFIo+Q9D7zm1KcaKgGjozNvNemVm730xIyJ6WDFY4gELFh4QNGbSVWejCUnRKppDk4X9OyfCvzjXPL/AF/6gLX1kn0rdBhiX/ppuZ/hWpP/AENQuSh+1kD/AEzxEt/LleWZIFstnblnDn+1ZqaQwpXsUKBUadhapFRWSGbcqVZYklpCo2q5NR8mvSgtDuM2xW5ZiLO6tHhkRZo2BEsLgGqkUI66VmqOqGYOqxKX9L+KWmL5FzgoZB+QtoYbFa0j/LzykkMPtMpQBdUbc921km7DbuQgc66ZWX49GkAhkTsFUi0PfofM8sf9q89GguT1/Tkp/wAY+jR+QvT+BIt+YcemzyfpHIMnWRbe42jv2NqLdxkkULeQcwN/DjuJ4+42gl4vBG1fGygkgBakmi+zVSlXRBtCdgOXDM2M95NapbiCMTJsZiGiYVUjeFNWHs0K40q1zQSEcqPCQvXXLv8AYTvA8EFurKZLWrv5zqG2daqEru8I69ugXLe6G6gaMtsttcRUwyyLyrlqKhET4y2aRqUo4m6f+jonGyQnzM2Upz5aZWb4tOTE4ZBLiYVprIN1BJqNB9w8hlT2JV5UUzQHJYSeJyv/AIQfm09ej6fuRAtv8i6kf0mZ2wMhUb2ik8xY/vbGqF+XUSE6XVUr8dpPHUecalquNBk2Qm28wOQKLGQTvAr2Cp05twCr6qES6ucatpdxMy27tAzkU6tX2kCvU+7Q5wrBh4uk1qDsFFjb/FNURSSIm8KQpDgHtr29D79Kwi2mM3cGgSttAY8zNHHtkZyZZvvBYwgB/wCCdE4qe9CnLaVmXa/4M5eoi7crL8WqVwkW8iXxI/jWR/mPzaDz1+Blb2H9uPU0dkorm+4nLDBC0ha3C1HvoNUab+PRZuKPnK7Z1ejBfpXHNZ2ssMg2MrtVT2jrr5/lWZReKKVmaksA5lshbRDJYiZtjXBF5AR0JjcqSyV7dki0bRuPN3LfxTG1Kjqz0FiLSyiJZ8klySIrtpTBId/9uRY020HZ07fbpmTW3IbszT1p3VFjIy2nFr5b++uSty6yUhUhbaKNlCH2bmp39a6RrVvA6vSXcN0WAubbg0uRu0aG+vt15cwN02CX6iFfYVSle/VGzYUYrtI1++5t/boZW9SgRlpfi0S6CtZHtxI/jWXxfRoPO8hlX2N+rh1NgcMewGJit2ZWZVo1addE4t9uzF6pEu/bUZtBuHD4WJ2eOCJGb6xUAV/hpS+97rJnVuKisBH5WnC+V5G949YXKyZnj6hr17YEPaPcfVTzKbG3bCHj699DreNaUK01CqVRUtr3nvH0eyu8YM5ZIp/KXds4Q7utBLE5BHuqDTRrsVSoa1daBNtxfK5XIy8l5VEjT2kTSY7Dq3mRp5QLoZ27HckUUDoO86nTuJYRGYxcnVjNxP1osPUjhGSkhsZMfkbMrDkLN28xVLgsjpJRaqdhHiAII1Z/0jlqyMoSp0M6epwplJD7zrLptnI+4i341l8f0aDzf130Knsr9XDqW9fLyji3Onx9jc0wMoEsSz9Qgbo4Vz2BToHElJRa+0mTt75fEZ8p+4TgXHIEtfPlzubjA8y2x4DQpIPsyXLUjHft3ayNmdzFraEbUcFiV5+3DktovKeUWt2wGUzkoyMT1r5mx5GljUnt2+bu01d+VrsyO7GKa1NA3Qh8ojYW302he/Q7jwCQWJX3q1y2HhvEZ7tUDZG7JtsdCexrh1NWP8sS+I/JpRWN8qaajMr2xV8DKnGOUcj4zkJMhiLw29xMjR3SsA8U6MasssbeFupqPcezVLavAmVJWb5LPnZPOvIkguPtPFXYe/aakfx1s1uMh8oU4vkrCG4tEluEj2uKs9VHXvOhctN2WlnQf9quRhyYSk6RqDs9yvk/Irt7rO5S4yE7dPxX8AH3VRdqAd1NHjBLJE8GA0TYvhUdgHSg+TXaMObTIZKxvre8xsj2txbPviukYxyAj7hHUaxquDyNTpii7OEfufyVnazW3M7M30kULvZ5G2CpJK6iqRXCCieI9PMUdPaNLSsOvyvAYjeWpUvOOf8AI+b5h8plyocHbaW6E+TBFX+nGnsB9rfWPadFSSVEBlJt1YCCEgVp307taYdwo148d6A1Hs1ph//Z'>";

                        $photo .= "</div></div>";

                        return $photo;
                    })
                    ->addColumn('areas', function($row){
                        return $row->region. " | " .$row->province;
                    });
            
            $dt->rawColumns(['photo']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function newagent($program_id)
    {
        try {
            $checkAgent = \DB::connection('mysql2')
                                    ->table('users')
                                    ->select('users.id', 'users.firstname', 'users.lastname', 'users.email')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
                                    ->join('user_programs', 'user_programs.user_id', 'user_details.user_id')
                                    ->leftJoin('users_areas', 'users_areas.user_id', 'users.id')
                                    ->where('user_details.IS_id', \Auth::user()->id)
                                    ->whereNull('users_areas.user_id')
                                    ->where('user_programs.program_id', $program_id)
                                    ->get();
                                                        
            $dt = DataTables::of($checkAgent)
                    ->addColumn('photo', function($row){
                        $photo = "<div class=avatar-icon-wrapper avatar-icon-sm'>";
                        $photo .= "<div class='avatar-icon'>";
                        $photo .= "<img src='data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkExQjJCNTVFRUNGMDExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkExQjJCNTVERUNGMDExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJGQTNDMzBENTkxNUNENDY3Qjg0REZERUVBM0VDRkYwMyIgc3RSZWY6ZG9jdW1lbnRJRD0iRkEzQzMwRDU5MTVDRDQ2N0I4NERGREVFQTNFQ0ZGMDMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwMDAwMDBAMDg8QDw4MExMUFBMTHBsbGxwfHx8fHx8fHx8fAQcHBw0MDRgQEBgaFREVGh8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx//wAARCABAAEADAREAAhEBAxEB/8QAlQAAAgMAAwEAAAAAAAAAAAAABQYEBwgBAgMAAQADAQEBAQAAAAAAAAAAAAADBAUBAgAGEAACAQMDAQUDCgYDAAAAAAABAgMRBAUAEgYhMWEiEwdBUXKBscEyQlIjFBYIkWIzQ2MVcaGyEQACAQIFAQYGAwAAAAAAAAAAAQIRAyExQRIEcVGBkTMkBWEiMlIjNMGSE//aAAwDAQACEQMRAD8AZ+RYq3TBu9OoAoffrjlW0rKfQ5tSrMnel1hH/pR09p1C5EcR628Dy9SuU5LAR4/F4KJZs1lGfZRRK0MKDq/l+9iaAt0HbrOHx1cbcvpQST7MypORr6p5lqSS5R0XogZ3jSlaHwqVXs1VhatxWCRw4zYJxnOPVTgk6zNNcy2aEGTGZNGubKRPutvqyfErCmulC3LSL7gc4ySxL0w3qrxr1B9N7y4t7OPHZ6xZFv8AGoAfKLN4ZY3AXdFIo+Q9D7zm1KcaKgGjozNvNemVm730xIyJ6WDFY4gELFh4QNGbSVWejCUnRKppDk4X9OyfCvzjXPL/AF/6gLX1kn0rdBhiX/ppuZ/hWpP/AENQuSh+1kD/AEzxEt/LleWZIFstnblnDn+1ZqaQwpXsUKBUadhapFRWSGbcqVZYklpCo2q5NR8mvSgtDuM2xW5ZiLO6tHhkRZo2BEsLgGqkUI66VmqOqGYOqxKX9L+KWmL5FzgoZB+QtoYbFa0j/LzykkMPtMpQBdUbc921km7DbuQgc66ZWX49GkAhkTsFUi0PfofM8sf9q89GguT1/Tkp/wAY+jR+QvT+BIt+YcemzyfpHIMnWRbe42jv2NqLdxkkULeQcwN/DjuJ4+42gl4vBG1fGygkgBakmi+zVSlXRBtCdgOXDM2M95NapbiCMTJsZiGiYVUjeFNWHs0K40q1zQSEcqPCQvXXLv8AYTvA8EFurKZLWrv5zqG2daqEru8I69ugXLe6G6gaMtsttcRUwyyLyrlqKhET4y2aRqUo4m6f+jonGyQnzM2Upz5aZWb4tOTE4ZBLiYVprIN1BJqNB9w8hlT2JV5UUzQHJYSeJyv/AIQfm09ej6fuRAtv8i6kf0mZ2wMhUb2ik8xY/vbGqF+XUSE6XVUr8dpPHUecalquNBk2Qm28wOQKLGQTvAr2Cp05twCr6qES6ucatpdxMy27tAzkU6tX2kCvU+7Q5wrBh4uk1qDsFFjb/FNURSSIm8KQpDgHtr29D79Kwi2mM3cGgSttAY8zNHHtkZyZZvvBYwgB/wCCdE4qe9CnLaVmXa/4M5eoi7crL8WqVwkW8iXxI/jWR/mPzaDz1+Blb2H9uPU0dkorm+4nLDBC0ha3C1HvoNUab+PRZuKPnK7Z1ejBfpXHNZ2ssMg2MrtVT2jrr5/lWZReKKVmaksA5lshbRDJYiZtjXBF5AR0JjcqSyV7dki0bRuPN3LfxTG1Kjqz0FiLSyiJZ8klySIrtpTBId/9uRY020HZ07fbpmTW3IbszT1p3VFjIy2nFr5b++uSty6yUhUhbaKNlCH2bmp39a6RrVvA6vSXcN0WAubbg0uRu0aG+vt15cwN02CX6iFfYVSle/VGzYUYrtI1++5t/boZW9SgRlpfi0S6CtZHtxI/jWXxfRoPO8hlX2N+rh1NgcMewGJit2ZWZVo1addE4t9uzF6pEu/bUZtBuHD4WJ2eOCJGb6xUAV/hpS+97rJnVuKisBH5WnC+V5G949YXKyZnj6hr17YEPaPcfVTzKbG3bCHj699DreNaUK01CqVRUtr3nvH0eyu8YM5ZIp/KXds4Q7utBLE5BHuqDTRrsVSoa1daBNtxfK5XIy8l5VEjT2kTSY7Dq3mRp5QLoZ27HckUUDoO86nTuJYRGYxcnVjNxP1osPUjhGSkhsZMfkbMrDkLN28xVLgsjpJRaqdhHiAII1Z/0jlqyMoSp0M6epwplJD7zrLptnI+4i341l8f0aDzf130Knsr9XDqW9fLyji3Onx9jc0wMoEsSz9Qgbo4Vz2BToHElJRa+0mTt75fEZ8p+4TgXHIEtfPlzubjA8y2x4DQpIPsyXLUjHft3ayNmdzFraEbUcFiV5+3DktovKeUWt2wGUzkoyMT1r5mx5GljUnt2+bu01d+VrsyO7GKa1NA3Qh8ojYW302he/Q7jwCQWJX3q1y2HhvEZ7tUDZG7JtsdCexrh1NWP8sS+I/JpRWN8qaajMr2xV8DKnGOUcj4zkJMhiLw29xMjR3SsA8U6MasssbeFupqPcezVLavAmVJWb5LPnZPOvIkguPtPFXYe/aakfx1s1uMh8oU4vkrCG4tEluEj2uKs9VHXvOhctN2WlnQf9quRhyYSk6RqDs9yvk/Irt7rO5S4yE7dPxX8AH3VRdqAd1NHjBLJE8GA0TYvhUdgHSg+TXaMObTIZKxvre8xsj2txbPviukYxyAj7hHUaxquDyNTpii7OEfufyVnazW3M7M30kULvZ5G2CpJK6iqRXCCieI9PMUdPaNLSsOvyvAYjeWpUvOOf8AI+b5h8plyocHbaW6E+TBFX+nGnsB9rfWPadFSSVEBlJt1YCCEgVp307taYdwo148d6A1Hs1ph//Z'>";

                        $photo .= "</div></div>";

                        return $photo;
                    })
                    ->addColumn('areas', function($row){
                        return null;
                    });
            
            $dt->rawColumns(['photo']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function vendor_agents($user_id = null)
    {

        try {

            if (is_null($user_id)) {
                
                $vendors = UserDetail::select('vendor_id')->where('user_id', \Auth::id())->first();

                $checkAgent = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                        ->where('user_details.vendor_id', $vendors->vendor_id)
                                        ->where('users.profile_id', 2)
                                        ->get();
                                                            
                $dt = DataTables::of($checkAgent)
                                    ->addColumn('action', function($row){
                                        return '<button class="btn btn-sm btn-primary update-data" data-value="'.$row->user_id.'" data-is_id="'.$row->IS_id.'" data-vendor_id="'.$row->vendor_id.'" title="Update"><i class="fa fa-edit"></i></button>';
                                    });
            } else {
                $vendors = UserDetail::select('vendor_id')->where('user_id', \Auth::id())->first();

                $checkAgent = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                        ->where('user_details.vendor_id', $vendors->vendor_id)
                                        ->where('users.profile_id', 2)
                                        ->where('user_details.IS_id', $user_id)
                                        ->get();
                                                            
                $dt = DataTables::of($checkAgent)
                                    ->addColumn('action', function($row){
                                        return '<button class="btn btn-sm btn-primary get_supervisor" data-user_id="'.$row->user_id.'" data-profile_id="'.$row->profile_id.'" data-is_id="'.$row->IS_id.'" data-name="'.$row->name.'" data-vendor_id="'.$row->vendor_id.'" title="Update"><i class="fa fa-edit"></i></button>';
                                    });
            }

                
            $dt->rawColumns(['action']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function vendor_supervisors()
    {
        try {
            $checkSupervisor = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                    ->where('user_details.IS_id', \Auth::id())
                                    ->where('users.profile_id', 3)
                                    ->get();
                                                        
            $dt = DataTables::of($checkSupervisor)
                                ->addColumn('number_agent', function($row){
                                    $agents = UserDetail::select('user_id')->where('IS_id', $row->user_id)->get();
                                    return count($agents);                            
                                });

            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function get_agent_of_supervisor($user_id)
    {
        try {
            $getAgentOfSupervisor = UserDetail::select('users.firstname', 'users.lastname', 'users.email', 'users_areas.lgu', 'users_areas.province', 'users_areas.region')
                                    ->join('users', 'user_details.user_id', 'users.id')
                                    ->leftJoin('users_areas', 'users_areas.user_id', 'users.id')
                                    ->where('user_details.IS_id', $user_id)
                                    // ->where('users.profile_id', 3)
                                    ->get();
            
            return response()->json(["error" => false, "message" => $getAgentOfSupervisor]);
        } catch (\Throwable $th) {
            return response()->json(["error" => true, "message" => $th->getMessage()]);
        }
    }

    public function get_region()
    {
        try {
            $is_location = \DB::connection('mysql2')->table('user_details')
                                                ->join('users_areas', 'users_areas.user_id', 'user_details.IS_id')
                                                ->where('user_details.user_id', \Auth::user()->id)
                                                ->first();
                                        
            if(!is_null($is_location)){
                $region = \DB::connection('mysql2')->table('location_regions')->where('region_name', $is_location->region)->get();
            } else {
                $region = \DB::connection('mysql2')->table('location_regions')->get();
            }
            return response()->json(['error' => false, 'message' => $region]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_location($location_id, $location_type)
    {
        try {
            if($location_type == "region") {
                $table = 'location_provinces';
            } else if($location_type == "province") {
                $table = 'location_lgus';
            }
            $location = \DB::connection('mysql2')->table($table)->where($location_type."_id", $location_id)->get();

            return response()->json(['error' => false, 'message' => $location]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function assign_agent_site(Request $request)
    {
        try {
            $provinces = collect();
            $lgus = collect();

            $region = preg_replace("/[\[\]']+/m", "", preg_replace('/(?:\[[^][]*])(*SKIP)(*F)|[^][(){}]+/m', '', $request->input('region')));

            $province = preg_replace("/[\[\]']+/m", "", preg_replace('/(?:\[[^][]*])(*SKIP)(*F)|[^][(){}]+/m', '', $request->input('province')));

            $lgus = preg_replace("/[\[\]']+/m", "", preg_replace('/(?:\[[^][]*])(*SKIP)(*F)|[^][(){}]+/m', '', $request->input('lgu')));


            $lgu_validator = in_array('all', $province) ? '' : 'required';
            $lgu = in_array('all', $province) ? ['all'] : $lgus;

            $validate = Validator::make($request->all(), array(
                'region' => 'required',
                'province' => 'required',
                'lgu' => $lgu_validator 
            ));

            if($validate->passes()){
                UsersArea::create([
                    'user_id' => $request->input('user_id'),
                    'region' => $region,
                    'province' => in_array('all', $province) ? '%' : implode(", ", $province),
                    'lgu' => in_array('all', $lgu) ? '%' : implode(", ", $lgu),
                ]);
                return response()->json(['error' => false, 'message' => "Successfully assigned agent site."]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }    

    public function loi_template($sam_id = "", $sub_activity_id = "")
    {
        try {

            $sub_activity_files = SubActivityValue::where('sam_id', $sam_id)
                                                        ->where('sub_activity_id', $sub_activity_id)
                                                        ->where('user_id', \Auth::id())
                                                        ->orderBy('date_created', 'desc')
                                                        ->first();
            if(is_null($sub_activity_files)){
                $content = "<img src='".asset('images/globe-logo.png')."' width='150px'><br>";
                $content .= "<p>October 1, 2019</p>";
                $content .= "<p>ROSELIO R. ARAN DIA AND YOLANDA DC. ARANDIA</p>";
                $content .= "<p>Arandia Academy, Airport Village, Barangay Moonwalk, Paranque City</p>";
                $content .= "<p>Subject: <b>NOTICE TO PROCEED</b></p>";
                $content .= "<p>Dear <b>Sir/Ma'am</b></p>";
                $content .= "<p>We would like to seek for your approval to allow Globe Telecom, Inc., its employees, agents or representatives to commence with the enhancement of facilities, equipment and appurtenances located at Arandia Academy, Airport Village, Barangay Moonwalk, Paranque City.</p>";
    
                $content .= "<p>Kindly signify your confirmation by affixing your signature in the space provided below. Thank you</p>";
    
    
                return response()->json(['error' => false, 'message' => $content]);
            } else {
                return response()->json(['error' => false, 'message' => $sub_activity_files->value]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function download_pdf(Request $request)
    {
        try {
            $sub_act = SubActivityValue::where('sam_id', $request->input("sam_id"))
                                        ->where('sub_activity_id', $request->input("sub_activity_id"))
                                        ->where('user_id', \Auth::id())
                                        ->first();

                                        // dd($sub_act);
            if(is_null($sub_act)){
                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'sub_activity_id' => $request->input("sub_activity_id"),
                    'value' => $request->input("editordata"),
                    'user_id' => \Auth::id(),
                    'status' => "pending",
                ]);
            } else {
            //     abort(403, 'Unable to print this to pdf.');
                SubActivityValue::where('id', $sub_act->id)
                                    ->update([
                                        'value' => $request->input("editordata"),
                                        'status' => "pending",
                                    ]);
            }

            $pdf = \App::make('dompdf.wrapper');
            $pdf = PDF::loadHTML($request->input('editordata'));
            $pdf->setPaper('a4');
            
            return $pdf->stream();

        } catch (\Throwable $th) {
            abort(403, $th->getMessage());
        }
    }

    public function fileupload(Request $request)
    {

        try {
            $validate = Validator::make($request->all(), array(
                'file' => 'required',
            ));

            // return response()->json(['error' => true, 'message' => $request->all() ]);
            
            if($validate->passes()){
                if($request->hasFile('file')) {
    
                    // Upload path
                    $destinationPath = 'files/';
                
                    // Get file extension
                    $extension = $request->file('file')->getClientOriginalExtension();
                    
                    // Rename file 
                    // $fileName = time().$request->file('file')->getClientOriginalName() .'.' . $extension;
                    $fileName = time().$request->file('file')->getClientOriginalName();

                    // Uploading file to given path
                    $request->file('file')->move($destinationPath, $fileName);
                    
                    return response()->json(['error' => false, 'message' => "Successfully uploaded a file.", "file" => $fileName]);
            
                }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()->all()]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function upload_my_file(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'file_name' => 'required',
            ));

            $new_file = $this->rename_file($request->input("file_name"), $request->input("sub_activity_name"), $request->input("sam_id"));

            \Storage::move( $request->input("file_name"), $new_file );

            // sub_activity_name
            if($validate->passes()){

                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'sub_activity_id' => $request->input("sub_activity_id"),
                    'value' => $new_file,
                    'user_id' => \Auth::id(),
                    'status' => "pending",
                ]);            
                
                return response()->json(['error' => false, 'message' => "Successfully uploaded a file."]);
            } else {
                return response()->json(['error' => true, 'message' => "Please upload a file."]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function rename_file($filename_data, $sub_activity_name, $sam_id)
    {
        $ext = pathinfo($filename_data, PATHINFO_EXTENSION);

        $file_name = strtolower($sam_id."-".str_replace(" ", "-", $sub_activity_name)).".".$ext;

        if (file_exists( public_path()."/files/".$file_name )) {

            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);

            $exploaded_name = explode("-", $withoutExt);

            if ( is_numeric( end( $exploaded_name) ) ) {
                $counter =  end( $exploaded_name) + "01";
            } else {
                $counter =  strtolower(str_replace(" ", "-", $sub_activity_name))."-01";
            }

            $imploded_name = implode("-", array_slice($exploaded_name, 0, -1));

            $new_file = $imploded_name . "-" . $counter . "." .$ext;

            while (file_exists( public_path()."/files/". $new_file)) {
                $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $new_file);

                $exploaded_name = explode("-", $withoutExt);

                if ( is_numeric( end( $exploaded_name) ) ) {
                    $counter =  end( $exploaded_name) + "01";
                } else {
                    $counter =  "01";
                }

                $imploded_name = implode("-", array_slice($exploaded_name, 0, -1));

                $new_file = $imploded_name . "-" . $counter . "." .$ext;
            }

            return $new_file = $new_file;

        } else {
            return $new_file = $file_name;
        }
    }

    public function add_ssds (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'site_name' => 'required',
                'lessor' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
            ));

            if ($validate->passes()) {

                $file = collect();
                for ($i=0; $i < count($request->input("file")); $i++) { 
                    $new_file = $this->rename_file($request->input("file")[$i], $request->input("sub_activity_name"), $request->input("sam_id"));
    
                    \Storage::move( $request->input("file")[$i], $new_file );

                    $file->push($new_file);
                }

                $json = array(
                    "site_name" => $request->input('site_name'),
                    "lessor" => $request->input('lessor'),
                    "address" => $request->input('address'),
                    "latitude" => $request->input('latitude'),
                    "longitude" => $request->input('longitude'),
                    "file" => $file,
                );

                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'type' => $request->input("type"),
                    'sub_activity_id' => $request->input("sub_activity_id"),
                    'value' => json_encode($json),
                    'user_id' => \Auth::id(),
                    'status' => "pending",
                ]);

                return response()->json(['error' => false, 'message' => "Successfully added sites." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function add_create_pr(Request $request)
    {
        try {
            
            $validate = Validator::make($request->all(), array(
                'pr_file' => 'required',
                'reference_number' => 'required',
            ));

            if($validate->passes()){

                $sub_activity = SubActivityValue::where('sam_id', $request->input("sam_id"))
                                                    ->where('sub_activity_id', $request->input("activity_id"))
                                                    ->where('type', "create_pr")
                                                    ->where('status', "pending")
                                                    ->first();

                SiteEndorsementEvent::dispatch($request->input('sam_id'));

                // $email_receiver = User::select('users.*')
                //                 ->join('user_details', 'users.id', 'user_details.user_id')
                //                 ->join('user_programs', 'user_programs.user_id', 'users.id')
                //                 ->join('program', 'program.program_id', 'user_programs.program_id')
                //                 ->where('user_details.vendor_id', $request->input('vendor'))
                //                 ->where('user_programs.program_id', $request->input('data_program'))
                //                 ->get();
                
                // for ($j=0; $j < count($email_receiver); $j++) { 
                //     $email_receiver[$j]->notify( new SiteEndorsementNotification($request->input('sam_id'), $request->input('activity_name'), "") );
                // }

                if (is_null($sub_activity)) {
                    $new_file = $this->rename_file($request->input("pr_file"), $request->input("activity_name"), $request->input("sam_id"));
    
                    \Storage::move( $request->input("pr_file"), $new_file );

                    $json = array(
                        "pr_file" => $new_file,
                        "reference_number" => $request->input('reference_number'),
                        "prepared_by" => $request->input('prepared_by'),
                        "vendor" => $request->input('vendor'),
                        "pr_date" => $request->input('pr_date'),
                        // "po_number" => $request->input('po_number'),
                    );
    
                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        // 'sub_activity_id' => $request->input("activity_id"),
                        'type' => "create_pr",
                        'value' => json_encode($json),
                        'user_id' => \Auth::id(),
                        'status' => "pending",
                    ]); 

                    \DB::connection('mysql2')->table("site")
                                                ->where("sam_id", $request->input("sam_id"))
                                                ->update([
                                                    'site_vendor_id' => $request->input('vendor'),
                                                    'site_pr' => $request->input('reference_number'),
                                                ]);
    
                    // a_update_data(SAM_ID, PROFILE_ID, USER_ID, true/false)
                    $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "'."true".'")');
    
                    return response()->json(['error' => false, 'message' => "Successfully created a PR."]);
                } else {
                    
                    $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "'."true".'")');

                    return response()->json(['error' => false, 'message' => "Successfully created a PR."]);
                }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function schedule_jtss(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'jtss_schedule' => 'required',
                'remarks' => 'required',
            ));

            // return response()->json(['error' => true, 'message' => json_encode($request->all()) ]);
            if ($validate->passes()) {
                $jtss_schedule_data = SubActivityValue::where('sam_id', $request->input('sam_id'))
                                                            ->where('type', 'jtss_schedule')
                                                            ->first();


                                                            
    
                SiteEndorsementEvent::dispatch($request->input('sam_id'));

                // $email_receiver = User::select('users.*')
                //                 ->join('user_details', 'users.id', 'user_details.user_id')
                //                 ->join('user_programs', 'user_programs.user_id', 'users.id')
                //                 ->join('program', 'program.program_id', 'user_programs.program_id')
                //                 ->where('user_details.vendor_id', $request->input('vendor'))
                //                 ->where('user_programs.program_id', $request->input('program_id'))
                //                 ->get();
                
                // for ($j=0; $j < count($email_receiver); $j++) { 
                //     $email_receiver[$j]->notify( new SiteEndorsementNotification($request->input('site_vendor_id'), $request->input('activity_name'), "") );
                // }

                if (is_null($jtss_schedule_data)) {

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'type' => "jtss_schedule",
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'status' => "pending",
                    ]); 

                    
                    // a_update_data(SAM_ID, PROFILE_ID, USER_ID, true/false)
                    $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');

                    return response()->json(['error' => false, 'message' => "Successfully scheduled JTSS." ]);
                } else {
                    
                    $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');

                    return response()->json(['error' => false, 'message' => "Successfully scheduled JTSS." ]);
                }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }


        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function approve_reject_pr (Request $request)
    {
        try {

            $data_action = $request->input('data_action') == "false" ? "denied" : "approved";

            SubActivityValue::where('id', $request->input('id'))
                            ->update([
                                'status' => $data_action,
                                'approver_id' => \Auth::id(),
                                'date_approved' => Carbon::now()->toDate(),
                            ]);

            SiteEndorsementEvent::dispatch($request->input('sam_id'));

            // $email_receiver = User::select('users.*')
            //                 ->join('user_details', 'users.id', 'user_details.user_id')
            //                 ->join('user_programs', 'user_programs.user_id', 'users.id')
            //                 ->join('program', 'program.program_id', 'user_programs.program_id')
            //                 ->where('user_details.vendor_id', $request->input('vendor'))
            //                 ->where('user_programs.program_id', $request->input('data_program'))
            //                 ->get();
            
            // for ($j=0; $j < count($email_receiver); $j++) { 
            //     $email_receiver[$j]->notify( new SiteEndorsementNotification($request->input('sam_id'), $request->input('activity_name'), $request->input('data_action')) );
            // }

            // a_update_data(SAM_ID, PROFILE_ID, USER_ID, true/false)
            // $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "'.$request->input('data_action').'")');

            if ($request->input('activity_name') != 'Vendor Awarding') {
                return response()->json(['error' => false, 'message' => "Successfully " .$data_action. " a PR."]);
            } else {
                return response()->json(['error' => false, 'message' => "Successfully awarded."]);
            }

        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_my_uploade_file(Request $request)
    {
        try {
            $sub_activity_files = SubActivityValue::where('sam_id', $request->input('sam_id'))
                                                        ->where('sub_activity_id', $request->input('sub_activity_id'))
                                                        ->where('user_id', \Auth::id())
                                                        ->orderBy('date_created', 'desc')
                                                        ->get();

            return response()->json(['error' => false, 'message' => $sub_activity_files]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_my_uploaded_site ($sub_activity_id, $sam_id)
    {
        try {
            $sub_activity_files = SubActivityValue::where('sam_id', $sam_id)
                                                        // ->where('sub_activity_id', $sub_activity_id)
                                                        ->where('user_id', \Auth::id())
                                                        ->where('type', "advanced_site_hunting")
                                                        ->orderBy('date_created', 'desc')
                                                        ->get();

            $dt = DataTables::of($sub_activity_files)
                                ->addColumn('sitename', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['site_name'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ->addColumn('lessor', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['lessor'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ->addColumn('address', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['address'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ->addColumn('latitude', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['latitude'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ->addColumn('longitude', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['longitude'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ;
            return $dt->make(true);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function set_approve_site (Request $request)
    {

        try {

            SubActivityValue::where('id', $request->input('id'))
                            ->update([
                                'status' => "approved",
                                'approver_id' => \Auth::id(),
                                'date_approved' => Carbon::now()->toDate(),
                            ]);

            SiteEndorsementEvent::dispatch($request->input('sam_id'));

            // $email_receiver = User::select('users.*')
            //                 ->join('user_details', 'users.id', 'user_details.user_id')
            //                 ->join('user_programs', 'user_programs.user_id', 'users.id')
            //                 ->join('program', 'program.program_id', 'user_programs.program_id')
            //                 ->where('user_details.vendor_id', $request->input('vendor_id'))
            //                 ->where('user_programs.program_id', $request->input('program_id'))
            //                 ->get();
            
            // for ($j=0; $j < count($email_receiver); $j++) { 
            //     $email_receiver[$j]->notify( new SiteEndorsementNotification($request->input('sam_id'), $request->input('activity_name'), "") );
            // }

            // a_update_data(SAM_ID, PROFILE_ID, USER_ID, true/false)
            $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');

            if ($request->input('activity_name') != 'Vendor Awarding') {
                return response()->json(['error' => false, 'message' => "Successfully approved a SSDS."]);
            } else {
                return response()->json(['error' => false, 'message' => "Successfully awarded."]);
            }

        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_my_site($sub_activity_id, $sam_id)
    {
        try {
            $sub_activity_files = SubActivityValue::where('sam_id', $sam_id)
                                                        ->where('sub_activity_id', $sub_activity_id)
                                                        ->where('user_id', \Auth::id())
                                                        ->orderBy('date_created', 'desc')
                                                        ->get();

            $dt = DataTables::of($sub_activity_files)
                                ->addColumn('sitename', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['site_name'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ->addColumn('lessor', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['lessor'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ->addColumn('address', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['address'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ->addColumn('latitude', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['latitude'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ->addColumn('longitude', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['longitude'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ;
            return $dt->make(true);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function get_datatable_columns($program_id, $table_name, $profile_id)
    {
        
        $cols = \DB::connection('mysql2')
                    ->table("table_fields")
                    ->where('program_id', $program_id)
                    ->where('table_name', $table_name)
                    ->orderBy('field_sort', 'asc')
                    ->get();

        return $cols;

    }

    public function get_doc_validations($program_id)
    {
        $sites = \DB::connection('mysql2')
                    ->table("view_doc_validation")
                    ->get();

        $dt = DataTables::of($sites);
        return $dt->make(true);
            
    }

    // public function doc_validation_approvals($id, $action)
    public function doc_validation_approvals(Request $request)
    {
        try {
            $required = "";
            if ($request->input('action') == "rejected") {
                $required = "required";
            }

            $validate = Validator::make($request->all(), array(
                'reason' => $required
            ));

            if ($validate->passes()) {
                SubActivityValue::where('id', $request->input('id'))->update([
                    'status' => $request->input('action') == "rejected" ? "denied" : "approved",
                    'reason' => $request->input('action') == "rejected" ? $request->input('reason') : null,
                    'approver_id' => \Auth::id(),
                ]);

                $sub_activity_files = SubActivityValue::find($request->input('id'));
                $user = User::find($sub_activity_files->user_id);

                // $email_receiver = User::select('users.*')
                //                 ->join('user_details', 'users.id', 'user_details.user_id')
                //                 ->join('user_programs', 'user_programs.user_id', 'users.id')
                //                 ->where('user_details.vendor_id', $request->input('site_vendor_id'))
                //                 ->where('user_programs.program_id', $request->input('program_id'))
                //                 ->get();
                            
                // SiteEndorsementEvent::dispatch($request->input('sam_id'));

                // for ($j=0; $j < count($email_receiver); $j++) { 
                //     $email_receiver[$j]->notify( new SiteEndorsementNotification($request->input('sam_id'), "document_approval", $request->input('action'), "", $request->input('filename'), $request->input('reason')) );
                // }

                return response()->json(['error' => false, 'message' => "Successfully ".$request->input('action')." docs." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()->all() ]);
            }

        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_site_approvals($program_id, $profile_id)
    {
        $sites = \DB::connection('mysql2')
                    ->table("site_milestone")
                    ->select("program_id, sam_id, stage_name, activity_name, activity_type, activity_complete, profile_id, stage_id, pending_count, site_name, site_fields, site_agent")
                    ->where('program_id', $program_id)
                    ->where('activity_complete', 'false')
                    ->where('profile_id', $profile_id)
                    ->get();

        $dt = DataTables::of($sites);
        return $dt->make(true);
            
    }

    public function get_localcoop($program_id, $profile_id, $activity_type)
    {
        if($activity_type == 'all'){
            $sites = \DB::connection('mysql2')
            ->table("local_coop")
            ->select(
                'region', 
                'id', 
                'prioritization_tagging', 
                'endorsement_tagging', 
                'coop_name',
                'coop_full_name',
                'province'
            )
            ->get();
        }

        $dt = DataTables::of($sites);
        return $dt->make(true);

    }

    public function get_localcoop_details($coop)
    {
        $coop_details = \DB::connection('mysql2')
            ->table("local_coop")
            ->select(
                'region', 
                'id', 
                'prioritization_tagging', 
                'endorsement_tagging', 
                'coop_name',
                'coop_full_name',
                'province'
            )
            ->where('coop_name', $coop)
            ->get();

        return $coop_details;
    }

    public function get_localcoop_values($coop, $type)
    {
        $coop_values = \DB::connection('mysql2')
                            ->table("local_coop_values")
                            ->join('users', 'local_coop_values.user_id', 'users.id')
                            ->where('coop', $coop)
                            ->where('type', $type)
                            ->get();

        return $coop_values;
    }

    public function get_localcoop_values_data($coop, $type)
    {
        $coop_values = \DB::connection('mysql2')
                            ->table("local_coop_values")
                            ->join('users', 'local_coop_values.user_id', 'users.id')
                            ->where('coop', $coop)
                            ->where('type', $type)
                            ->orderBy('add_timestamp', 'desc')
                            ->get();

        if ($type == "contacts") {
            $dt = DataTables::of($coop_values)
                ->addColumn('type', function($row){
                    return json_decode($row->value)->contact_type;
                })
                ->addColumn('firstname', function($row){
                    return json_decode($row->value)->firstname;
                })
                ->addColumn('lastname', function($row){
                    return json_decode($row->value)->lastname;
                })
                ->addColumn('cellphone', function($row){
                    return json_decode($row->value)->contact_number;
                })
                ->addColumn('email', function($row){
                    return json_decode($row->value)->email;
                })
                ->addColumn('action', function($row){
                    $button = "<button class='btn btn-sm btn-primary btn-shadow edit_contact' data-action='edit' title='Edit' data-id='".$row->ID."'><i class='pe-7s-pen'></i></button>";
                    $button .= "<button class='btn btn-sm btn-danger btn-shadow delete_contact' data-action='delete' title='Delete' data-id='".$row->ID."'><i class='pe-7s-trash'></i></button>";
                    
                    return $button;
                });

            $dt->rawColumns(['action']);

        } else if ($type == "engagements") {
            $dt = DataTables::of($coop_values)
                ->addColumn('engagement_type', function($row){
                    return json_decode($row->value)->engagement_type;
                })
                ->addColumn('result_of_engagement', function($row){
                    return json_decode($row->value)->result_of_engagement;
                })
                ->addColumn('remarks', function($row){
                    return json_decode($row->value)->remarks;
                });
        } else if ($type == "issues") {
            $dt = DataTables::of($coop_values)
                ->addColumn('dependency', function($row){
                    return json_decode($row->value)->dependency;
                })
                ->addColumn('nature_of_issue', function($row){
                    return json_decode($row->value)->nature_of_issue;
                })->addColumn('description', function($row){
                    return json_decode($row->value)->description;
                })
                ->addColumn('issue_raised_by', function($row){
                    return json_decode($row->value)->issue_raised_by;
                })
                ->addColumn('issue_raised_by_name', function($row){
                    return json_decode($row->value)->issue_raised_by_name;
                })
                ->addColumn('date_of_issue', function($row){
                    return json_decode($row->value)->date_of_issue;
                })
                ->addColumn('issue_assigned_to', function($row){
                    return json_decode($row->value)->issue_assigned_to;
                })
                ->addColumn('status_of_issue', function($row){
                    return json_decode($row->value)->status_of_issue;
                });
        }

        return $dt->make(true);
    }

    public function get_site_milestones($program_id, $profile_id, $activity_type)
    {
        
        if($activity_type == 'all'){
            $sites = \DB::connection('mysql2')
            ->table("site_milestone")
            ->distinct()
            ->where('program_id', $program_id)
            ->where('activity_complete', 'false')
            ->get();
        }

        elseif($activity_type == 'mine'){

            $sites = \DB::connection('mysql2')
            ->table("site_milestone")
            ->distinct()
            ->where('program_id', $program_id)
            ->where('activity_complete', 'false')
            ->where("site_agent_id", \Auth::id())
            ->get();

            // return \Auth::user()->profile_id;
        }

        elseif($activity_type == 'mine_completed'){

            $sites = \DB::connection('mysql2')
            ->table("milestone_tracking")
            ->distinct()
            ->where('program_id', $program_id)
            ->where('activity_complete', 'true')
            ->where("site_agent_id", \Auth::id())
            ->get();

            // return \Auth::user()->profile_id;
        }

        elseif($activity_type == 'is'){

            $sites = \DB::connection('mysql2')
            ->table("site_milestone")
            ->distinct()
            ->where('program_id', $program_id)
            ->where('activity_complete', 'false')
            ->where("site_IS_id", \Auth::id())
            ->where("profile_id", "2")
            ->get();

        }

        elseif($activity_type == 'vendor'){

            $sites = \DB::connection('mysql2')
            ->table("site_milestone")
            ->distinct()
            ->where('program_id', $program_id)
            ->where('activity_complete', 'false')
            ->where("profile_id", "2")
            ->get();

        }

        elseif($activity_type == 'set site value'){

            $sites = \DB::connection('mysql2') 
                    ->table("milestone_tracking")
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_type', 'set site value')
                    ->where('profile_id', \Auth::user()->profile_id)
                    ->where('activity_complete', 'false')
                    ->get();

        }

        elseif($activity_type == 'rtb declaration'){

            $sites = \DB::connection('mysql2') 
                    ->table("milestone_tracking")
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_type', 'rtb declaration')
                    ->where('activity_complete', 'false')
                    ->where('profile_id', \Auth::user()->profile_id)
                    ->get();

        }

        elseif($activity_type == 'site approval'){

            // if (\Auth::user()->profile_id == 9 || \Auth::user()->profile_id == 10 || \Auth::user()->profile_id == 6 || \Auth::user()->profile_id == 7 ) {
                $sites = \DB::connection('mysql2') 
                                ->table("milestone_tracking")
                                ->where('program_id', $program_id)
                                ->whereIn('activity_type', ['doc approval', 'site approval'])
                                ->where('profile_id', \Auth::user()->profile_id)
                                ->where('activity_complete', 'false')
                                ->get();
            // } else {
            //     $sites = \DB::connection('mysql2') 
            //                 ->table("milestone_tracking")
            //                 ->distinct()
            //                 ->where('program_id', $program_id)
            //                 ->where('activity_type', 'site approval')
            //                 ->where('profile_id', \Auth::user()->profile_id)
            //                 ->where('activity_complete', 'false')
            //                 ->get();
            // }

        }


        elseif($activity_type == 'doc validation'){

            $sites = \DB::connection('mysql2')
                    ->table("view_for_doc_validation")
                    ->select('sam_id', 'site_name', 'site_fields', 'counter')
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_complete', 'false')
                    ->where('counter', '>', 0)
                    ->get();

        }
        elseif($activity_type == 'new endorsements globe'){

            $sites = \DB::connection('mysql2') 
                    ->table("milestone_tracking")
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_type', 'endorsement')
                    ->where('profile_id', \Auth::user()->profile_id)
                    ->where('activity_complete', 'false')
                    ->get();
        }
        elseif($activity_type == 'new endorsements vendor'){
            
            $sites = \DB::connection('mysql2') 
                    ->table("milestone_tracking")
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_type', 'endorsement')
                    ->where('profile_id', \Auth::user()->profile_id)
                    ->where('activity_complete', 'false')
                    ->get();
        }

        elseif($activity_type == 'unassigned sites'){
            
            $sites = \DB::connection('mysql2') 
                    ->table("milestone_tracking")
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_type', 'unassigned site')
                    ->where('profile_id', \Auth::user()->profile_id)
                    ->get();

        } else if ($activity_type == 'all-site-issues') {
            // $sites = \DB::connection('mysql2')
            //     ->table("site")
            //     ->leftjoin('site_issue', 'site.sam_id', 'issue.sam_id')
            //     ->where('site.program_id', $program_id)
            //     ->get();

            $sites = \DB::connection('mysql2')
                ->table("site_issue")
                ->leftjoin('site', 'site.sam_id', 'site_issue.sam_id')
                ->join('issue_type', 'issue_type.issue_type_id', 'site_issue.issue_type_id')
                ->where('site.program_id', $program_id)
                // ->where('site_issue.issue_status', 'active')
                ->whereNull('site_issue.date_resolve')
                ->get();

                // dd($sites);
        }

        else {

            $sites = \DB::connection('mysql2')
                    ->table("milestone_tracking")
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_complete', 'false')
                    ->where('profile_id', $profile_id)
                    ->where('activity_type', $activity_type)
                    ->get();

        }

        $dt = DataTables::of($sites);
        return $dt->make(true);
            
    }

    public function get_site_doc_validation($program_id, $profile_id, $activity_type)
    {
        $sites = \DB::connection('mysql2')
                    ->table("site_milestone")
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_complete', 'false')
                    ->where('pending_count', '>', 0)
                    ->get();

        $dt = DataTables::of($sites);
        return $dt->make(true);
            
    }

    public function sub_activity_view($sam_id, $sub_activity, $sub_activity_id, $program_id)
    {

        if($sub_activity == 'Add SSDS'){

            $what_component = "components.subactivity-ssds";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
            ])
            ->render();

        }
        elseif($sub_activity == 'Lessor Negotiation' || $sub_activity == 'LESSOR ENGAGEMENT'){

            $what_component = "components.subactivity-lessor-engagement";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
            ])
            ->render();
            
        }
        elseif($sub_activity == 'LESSOR ENGAGEMENT'){

            $what_component = "components.subactivity-lessor-engagement";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
            ])
            ->render();
            
        }
        elseif($sub_activity == 'Set Approved Site'){

            $what_component = "components.subactivity-set-approved-site";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
            ])
            ->render();
            
        }
        elseif($sub_activity == 'Set Site Category'){

            $what_component = "components.set-site-category";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
            ])
            ->render();
            
        }
        else {

            $what_component = "components.subactivity-doc-upload";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
            ])
            ->render();
        }

    }

    public function modal_view_site_components($sam_id, $component)
    {
        try{
            
            if($component == 'site-status'){

                $what_modal = "components.site-status";           
                return \View::make($what_modal)
                        ->with([
                            'sam_id' => $sam_id,
                            'site_name' => "test",
                        ])        
                        ->render();
     
            } 
            elseif($component == 'agent-activities'){

                $what_modal = "components.agent-activity-list";      
                return \View::make($what_modal)
                        ->render();
          
            } 
            elseif($component == 'agent-progress'){

                $what_modal = "components.site-progress";      
                return \View::make($what_modal)
                        ->render();
          
            } 
            elseif($component == 'tab-content-activities'){

                $what_modal = "components.site-activities";      
                return \View::make($what_modal)
                        ->with([
                            'sam_id' => $sam_id,
                            'site_name' => "test",
                        ])
                        ->render();
          
            } 
            elseif($component == 'tab-content-files'){

                $what_modal = "components.site-files";      
                return \View::make($what_modal)
                        ->with([
                            'sam_id' => $sam_id,
                        ])
                        ->render();
          
            } 
            elseif($component == 'site-modal-site_fields'){

                $sites = \DB::connection('mysql2')
                ->table("site_milestone")
                ->select('site_fields')
                ->distinct()
                ->where('sam_id', $sam_id)
                ->where('activity_complete', 'false')
                ->get();

                // dd($sites[0]->site_fields);
                

                $what_modal = "components.site-fields";      
                return \View::make($what_modal)
                        ->with([
                            'sam_id' => $sam_id,
                            'sitefields' => json_decode($sites[0]->site_fields),
                        ])
                        ->render();
          
            } 

        


        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    
    public function get_all_docs(Request $request)
    {
        // return "test";
        $documents = array("RTB Docs Validation", "RTB Docs Approval", "PAC Approval");
        $doc_preview_main_activities = array("Document Validation");
        $site_view_main_actiivities = array("Program Sites", "Assigned Sites");
        $rtb = array("RTB Declaration", "RTB Declaration Approval");
        $vendor_profiles = array(2, 3);

        // dd( $request->all() );
        try {
            $site = \DB::connection('mysql2')
                    ->table('site_milestone')
                    ->distinct()
                    ->where('sam_id', '=', $request['sam_id'])
                    ->where('activity_complete', "=", 'false')
                    ->get();

            $site_fields = json_decode($site[0]->site_fields);

            if($request['main_activity'] == "doc_validation"){
                $mainactivity = "Document Validation";
            // } else if($request['main_activity'] == "Program Sites" && $request['program_id'] == 1){
            //     $mainactivity = "";
            } else {
                $mainactivity = $request['main_activity'];
            }

            // $rtbdeclaration = RTBDeclaration::where('sam_id', $request['sam_id'])->where('status', 'pending')->first();

            $rtbdeclaration = SubActivityValue::where('sam_id', $request->input('sam_id'))
                                        ->where('status', "pending")
                                        ->where('type', "rtb_declaration")
                                        ->first();

            $pr = SubActivityValue::select('users.name', 'sub_activity_value.*')
                                    ->join('users', 'users.id', 'sub_activity_value.user_id')
                                    ->where('sub_activity_value.sam_id', $request->input('sam_id'))
                                    // ->where('sub_activity_value.status', "pending")
                                    ->where('sub_activity_value.type', "create_pr")
                                    ->first();

            if($request['vendor_mode']){
                
                $what_modal = "components.modal-vendor-activity";

                return \View::make($what_modal)
                ->with([
                    'site' => $site,
                    'sam_id' => $request['sam_id'],
                    'site_fields' => $site_fields,
                    'rtbdeclaration' => $rtbdeclaration,
                    'activity_id' => $request['activity_id'],
                    // 'main_activity' => $request['main_activity'],
                    'main_activity' => $mainactivity,
                ])
                ->render();

            } else {

                $what_modal = "components.modal-view-site";

                return \View::make($what_modal)
                ->with([
                    'site' => $site,
                    'pr' => $pr,
                    'sam_id' => $request['sam_id'],
                    'site_fields' => $site_fields,
                    'rtbdeclaration' => $rtbdeclaration,
                    'main_activity' => $mainactivity,
                ])
                ->render();
    
            }




        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }



        // if(in_array( $request['main_activity'], $doc_preview_main_activities )){

        //     try {
        //         $site = \DB::connection('mysql2')
        //                 ->table('site_milestone')
        //                 ->distinct()
        //                 ->where('sam_id', '=', $request['sam_id'])
        //                 ->where('activity_complete', "=", 'false')
        //                 ->get();

        //         $site_fields = json_decode($site[0]->site_fields);

        //         if($request['main_activity'] == "doc_validation"){
        //             $mainactivity = "Document Validation";
        //         }

        //         return \View::make('components.modal-document-preview')
        //             ->with([
        //                 'site' => $site,
        //                 'sam_id' => $request['sam_id'],
        //                 'site_fields' => $site_fields,
        //                 'main_activity' => $request['main_activity']
        //             ])

        //             // ->with(['file_list' => $data,  'mode'=>$request['mode'],  'activity'=>$request['activity'],  'site'=>$request['site']])
        //             ->render();

        //         // return response()->json(['error' => false, 'message' => $data ]);

        //     } catch (\Throwable $th) {
        //         return response()->json(['error' => true, 'message' => $th->getMessage()]);
        //     }

        

        // }

        // elseif(in_array( $request['main_activity'], $site_view_main_actiivities )){

        //     // VIEW SITE MAKER
        //     try{

        //         $site = \DB::connection('mysql2')
        //         ->table('site_milestone')
        //         ->distinct()
        //         ->where('activity_complete', "=", 'false')
        //         ->where('sam_id', "=", $request['sam_id'])
        //         ->get();

        //         $site_fields = json_decode($site[0]->site_fields);

        //         return \View::make('components.modal-view-site')
        //                 ->with([
        //                     'site' => $site,
        //                     'sam_id' => $request['sam_id'],
        //                     'site_fields' => $site_fields,
        //                     'main_activity' => $request['main_activity']
        //                 ])
        //                 ->render();


        //     } catch (\Throwable $th) {
        //         return response()->json(['error' => true, 'message' => $th->getMessage()]);
        //     }


        // }
        
        // else {

        //     if((in_array($request['activity'], $documents) && in_array(\Auth::user()->profile_id, $vendor_profiles) == false)){

        //         try {
        //             $site = \DB::connection('mysql2')
        //                     ->table('site_milestone')
        //                     ->distinct()
        //                     ->where('sam_id', '=', $request['sam_id'])
        //                     ->where('activity_complete', "=", 'false')
        //                     ->get();
    
        //             $site_fields = json_decode($site[0]->site_fields);
    
        //             return \View::make('components.modal-document-preview')
        //                 ->with([
        //                     'site' => $site,
        //                     'sam_id' => $request['sam_id'],
        //                     'site_fields' => $site_fields,
        //                     'main_activity' => $request['main_activity']
        //                 ])
    
        //                 // ->with(['file_list' => $data,  'mode'=>$request['mode'],  'activity'=>$request['activity'],  'site'=>$request['site']])
        //                 ->render();
    
        //             // return response()->json(['error' => false, 'message' => $data ]);
    
        //         } catch (\Throwable $th) {
        //             return response()->json(['error' => true, 'message' => $th->getMessage()]);
        //         }
        //     }
    
        //     elseif(in_array($request['activity'], $rtb) && in_array(\Auth::user()->profile_id, $vendor_profiles) == false){
    
        //         try{
    
        //             return \View::make('components.modal-site-rtb')
        //                     ->with(['mode'=>$request['mode'],  'activity'=>$request['activity'],  'site'=>$request['site']])
        //                     ->render();
    
    
        //         } catch (\Throwable $th) {
        //             return response()->json(['error' => true, 'message' => $th->getMessage()]);
        //         }
    
    
        //     } 
            
        //     else {


        //         // VIEW SITE MAKER
        //         try{
    
        //             $site = \DB::connection('mysql2')
        //             ->table('site_milestone')
        //             ->distinct()
        //             ->where('activity_complete', "=", 'false')
        //             ->where('sam_id', "=", $request['sam_id'])
        //             ->get();
    
        //             $site_fields = json_decode($site[0]->site_fields);
    
        //             return \View::make('components.modal-view-site')
        //                     ->with([
        //                         'site' => $site,
        //                         'sam_id' => $request['sam_id'],
        //                         'site_fields' => $site_fields,
        //                         'main_activity' => $request['main_activity']

        //                     ])
        //                     ->render();
    
    
        //         } catch (\Throwable $th) {
        //             return response()->json(['error' => true, 'message' => $th->getMessage()]);
        //         }
    
        //     }
    

        // }


    }

    public function get_site_issues ($issue_id, $what_table) 
    {
        try {

            $site = \DB::connection('mysql2')
                            ->table('site_issue')
                            ->join('issue_type', 'issue_type.issue_type_id', 'site_issue.issue_type_id')
                            ->where('site_issue.issue_id', $issue_id)
                            ->first();

            $what_modal = "components.site-issue-validation";

            return response()->json(['error' => false, 'site' => $site  ]);

            // return \View::make($what_modal)
            // ->with([
            //     'site' => $site,
            //     'main_activity' => "Issue Validation",
            //     'what_table' => $what_table,
            //     'issue_id' => $issue_id,
            // ])
            // ->render();
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function resolve_issues($issue_id)
    {
        try {
            $site = \DB::connection('mysql2')
                            ->table('site_issue')
                            ->where('issue_id', $issue_id)
                            ->update([
                                'date_resolve' => Carbon::now()->toDate(),
                                'approver_id' => \Auth::id(),
                            ]);

            
            return response()->json(['error' => false, 'message' => "Successfully resolve an issue." ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function approve_reject_docs($data_id, $data_action)
    {
        try {
            SubActivityValue::where('id', $data_id)
                            ->update([
                                'status' => $data_action,
                                'approver_id' => \Auth::id(),
                                'date_approved' => Carbon::now()->toDate(),
                            ]);

            return response()->json(['error' => false, 'message' => "Successfully " .$data_action. "."]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_issue($issue_name)
    {
        try {
            $issue_type = IssueType::where('issue_type', $issue_name)->get();
            return response()->json(['error' => false, 'message' => $issue_type ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function add_issue(Request $request)
    {
        try {
            // return response()->json(['error' => true, 'message' => $request->all() ]);

            

            $validate = Validator::make($request->all(), array(
                'issue_type' => 'required',
                'issue' => 'required',
                'issue_details' => 'required'
            ));

            if($validate->passes()){
                $issue_type = Issue::create([
                    'issue_type_id' => $request->input('issue'),
                    'sam_id' => $request->input('hidden_sam_id'),
                    'start_date' => $request->input('start_date'),
                    'issue_details' => $request->input('issue_details'),
                    'issue_status' => "active",
                    'user_id' => \Auth::id(),
                ]);
                return response()->json(['error' => false, 'message' => "Successfully added issue." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }

            
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_my_issue($sam_id)
    {
        try {
            // if (\Auth::user()->profile_id == 2) {
            //     $data = Issue::join('issue_type', 'issue_type.issue_type_id', 'site_issue.issue_type_id')
            //                         ->join('users', 'users.id', 'site_issue.user_id')
            //                         ->where('site_issue.user_id', \Auth::id())
            //                         ->where('site_issue.sam_id', $sam_id)
            //                         ->get();
            // } else if (\Auth::user()->profile_id == 3) {
            //     $agents = \DB::connection('mysql2')
            //                             ->table('users')
            //                             ->select('users.id')
            //                             ->join('user_details', 'user_details.user_id', 'users.id')
            //                             ->where('user_details.IS_id', \Auth::user()->id)
            //                             ->get();

            //     $array_id = collect();

            //     foreach ($agents as $agent) {
            //         $array_id->push($agent->id);
            //     }
                
            //     $data = Issue::join('issue_type', 'issue_type.issue_type_id', 'site_issue.issue_type_id')
            //                     ->join('users', 'users.id', 'site_issue.user_id')
            //                     ->whereIn('site_issue.user_id', $array_id->all())
            //                     ->where('site_issue.sam_id', $sam_id)
            //                     ->get();
            // } else {
                $data = Issue::join('issue_type', 'issue_type.issue_type_id', 'site_issue.issue_type_id')
                                ->join('users', 'users.id', 'site_issue.user_id')
                                ->where('site_issue.user_id', \Auth::id())
                                ->where('site_issue.sam_id', $sam_id)
                                ->get();
            // }

            $dt = DataTables::of($data);

            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function get_issue_details($issue_id)
    {
        try {
            $data = IssueType::join('site_issue', 'site_issue.issue_type_id', 'issue_type.issue_type_id')
                            ->where('site_issue.issue_id', $issue_id)
                            ->first();
                            
            return response()->json(['error' => false, 'message' => $data ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function cancel_issue($issue_id)
    {
        try {
            Issue::where('issue_id', $issue_id)
                        ->update([
                            'issue_status' => "cancelled"
                        ]);

            return response()->json(['error' => false, 'message' => "Successfully cancelled issue." ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function chat_send(Request $request)
    {
        try {
            $chat = Chat::create([
                'sam_id' => $request->input('sam_id'),
                'user_id' => \Auth::id(),
                'comment' => $request->input('comment'),
            ]);

            $chat_data = Chat::join('users', 'users.id', 'chat.user_id')
                                ->join('profiles', 'profiles.id', 'users.profile_id')
                                ->where('chat.id', $chat->id)
                                ->first();

            return response()->json(['error' => false, 'message' => "Successfully send a message.", "chat" => $chat_data ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function declare_rtb(Request $request)
    {
        try {

            $validate = \Validator::make($request->all(), array(
                'rtb_declaration_date' => 'required',
                'rtb_declaration' => 'required',
            ));

            if ($validate->passes()){

                $rtb = SubActivityValue::where('sam_id', $request->input('sam_id'))
                                        ->where('user_id', \Auth::id())
                                        ->where('status', "pending")
                                        ->where('type', "rtb_declaration")
                                        ->first();

                // $email_receiver = User::select('users.*')
                //             ->join('user_details', 'users.id', 'user_details.user_id')
                //             ->join('user_programs', 'user_programs.user_id', 'users.id')
                //             ->where('user_details.vendor_id', $request->input('site_vendor_id'))
                //             ->where('user_programs.program_id', $request->input('program_id'))
                //             ->get();
                        
                // SiteEndorsementEvent::dispatch($request->input('sam_id'));

                // for ($j=0; $j < count($email_receiver); $j++) { 
                //     $email_receiver[$j]->notify( new SiteEndorsementNotification($request->input('sam_id'), $request->input('activity_name'), "") );
                // }

                if (is_null($rtb)){

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'status' => "pending",
                        'type' => "rtb_declaration",
                    ]); 

                    // a_update_data(SAM_ID, PROFILE_ID, USER_ID, true/false)
                    $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');
                    
                    return response()->json(['error' => false, 'message' => "Successfully declared RTB."]); 
                } else {
                    
                    $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');
                    
                    return response()->json(['error' => false, 'message' => "Successfully declared RTB."]); 
                }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function approve_reject_rtb (Request $request)
    {
        try {
            $required = "";
            if ($request->input('action') == "false" ) {
                $required = "required";
            }
            
            $validate = \Validator::make($request->all(), array(
                'remarks' => $required,
            ));

            if ($validate->passes()) {

                $rtb = SubActivityValue::where('sam_id', $request->input('sam_id'))
                                        ->where('type', "rtb_declaration")
                                        ->update([
                                            'status'=> $request->input('action') == "false" ? "denied" : "approved",
                                            'reason'=> $request->input('remarks'),
                                            'approver_id'=> \Auth::id(),
                                        ]);

                // $email_receiver = User::select('users.*')
                //         ->join('user_details', 'users.id', 'user_details.user_id')
                //         ->join('user_programs', 'user_programs.user_id', 'users.id')
                //         ->where('user_details.vendor_id', $request->input('site_vendor_id'))
                //         ->where('user_programs.program_id', $request->input('program_id'))
                //         ->get();
                        
                // SiteEndorsementEvent::dispatch($request->input('sam_id'));

                // for ($j=0; $j < count($email_receiver); $j++) { 
                //     $email_receiver[$j]->notify( new SiteEndorsementNotification($request->input('sam_id'), "rtb_declation_approval", $request->input('action'), "", "", $request->input('remarks') ));
                // }

                return response()->json(['error' => false, 'message' => "Successfully approved RTB."]); 

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_my_uploade_file_data($sub_activity_id, $sam_id)
    {
        try {

            if (\Auth::user()->getUserProfile()->id == 3) {
                $user_to_gets = UserDetail::where('IS_id', \Auth::id())->get();

                $array_id = collect();

                foreach ($user_to_gets as $user_to_get) {
                    $array_id->push($user_to_get->user_id);
                }
            } else {
                $array_id = collect(\Auth::id());
            }
            $sub_activity_files = SubActivityValue::where('sam_id', $sam_id)
                                                        ->where('sub_activity_id', $sub_activity_id)
                                                        // ->whereNull('type')
                                                        ->whereIn('user_id', $array_id)
                                                        ->orderBy('date_created', 'desc')
                                                        ->get();

            $dt = DataTables::of($sub_activity_files)
                                ->addColumn('value', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['lessor_remarks'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ->addColumn('method', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['lessor_method'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                });
            return $dt->make(true);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function get_engagement($sub_activity_id, $sam_id)
    {
        try {

            if (\Auth::user()->getUserProfile()->id == 3) {
                $user_to_gets = UserDetail::where('IS_id', \Auth::id())->get();

                $array_id = collect();

                foreach ($user_to_gets as $user_to_get) {
                    $array_id->push($user_to_get->user_id);
                }
            } else {
                $array_id = collect(\Auth::id());
            }
            $sub_activity_files = SubActivityValue::where('sam_id', $sam_id)
                                                        // ->where('sub_activity_id', $sub_activity_id)
                                                        ->where('type', 'lessor_engagement')
                                                        ->whereIn('user_id', $array_id)
                                                        ->whereJsonContains("value", [
                                                            "sub_activity_id" => $sub_activity_id
                                                        ])
                                                        ->orderBy('date_created', 'desc')
                                                        ->get();

            $dt = DataTables::of($sub_activity_files)
                                ->addColumn('value', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['lessor_remarks'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ->addColumn('method', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['lessor_method'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                });
            return $dt->make(true);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function save_engagement(Request $request)
    {
        try {

            $validate = Validator::make($request->all(), array(
                "lessor_approval" => "required",
                "lessor_remarks" => "required",
            ));

            // return response()->json(['error' => true, 'message' => json_encode($request->all()) ]);

            if ($validate->passes()) {
                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'sub_activity_id' => !is_null($request->input("log")) ? null : $request->input("sub_activity_id"),
                    'value' => json_encode($request->all()),
                    'user_id' => \Auth::id(),
                    'status' => $request->input('lessor_approval'),
                    'type' => 'lessor_engagement',
                ]); 

                // $email_receiver = User::select('users.*')
                //                 ->join('user_details', 'users.id', 'user_details.user_id')
                //                 ->join('user_programs', 'user_programs.user_id', 'users.id')
                //                 ->where('user_details.vendor_id', $request->input('site_vendor_id'))
                //                 ->where('user_programs.program_id', $request->input('program_id'))
                //                 ->get();
                            
                // SiteEndorsementEvent::dispatch($request->input('sam_id'));

                // for ($j=0; $j < count($email_receiver); $j++) { 
                //     $email_receiver[$j]->notify( new SiteEndorsementNotification($request->input('sam_id'), "lessor_approval", "", $request->input('site_name')) );
                // }

                return response()->json(['error' => false, 'message' => "Successfully saved engagement."]);

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_agent_based_program($program_id)
    {
        try {
            $agents = \DB::connection('mysql2')
                                        ->table('users')
                                        ->select('users.*')
                                        ->join('user_details', 'user_details.user_id', 'users.id')
                                        ->join('user_programs', 'user_programs.user_id', 'users.id')
                                        ->where('user_details.IS_id', \Auth::user()->id)
                                        ->where('user_programs.program_id', $program_id)
                                        ->get();
            

            return response()->json(['error' => false, 'message' => $agents ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function agent_based_program($program_id)
    {
        try {
            $agents = \DB::connection('mysql2')
                                        ->table('users')
                                        ->select('users.*')
                                        ->join('user_programs', 'user_programs.user_id', 'users.id')
                                        ->where('user_programs.program_id', $program_id)
                                        ->get();
            

            return response()->json(['error' => false, 'message' => $agents ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function add_coop_value (Request $request)
    {
        try { 
            if ($request->input('action') == 'engagements') {
                $validate = Validator::make($request->all(), array(
                    'coop' => 'required',
                    'engagement_type' => 'required',
                    'result_of_engagement' => 'required',
                    'remarks' => 'required',
                ));

                $array = array(
                    'engagement_type' => $request->input('engagement_type'),
                    'result_of_engagement' => $request->input('result_of_engagement'),
                    'remarks' => $request->input('remarks'),
                );

                $coop = $request->input('coop');

                $message = "Successfuly added engagements.";
            } else if ($request->input('action') == 'contacts') {
                $validate = Validator::make($request->all(), array(
                    'coop' => 'required',
                    'contact_number' => 'required',
                    'contact_type' => 'required',
                    'email' => 'required | email',
                    'firstname' => 'required',
                    'lastname' => 'required',
                ));

                $array = array(
                    'contact_type' => $request->input('contact_type'),
                    'firstname' => $request->input('firstname'),
                    'lastname' => $request->input('lastname'),
                    'contact_number' => $request->input('contact_number'),
                    'email' => $request->input('email'),
                );

                $coop = $request->input('coop');

                $message = "Successfuly added contacts.";

                if (!is_null($request->input('ID'))) {
                    LocalCoopValue::where('ID', $request->input('ID'))
                    ->update([
                        'coop' => $coop,
                        'type' => $request->input('action'),
                        'value' => json_encode($array),
                        'user_id' => \Auth::id(),
                    ]);

                    $message = "Successfuly updated contacts.";

                    return response()->json(['error' => false, 'message' => $message ]);
                }
            } else if ($request->input('action') == 'issues') {
                $validate = Validator::make($request->all(), array(
                    'coop' => 'required',
                    'date_of_issue' => 'required',
                    'dependency' => 'required',
                    'description' => 'required',
                    'issue_assigned_to' => 'required',
                    'issue_raised_by' => 'required',
                    'issue_raised_by_name' => 'required',
                    'nature_of_issue' => 'required',
                    'status_of_issue' => 'required',
                ));

                $array = array(
                    'dependency' => $request->input('dependency'),
                    'nature_of_issue' => $request->input('nature_of_issue'),
                    'description' => $request->input('description'),
                    'issue_raised_by' => $request->input('issue_raised_by'),
                    'issue_raised_by_name' => $request->input('issue_raised_by_name'),
                    'date_of_issue' => $request->input('date_of_issue'),
                    'issue_assigned_to' => $request->input('issue_assigned_to'),
                    'status_of_issue' => $request->input('status_of_issue'),
                );

                $coop = $request->input('coop');

                $message = "Successfuly added issue.";
            } else if ($request->input('action') == 'issue_history') {
                $validate = Validator::make($request->all(), array(
                    // 'date_history' => 'required',
                    'remarks' => 'required',
                    'status_of_issue' => 'required',
                ));

                $coop_data = LocalCoopValue::where('ID', $request->input('issue_id') )->first();

                $array_update = array(
                    'dependency' => json_decode($coop_data->value)->dependency,
                    'nature_of_issue' => json_decode($coop_data->value)->nature_of_issue,
                    'description' => json_decode($coop_data->value)->description,
                    'issue_raised_by' => json_decode($coop_data->value)->issue_raised_by,
                    'issue_raised_by_name' => json_decode($coop_data->value)->issue_raised_by_name,
                    'date_of_issue' => json_decode($coop_data->value)->date_of_issue,
                    'issue_assigned_to' => json_decode($coop_data->value)->issue_assigned_to,
                    'status_of_issue' => $request->input('status_of_issue'),
                );

                LocalCoopValue::where('ID', $request->input('issue_id') )
                                ->update([
                                    'value' => json_encode($array_update),
                                ]);

                $array = array(
                    'id' => $request->input('issue_id'),
                    // 'date_history' => $request->input('date_history'),
                    'user_id' => $request->input('user_id'),
                    'remarks' => $request->input('remarks'),
                    'status_of_issue' => $request->input('status_of_issue'),
                );

                $coop = $coop_data->coop;

                $message = "Successfuly added history.";
            }


            if ($validate->passes()) {
                LocalCoopValue::create([
                    'coop' => $coop,
                    'type' => $request->input('action'),
                    'value' => json_encode($array),
                    'user_id' => \Auth::id(),
                ]);
    
                return response()->json(['error' => false, 'message' => $message ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function issue_history_data($id)
    {
        try {

            $history = LocalCoopValue::where('type', 'issue_history')
                                        ->whereJsonContains('value', ['id' => $id ])
                                        ->orderBy('add_timestamp', 'desc')
                                        ->get();

            $dt = DataTables::of($history)
                        ->addColumn('staff', function($row){
                            $user = User::find(json_decode($row->value)->user_id);
                            return $user->name;
                        })
                        ->addColumn('remarks', function($row){
                            return json_decode($row->value)->remarks;
                        })
                        ->addColumn('status', function($row){
                            return json_decode($row->value)->status_of_issue;
                        });
            
            // $dt->rawColumns(['checkbox', 'technology']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function get_contact($id, $action)
    {
        try {
            $contact = LocalCoopValue::where('type', 'contacts')
                                            ->where('ID', $id)
                                            ->first();
            
            return response()->json(['error' => false, 'message' => $contact ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function get_my_sub_act_value($sub_activity_id, $sam_id)
    {
        try {

            $sub_activity_id = SubActivityValue::where('sub_activity_id', $sub_activity_id)
                                        ->where('sam_id', $sam_id)
                                        ->get();

            $dt = DataTables::of($sub_activity_id);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function set_site_category(Request $request)
    {
        try {

            // SiteEndorsementEvent::dispatch($request->input('sam_id'));

            // if ( !is_null(\Auth::user()->getUserDetail()->first()) ) {
            //     $vendor = \Auth::user()->getUserDetail()->first()->vendor_id;

            //     $email_receiver = User::select('users.*')
            //                     ->join('user_details', 'users.id', 'user_details.user_id')
            //                     ->join('user_programs', 'user_programs.user_id', 'users.id')
            //                     ->join('program', 'program.program_id', 'user_programs.program_id')
            //                     ->where('user_details.vendor_id', $vendor)
            //                     ->where('user_programs.program_id', $request->input('data_program'))
            //                     ->get();
                
            //     for ($j=0; $j < count($email_receiver); $j++) { 
            //         $email_receiver[$j]->notify( new SiteEndorsementNotification($request->input('sam_id'), $request->input('activity_name'), "true") );
            //     }
            // }
            
            $profile_id = \Auth::user()->profile_id;
            $id = \Auth::id();
            
            \DB::connection('mysql2')->table("site")
                                    ->where("sam_id", $request->input("sam_id"))
                                    ->update([
                                        'site_category' => $request->input('site_category'),
                                    ]);
                                              
            $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.$profile_id.', '.$id.', "true")');

            return response()->json(['error' => false, 'message' => "Successfully set site category."]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_user_data ($user_id, $vendor_id, $is)
    {
        try {
            $vendor_program = VendorProgram::join('program', 'program.program_id', 'vendor_programs.programs')
                                                ->where('vendor_programs.vendors_id', $vendor_id)
                                                ->get();

            $user_data = UserProgram::select('program_id')->where('user_id', $user_id)->get();

            $supervisor = User::select('users.*')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
                                    ->where('vendor_id', $vendor_id)
                                    ->where('designation', 3)
                                    ->get();

            return response()->json(['error' => false, 'user_data' => $user_data, 'vendor_program' => $vendor_program, 'supervisor' => $supervisor ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function update_user_data(Request $request)
    {
        try {
            
            // return response()->json(['error' => true, 'message' => $request->all()]);

            UserProgram::where('user_id', $request->input('user_id'))
                                                ->delete();  

            for ($i=0; $i < count($request->input('program')); $i++) { 
                UserProgram::create([
                    'user_id' => $request->input('user_id'),
                    'program_id' => $request->input('program')[$i],
                ]);
            }

            $supervisor = UserDetail::where('user_id', $request->input('user_id'))
                                    ->update([
                                        'IS_id' => $request->input('is_id')
                                    ]);

            return response()->json(['error' => false, 'message' => "Successfully updated data." ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_supervisor ($user_id, $vendor_id)
    {
        try {
            $supervisor = User::select('users.*')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
                                    ->where('vendor_id', $vendor_id)
                                    ->where('designation', 3)
                                    ->get();

            return response()->json(['error' => false, 'supervisor' => $supervisor ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }
    
    public function change_supervisor($user_id, $is_id)
    {
        try {
            $supervisor = UserDetail::where('user_id', $user_id)
                                    ->update([
                                        'IS_id' => $is_id
                                    ]);

            return response()->json(['error' => false, 'message' => "Successfully changed supervisor." ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_site_issue_remarks($issue_id)
    {
        try {
            $issue_remakrs = \DB::connection('mysql2')
                                        ->table('site_issue_remarks')
                                        ->where('site_issue_id', $issue_id)
                                        ->get();

            $dt = DataTables::of($issue_remakrs);
            
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function add_remarks(Request $request)
    {
        try {
            $validate = \Validator::make($request->all(), array(
                'remarks' => 'required',
                'date_engage' => 'required',
            ));

            if ($validate->passes()) {
                IssueRemark::create($request->all());
                Issue::where('issue_id', $request->input('site_issue_id'))
                        ->update([
                            'issue_status' => $request->input('status'),
                        ]);
                return response()->json(['error' => false, 'message' => "Successfully added remarks."]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function subactivity_step($sub_activity_id, $sam_id, $sub_activity)
    {
        try {
            // $substeps = \DB::connection('mysql2')->table('sub_activity_step')->where('sub_activity_id', $sub_activity_id)->get();
            $substeps = \Auth::user()->subactivity_step($sub_activity_id);

            $what_component = "components.site-sub-step";
            return \View::make($what_component)
            ->with([
                'substeps' => $substeps,
                'sam_id' => $sam_id,
                'sub_activity' => $sub_activity
            ])
            ->render();
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function submit_subactivity_step(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                "date" => "required",
                "remarks" => "required",
            ));

            if ($validate->passes()) {
                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'value' => json_encode($request->all()),
                    'user_id' => \Auth::id(),
                    'type' => "substep",
                    'status' => "approved",
                ]); 

                return response()->json([ 'error' => false, 'message' => "Successfully saved." ]);
            } else {
                return response()->json([ 'error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_fiancial_analysis ($sam_id)
    {
        try {
            $sites = \DB::connection('mysql2')
                            ->table('new_sites')
                            ->where('sam_id', $sam_id)
                            ->first();

            return response()->json([ 'error' => false, 'message' => $sites ]);
            
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function add_pr_po(Request $request)
    {
        try {
            // $file= public_path() . "/files/1623380277user_details.csv";

            // $headers = array(
            //         'Content-Type: application/pdf',
            //     );

            // return \Response::download($file, 'filename.pdf', $headers);

            $validate = \Validator::make($request->all(), array(
                'budget_source' => 'required',
                'date_created' => 'required',
                'department' => 'required',
                'division' => 'required',
                'from' => 'required',
                'group' => 'required',
                'recommendation' => 'required',
                'requested_amount' => 'required',
                'subject' => 'required',
                'thru' => 'required',
                'to' => 'required',
            ));
            if ($validate->passes()) {

                $array_data = array(
                    'budget_source' => $request->input("budget_source"),
                    'date_created' => $request->input("date_created"),
                    'department' => $request->input("department"),
                    'division' => $request->input("division"),
                    'from' => $request->input("from"),
                    'group' => $request->input("group"),
                    'recommendation' => $request->input("recommendation"),
                    'requested_amount' => $request->input("requested_amount"),
                    'subject' => $request->input("subject"),
                    'thru' => $request->input("thru"),
                    'to' => $request->input("to"),
                );

                for ($i=0; $i < count($request->input("sam_id")); $i++) { 
                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id")[$i],
                        'value' => json_encode($array_data),
                        'user_id' => \Auth::id(),
                        'type' => "create_pr_po",
                        'status' => "approved",
                    ]);
                }
                
                return response()->json([ 'error' => false, 'message' => "Successfully added PR / PO." ]);
            } else {
                return response()->json([ 'error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function print_to_pdf_pr_po (Request $request)
    {
        try {
            // $request->input("budget_source"),
            // $request->input("date_created"),
            // $request->input("department"),
            // $request->input("division"),
            // $request->input("from"),
            // $request->input("group"),
            // $request->input("recommendation"),
            // $request->input("requested_amount"),
            // $request->input("subject"),
            // $request->input("thru"),
            // $request->input("to")

            $html = '<b>To: </b> '.$request->input("to") ."<br>";
            $html .= '<b>Thru: </b> '.$request->input("thru") ."<br>";
            $html .= '<b>From: </b> '.$request->input("from") ."<br>";
            $html .= '<b>Division: </b> '.$request->input("division") ."<br>";
            $html .= '<b>Subject: </b> '.$request->input("subject") ."<br>";
            $html .= '<b>Reqested Amount: </b> '.$request->input("requested_amount") ."<br>";
            $html .= '<b>Date Created: </b> '.$request->input("date_created") ."<br>";
            $html .= '<b>Group: </b> '.$request->input("group") ."<br>";
            $html .= '<b>Department: </b> '.$request->input("department") ."<br>";
            $html .= '<b>Budget Source: </b> '.$request->input("budget_source") ."<br>";
            $html .= '<b>Recommendation: </b> '.$request->input("recommendation") ."<br><br><br>";

            $html .= '<table class="table">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th style="width: 20%">Sam ID</th>';
            // $html .= '<th style="width: 40%">Searching Name</th>';
            // $html .= '<th>Region</th>';
            // $html .= '<th>Province</th>';
            // $html .= '<th style="width: 10%">Gross Amount PHP (VAT EXCLUSIVE)</th>';

            $html .= '<tbody>';
            for ($i=0; $i < count($request->input("sam_id")); $i++) { 
                $html .= '<tr>';
                $html .= '<td>'.$request->input("sam_id")[$i].'</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';

            $pdf = \App::make('dompdf.wrapper');
            $pdf = PDF::loadHTML($html);
            $pdf->setPaper('a4');
            
            return $pdf->stream();

        } catch (\Throwable $th) {
            abort(403, $th->getMessage());
        }
    }

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
                $sites = \DB::connection('mysql2')
                ->table("towerco")
                ->where('TOWERCO', 'CREI')
                ->get();
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
        }
        elseif($who == 'agile'){

            $allowed_fields = [
                ['field' => 'TSSR STATUS', 'field_type' => 'select', 'selection' => ['SUBMITTED', 'NOT YET SUBMITTED']],
                ['field' => 'Tower Co TSSR Submission Date to GT', 'field_type' => 'date'],	
                ['field' => 'TSSR APPROVED DATE', 'field_type' => 'date'],	
                ['field' => 'RFI DATE APPROVED (TEMPO POWER)', 'field_type' => 'date'],	
                ['field' => 'RFI DATE APPROVED (PERMANENT POWER)', 'field_type' => 'date'],	
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
                if($allowed_field['field']==$col){

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

                    break;
                }
            }

            $details .= '
                    <div class="row border-bottom mb-1 pb-1">
                        <div class="col-md-4">
                            ' . $col . '
                        </div>
                        <div class="col-md-8">
                            <input type="text" value="' . $value . '" class="form-control" readonly>
                        </div>
                    </div>            
            ';
        }

        $actor .="</form>";


        return response()->json([ 'error' => false, 'details' => $details, 'actor' => $actor ]);


    }

    public function get_towerco_multi($who)
    {
        if($who == 'towerco'){

            $allowed_fields = [
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
        }
        elseif($who == 'agile'){

            $allowed_fields = [
                ['field' => 'TSSR STATUS', 'field_type' => 'select', 'selection' => ['SUBMITTED', 'NOT YET SUBMITTED']],
                ['field' => 'Tower Co TSSR Submission Date to GT', 'field_type' => 'date'],	
                ['field' => 'TSSR APPROVED DATE', 'field_type' => 'date'],	
                ['field' => 'RFI DATE APPROVED (TEMPO POWER)', 'field_type' => 'date'],	
                ['field' => 'RFI DATE APPROVED (PERMANENT POWER)', 'field_type' => 'date'],	
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

            \DB::table('towerco_logs')->insert([
                'Serial Number' => 'kayla@example.com',
                'field' => '',
                'old_value' => '',
                'new_value' => '',
            ]);

            return response()->json([ 'error' => false, 'message' => "Successfully updated site", 'db' => \DB::getQueryLog() ]);    


        } catch (\Throwable $th) {

            return response()->json(['error' => true, 'message' => $th->getMessage()]);

        }

    }


    public function TowerCoExport()
    {
        return Excel::download(new TowerCoExport, 'towerco.xlsx');
    }

}

