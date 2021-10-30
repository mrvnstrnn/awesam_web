<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                                ->select('component_activity')
                                ->where('category', $get_current_act->site_category)
                                ->where('program_id', $get_current_act->program_id)
                                ->where('activity_id', $get_current_act->activity_id)
                                ->first();

            return \View::make('components.' . $get_component->component_activity)
                    ->with([
                        'site' => $request['site'],
                        'site_category' => $get_current_act->site_category,
                    ])
                    ->render();

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }
}
