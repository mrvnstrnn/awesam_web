<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Log;
use PDF;
use Carbon;
use DateTime;
use App\Models\User;
use App\Models\SiteStageTracking;
use App\Models\Site;
use App\Models\SubActivityValue;
use App\Models\PrMemoTableRenewal;
use App\Models\PrMemoSite;

use Notification;
use App\Notifications\SiteMoved;

use App\Mail\LOIMail;
use Illuminate\Support\Facades\Mail;

class RenewalController extends Controller
{
    public function save_loi(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                '*' => 'required',
                'undersigned_email' => 'required | email',
            ]);

            if ($validate->passes()) {

                $samid = $request->input("sam_id");
                $site_category = $request->input("site_category");
                $program_id = $request->input("program_id");
                $activity_id = $request->input("activity_id");
                $action = "true";

                $array = [
                    'lessor' => $request->input("lessor"),
                    'lessor_address' => $request->input("lessor_address"),
                    'cell_site_address' => $request->input("cell_site_address"),
                    'from_date' => date('M d, Y', strtotime($request->input("from_date"))),
                    'to_date' => date('M d, Y', strtotime($request->input("to_date"))),
                    // 'date_word' => $date_word,
                    'expiration_date' => date('M d, Y', strtotime($request->input("expiration_date"))),
                    'undersigned_number' => $request->input("undersigned_number"),
                    'undersigned_email' => $request->input("undersigned_email")
                ];

                // $view = \View::make('components.loi-pdf')
                //     ->with([
                //         'json_data' => json_encode($array)   
                //     ])
                //     ->render();

                // $pdf = \App::make('dompdf.wrapper');
                // $pdf = PDF::loadHTML($view);
                // $pdf->setPaper('a4', 'portrait');
                // $pdf->download();

                $this->create_pdf($array, $samid, 'loi-pdf', 'loi.pdf');

                // \Storage::put(strtolower($samid)."-loi-renew.pdf", $pdf->output());

                // Mail::to($request->input("undersigned_email"))->send(new LOIMail( 'pdf/'. strtolower($samid)."-loi-renew.pdf"));

                $stage_activities = \DB::connection('mysql2')
                                ->table('stage_activities')
                                ->select('id', 'activity_type', 'approver_profile_id_1')
                                ->where('program_id', $request->input('program_id'))
                                ->where('activity_id', $request->input('activity_id'))
                                ->where('category', $request->input("site_category"))
                                ->first();

                $stage_activities_approvers = \DB::connection('mysql2')
                                ->table('stage_activities_approvers')
                                ->select('approver_profile_id')
                                ->where('stage_activities_id', $stage_activities->id)
                                ->get();

                $approvers_collect = collect();

                foreach ($stage_activities_approvers as $stage_activities_approver) {
                    $approvers_collect->push([
                        'profile_id' => $stage_activities_approver->approver_profile_id,
                        'status' => 'pending'
                    ]);
                }

                $array_data = [
                    'file' => strtolower($samid)."-loi-renew.pdf",
                    'active_profile' => $stage_activities_approvers[0]->approver_profile_id,
                    'active_status' => 'pending',
                    'validator' => count($approvers_collect->all()),
                    'validators' => $approvers_collect->all()
                ];

                $sub_activity_value = SubActivityValue::where('sam_id', $request->input("sam_id"))
                                                        ->where('sub_activity_id', $request->input("sub_activity_id"))
                                                        ->where('status', 'pending')
                                                        ->first();

                if (!is_null($sub_activity_value)) {
                    $sub_activity_value->update([
                        'value' => json_encode($array_data),
                    ]);
                } else {
                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($array_data),
                        'user_id' => \Auth::id(),
                        'type' => 'doc_upload',
                        'status' => 'pending',
                    ]);   
                }

                // $asd = $this->move_site([$samid], $program_id, $action, [$site_category], [$activity_id]);
                
                return response()->json(['error' => false, 'message' => "Successfully submitted a LOI." ]);

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function email_loi (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'email' => 'required | email'
            ]);

            if ($validate->passes()) {
                // $url = asset('files/'.$request->input("file_name"));
                Mail::to($request->input("email"))->send(new LOIMail( $request->input("file_name")));

                return response()->json(['error' => false, 'message' => "Successfully emailed loi to " .$request->input("email") ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function create_pr (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                '*' => 'required'
            ]);

            if ($validate->passes()) {
                $po_number = $request->get('po_number');
                $po_date = $request->get('po_date');
                $vendor = $request->get('vendor');
                $action = "true";

                $last_pr_memo = PrMemoTableRenewal::orderBy('pr_memo_id', 'desc')->first();

                $generated_pr = "PR-MEMO-00000".(!is_null($last_pr_memo) ? $last_pr_memo->pr_memo_id + 1 : 0 + 1);
                
                PrMemoTableRenewal::create([
                    'po_number' => $request->get('po_number'),
                    'po_date' => $request->get('po_date'),
                    'vendor' => $request->get('vendor'),
                    'generated_pr_memo' => $generated_pr,
                ]);

                for ($i=0; $i < count($request->input('sam_id')); $i++) { 

                    PrMemoSite::create([
                        'sam_id' => $request->input("sam_id")[$i],
                        'pr_memo_id'=> $generated_pr
                    ]);

                    $sites = \DB::connection('mysql2')
                                ->table('view_site')
                                ->select('program_id', 'site_category', 'activity_id')
                                ->where('sam_id', $request->get('sam_id')[$i])
                                ->first();

                    $asd = $this->move_site([$request->input('sam_id')[$i]], $sites->program_id, $action, [$sites->site_category], [$sites->activity_id]);
                }

                return response()->json(['error' => false, 'message' => "Successfully submitted a LOI.", 'program_id' => $request->get('program_id') ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function save_lrn (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                '*' => 'required'
            ]);

            if ($validate->passes()) {
                $this->create_pdf($request->all(), $request->get('sam_id'), 'lrn-no-security-a-r-e-r-pdf','lrn.pdf');
                return response()->json(['error' => true, 'message' => $request->all()]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    private function move_site($sam_id, $program_id, $action, $site_category, $activity_id)
    {
        for ($i=0; $i < count($sam_id); $i++) {


            $get_past_activities = \DB::connection('mysql2')
                                    ->table('site_stage_tracking')
                                    ->where('sam_id', $sam_id[$i])
                                    ->where('activity_complete', 'false')
                                    ->get();
            if (count($get_past_activities) < 1) {
                SiteStageTracking::create([
                    'sam_id' => $sam_id[$i],
                    'activity_id' => 1,
                    'activity_complete' => 'false',
                    'user_id' => \Auth::id()
                ]);

                $get_past_activities = \DB::connection('mysql2')
                                    ->table('site_stage_tracking')
                                    ->where('sam_id', $sam_id[$i])
                                    ->where('activity_complete', 'false')
                                    ->get();
            }

            $past_activities = collect();

            for ($j=0; $j < count($get_past_activities); $j++) {
                $past_activities->push($get_past_activities[$j]->activity_id);
            }

            if ( in_array($activity_id[$i] == null || $activity_id[$i] == "null" || $activity_id[$i] == "undefined" ? 1 : $activity_id[$i], $past_activities->all()) ) {
                $activities = \DB::connection('mysql2')
                                ->table('stage_activities')
                                ->select('next_activity', 'activity_name', 'return_activity')
                                ->where('activity_id', $activity_id[$i] == null || $activity_id[$i] == "null" || $activity_id[$i] == "undefined" ? 1 : $activity_id[$i])
                                ->where('program_id', $program_id)
                                ->where('category', is_null($site_category[$i]) || $site_category[$i] == "null" ? "none" : $site_category[$i])
                                ->first();
                                     
                if (!is_null($activities)) {
                    if ($action == "true") {
                        $get_activitiess = \DB::connection('mysql2')
                                                ->table('stage_activities')
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

                        $check_if_added = \DB::connection('mysql2')
                                            ->table('site_stage_tracking')
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

                        $get_activitiess = \DB::connection('mysql2')
                                        ->table('stage_activities')
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

                    $get_stage_activity = \DB::connection('mysql2')
                                                ->table('stage_activities')
                                                ->select('stage_id')
                                                ->where('activity_id', $activity)
                                                ->where('program_id', $program_id)
                                                ->first();

                    if (!is_null($get_stage_activity)) {
                        $get_program_stages = \DB::connection('mysql2')
                                                ->table('program_stages')
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

        $notification_settings = \DB::connection('mysql2')
                                    ->table('notification_settings')
                                    ->where('program_id', $program_id[0])
                                    ->where('activity_id', $activity_id[0])
                                    ->where('action', $action_id)
                                    ->first();

        if (!is_null($notification_settings)) {
            $notification_receiver_profiles = \DB::connection('mysql2')
                        ->table('notification_receiver_profiles')
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

    private function create_pdf ($array, $samid, $component, $filename)
    {
        $view = \View::make('components.'.$component)
                    ->with([
                        'json_data' => json_encode($array)   
                    ])
                    ->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf = PDF::loadHTML($view);
        $pdf->setPaper('a4', 'portrait');
        $pdf->download();

        \Storage::put(strtolower($samid)."-".$filename, $pdf->output());
    }
}
