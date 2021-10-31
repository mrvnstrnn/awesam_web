<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

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

            $get_component = \DB::connection('mysql2')
                                ->table('stage_activities')
                                ->leftjoin('stage_activities_profiles', 'stage_activities_profiles.stage_activity_id', 'stage_activities.id')
                                ->select('activity_component')
                                // ->where('profile_id', \Auth::id())
                                ->where('stage_activities.category', $get_current_act->site_category)
                                ->where('stage_activities.program_id', $get_current_act->program_id)
                                ->where('stage_activities.activity_id', $get_current_act->activity_id)
                                ->where('stage_activities_profiles.activity_source', $request->get('type'))
                                ->first();

            if ( is_null($get_component) ) {
                $site = \DB::connection('mysql2')
                                ->table('view_site')
                                ->distinct()
                                ->where('sam_id', $request['sam_id'])
                                ->get();

                return \View::make('components.modal-info-site')
                        ->with([
                            'site' => $site,
                            'site_category' => $get_current_act->site_category,
                            'main_activity' => '',
                        ])
                        ->render();
            } else {
                return \View::make('components.' . $get_component->activity_component)
                        ->with([
                            'site' => $request['site'],
                            'site_category' => $get_current_act->site_category,
                        ])
                        ->render();
            }

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }
}
