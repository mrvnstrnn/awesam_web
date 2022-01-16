<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use Carbon;

use App\Events\SiteEndorsementEvent;
use App\Models\SubActivityValue;
use App\Models\SiteStageTracking;
use App\Models\Site;
use Log;

use Illuminate\Http\Request;

class NewSitesController extends Controller
{
    public function ibs_get_site_by_activity_id($activity_id)
    {
        
        try {
            $data = \DB::table('view_site')
                        ->where('program_id', 4)
                        ->whereIn('activity_id', [  $activity_id ])
                        ->get();

            $dt = DataTables::of($data);
     
            return $dt->make(true);

        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }   
    }


    public function get_site_by_activity_id($activity_id)
    {
        
        try {
            $data = \DB::table('view_site')
                        ->where('program_id', 1)
                        ->whereIn('activity_id', [  $activity_id ])
                        ->get();

            $dt = DataTables::of($data);
     
            return $dt->make(true);

        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }   
    }


    public function schedule_jtss(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                $request->input('activity_name') => 'required',
                'remarks' => 'required',
            ));

            if ($validate->passes()) {
                
                // $jtss_schedule_data = SubActivityValue::where('sam_id', $request->input('sam_id'))
                //                                             ->where('type', $request->input('activity_name'))
                //                                             ->first();
                                                            
    
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

                // if (is_null($jtss_schedule_data)) {

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'type' => $request->input('activity_name'),
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'status' => "pending",
                    ]); 

                    if ($request->input('activity_name') == "jtss_schedule") {
                        $message_info = "Successfully scheduled JTSS.";
                    } else {
                        $message_info = "Successfully scheduled site.";
                        $this->move_site([$request->input("sam_id")], $request->input("program_id"), "true", [$request->input("site_category")], [$request->input("activity_id")]);
                    }

                    
                    // a_update_data(SAM_ID, PROFILE_ID, USER_ID, true/false)
                    // $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');

                    return response()->json(['error' => false, 'message' => $message_info ]);
                // } else {

                //     if ($request->input('activity_name') == "jtss_schedule") {
                //         $message_info = "Successfully scheduled JTSS.";
                //     } else {
                //         $message_info = "Successfully scheduled site.";
                //         $this->move_site([$request->input("sam_id")], $request->input("program_id"), "true", [$request->input("site_category")], [$request->input("activity_id")]);
                //     }
                    
                //     // $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');

                //     return response()->json(['error' => false, 'message' => $message_info ]);
                // }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }


        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_my_scheduled_jtss ($sam_id)
    {
        try {
            $data = SubActivityValue::where('sam_id', $sam_id)->where('type', 'jtss_schedule')->get();

            $dt = DataTables::of($data)
                                ->addColumn('remarks', function($row){
                                    return json_decode($row->value, true)['remarks'];      
                                })->addColumn('jtss_schedule', function($row){
                                    return date('M d, Y', strtotime( json_decode($row->value, true)['jtss_schedule'] ));                           
                                })
                                ->addColumn('status_sched', function($row){
                                    return strtoupper(json_decode($row->value, true)['status']);                           
                                })
                                ->addColumn('date_created', function($row){
                                    return date('M d, Y h:m:s:a', strtotime( $row->date_created, true ));                           
                                });
            
            return $dt->make(true);

        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }   
    }

    public function confirm_schedule (Request $request)
    {
        try {
            SubActivityValue::where('id', $request->input('id'))
                                ->update([
                                    'status' => "approved",
                                    'approver_id' => \Auth::id(),
                                    'date_approved' => Carbon::now()->toDate(),
                                ]);

            $this->move_site($request->input("sam_id"), $request->input("program_id"), "true", $request->input("site_category"), $request->input("activity_id"));
            
            return response()->json(['error' => false, 'message' => "Successfully confirmed schedule."]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    
    // NEWSIES PR-PO COUNTER VIA AJAX
    public function get_pr_po_counter()
    {
        try {
            $counters = \DB::select(
                'call milestones_newsites()'
            );
    
            return response()->json(['error' => false, 'message' => $counters]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }

    }

    //moving site
    private function move_site($sam_id, $program_id, $action, $site_category, $activity_id)
    {
        for ($i=0; $i < count($sam_id); $i++) {


            $get_past_activities = \DB::table('site_stage_tracking')
                                    ->where('sam_id', $sam_id[$i])
                                    ->where('activity_complete', 'false')
                                    ->get();
                                    
            if (count($get_past_activities) < 1) {
                // SiteStageTracking::create([
                //     'sam_id' => $sam_id[$i],
                //     'activity_id' => 1,
                //     'activity_complete' => 'false',
                //     'user_id' => \Auth::id()
                // ]);
                
                $site_check = \DB::table('site')
                                ->where('sam_id',  $sam_id[$i])
                                ->first();

                if ( is_null($site_check->activities) ) {
                    SiteStageTracking::create([
                        'sam_id' => $sam_id[$i],
                        'activity_id' => 1,
                        'activity_complete' => 'false',
                        'user_id' => \Auth::id()
                    ]);
                } else {
                    SiteStageTracking::create([
                        'sam_id' => $sam_id[$i],
                        'activity_id' => 1,
                        'activity_complete' => 'true',
                        'user_id' => \Auth::id()
                    ]);
                    
                    SiteStageTracking::create([
                        'sam_id' => $sam_id[$i],
                        'activity_id' => $activity_id[$i],
                        'activity_complete' => 'false',
                        'user_id' => \Auth::id()
                    ]);
                }

                $get_past_activities = \DB::table('site_stage_tracking')
                                    ->where('sam_id', $sam_id[$i])
                                    ->where('activity_complete', 'false')
                                    ->get();
            }

            $past_activities = collect();

            for ($j=0; $j < count($get_past_activities); $j++) {
                $past_activities->push($get_past_activities[$j]->activity_id);
            }
            
            if ( in_array($activity_id[$i] == null || $activity_id[$i] == "null" || $activity_id[$i] == "undefined" ? 1 : $activity_id[$i], $past_activities->all()) ) {
                $activities = \DB::table('stage_activities')
                                ->select('next_activity', 'activity_name', 'return_activity')
                                ->where('activity_id', $activity_id[$i] == null || $activity_id[$i] == "null" || $activity_id[$i] == "undefined" ? 1 : $activity_id[$i])
                                ->where('program_id', $program_id)
                                ->where('category', is_null($site_category[$i]) || $site_category[$i] == "null" ? "none" : $site_category[$i])
                                ->first();
                                     
                if (!is_null($activities)) {
                    if ($action == "true") {
                        $get_activitiess = \DB::table('stage_activities')
                                                ->select('next_activity', 'activity_name', 'profile_id', 'activity_id')
                                                ->where('activity_id', $activities->next_activity)
                                                ->where('program_id', $program_id)
                                                ->where('category', is_null($site_category[$i]) || $site_category[$i] == "null" ? "none" : $site_category[$i])
                                                ->first();

                        $activity_name = $get_activitiess->activity_name;

                        $activity = $get_activitiess->activity_id;

                        SiteStageTracking::where('sam_id', $sam_id[$i])
                                                ->where('activity_complete', 'false')
                                                ->where('activity_id', $activity_id[$i] == null || $activity_id[$i] == "null" || $activity_id[$i] == "undefined" ? 1 : $activity_id[$i])
                                                ->update([
                                                    'activity_complete' => "true"
                                                ]);

                        $check_if_added = \DB::table('site_stage_tracking')
                                            ->select('sam_id')
                                            ->where('sam_id', $sam_id[$i])
                                            ->where('activity_id', $activity)
                                            ->where('activity_complete', 'false')
                                            ->get();

                        if ( count($check_if_added) < 1 ) {
                            SiteStageTracking::create([
                                'sam_id' => $sam_id[$i],
                                'activity_id' => $activity,
                                'activity_complete' => 'false',
                                'user_id' => \Auth::id()
                            ]);
                        }


                    } else {

                        $activity = $activities->return_activity;

                        $get_activitiess = \DB::table('stage_activities')
                                        ->select('next_activity', 'activity_name', 'profile_id', 'activity_id')
                                        ->where('activity_id', $activity)
                                        ->where('program_id', $program_id)
                                        ->where('category', is_null($site_category[$i]) || $site_category[$i] == "null" ? "none" : $site_category[$i])
                                        ->first();

                        $activity_name = $get_activitiess->activity_name;

                        SiteStageTracking::where('sam_id', $sam_id[$i])
                                                ->update([
                                                    'activity_complete' => "true"
                                                ]);

                        SiteStageTracking::create([
                            'sam_id' => $sam_id[$i],
                            'activity_id' => $activity,
                            'activity_complete' => 'false',
                            'user_id' => \Auth::id()
                        ]);
                    }

                    $get_stage_activity = \DB::table('stage_activities')
                                                ->select('stage_id')
                                                ->where('activity_id', $activity)
                                                ->where('program_id', $program_id)
                                                ->where('category', $site_category[0])
                                                ->first();

                    if (!is_null($get_stage_activity)) {
                        $get_program_stages = \DB::table('program_stages')
                                                ->select('stage_name')
                                                ->where('stage_id', $get_stage_activity->stage_id)
                                                ->where('program_id', $program_id)
                                                ->first();
                    }

                    $array = array(
                        'stage_id' => !is_null($get_stage_activity) ? $get_stage_activity->stage_id : "",
                        'stage_name' => !is_null($get_program_stages) ? $get_program_stages->stage_name : "",
                        'activity_id' => $activity,
                        'activity_name' => $activity_name,
                        'profile_id' => $get_activitiess->profile_id,
                        'category' => is_null($site_category[$i]) || $site_category[$i] == "null" ? "none" : $site_category[$i],
                        'activity_created' => Carbon::now()->toDateString(),
                    );

                    Site::where('sam_id', $sam_id[$i])
                    ->update([
                        'activities' => json_encode($array)
                    ]);
                }
            }
        }

        // //////////////////////////// //
        //                              //   
        //     NOTIFICATION SYSTEM      //
        //                              //
        // //////////////////////////// //


        $site_count = count($sam_id);
        if($action == 'true'){
            $action_id = 1;
        } else {
            $action_id = 0;
        }

        $notification_settings = \DB::table('notification_settings')
                                    ->where('program_id', $program_id[0])
                                    ->where('activity_id', $activity_id[0])
                                    ->where('action', $action_id)
                                    ->first();

        if (!is_null($notification_settings)) {
            $notification_receiver_profiles = \DB::table('notification_receiver_profiles')
                        ->select('profile_id')
                        ->where('notification_settings_id', $notification_settings->notification_settings_id)
                        ->get();


            $receiver_profiles = json_decode(json_encode($notification_receiver_profiles), true);


            if($site_count > 1){
            $title = $notification_settings->title_multi;
            $body = str_replace("<count>", $site_count, $notification_settings->body_multi);

            } else {
            $title = $notification_settings->title_single;
            $body = $notification_settings->body_single;
            }

            $userSchema = User::whereIn("profile_id", $receiver_profiles)
                ->get();                            

            foreach($userSchema as $user){

            $notifData = [
            'user_id' => $user->id,
            'program_id' => $program_id,                
            'site_count' => $site_count,
            'action' => $action,
            'activity_id' => $activity_id,
            'title' => $title,	
            'body' => $body,
            'goUrl' => url('/'),
            ];

            Notification::send($user, new SiteMoved($notifData));

            }   
        }

        // ///////////////////////////// //
        //                               //   
        //   END NOTIFICATION SYSTEM     //
        //                               //
        // ///////////////////////////// //



    }

    public function get_jtss_site_table ($sam_id)
    {
        try {
            $data = SubActivityValue::where('sam_id', $sam_id)
                                            ->where('type', 'jtss_add_site')
                                            ->get();
                                    
            $dt = DataTables::of($data)
                                ->addColumn('site_name', function($row){
                                    // dd($row->value);
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        // return $json['site_name'];
                                        return $json['address'];
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
                                ->addColumn('latitude', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['latitude'];
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
                                ->addColumn('longitude', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return $json['longitude'];
                                    } else {
                                        return $row->value;  
                                    }                      
                                })
                                ->addColumn('rank', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);
                                        
                                        return isset($json['rank_number']) ? $json['rank_number'] : "Not yet ranked.";
                                    } else {
                                        return $row->value;  
                                    }                      
                                });
            
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function view_jtss_site ($id)
    {
        try {
            $data = SubActivityValue::where('id', $id)
                                        ->where('type', 'jtss_add_site')
                                        ->first();

                                                        
            return response()->json(['error' => false, 'message' => json_decode($data->value), 'sam_id' => $data->sam_id, 'id' => $data->id ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function set_rank_site (Request $request)
    {
        try {
            $count_data = SubActivityValue::select('sam_id')
                                        ->where('sam_id', $request->input('sam_id'))
                                        ->where('type', 'jtss_add_site')
                                        ->get();

            $validate = Validator::make($request->all(), array(
                'rank_number' => ['required', 'numeric', 'min:1', 'max:'.count($count_data) ]
            ));

            if ($validate->passes()) {
                $data = SubActivityValue::where('sam_id', $request->input('sam_id'))
                                        ->where('type', 'jtss_add_site')
                                        ->whereJsonContains('value', [
                                            'rank_number' => $request->input('rank_number')
                                        ])
                                        ->first();

                $get_data = SubActivityValue::where('id', $request->input('id'))
                                        ->where('sam_id', $request->input('sam_id'))
                                        ->where('type', 'jtss_add_site')
                                        ->first();

                if ( is_null($data) ) {

                    $json = json_decode($get_data->value);

                    $array = array(
                        'site_name' => $json->site_name,
                        'lessor' => $json->lessor,
                        'address' => $json->address,
                        'latitude' => $json->latitude,
                        'longitude' => $json->longitude,
                        'file' => $json->file,
                        'rank_number' => $request->input('rank_number'),
                    );

                    SubActivityValue::where('id', $request->input('id'))
                                        ->update([
                                            'value' => json_encode($array)
                                        ]);


                    $jtss_sites = SubActivityValue::select('sam_id')
                                        ->where('sam_id', $request->input('sam_id'))
                                        ->where('type', 'jtss_add_site')
                                        ->get();

                    $jtss_sites_json = SubActivityValue::select('sam_id')
                                                        ->where('sam_id', $request->input('sam_id'))
                                                        ->where('type', 'jtss_add_site')
                                                        ->where('value->rank_number', '!=', 'null')
                                                        ->get();

                    $done = count($jtss_sites) == count($jtss_sites_json);

                    return response()->json(['error' => false, 'message' => "Successfully set a rank.", 'done' => $done ]);
                } else {
                    $json = json_decode($data->value);
                    if ($request->input('id') == $data->id) {
                        $array = array(
                            'site_name' => $json->site_name,
                            'lessor' => $json->lessor,
                            'address' => $json->address,
                            'latitude' => $json->latitude,
                            'longitude' => $json->longitude,
                            'file' => $json->file,
                            'rank_number' => $request->input('rank_number'),
                        );

                        SubActivityValue::where('id', $request->input('id'))
                                        ->update([
                                            'value' => json_encode($array)
                                        ]);

                                        $jtss_sites = SubActivityValue::select('sam_id')
                                        ->where('sam_id', $request->input('sam_id'))
                                        ->where('type', 'jtss_add_site')
                                        ->get();

                        $jtss_sites_json = SubActivityValue::select('sam_id')
                                                            ->where('sam_id', $request->input('sam_id'))
                                                            ->where('type', 'jtss_add_site')
                                                            ->where('value->rank_number', '!=', 'null')
                                                            ->get();

                        $done = count($jtss_sites) == count($jtss_sites_json);

                        return response()->json(['error' => false, 'message' => "Successfully set a rank.", 'done' => $done ]);
                    } else {
                        return response()->json(['error' => true, 'message' => "This rank already exist on " . $json->site_name ]);
                    }
                    
                }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }
}
