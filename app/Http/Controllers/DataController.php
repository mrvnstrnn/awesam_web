<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Log;
use Validator;
use Carbon;
use ZipArchive;

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

            $user_detail = \Auth::user()->getUserDetail()->first();

            $user_area = \DB::table('users_areas')
                                ->select('region')
                                ->where('user_id', \Auth::id())
                                ->get()
                                ->pluck('region');

            $sites = \DB::table("views_sites_with_document_validation")
                ->leftJoin('view_site', 'views_sites_with_document_validation.sam_id', 'view_site.sam_id')
                ->where('program_id', $program_id)
                ->where('active_status', 'pending')
                ->where('active_profile_id', \Auth::user()->profile_id);
                
            if (!is_null($user_detail) && $user_detail->mode == 'vendor') {
                $vendor = is_null($user_detail) ? NULL : $user_detail->vendor_id;
                $sites->where('view_site.vendor_id', $vendor);
            }
        
            if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                $sites->whereIn('view_site.sam_region_id', $user_area);
            }

            if($program_id == 3){
                $sites->leftJoin('program_coloc', 'program_coloc.sam_id', 'view_site.sam_id')
                ->get();

            }
            elseif($program_id == 8){
                $sites->leftJoin('program_renewal', 'program_renewal.sam_id', 'view_site.sam_id');
            }
            elseif($program_id == 4){
                $sites->leftJoin('program_ibs', 'program_ibs.sam_id', 'view_site.sam_id');
            }
            elseif($program_id == 2){
                $sites->leftJoin('program_ftth', 'program_ftth.sam_id', 'view_site.sam_id')
                    ->get();
            }              

       }
       elseif($activity_type == 'program sites'){

            $sites = \DB::table("view_site")
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

            $required = "";

            if ( $request->get('method') == "Call" ) {
                $required = "required";
            }

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
                'name' => $required,
                'contact_no' => $required,
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

            $required = "";

            if ( $request->get('lessor_method') == "Call" ) {
                $required = "required";
            }

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
                'name' => $required,
                'contact_no' => $required,
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
                $sites = \DB::table("site_users")
                        ->join("view_site", 'view_site.sam_id', 'site_users.sam_id')
                        ->select("view_site.site_name", "view_site.activity_name", "view_site.sam_id", "view_site.activity_id", "view_site.activity_name", "view_site.program_id", "view_site.site_category")
                        // ->whereJsonContains('site_agent', [
                        //     'user_id' => \Auth::id()
                        // ])
                        ->where('site_users.agent_id', \Auth::id())
                        ->get();
            } else {
                $get_user_under_me = UserDetail::select('user_id')
                                        ->where('IS_id', \Auth::id())
                                        ->get()
                                        ->pluck('user_id');

                $sites = \DB::table("site_users")
                        ->join("view_site", 'view_site.sam_id', 'site_users.sam_id')
                        ->select("view_site.site_name", "view_site.activity_name", "view_site.sam_id", "view_site.activity_id", "view_site.activity_name", "view_site.program_id", "view_site.site_category")
                        // ->whereJsonContains('site_agent', [
                        //     'user_id' => \Auth::id()
                        // ])
                        ->whereIn('site_users.agent_id', $get_user_under_me)
                        ->get();
            }
    
            $dt = DataTables::of($sites)
                            ->addColumn('action', function($row){

                                $json = array(
                                    'sam_id' => $row->sam_id,
                                    'activity_id' => $row->activity_id,
                                    'activity_name' => $row->activity_name,
                                    'site_name' => $row->site_name,
                                    'program_id' => $row->program_id,
                                    'category' => $row->site_category
                                );

                                // {"sam_id":'.$row->sam_id.',"activity_id":'.$row->activity_id.',"sam_id":'.$row->activity_name.',"site_name":'.$row->site_name.',"program_id":'.$row->program_id.',"category":'.$row->site_category.'}

                                // return '<button class="btn btn-sm btn-primary show_action_modal" data-activity_source="work_plan_activity_add" data-json="'.json_encode($json).'">Add Work Plan</button>';
                                return "<button class='btn btn-sm btn-primary show_action_modal' data-activity_source='work_plan_activity_add' data-json='".json_encode($json)."'>Add Work Plan</button>";
                            });
                            
            $dt->rawColumns(['action']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }


    // ************ GET SITE DATA VIA AJAX ************** //

    public function get_milestone_per_program(Request $request)
    {
        try {
            $user_id = \Auth::id();
            // $category = $request->get('category');
            // $category = "none";
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');

            $milestone_count = \DB::select('call GET_SITE_MILESTONE_COUNT(?,?,?)',array($user_id, $start_date, $end_date));

            return response()->json(['error' => false, 'message' => $milestone_count ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function site_approvals_per_site (Request $request)
    {
        try {
            $site = \DB::select('call GET_APPROVALS_TAB(?)',array($request->get('sam_id')));

            $dt = DataTables::of($site);
            return $dt->make(true);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function zipDownload(Request $request)
    {
        try {
            if($request->has('sam_id')) {

                $get_all_files = SubActivityValue::where('sam_id', $request->get('sam_id'))
                                    ->where('status', 'approved')
                                    ->where('type', 'doc_upload')
                                    ->get();

                $files_list = collect();

                foreach ($get_all_files as $get_all_file) {
                    $file_encode = json_decode($get_all_file->value);

                    $files_list->push($file_encode->file);
                }
                
                $zip = new ZipArchive;
                
                $fileName = time().$request->get('sam_id') . ".zip";
                if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
                    $files = \File::files(public_path('files'));

                    $fileNames = [];

                    for ($i=0; $i < count($files_list->all()); $i++) { 
                        $relativeName = basename($files_list->all()[$i]);

                        array_push($fileNames, $relativeName);
                        // $zip->addFile($relativeName);
                        $zip->addFile($files[0], $relativeName);
                    }
                    
                    $zip->close();
                }
                return response()->download(public_path($fileName));
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

    }



}
