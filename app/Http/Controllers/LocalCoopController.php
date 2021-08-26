<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\LocalCoopValue;
use App\Models\LocalCoop;

use App\Models\User;
use Validator;


class LocalCoopController extends Controller
{
    public function get_localcoop($program_id, $profile_id, $activity_type)
    {
        if($activity_type == 'all'){
            
            $sites = \DB::connection('mysql2')
                                ->table("local_coop")
                                ->select(
                                    'region', 
                                    'id', 
                                    'prioritization_tagging', 
                                    'endorsement_tagging', 
                                    'coop_name',
                                    'coop_full_name',
                                    'province'
                                )
                                ->distinct();

            if (\Auth::user()->profile_id == 18 || \Auth::user()->profile_id == 25) {
                $sites->get();
            } else {
                $sites_locations = \DB::connection('mysql2')
                                ->table("local_coop_user_locations")
                                ->where('user_id', \Auth::id())
                                ->get();

                $locations = collect();

                foreach ($sites_locations as $sites_location) {
                    $locations->push($sites_location->region);
                }
                
                $sites->whereIn('region', $locations->all())
                ->get();
            }
            

            // $sites = \DB::connection('mysql2')
            // ->table("local_coop")
            // ->select(
            //     'region', 
            //     'id', 
            //     'prioritization_tagging', 
            //     'endorsement_tagging', 
            //     'coop_name',
            //     'coop_full_name',
            //     'province'
            // )
            // ->get();
        }

        $dt = DataTables::of($sites);
        return $dt->make(true);

    }


    public function get_coop_issues()
    {


        $coop_issues = \DB::table('view_local_coop_issues');


        if (\Auth::user()->profile_id == 18) {
            $coop_issues->get();
        }
        elseif (\Auth::user()->profile_id == 25) {
            $coop_issues->get();
        } else {
            $sites_locations = \DB::connection('mysql2')
                            ->table("local_coop_user_locations")
                            ->where('user_id', \Auth::id())
                            ->get();

            $locations = collect();

            foreach ($sites_locations as $sites_location) {
                $locations->push($sites_location->region);
            }
            
            $coop_issues->whereIn('region', $locations->all())
            ->get();
        }


        $dt = DataTables::of($coop_issues);

        return $dt->make(true);
                        
    }

    public function get_coop_issue_list($issue_type)
    {
        $issues = \DB::table('issue_type')
                        ->where('issue_type', $issue_type)
                        ->where('program_id', 7)
                        ->orderBy('issue')
                        ->get();        
        return $issues;
    }

    

    public function get_localcoop_details($coop)
    {
        $coop_details = \DB::connection('mysql2')
            ->table("local_coop")
            ->select(
                'id', 
                'coop_name',
                'coop_full_name',
                'prioritization_tagging', 
                'endorsement_tagging', 
                'region', 
                'province',
            )
            ->where('coop_name', $coop)
            ->get();

        return $coop_details;
    }

    public function get_localcoop_values($coop, $type)
    {
        $coop_values = \DB::connection('mysql2')
                            ->table("local_coop_values")
                            ->join('users', 'local_coop_values.user_id', 'users.id')
                            ->where('coop', $coop)
                            ->where('type', $type)
                            ->get();

        return $coop_values;
    }

    public function get_localcoop_values_data($coop, $type)
    {
        $coop_values = \DB::connection('mysql2')
                            ->table("local_coop_values")
                            ->join('users', 'local_coop_values.user_id', 'users.id')
                            ->where('coop', $coop)
                            ->where('type', $type)
                            ->orderBy('add_timestamp', 'desc')
                            ->get();

        if ($type == "contacts") {
            $dt = DataTables::of($coop_values)
                ->addColumn('type', function($row){
                    return json_decode($row->value)->contact_type;
                })
                ->addColumn('firstname', function($row){
                    return json_decode($row->value)->firstname;
                })
                ->addColumn('lastname', function($row){
                    return json_decode($row->value)->lastname;
                })
                ->addColumn('cellphone', function($row){
                    return json_decode($row->value)->contact_number;
                })
                ->addColumn('email', function($row){
                    return json_decode($row->value)->email;
                })
                ->addColumn('action', function($row){
                    $button = "<button class='btn btn-sm btn-primary btn-shadow edit_contact' data-action='edit' title='Edit' data-id='".$row->ID."'><i class='pe-7s-pen'></i></button>";
                    // $button .= "<button class='btn btn-sm btn-danger btn-shadow delete_contact' data-action='delete' title='Delete' data-id='".$row->ID."'><i class='pe-7s-trash'></i></button>";
                    
                    return $button;
                });

            $dt->rawColumns(['action']);

        } else if ($type == "engagements") {
            $dt = DataTables::of($coop_values)
                ->addColumn('engagement_type', function($row){
                    return json_decode($row->value)->engagement_type;
                })
                ->addColumn('result_of_engagement', function($row){
                    return json_decode($row->value)->result_of_engagement;
                })
                ->addColumn('remarks', function($row){
                    return json_decode($row->value)->remarks;
                });
        } else if ($type == "issues") {
            $dt = DataTables::of($coop_values)
                ->addColumn('dependency', function($row){
                    return json_decode($row->value)->dependency;
                })
                ->addColumn('nature_of_issue', function($row){
                    return json_decode($row->value)->nature_of_issue;
                })
                // ->addColumn('issue', function($row){
                //     return json_decode($row->value)->issue;
                // })
                ->addColumn('description', function($row){
                    return json_decode($row->value)->description;
                })
                ->addColumn('issue_raised_by', function($row){
                    return json_decode($row->value)->issue_raised_by;
                })
                ->addColumn('issue_raised_by_name', function($row){
                    return json_decode($row->value)->issue_raised_by_name;
                })
                ->addColumn('date_of_issue', function($row){
                    return json_decode($row->value)->date_of_issue;
                })
                ->addColumn('issue_assigned_to', function($row){
                    return json_decode($row->value)->issue_assigned_to;
                })
                ->addColumn('status_of_issue', function($row){
                    return json_decode($row->value)->status_of_issue;
                });
        }

        return $dt->make(true);
    }

    public function add_coop_value (Request $request)
    {
        try { 
            if ($request->input('action') == 'engagements') {
                $validate = Validator::make($request->all(), array(
                    'coop' => 'required',
                    'engagement_type' => 'required',
                    'result_of_engagement' => 'required',
                    'remarks' => 'required',
                ));

                $array = array(
                    'engagement_type' => $request->input('engagement_type'),
                    'result_of_engagement' => $request->input('result_of_engagement'),
                    'remarks' => $request->input('remarks'),
                );

                $coop = $request->input('coop');

                $message = "Successfuly added engagements.";
            } else if ($request->input('action') == 'contacts') {
                $validate = Validator::make($request->all(), array(
                    'coop' => 'required',
                    'contact_number' => 'required',
                    'contact_type' => 'required',
                    'email' => 'required | email',
                    'firstname' => 'required',
                    'lastname' => 'required',
                ));

                $array = array(
                    'contact_type' => $request->input('contact_type'),
                    'firstname' => $request->input('firstname'),
                    'lastname' => $request->input('lastname'),
                    'contact_number' => $request->input('contact_number'),
                    'email' => $request->input('email'),
                );

                $coop = $request->input('coop');

                $message = "Successfuly added contacts.";

                if (!is_null($request->input('ID'))) {
                    LocalCoopValue::where('ID', $request->input('ID'))
                    ->update([
                        'coop' => $coop,
                        'type' => $request->input('action'),
                        'value' => json_encode($array),
                        'user_id' => \Auth::id(),
                    ]);

                    $message = "Successfuly updated contacts.";

                    return response()->json(['error' => false, 'message' => $message ]);
                }
            } else if ($request->input('action') == 'issues') {
                $validate = Validator::make($request->all(), array(
                    'coop' => 'required',
                    'date_of_issue' => 'required',
                    'dependency' => 'required',
                    'description' => 'required',
                    'issue_assigned_to' => 'required',
                    'issue_raised_by' => 'required',
                    'issue_raised_by_name' => 'required',
                    'nature_of_issue' => 'required',
                    'issue' => 'required',
                    'status_of_issue' => 'required',
                ));

                $array = array(
                    'dependency' => $request->input('dependency'),
                    'nature_of_issue' => $request->input('nature_of_issue'),
                    'issue' => $request->input('issue'),
                    'description' => $request->input('description'),
                    'issue_raised_by' => $request->input('issue_raised_by'),
                    'issue_raised_by_name' => $request->input('issue_raised_by_name'),
                    'date_of_issue' => $request->input('date_of_issue'),
                    'issue_assigned_to' => $request->input('issue_assigned_to'),
                    'status_of_issue' => $request->input('status_of_issue'),
                );

                $coop = $request->input('coop');

                $message = "Successfuly added issue.";
            } else if ($request->input('action') == 'issue_history') {
                $validate = Validator::make($request->all(), array(
                    // 'date_history' => 'required',
                    'remarks' => 'required',
                    'status_of_issue' => 'required',
                ));

                $coop_data = LocalCoopValue::where('ID', $request->input('issue_id') )->first();

                $array_update = array(
                    'dependency' => json_decode($coop_data->value)->dependency,
                    'nature_of_issue' => json_decode($coop_data->value)->nature_of_issue,
                    'description' => json_decode($coop_data->value)->description,
                    'issue_raised_by' => json_decode($coop_data->value)->issue_raised_by,
                    'issue_raised_by_name' => json_decode($coop_data->value)->issue_raised_by_name,
                    'date_of_issue' => json_decode($coop_data->value)->date_of_issue,
                    'issue_assigned_to' => json_decode($coop_data->value)->issue_assigned_to,
                    'status_of_issue' => $request->input('status_of_issue'),
                );

                LocalCoopValue::where('ID', $request->input('issue_id') )
                                ->update([
                                    'value' => json_encode($array_update),
                                ]);

                $array = array(
                    'id' => $request->input('issue_id'),
                    // 'date_history' => $request->input('date_history'),
                    'user_id' => $request->input('user_id'),
                    'remarks' => $request->input('remarks'),
                    'status_of_issue' => $request->input('status_of_issue'),
                );

                $coop = $coop_data->coop;

                $message = "Successfuly added history.";
            }


            if ($validate->passes()) {
                LocalCoopValue::create([
                    'coop' => $coop,
                    'type' => $request->input('action'),
                    'value' => json_encode($array),
                    'user_id' => \Auth::id(),
                ]);
    
                return response()->json(['error' => false, 'message' => $message ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function issue_history_data($id)
    {
        try {

            $history = LocalCoopValue::where('type', 'issue_history')
                                        ->whereJsonContains('value', ['id' => $id ])
                                        ->orderBy('add_timestamp', 'desc')
                                        ->get();

            $dt = DataTables::of($history)
                        ->addColumn('staff', function($row){
                            $user = User::find(json_decode($row->value)->user_id);
                            return $user->name;
                        })
                        ->addColumn('remarks', function($row){
                            return json_decode($row->value)->remarks;
                        })
                        ->addColumn('status', function($row){
                            return json_decode($row->value)->status_of_issue;
                        });
            
            // $dt->rawColumns(['checkbox', 'technology']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function localcoop_details_approval ()
    {

        try {

            $values = \DB::connection('mysql2')
                                        ->table('local_coop_values')
                                        ->where('type', 'update_details')
                                        ->whereJsonContains('value', [
                                            'status' => 'pending'
                                        ])
                                        ->get();

            $dt = DataTables::of($values)
                                ->addColumn('prioritization_tagging', function($row){
                                    return json_decode($row->value)->prioritization_tagging;
                                })
                                ->addColumn('endorsement_tagging', function($row){
                                    return json_decode($row->value)->endorsement_tagging;
                                })
                                ->addColumn('status', function($row){
                                    return json_decode($row->value)->status;
                                })
                                ->addColumn('action', function($row){
                                    $btn = "<button class='btn btn-sm btn-shadow btn-primary approve_disapprove_coop_detail' data-endorsement_tagging='".json_decode($row->value)->endorsement_tagging."' data-prioritization_tagging='".json_decode($row->value)->prioritization_tagging."' data-id='".$row->ID."' data-coop='".$row->coop."' data-action='approved'>Approve</button>";
                                    
                                    $btn .= "<button class='btn btn-sm btn-shadow btn-danger approve_disapprove_coop_detail' data-endorsement_tagging='".json_decode($row->value)->endorsement_tagging."' data-prioritization_tagging='".json_decode($row->value)->prioritization_tagging."' data-id='".$row->ID."' data-coop='".$row->coop."' data-action='rejected'>Disapprove</button>";
                                    return $btn;
                                });
                        // ->addColumn('remarks', function($row){
                        //     return json_decode($row->value)->remarks;
                        // })
                        // ->addColumn('status', function($row){
                        //     return json_decode($row->value)->status_of_issue;
                        // });
            $dt->rawColumns(['action']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function get_contact($id, $action)
    {
        try {
            $contact = LocalCoopValue::where('type', 'contacts')
                                            ->where('ID', $id)
                                            ->first();
            
            return response()->json(['error' => false, 'message' => $contact ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function update_coop_details (Request $request) {
        try {
            $array = array(
                'id' => $request->input('id'),
                'endorsement_tagging' => $request->input('endorsement_tagging'),
                'prioritization_tagging' => $request->input('prioritization_tagging'),
                'status' => 'pending',
            );

            LocalCoopValue::create([
                'coop' => $request->input('coop_name'),
                'type' => "update_details",
                'value' => json_encode($array),
                'user_id' => \Auth::id()
            ]);

            return response()->json(['error' => false, 'message' => "This was sent for approval of BD." ]);

        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function approve_change_details ($id, $status) 
    {
        try {
            $values = \DB::connection('mysql2')
                                        ->table('local_coop_values')
                                        ->where('type', 'update_details')
                                        ->where('ID', $id)
                                        ->first();

            $array = array(
                'endorsement_tagging' => json_decode($values->value)->endorsement_tagging,
                'prioritization_tagging' => json_decode($values->value)->prioritization_tagging,
                'status' => $status,
            );

            LocalCoopValue::where('ID', $id)
            ->update([
                'value' => $array
            ]);
            
            if ($status == "approved") {
    
                LocalCoop::where('coop_name', $values->coop)
                ->update([
                    'prioritization_tagging' => json_decode($values->value)->endorsement_tagging,
                    'endorsement_tagging' => json_decode($values->value)->endorsement_tagging,
                ]);
            }
            
            return response()->json(['error' => false, 'message' => "Details have been " .$status ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

}
