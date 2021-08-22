<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use Carbon;

use App\Events\SiteEndorsementEvent;
use App\Models\SubActivityValue;
use App\Models\SiteStageTracking;
use App\Models\Site;

use Illuminate\Http\Request;

class NewSitesController extends Controller
{
    public function schedule_jtss(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                $request->input('activity_name') => 'required',
                'remarks' => 'required',
            ));

            if ($validate->passes()) {
                
                $jtss_schedule_data = SubActivityValue::where('sam_id', $request->input('sam_id'))
                                                            ->where('type', $request->input('activity_name'))
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

                    if ($request->input('activity_name') == "jtss_schedule") {
                        $message_info = "Successfully scheduled JTSS.";
                    } else {
                        $message_info = "Successfully scheduled site.";
                    }
                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'type' => $request->input('activity_name'),
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'status' => "pending",
                    ]); 

                    
                    // a_update_data(SAM_ID, PROFILE_ID, USER_ID, true/false)
                    // $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');

                    return response()->json(['error' => false, 'message' => $message_info ]);
                } else {
                    
                    // $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');

                    return response()->json(['error' => false, 'message' => $message_info ]);
                }
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
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    //moving site
    private function move_site($sam_id, $program_id, $action, $site_category, $activity_id)
    {
        for ($i=0; $i < count($sam_id); $i++) {
            $get_past_activities = \DB::connection('mysql2')
                                    ->table('site_stage_tracking')
                                    ->where('sam_id', $sam_id[$i])
                                    ->where('activity_complete', 'false')
                                    ->get();

                                    $past_activities = collect();

            for ($j=0; $j < count($get_past_activities); $j++) {
                $past_activities->push($get_past_activities[$j]->activity_id);
            }

            if ( in_array($activity_id[$i], $past_activities->all()) ) {
                $activities = \DB::connection('mysql2')
                                        ->table('stage_activities')
                                        ->select('next_activity')
                                        ->where('activity_id', $activity_id[$i])
                                        ->where('program_id', $program_id)
                                        ->where('category', $site_category[$i])
                                        ->first();

                $get_activitiess = \DB::connection('mysql2')
                                        ->table('stage_activities')
                                        ->select('next_activity', 'activity_name', 'profile_id')
                                        ->where('activity_id', $activities->next_activity)
                                        ->where('program_id', $program_id)
                                        ->where('category', $site_category[$i])
                                        ->first();

                $get_activities = \DB::connection('mysql2')
                                        ->table('stage_activities')
                                        ->where('next_activity', $get_activitiess->next_activity)
                                        ->where('program_id', $program_id)
                                        ->where('category', $site_category[$i])
                                        ->get();

                foreach ($get_activities as $get_activity) {
                    if ($action == "true") {
                        $check_done = \DB::connection('mysql2')
                                                ->table('site_stage_tracking')
                                                ->where('sam_id', $sam_id[$i])
                                                ->where('activity_complete', 'false')
                                                ->get();

                        $activity = $get_activity->activity_id;

                        SiteStageTracking::where('sam_id', $sam_id[$i])
                                                ->where('activity_complete', 'false')
                                                ->where('activity_id', $activity_id[$i])
                                                ->update([
                                                    'activity_complete' => "true"
                                                ]);

                        if (count($check_done) <= 1) {
        
                            SiteStageTracking::create([
                                'sam_id' => $sam_id[$i],
                                'activity_id' => $activity,
                                'activity_complete' => 'false',
                                'user_id' => \Auth::id()
                            ]);
                        }
                    } else {
                        $activity = $get_activity->return_activity;
                        SiteStageTracking::where('sam_id', $sam_id[$i])
                                                ->where('activity_id', ">", $activity)
                                                ->delete();
    
                        SiteStageTracking::where('sam_id', $sam_id[$i])
                                                ->where('activity_id', $activity)
                                                ->update([
                                                    'activity_complete' => "false"
                                                ]);
                    }
    
                    $array = array(
                        'activity_id' => $activity,
                        'activity_name' => $get_activitiess->activity_name,
                        'profile_id' => $get_activitiess->profile_id,
                        'category' => $site_category[$i],
                        'activity_created' => Carbon::now()->toDateString(),
                    );
    
                    Site::where('sam_id', $sam_id[$i])
                    ->update([
                        'activities' => json_encode($array)
                    ]);
                }
            }
        }
    }
}
