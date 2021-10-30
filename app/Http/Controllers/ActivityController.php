<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class ActivityController extends Controller
{
    public function get_component(Request $request)
    {
        try {
            // return response()->json(['error' => true, 'message' => $request->all()]);
            if ($request['type'] == 'mine_completed' || $request['type'] == 'unassigned sites' || $request['type'] == 'all' ) {
                $site = \DB::connection('mysql2')
                                ->table('view_site')
                                ->distinct()
                                ->where('sam_id', $request['sam_id'])
                                ->get();

                return \View::make('components.modal-info-site')
                            ->with([
                                'site' => $site,
                                'main_activity' => ''
                            ])
                            ->render();
            } else {
                $get_current_act = \DB::connection('mysql2')
                                    ->table('view_site')
                                    ->select('program_id', 'site_category', 'activity_id')
                                    ->where('sam_id', $request['sam_id'])
                                    ->first();
    
                $get_component = \DB::connection('mysql2')
                                    ->table('stage_activities')
                                    ->select('component_activity')
                                    // ->where('profile_id', \Auth::id())
                                    ->where('category', $get_current_act->site_category)
                                    ->where('program_id', $get_current_act->program_id)
                                    ->where('activity_id', $get_current_act->activity_id)
                                    ->first();
    
                if ( is_null($get_component) ) {
                    return \View::make('components.activity_error')
                            ->render();
                } else {
                    return \View::make('components.' . $get_component->component_activity)
                            ->with([
                                'site' => $request['site'],
                                'site_category' => $get_current_act->site_category,
                            ])
                            ->render();
                }
            }

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }
}
