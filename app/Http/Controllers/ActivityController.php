<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\StageActivitiesProfile;

class ActivityController extends Controller
{
    public function get_component(Request $request)
    {
        try {
            $get_current_act = \DB::connection('mysql2')
                                ->table('view_site')
                                ->select('program_id', 'site_category', 'activity_id')
                                ->where('sam_id', $request['sam_id'])
                                ->first();

            // return dd($get_current_act);

            $get_component = \DB::connection('mysql2')
                                ->table('stage_activities')
                                ->leftjoin('stage_activities_profiles', 'stage_activities_profiles.stage_activity_id', 'stage_activities.id')
                                ->select('activity_component')
                                ->where('stage_activities.category', $get_current_act->site_category)
                                ->where('stage_activities.program_id', $get_current_act->program_id)
                                ->where('stage_activities.activity_id', $get_current_act->activity_id)
                                ->where('stage_activities_profiles.activity_source', $request->get('activity_source'))
                                ->first();


                                
            $site = \DB::connection('mysql2')
                        ->table('view_site')
                        ->where('sam_id', $request['sam_id'])
                        ->get();
                    
            if ( is_null($get_component) ) {

                return \View::make('components.activity-error')
                        ->with([
                            'site' => $site,
                            'activity_source' => $request->get('activity_source'),  
                            'main_activity' => '',
                        ])
                        ->render();
            } else {
                return \View::make('components.' . $get_component->activity_component)
                        ->with([
                            'site' => $site,
                            'activity_source' => $request->get('activity_source'),
                            'main_activity' => '',
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
}
