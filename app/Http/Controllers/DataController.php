<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Log;
use Validator;
use Carbon;

use App\Models\SubActivityValue;
use App\Models\UserDetail;


class DataController extends Controller
{

    public function Datatable_Columns(Request $request)
    {




    }

    public function work_plan ($user_id = '')
    {

    }



    public function Datatable_Data($program_id, $profile_id, $activity_type)
    {

        // Document Validation Datatable
       if($activity_type == 'doc validation'){

            $sites = \DB::connection('mysql2')
                ->table("views_sites_with_document_validation")
                ->leftJoin('view_site', 'views_sites_with_document_validation.sam_id', 'view_site.sam_id')
                ->where('program_id', $program_id)
                ->where('active_status', 'pending   ')
                ->where('active_profile_id', \Auth::user()->profile_id);
            
            
            if($program_id == 3){
                $sites->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id');
                $sites->get();
            }                

       }
       elseif($activity_type == 'program sites'){

            $sites = \DB::connection('mysql2')
                ->table("view_site")
                ->where('program_id', $program_id)
                // ->where('active_profile_id', \Auth::user()->profile_id)
                ->get();


        } else {
            
        }

        $dt = DataTables::of($sites);
        return $dt->make(true);

    }

    // ///////////////////////////// //
    //                               //
    // ADDING IN SUB ACTIVITY VALUES //
    //                               //
    // ///////////////////////////// //

    // ************ WORK PLAN ************** //

    public function Add_Work_Plan(Request $request)
    {   
        try {

            $notification = "Successfully Added Work Plan";

            $validate = Validator::make($request->all(), array(              
                'sam_id' => 'required',
                'site_name' => 'required',
                'activity_id' => 'required',
                'activity_name' => 'required',
                'sub_activity_id' => 'required',
                'sub_activity_name' => 'required',
                'method' => 'required',
                'planned_date' => 'required',
                'saq_objective' => 'required',
                'remarks' => 'required',
            ));

            if ($validate->passes()) {

                SubActivityValue::create([
                    'sam_id' => $request->sam_id,
                    'site_name' => $request->site_name,
                    'activity_id' => $request->activity_id,
                    'activity_name' => $request->activity_name,
                    'sub_activity_name' => $request->sub_activity_name,
                    'sub_activity_id' => $request->sub_activity_id,
                    'value' => json_encode($request->all()),
                    'user_id' => \Auth::id(),
                    'status' => 'pending',
                    'type' => 'work_plan'
                ]);
            } 
            else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }

            return response()->json(['error' => false, 'message' => $notification ]);

        } catch (\Throwable  $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }

    }

    public function add_engagement(Request $request)
    {   
        try {

            $notification = "Successfully Added Engagement";

            $validate = Validator::make($request->all(), array(              
                'sam_id' => 'required',
                'site_name' => 'required',
                // 'activity_id' => 'required',
                'activity_name' => 'required',
                'sub_activity_id' => 'required',
                'sub_activity_name' => 'required',
                'lessor_method' => 'required',
                'saq_objective' => 'required',
                'lessor_remarks' => 'required',
            ));

            if ($validate->passes()) {

                $get_workplan = SubActivityValue::where('sam_id', $request->get('sam_id'))
                                        // ->where('value->planned_date', Carbon::now()->toDateString())
                                        ->where('value->method', $request->get('lessor_method'))
                                        // ->where('sub_activity_id', $request->get('sub_activity_id'))
                                        ->where('type', 'work_plan')
                                        ->where('status', 'pending')
                                        ->first();

                                   
                if ( !is_null($get_workplan) ) {

                    $json = json_decode( $get_workplan->value );

                    if ( $json->planned_date == Carbon::now()->toDateString() || $json->planned_date >= Carbon::now()->toDateString() ) {
                        $get_workplan->update([
                            'status' => 'Done'
                        ]);
                    } else {
                        $get_workplan->update([
                            'status' => 'Delayed'
                        ]);
                    }
                }  

                SubActivityValue::create([
                    'sam_id' => $request->get('sam_id'),
                    // 'site_name' => $request->site_name,
                    // 'activity_id' => $request->activity_id,
                    // 'activity_name' => $request->activity_name,
                    // 'sub_activity_name' => $request->sub_activity_name,
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'value' => json_encode($request->all()),
                    'user_id' => \Auth::id(),
                    'status' => 'pending',
                    'type' => 'lessor_engagement'
                ]);

                return response()->json(['error' => false, 'message' => $notification ]);
            } 
            else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }

            return response()->json(['error' => false, 'message' => $notification ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    

    // ************ WORK PLAN ************** //


    // ///////////////////////////// //
    //                               //
    //     GETTING DATA VIA AJAX     //
    //                               //
    // ///////////////////////////// //

    
    // ************ GET SITE DATA VIA AJAX ************** //


    public function SiteAjax(Request $request)
    {
        try {        


            if($request->type === 'work_plan_stage_activities'){

                $site = \DB::table('view_site')
                        ->where('sam_id', $request->sam_id)
                        ->first();

                $data = \DB::table('stage_activities')
                        ->where('program_id', $site->program_id)          
                        ->where('category', $site->site_category)
                        ->where('activity_id','>',  $site->activity_id)
                        ->where('profile_id','=',  2)
                        ->get();      

            }  

            elseif($request->type === 'work_plan_sub_activities'){

                $site = \DB::table('view_site')
                        ->where('sam_id', $request->sam_id)
                        ->first();

                $data = \DB::table('sub_activity')
                        ->where('program_id', $site->program_id)          
                        ->where('category', $site->site_category)
                        ->where('activity_id','=',  $request->activity_id)
                        ->get();      
            }  
            elseif($request->type === 'home_widgets_stage_counters'){
                

                $data = \DB::table("view_milestone_stages_globe")
                        ->select('stage_id', 'stage_name', \DB::raw("SUM(counter) as counter"))
                        ->where('program_id', $request->programid)
                        ->groupBy('stage_id', 'stage_name')
                        ->get();

            }

            
            else {

                return response()->json(['error' => true, 'message' => $request->type ]);
            }

            return response()->json(['error' => false, 'message' => $data]);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }


    }

    public function get_assigned_sites ()
    {
        try {
            if (\Auth::user()->profile_id == 2) {
                $sites = \DB::connection('mysql2')
                        ->table("view_site")
                        ->select("site_name", "activity_name")
                        // ->where('profile_id', \Auth::user()->profile_id)
                        ->whereJsonContains('site_agent', [
                            'user_id' => \Auth::id()
                        ])
                        // ->where('site_agent->user_id', \Auth::id())
                        ->get();
            } else {
                $get_user_under_me = UserDetail::select('user_id')
                                        ->where('IS_id', \Auth::id())
                                        ->get()
                                        ->pluck('user_id');

                $sites = \DB::connection('mysql2')
                        ->table("view_site")
                        ->select("site_name", "activity_name")
                        ->where('profile_id', \Auth::user()->profile_id)
                        ->whereJsonContains('site_agent', [
                            'user_id' => $get_user_under_me
                        ])
                        // ->where('site_agent->user_id', \Auth::id())
                        ->get();
            }
    
            $dt = DataTables::of($sites);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }


    // ************ GET SITE DATA VIA AJAX ************** //



}
