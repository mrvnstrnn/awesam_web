<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use App\Models\SiteStageTracking;
use App\Models\Site;

use DataTables;
use Notification;

use App\Notifications\SiteMoved;
use App\Notifications\AgentMoveSite;

class FTTHController extends Controller
{
    private function move_site($sam_id, $program_id, $action, $site_category, $activity_id, $remarks = null)
    {
        for ($i=0; $i < count($sam_id); $i++) {

            $get_past_activities = \DB::table('site_stage_tracking')
                                    ->where('sam_id', $sam_id[$i])
                                    ->where('activity_complete', 'false')
                                    ->get();

            if (count($get_past_activities) < 1) {
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
                    } else {
                        $get_program_stages = NULL;
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
                                    ->where('program_id', $program_id)
                                    ->where('activity_id', is_null($activity_id[0]) || $activity_id[0] == 'null' ? 1 : $activity_id[0])
                                    ->where('category', $site_category[0])
                                    ->where('action', $action_id)
                                    ->first();

        if (!is_null($notification_settings)) {

            $notification_receiver_profiles = \DB::table('notification_receiver_profiles')
                                            ->select('profile_id')
                                            ->where('notification_settings_id', $notification_settings->notification_settings_id)
                                            ->get()
                                            ->pluck('profile_id');

            $receiver_profiles = $notification_receiver_profiles;

            for ($i=0; $i < count($sam_id); $i++) {
                $site_data = \DB::table('site')
                                ->select('site_name', 'site_vendor_id')
                                ->where('sam_id', $sam_id[$i])
                                ->first();

                $site_users = \DB::table('site_users')
                                ->where('sam_id', $sam_id[$i])
                                ->first();

                if($site_count > 1){
                    $title = $notification_settings->title_multi;
                    $body = str_replace("<count>", $site_count, $notification_settings->body_multi);
                } else {
                    $title = $notification_settings->title_single;

                    if ( is_null($site_data) ) {
                        $site_name = $sam_id[$i];
                    } else {
                        $site_name = $site_data->site_name;
                    }

                    if ( $action == "true" ) {
                        $body = str_replace("<site>", $site_name, $notification_settings->body_single);
                    } else {
                        $body_rejected = str_replace("<site>", $site_name, $notification_settings->body_single);
                        $body = str_replace("<reason>", $remarks, $body_rejected);
                    }
                }

                for ($x=0; $x < count($receiver_profiles); $x++) { 

                    if ( $receiver_profiles[$x] == 2 ) {
    
                        if ( !is_null($site_users) ) {
                            $user_agent = User::find($site_users->agent_id);
                            if ( !is_null($user_agent) ) {
                                
                                $notifDataForAgent = [
                                    'user_id' => $site_users->agent_id,
                                    'program_id' => $program_id,
                                    'site_count' => $site_count,
                                    'action' => $action,
                                    'activity_id' => $activity_id,
                                    'title' => $title,	
                                    'body' => $body,
                                    'goUrl' => url($notification_settings->notification_url),
                                ];
                                Notification::send($user_agent, new SiteMoved($notifDataForAgent));
                            }
                        }
                    } else {
                        if ( $receiver_profiles[$x] == 1 || $receiver_profiles[$x] == 2 || $receiver_profiles[$x] == 3 || $receiver_profiles[$x] == 4 || $receiver_profiles[$x] == 5 ) {
                            $userSchema = User::select('users.*', 'user_details.vendor_id')
                                    ->join('user_programs', 'user_programs.user_id', 'users.id')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
    
                                    ->where("user_programs.program_id", $program_id)
    
                                    ->where("profile_id", $receiver_profiles[$x])
                                    ->where('user_details.vendor_id', $site_data->site_vendor_id)
                                    ->get();
                        } else {
                            $userSchema = User::select('users.*', 'user_details.vendor_id')
                                    ->join('user_programs', 'user_programs.user_id', 'users.id')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
    
                                    ->where("user_programs.program_id", $program_id)
    
                                    ->where("profile_id", $receiver_profiles[$x])
                                    ->where('user_programs.program_id', $program_id)
                                    ->get();
                        }
    
                        foreach($userSchema as $user){
                            $notifData = [
                                'user_id' => $user->id,
                                'program_id' => $program_id,
                                'site_count' => $site_count,
                                'action' => $action,
                                'activity_id' => $activity_id,
                                'title' => $title,	
                                'body' => $body,
                                'goUrl' => url($notification_settings->notification_url),
                            ];
                            
                            Notification::send($user, new SiteMoved($notifData));
                        }
                    }
                }

                $site_data = \DB::table('site')
                    ->select('site_name')
                    ->where('sam_id', $sam_id[$i])
                    ->first();

                if ( is_null($site_data) ) {
                    $site_name = $sam_id[$i];
                } else {
                    $site_name = $site_data->site_name;
                }

                if ( !is_null($site_users) ) {
                    $user_agent = User::find($site_users->agent_id);
                    if ( !is_null($user_agent) ) {

                        if ( $action == "true" ) {
                            $body_agent = "Your site has been moved to " . $activity_name;
                        } else {
                            $body_agent = "Your site has been rejected. Reason: ".$remarks;
                        }
                        
                        $notifDataForAgent = [
                            'user_id' => $site_users->agent_id,
                            'program_id' => $program_id,
                            'action' => $action,
                            'activity_id' => $activity_id,
                            'title' => "Site Update for " .$site_name,	
                            'body' => $body_agent,
                            'goUrl' => url('/program-sites'),
                        ];
                        Notification::send($user_agent, new AgentMoveSite($notifDataForAgent));
                    }
                }
            }
            // End of Loop
        }

        // ///////////////////////////// //
        //                               //   
        //   END NOTIFICATION SYSTEM     //
        //                               //
        // ///////////////////////////// //



    }

    public function get_partial_rtb_declaration (Request $request)
    {
        try {
            $sub_activity_value = \DB::table('sub_activity_value')
                            ->where('sam_id', $request->get('sam_id'))
                            ->where('type', 'rtb_declaration_partial')
                            ->where('status', $request->get('status'))
                            ->get();

            $dt = DataTables::of($sub_activity_value)
                        ->addColumn('afi_lines', function($row){
                            json_decode($row->value);
                            if (json_last_error() == JSON_ERROR_NONE){
                                $json = json_decode($row->value, true);

                                return $json['afi_lines'];
                            } else {
                                return $row->value;
                            }
                        })
                        ->addColumn('afi_type', function($row){
                            json_decode($row->value);
                            if (json_last_error() == JSON_ERROR_NONE){
                                $json = json_decode($row->value, true);

                                return $json['afi_type'];
                            } else {
                                return $row->value;
                            }
                        })
                        ->addColumn('rtb_declaration_date', function($row){
                            json_decode($row->value);
                            if (json_last_error() == JSON_ERROR_NONE){
                                $json = json_decode($row->value, true);

                                return $json['rtb_declaration_date'];
                            } else {
                                return $row->value;
                            }
                        })
                        ->addColumn('solution', function($row){
                            json_decode($row->value);
                            if (json_last_error() == JSON_ERROR_NONE){
                                $json = json_decode($row->value, true);

                                return $json['solution'];
                            } else {
                                return $row->value;
                            }
                        });

            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }
}
