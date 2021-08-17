<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\User;


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

            if (\Auth::user()->profile_id == 18) {
                $sites->get();
            }
            elseif (\Auth::user()->profile_id == 25) {
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
                })->addColumn('description', function($row){
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
}
