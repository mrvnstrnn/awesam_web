<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\StageActivitiesProfile;
use App\Models\StageActivities;
use App\Models\SubActivityValue;

use DataTables;

class ActivityController extends Controller
{
    public function get_component(Request $request)
    {
        try {

            if(!isset($request->direct_mode)){

                $site = \DB::table('view_site')
                                ->where('sam_id', $request['sam_id'])
                                ->get();
                                
                if(!isset($request->bypass_activity_profiles)){
                
                    $get_current_act = \DB::table('view_site')
                                    ->select('program_id', 'site_category', 'activity_id')
                                    ->where('sam_id', $request['sam_id'])
                                    ->first();

                    $get_component = \DB::table('stage_activities')
                                    ->leftjoin('stage_activities_profiles', 'stage_activities_profiles.stage_activity_id', 'stage_activities.id')
                                    ->select('activity_component', 'return_activity')
                                    ->where('stage_activities.category', $get_current_act->site_category)
                                    ->where('stage_activities.program_id', $get_current_act->program_id)
                                    ->where('stage_activities.activity_id', $get_current_act->activity_id)
                                    ->where('stage_activities_profiles.activity_source', $request->get('activity_source'))
                                    ->first();
                                      
                    if ( is_null($get_component) ) {

                        // return \View::make('components.activity-error')
                        return \View::make('components.modal-info-site')
                                ->with([
                                    'site' => $site,
                                    'activity_source' => $request->get('activity_source'),
                                    'main_activity' => '',
                                ])
                                ->render();
                    } else {

                        if ( 
                            ($get_current_act->activity_id == 17 && $get_current_act->program_id == 3) ||
                            ($get_current_act->activity_id == 18 && $get_current_act->program_id == 4)
                            
                            ) {
                            $rtbdeclaration = SubActivityValue::where('sam_id', $request->input('sam_id'))
                                                ->where('status', "pending")
                                                ->where('type', "rtb_declaration")
                                                ->first();
        
                            return \View::make('components.modal-view-site')
                                ->with([
                                    'activity_component' => $get_component->activity_component,
                                    'rtbdeclaration' => $rtbdeclaration,
                                    'site' => $site,
                                    'activity_source' => $request->get('activity_source'),
                                    'main_activity' => '',
                                ])
                                ->render();
                        }
                        
                        if (\Auth::user()->profile_id == 2 || \Auth::user()->profile_id == 38) {
                            return \View::make('components.' . $get_component->activity_component)
                                    ->with([
                                        'site' => $site,
                                        'activity_source' => $request->get('activity_source'),
                                        'main_activity' => '',
                                    ])
                                    ->render();
                        } else {
                    
                            return \View::make('components.modal-view-site')
                                ->with([
                                    'activity_component' => $get_component->activity_component,
                                    'site' => $site,
                                    'return_activity' => $get_component->return_activity,
                                    'activity_source' => $request->get('activity_source'),
                                    'main_activity' => '',
                                ])
                                ->render();
                        }
                    }

                } else {

                    return \View::make('components.modal-view-site')
                    ->with([
                        'activity_component' => "site-rtb-docs-validation",
                        'site' => $site,
                        'activity_source' => $request->get('activity_source'),
                        'main_activity' => $request->activity_source,
                    ])
                    ->render();

                }

            } else {

                switch($request['activity_source']){

                    case "work_plan_add": 
                        
                        $component_to_load = "activity-work-plan-date";
                        break;

                    case "work_plan_activity_add": 
                        
                        $component_to_load = "activity-work-plan-date";
                        break;

                    case "work_plan_view": 
                        
                        $component_to_load = "activity-work-plan-date";
                        break;

                    case "my-activities-engagement": 
                        
                        $component_to_load = "my-activities-engagement";
                        break;

                    case "new endorsement apmo": 
                        
                        $component_to_load = "activity-work-plan-date";
                        break;

                    default: 

                        $component_to_load = "activity-error-action";

                }

                return \View::make('components.' . $component_to_load)
                            ->with([
                                'activity_source' => $request['activity_source'],  
                                'json' => $request['json'],
                            ])
                            ->render();

            }


        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function save_stage_activities_profiles (Request $request) 
    {
        try {
            StageActivitiesProfile::updateOrCreate([
                'id'   => $request->get('id'),
            ], $request->all());

            return redirect('/workflow');
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function save_stage_activities (Request $request) 
    {
        try {
            StageActivities::updateOrCreate([
                'id'   => $request->get('id'),
            ], $request->all());

            return redirect('/workflow');
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function delete_stage_activities_profiles ($id)
    {
        try {
            StageActivitiesProfile::where('id', $id)->delete();
            return redirect('/workflow');
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_site_based_on_activity_id (Request $request)
    {
        try {

            $user_program = \Auth::user()->getUserProgram()[0]->program_id;

            if ( $user_program == 3) {
                $activity_collection = [ "12", "13", "14" ];
                if ( in_array( $request->get('activity_id'), $activity_collection ) ) {
                    $activity_id = 11;
                } else {
                    $activity_id = $request->get('activity_id');
                }
            } else if ( $user_program == 4) {
                $activity_collection = [ "13", "14", "15" ];
                if ( in_array( $request->get('activity_id'), $activity_collection ) ) {
                    $activity_id = 12;
                } else {
                    $activity_id = $request->get('activity_id');
                }
            }

            $site = \DB::table( 'view_site' )
                    ->select( 'site_name', 'sam_id', 'sam_region_name' )
                    ->where( 'program_id', $user_program )
                    ->where( 'activity_id', $activity_id )
                    ->where( 'site_category', $request->get('category') )
                    ->get();

            $dt = DataTables::of($site);
            return $dt->make(true);

            return response()->json([ 'error' => false, 'message' => $site ]);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

}


