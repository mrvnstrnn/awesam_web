<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\SiteAgent;
use App\Models\UsersArea;
use App\Models\Program;
use App\Models\UserDetail;
use App\Models\SubActivityValue;
use App\Models\IssueType;
use App\Models\Issue;
use App\Models\Chat;
use App\Models\User;
use App\Models\RTBDeclaration;
use App\Models\VendorProgram;
use App\Models\Vendor;
use App\Models\UserProgram;
use App\Models\IssueRemark;
use App\Models\SiteStageTracking;
use App\Models\PrMemoSite;
use App\Models\PrMemoTable;
use App\Models\FsaLineItem;
use App\Models\Site;
use App\Models\SubActivity;

use Notification;
use App\Notifications\SiteMoved;
use Pusher\Pusher;
use Log;

use App\Mail\RepresentativeInvitation;
use Illuminate\Support\Facades\Mail;

// use App\Models\ToweCoFile;
// use App\Exports\TowerCoExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\SiteLineItemsExport;
use App\Exports\PerSheetPrExport;

use Illuminate\Support\Facades\Schema;
use Validator;
use PDF;
use Carbon;
// use Illuminate\Support\Facades\Notification;


use App\Events\SiteEndorsementEvent;
use App\Listeners\SiteEndorsementListener;
use App\Notifications\SiteEndorsementNotification;


class GlobeController extends Controller
{
    public function clean_table ()
    {
        return \DB::connection('mysql2')->statement('call `clean_variables`()');
    }

    public function acceptRejectEndorsement(Request $request)
    {
        try {
            // return response()->json(['error' => true, 'message' => $request->all()]);
            if(is_null($request->input('sam_id'))){
                return response()->json(['error' => true, 'message' => "No data selected."]);
            }

            if ($request->input('activity_name') == "Vendor Awarding" || $request->input('activity_name') == "Set Ariba PR Number to Sites") {
                if ($request->input('activity_name') == "Vendor Awarding") {
                    $validate = Validator::make($request->all(), array(
                        'po_number' => 'required',
                    ));

                    if (!$validate->passes()) {
                        return response()->json(['error' => true, 'message' => $validate->errors() ]);
                    } else {
                        \DB::connection('mysql2')->table("site")
                                        ->where("sam_id", $request->input("sam_id"))
                                        ->update([
                                            'site_po' => $request->input('po_number'),
                                        ]);
                    }

                } else {
                    $validate = Validator::make($request->all(), array(
                        'pr_number' => 'required',
                    ));
                    if (!$validate->passes()) {
                        return response()->json(['error' => true, 'message' => $validate->errors() ]);
                    }
                }
            }

            $profile_id = \Auth::user()->profile_id;
            $id = \Auth::user()->id;

            $message = $request->input('data_complete') == 'false' ? 'rejected' : 'accepted';

            if ($request->input('activity_name') == "endorse_site") {

                $notification = "Successfully " .$message. " endorsement.";
                $action = $request->input('data_complete');
                $program_id = $request->input('data_program');
                $site_category = $request->input('site_category');
                $activity_id = $request->input('activity_id');

                $samid = $request->input('sam_id');

                if (\Auth::user()->profile_id == 12) {
                    for ($i=0; $i < count($samid); $i++) {
                        Site::where('sam_id', $samid[$i])->update([
                            'program_endorsement_date' => Carbon::now()
                        ]);
                    }
                }

            } else if ($request->input('activity_name') == "submit_elas") {

                $notification = "Successfully updated elas.";
                $action = $request->input('data_complete');
                $program_id = $request->input('program_id');
                $site_category = $request->input('site_category');
                $activity_id = $request->input('activity_id');

                $samid = $request->input('sam_id');

                $validate = Validator::make($request->all(), array(
                    'elas_reference' => 'required',
                    'elas_filing_date' => 'required',
                ));

                if ($validate->passes()) {
                    $elas_approved_is_added = SubActivityValue::where('sam_id', $request->input('sam_id')[0])
                                                                ->where('type', 'elas_approved')
                                                                ->first();
                    if ( is_null($elas_approved_is_added) ) {
                        SubActivityValue::create([
                            'sam_id' => $request->input('sam_id')[0],
                            'value' => json_encode($request->all()),
                            'user_id' => \Auth::id(),
                            'status' => 'pending',
                            'type' => 'elas_approved'
                        ]);
                    } else {
                        SubActivityValue::where('sam_id', $request->input('sam_id')[0])
                                            ->where('type', 'elas_approved')
                                            ->update([
                                                'sam_id' => $request->input('sam_id')[0],
                                                'value' => json_encode($request->all()),
                                                'user_id' => \Auth::id(),
                                                'status' => 'pending',
                                                'type' => 'elas_approved'
                                            ]);
                    }
                } else {
                    return response()->json(['error' => true, 'message' => $validate->errors() ]);
                }


            } else if ($request->input('activity_name') == "submit_elas_approval") {

                $notification = "Successfully submitted eLAS Approval.";
                $action = $request->input('data_complete');
                $program_id = $request->input('program_id');
                $site_category = [$request->input('site_category')];
                $activity_id = [$request->input('activity_id')];

                $samid = [$request->input('sam_id')];

                $validate = Validator::make($request->all(), array(
                    'elas_approval_date' => 'required',
                ));

                if ($validate->passes()) {
                    $elas_approved_is_added = SubActivityValue::where('sam_id', $request->input('sam_id')[0])
                                                                ->where('type', 'submit_elas_approval')
                                                                ->first();
                    if ( is_null($elas_approved_is_added) ) {
                        SubActivityValue::create([
                            'sam_id' => $request->input('sam_id')[0],
                            'value' => json_encode($request->all()),
                            'user_id' => \Auth::id(),
                            'status' => 'pending',
                            'type' => 'elas_approved'
                        ]);
                    } else {
                        SubActivityValue::where('sam_id', $request->input('sam_id')[0])
                                            ->where('type', 'elas_approved')
                                            ->update([
                                                'sam_id' => $request->input('sam_id')[0],
                                                'value' => json_encode($request->all()),
                                                'user_id' => \Auth::id(),
                                                'status' => 'pending',
                                                'type' => 'elas_approved'
                                            ]);
                    }
                } else {
                    return response()->json(['error' => true, 'message' => $validate->errors() ]);
                }


            } else if ($request->input('activity_name') == "AEPM Validation and Scheduling") {

                $notification = "JTSS Schedule Sent";
                $action = $request->input('data_complete');
                $program_id = $request->input('program_id');
                $site_category = $request->input('site_category');
                $activity_id = $request->input('activity_id');

                $samid = $request->input('sam_id');

                $sub_activity_values = SubActivityValue::where('sam_id', $request->input('sam_id')[0])
                                                        ->where('type', 'jtss_add_site')
                                                        ->where('status', 'pending')
                                                        ->get();
                
                foreach ($sub_activity_values as $sub_activity_value) {
                    $new_json = json_decode($sub_activity_value->value, true);
                    
                    $json = [
                        "id" => $sub_activity_value->id,
                        "jtss_schedule" => "Not included",
                        "lessor" => $new_json['lessor'],
                        "contact_number" => $new_json['contact_number'],
                        "address" => $new_json['address'],
                        "region" => $new_json['region'],
                        "province" => $new_json['province'],
                        "lgu" => $new_json['lgu'],
                        "latitude" => $new_json['latitude'],
                        "longitude" => $new_json['longitude'],
                        "distance_from_nominal_point" => $new_json['distance_from_nominal_point'],
                        "site_type" => $new_json['site_type'],
                        "building_no_of_floors" => $new_json['building_no_of_floors'],
                        "area_size" => $new_json['area_size'],
                        "lease_rate" => $new_json['lease_rate'],
                        "property_use" => $new_json['property_use'],
                        "right_of_way_access" => $new_json['right_of_way_access'],
                        "certificate_of_title" => $new_json['certificate_of_title'],
                        "tax_declaration" => $new_json['tax_declaration'],
                        "tax_clearance" => $new_json['tax_clearance'],
                        "mortgaged" => $new_json['mortgaged'],
                        "tower_structure" => $new_json['tower_structure'],
                        "tower_height" => $new_json['tower_height'],
                        "swat_design" => $new_json['swat_design'],
                        "with_neighbors" => $new_json['with_neighbors'],
                        "with_history_of_opposition" => $new_json['with_history_of_opposition'],
                        "with_hoa_restriction" => $new_json['with_hoa_restriction'],
                        "with_brgy_restriction" => $new_json['with_brgy_restriction'],
                        "tap_to_lessor" => $new_json['tap_to_lessor'],
                        "tap_to_neighbor" => $new_json['tap_to_neighbor'],
                        "distance_to_tapping_point" => $new_json['distance_to_tapping_point'],
                        "meralco" => $new_json['meralco'],
                        "localcoop" => $new_json['localcoop'],
                        "genset_availability" => $new_json['genset_availability'],
                        "distance_to_nearby_transmission_line" => $new_json['distance_to_nearby_transmission_line'],
                        "distance_from_creek_river" => $new_json['distance_from_creek_river'],
                        "distance_from_national_road" => $new_json['distance_from_national_road'],
                        "demolition_of_existing_structure" => $new_json['demolition_of_existing_structure']
                    ];

                    SubActivityValue::create([
                        'type' => 'jtss_schedule_site',
                        'sam_id' => $request->input('sam_id')[0],
                        'value' => json_encode($json),
                        'status' => 'pending',
                        'user_id' => \Auth::id()
                    ]);
                }

            } else if ($request->input('activity_name') == "pac_approval" || $request->input('activity_name') == "pac_director_approval" || $request->input('activity_name') == "pac_vp_approval" || $request->input('activity_name') == "fac_approval" || $request->input('activity_name') == "fac_director_approval" || $request->input('activity_name') == "fac_vp_approval" || $request->input('activity_name') == "precon_docs_approval" || $request->input('activity_name') == "postcon_docs_approval" || $request->input('activity_name') == "approved_ssds_/_ntp_validation" || $request->input('activity_name') == "approved_moc/ntp_ram_validation" || $request->input('activity_name') == "approval_ms_lead" || $request->input('activity_name') == "approval_ibs_lead" || $request->input('activity_name') == "loi_&_ip_approval_ms_lead" || $request->input('activity_name') == "loi_&_ip_approval_ms_lead" || $request->input('activity_name') == "rt_docs_approval_ms_lead" || $request->input('activity_name') == "rt_docs_approval_ibs_lead" || $request->input('activity_name') == "precon_docs_approval_ms_lead" || $request->input('activity_name') == "precon_docs_approval_ibs_lead" || $request->input('activity_name') == "postcon_docs_approval_ms_lead" || $request->input('activity_name') == "postcon_docs_approval_ibs_lead") {
                
                $notification = "Site successfully " .$message;
                $action = $request->input('data_complete');
                $site_category = $request->input('site_category');
                $activity_id = $request->input('activity_id');
                $program_id = $request->input('program_id');

                $samid = $request->input('sam_id');

                // if ($request->input('data_complete') == 'false') {

                //     $activities = \DB::connection('mysql2')
                //                         ->table('stage_activities')
                //                         ->select('return_activity')
                //                         ->where('activity_id', $activity_id[0])
                //                         ->where('program_id', $program_id)
                //                         ->where('category', $site_category[0])
                //                         ->first();

                //     $sub_activities = \DB::connection('mysql2')
                //                             ->table('sub_activity')
                //                             ->select('sub_activity_id')
                //                             ->where('activity_id', $activities->return_activity)
                //                             ->where('program_id', $program_id)
                //                             ->where('category', $site_category[0])
                //                             ->where('requires_validation', 1)
                //                             ->get()
                //                             ->pluck('sub_activity_id');

                //     if (\Auth::user()->profile_id == 8) {
                //         $column_var = 'reviewer_id';
                //         $column_var2 = 'reviewer_approved';
                //     } else {
                //         $column_var = 'reviewer_id_2';
                //         $column_var2 = 'reviewer_approved_2';
                //     }

                //     SubActivityValue::whereIn('sub_activity_id', $sub_activities)
                //                         ->update([
                //                             'status' => 'rejected',
                //                             'reason' => $request->input('text_area_reason'),
                //                             $column_var => \Auth::id(),
                //                             $column_var2 => Carbon::now()->toDate(),
                //                         ]);
                // }

            } else if ($request->input('activity_name') == "elas_approved") {

                $notification = "Site successfully " .$message;
                $action = $request->input('data_complete');
                $site_category = $request->input('site_category');
                $activity_id = $request->input('activity_id');
                $program_id = $request->input('program_id');

                $samid = $request->input('sam_id');

                if ($action == "false") {
                    $validate = Validator::make($request->all(), array(
                        'remarks' => 'required',
                    ));
    
                    if (!$validate->passes()) {
                        return response()->json(['error' => true, 'message' => $validate->errors() ]);
                    } else {

                        $activities = \DB::connection('mysql2')
                                ->table('stage_activities')
                                ->select('return_activity')
                                ->where('activity_id', $activity_id[0])
                                ->where('program_id', $program_id)
                                ->where('category', $site_category[0])
                                ->first();

                        $sub_activities = \DB::connection('mysql2')
                                                ->table('sub_activity')
                                                ->select('sub_activity_id')
                                                ->where('program_id', $program_id)
                                                ->where('category', $site_category[0])
                                                ->where('activity_id', $activities->return_activity)
                                                ->where('requirements', 'required')
                                                ->where('requires_validation', '1')
                                                ->get()
                                                ->pluck('sub_activity_id');

                        SubActivityValue::whereIn('sub_activity_id', $sub_activities->all())
                                            ->where('status', 'approved')
                                            ->update([
                                                'approver_id' => \Auth::id(),
                                                'status' => 'rejected',
                                                'reason' => $request->input('remarks'),
                                                'date_approved' => Carbon::now()->toDate(),
                                            ]);
                                            
                        SubActivityValue::create([
                            'sam_id' => $samid[0],
                            'value' => $request->input('remarks'),
                            'type' => $request->input('type'),
                            'status' => 'rejected',
                            'user_id' => \Auth::id(),
                        ]);
                    }
                }

            } else if ($request->input('activity_name') == "Approved SSDS / SSDS NTP Validation") {

                $notification = "Site successfully " . $message;
                $action = $request->input('data_complete');
                $site_category = $request->input('site_category');
                $activity_id = $request->input('activity_id');
                $program_id = $request->input('program_id');
                $samid = $request->input('sam_id');

            } else if ($request->input('activity_name') == "rtb_docs_approval") {

                $notification = "RTB Docs successfully approved";
                $action = $request->input('data_complete');
                $site_category = $request->input('site_category');
                $activity_id = $request->input('activity_id');
                $program_id = $request->input('program_id');
                $samid = $request->input('sam_id');

            } else if ($request->input('activity_name') == "Vendor Awarding") {

                $notification = "Successfully awarded.";
                $vendor = $request->input('vendor');
                $action = $request->input('data_action');
                $activity_id = $request->input('activity_id');
                $program_id = $request->input('program_id');
                $samid = $request->input('sam_id');

            } else if ($request->input('activity_name') == "JTSS Sched Confirmation") {

                if ($request->input('data_complete') == "false") {
                    $validate = Validator::make($request->all(), array(
                        'remarks' => 'required',
                    ));
    
                    if (!$validate->passes()) {
                        return response()->json(['error' => true, 'message' => $validate->errors() ]);
                    }

                    $data = SubActivityValue::where('type', 'jtss_add_site')
                                            ->where('sam_id', $request->input('sam_id'))
                                            ->update([
                                                'status' => 'pending',
                                            ]);

                    SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('status', 'pending')
                                        ->where('sam_id', $request->input('sam_id'))
                                        ->update([
                                            'reason' => $request->input('remarks'),
                                            'approver_id' => \Auth::id(),
                                            'status' => 'rejected',
                                            'date_approved' => Carbon::now()->toDate(),
                                        ]);
                }

                $notification = "Successfully " .$message. " schedule.";
                $vendor = $request->input('vendor');
                $action = $request->input('data_complete');
                $activity_id = $request->input('activity_id');
                $program_id = $request->input('program_id');
                $samid = $request->input('sam_id');
                $site_category = $request->input('site_category');

            } else if ($request->input('activity_name') == "SSDS" || $request->input('activity_name') == "SSDS RAM Validation" || $request->input('activity_name') == "Add Site Candidates" || $request->input('activity_name') == "Joint Technical Site Survey") {

                $notification = "Successfully mark this site as completed.";
                $action = "true";
                $activity_id = $request->input('activity_id');
                $program_id = $request->input('program_id');
                $samid = $request->input('sam_id');
                $site_category = $request->input('site_category');

            } else if ($request->input('activity_name') == "mark_as_complete") {

                $notification = "Successfully mark this site as completed.";
                $action = "true";
                $activity_id = $request->input('activity_id');
                $program_id = $request->input('program_id');
                $samid = $request->input('sam_id');
                $site_category = $request->input('site_category');
                
                
                // return response()->json(['error' => true, 'message' => $request->all()]);

            } else if ($request->input('activity_name') == "Lease Details") {

                $notification = "Successfully requested an approval to RAM.";
                $action = "true";
                $activity_id = $request->input('activity_id');
                $program_id = $request->input('program_id');
                $samid = $request->input('sam_id');
                $site_category = $request->input('site_category');
                
                
                // return response()->json(['error' => true, 'message' => $request->all()]);

            } else if ($request->input('activity_name') == "Set Ariba PR Number to Sites") {

                $notification = "Successfully set PR Number.";
                $action = $request->input('data_action');

                $sites = PrMemoSite::where('pr_memo_id', $request->input('pr_id'))->get();
                $activity_id_collect = collect();
                $samid_collect = collect();
                $sitecategory_collect = collect();

                foreach ($sites as $site) {

                    if($request->input('program_id') == 1){

                        \DB::connection('mysql2')->table("site")
                        ->where("sam_id", $site->sam_id)
                        ->update([
                            'site_pr' => $request->input('pr_number'),
                        ]);

                        $samid_collect->push($site->sam_id);
                        $activity_id_collect->push(5);
                        $sitecategory_collect->push("none");

                    } else {

                        \DB::connection('mysql2')->table("site")
                        ->where("sam_id", $site->sam_id)
                        ->update([
                            'site_pr' => $request->input('pr_number'),
                        ]);

                        $samid_collect->push($site->sam_id);
                        $activity_id_collect->push(8);
                        $sitecategory_collect->push("none");

                    }
                }

                $site_category = $sitecategory_collect->all();
                $samid = $samid_collect->all();
                $activity_id = $activity_id_collect->all();
                $program_id = $request->input('program_id');

            } else {
                $notification = "Successfully approved site.";
                $vendor = $request->input('site_vendor_id');
                $action = $request->input('data_complete');
                $activity_id = $request->input('activity_id');
                $site_category = $request->input('site_category');

                $program_id = $request->input('program_id');
                $samid = $request->input('sam_id');
            }

            $asd = $this->move_site($samid, $program_id, $action, $site_category, $activity_id);

            // return response()->json(['error' => true, 'message' => $asd]);
            return response()->json(['error' => false, 'message' => $notification ]);
        } catch (\Throwable  $th) {
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

                    $array = array(
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

    public function getDataWorkflow($program_id)
    {
        try {
            $stored_procs = \DB::table('view_stage_activities_workflow_with_notifs')
                            ->where('program_id', $program_id)
                            ->get();

            $dt = DataTables::of($stored_procs);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function getWorkflow($program_id)
    {
        return \DB::connection('mysql2')->select('call `stage_activites`('.$program_id. ')');
    }

    public function unassignedSites($profile_id, $program_id, $activity_id, $what_to_load)
    {
        try {

            $vendor = \Auth::user()->getUserDetail()->first()->vendor_id;

            $stored_procs = \DB::connection('mysql2')->select('call `a_pull_data`('.$vendor.', ' .  $program_id . ', ' .  $profile_id . ', "' . $activity_id .'", "' . $what_to_load .'", "' . \Auth::user()->id .'")');

            $dt = DataTables::of($stored_procs)
                            ->addColumn('photo', function($row){
                                $photo = "<div class='avatar-icon-wrapper avatar-icon-sm avatar-icon-add'>";
                                $photo .= "<div class='avatar-icon'>";
                                $photo .= "<i>+</i>";

                                $photo .= "</div></div>";

                                return $photo;
                            })
                            ->addColumn('technology', function($row){
                                // $technology = array_key_exists('TECHNOLOGY', $row['site_fields'][0]) ? $row['site_fields'][0]['TECHNOLOGY'] : '';
                                if(isset($row->technology)){
                                    $technology = $row->technology;
                                } else {
                                    $technology = "";
                                }
                                // $technology = array_key_exists('TECHNOLOGY', $row['site_fields'][0]) ? $row['site_fields'][0]['TECHNOLOGY'] : '';
                                return "<div class='badge badge-success'>".$technology."</div>";
                            });

            $dt->rawColumns(['photo', 'technology']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function assign_agent(Request $request)
    {
        try {
            $checkAgent = \DB::connection('mysql2')->table('site_users')->where('sam_id', $request->input('sam_id'))->where('agent_id', $request->input('agent_id'))->first();

            $profile_id = \Auth::user()->profile_id;
            $id = \Auth::user()->id;

            if(is_null($checkAgent)) {

                SiteAgent::create([
                    'agent_id' => $request->input('agent_id'),
                    'sam_id' => $request->input('sam_id'),
                ]);

                $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);

                return response()->json(['error' => false, 'message' => "Successfully assigned agent."]);
            } else {
                $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);

                return response()->json(['error' => false, 'message' => "Successfully assigned agent."]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function assign_supervisor(Request $request)
    {
        try {
            $checkAgent = \DB::connection('mysql2')->table('site_users')->where('sam_id', $request->input('sam_id'))->where('agent_id', $request->input('agent_id'))->first();

            $profile_id = \Auth::user()->profile_id;
            $id = \Auth::user()->id;

            if(is_null($checkAgent)) {

                SiteAgent::create([
                    'agent_id' => $request->input('agent_id'),
                    'sam_id' => $request->input('sam_id'),
                ]);

                $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);

                return response()->json(['error' => false, 'message' => "Successfully assigned supervisor."]);
            } else {
                $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);

                return response()->json(['error' => false, 'message' => "Successfully assigned supervisor."]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function vendor_assigned_sites($program_id, $mode)
    {
        if($mode == "vendor"){
            if((\Auth::user()->profile_id)==2){
                $sites = \DB::connection('mysql2')->table('site')
                            ->join('site_users', 'site_users.sam_id', 'site.sam_id')
                            ->where('program_id', "=", $program_id)
                            ->where('site_users.agent_id', "=", \Auth::user()->id)
                            ->get();
            } else {
                $sites = \DB::connection('mysql2')->table('site')
                            ->join('site_users', 'site_users.sam_id', 'site.sam_id')
                            ->join('user_details', 'user_details.user_id', 'site_users.agent_id')
                            ->where('program_id', "=", $program_id)
                            ->where('IS_id', "=", \Auth::user()->id)
                            ->get();
            }
        } else {

            $sites = \DB::connection('mysql2')->table('site')
            ->join('site_users', 'site_users.sam_id', 'site.sam_id')
            ->join('user_details', 'user_details.user_id', 'site_users.agent_id')
            ->where('program_id', "=", $program_id)
            ->get();

        }


        // dd($sites);


        $dt = DataTables::of($sites);
        return $dt->make(true);
    }

    public function agent_assigned_sites_columns()
    {
        $sites = \Schema::connection('mysql2')->getColumnListing('site');
        return $sites;
    }

    public function agents($program_id)
    {

        try {
            $checkAgent = \DB::connection('mysql2')
                                    ->table('users')
                                    ->select('users.id', 'users.firstname', 'users.lastname', 'users.email', 'users_areas.region', 'users_areas.province')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
                                    ->join('user_programs', 'user_programs.user_id', 'users.id')
                                    ->join('users_areas', 'users_areas.user_id', 'users.id')
                                    ->where('user_details.IS_id', \Auth::user()->id)
                                    ->where('user_programs.program_id', $program_id)
                                    ->get();

            $dt = DataTables::of($checkAgent)
                    ->addColumn('photo', function($row){
                        $photo = "<div class=avatar-icon-wrapper avatar-icon-sm'>";
                        $photo .= "<div class='avatar-icon'>";
                        $photo .= "<img src='data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkExQjJCNTVFRUNGMDExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkExQjJCNTVERUNGMDExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJGQTNDMzBENTkxNUNENDY3Qjg0REZERUVBM0VDRkYwMyIgc3RSZWY6ZG9jdW1lbnRJRD0iRkEzQzMwRDU5MTVDRDQ2N0I4NERGREVFQTNFQ0ZGMDMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwMDAwMDBAMDg8QDw4MExMUFBMTHBsbGxwfHx8fHx8fHx8fAQcHBw0MDRgQEBgaFREVGh8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx//wAARCABAAEADAREAAhEBAxEB/8QAlQAAAgMAAwEAAAAAAAAAAAAABQYEBwgBAgMAAQADAQEBAQAAAAAAAAAAAAADBAUBAgAGEAACAQMDAQUDCgYDAAAAAAABAgMRBAUAEgYhMWEiEwdBUXKBscEyQlIjFBYIkWIzQ2MVcaGyEQACAQIFAQYGAwAAAAAAAAAAAQIRAyExQRIEcVGBkTMkBWEiMlIjNMGSE//aAAwDAQACEQMRAD8AZ+RYq3TBu9OoAoffrjlW0rKfQ5tSrMnel1hH/pR09p1C5EcR628Dy9SuU5LAR4/F4KJZs1lGfZRRK0MKDq/l+9iaAt0HbrOHx1cbcvpQST7MypORr6p5lqSS5R0XogZ3jSlaHwqVXs1VhatxWCRw4zYJxnOPVTgk6zNNcy2aEGTGZNGubKRPutvqyfErCmulC3LSL7gc4ySxL0w3qrxr1B9N7y4t7OPHZ6xZFv8AGoAfKLN4ZY3AXdFIo+Q9D7zm1KcaKgGjozNvNemVm730xIyJ6WDFY4gELFh4QNGbSVWejCUnRKppDk4X9OyfCvzjXPL/AF/6gLX1kn0rdBhiX/ppuZ/hWpP/AENQuSh+1kD/AEzxEt/LleWZIFstnblnDn+1ZqaQwpXsUKBUadhapFRWSGbcqVZYklpCo2q5NR8mvSgtDuM2xW5ZiLO6tHhkRZo2BEsLgGqkUI66VmqOqGYOqxKX9L+KWmL5FzgoZB+QtoYbFa0j/LzykkMPtMpQBdUbc921km7DbuQgc66ZWX49GkAhkTsFUi0PfofM8sf9q89GguT1/Tkp/wAY+jR+QvT+BIt+YcemzyfpHIMnWRbe42jv2NqLdxkkULeQcwN/DjuJ4+42gl4vBG1fGygkgBakmi+zVSlXRBtCdgOXDM2M95NapbiCMTJsZiGiYVUjeFNWHs0K40q1zQSEcqPCQvXXLv8AYTvA8EFurKZLWrv5zqG2daqEru8I69ugXLe6G6gaMtsttcRUwyyLyrlqKhET4y2aRqUo4m6f+jonGyQnzM2Upz5aZWb4tOTE4ZBLiYVprIN1BJqNB9w8hlT2JV5UUzQHJYSeJyv/AIQfm09ej6fuRAtv8i6kf0mZ2wMhUb2ik8xY/vbGqF+XUSE6XVUr8dpPHUecalquNBk2Qm28wOQKLGQTvAr2Cp05twCr6qES6ucatpdxMy27tAzkU6tX2kCvU+7Q5wrBh4uk1qDsFFjb/FNURSSIm8KQpDgHtr29D79Kwi2mM3cGgSttAY8zNHHtkZyZZvvBYwgB/wCCdE4qe9CnLaVmXa/4M5eoi7crL8WqVwkW8iXxI/jWR/mPzaDz1+Blb2H9uPU0dkorm+4nLDBC0ha3C1HvoNUab+PRZuKPnK7Z1ejBfpXHNZ2ssMg2MrtVT2jrr5/lWZReKKVmaksA5lshbRDJYiZtjXBF5AR0JjcqSyV7dki0bRuPN3LfxTG1Kjqz0FiLSyiJZ8klySIrtpTBId/9uRY020HZ07fbpmTW3IbszT1p3VFjIy2nFr5b++uSty6yUhUhbaKNlCH2bmp39a6RrVvA6vSXcN0WAubbg0uRu0aG+vt15cwN02CX6iFfYVSle/VGzYUYrtI1++5t/boZW9SgRlpfi0S6CtZHtxI/jWXxfRoPO8hlX2N+rh1NgcMewGJit2ZWZVo1addE4t9uzF6pEu/bUZtBuHD4WJ2eOCJGb6xUAV/hpS+97rJnVuKisBH5WnC+V5G949YXKyZnj6hr17YEPaPcfVTzKbG3bCHj699DreNaUK01CqVRUtr3nvH0eyu8YM5ZIp/KXds4Q7utBLE5BHuqDTRrsVSoa1daBNtxfK5XIy8l5VEjT2kTSY7Dq3mRp5QLoZ27HckUUDoO86nTuJYRGYxcnVjNxP1osPUjhGSkhsZMfkbMrDkLN28xVLgsjpJRaqdhHiAII1Z/0jlqyMoSp0M6epwplJD7zrLptnI+4i341l8f0aDzf130Knsr9XDqW9fLyji3Onx9jc0wMoEsSz9Qgbo4Vz2BToHElJRa+0mTt75fEZ8p+4TgXHIEtfPlzubjA8y2x4DQpIPsyXLUjHft3ayNmdzFraEbUcFiV5+3DktovKeUWt2wGUzkoyMT1r5mx5GljUnt2+bu01d+VrsyO7GKa1NA3Qh8ojYW302he/Q7jwCQWJX3q1y2HhvEZ7tUDZG7JtsdCexrh1NWP8sS+I/JpRWN8qaajMr2xV8DKnGOUcj4zkJMhiLw29xMjR3SsA8U6MasssbeFupqPcezVLavAmVJWb5LPnZPOvIkguPtPFXYe/aakfx1s1uMh8oU4vkrCG4tEluEj2uKs9VHXvOhctN2WlnQf9quRhyYSk6RqDs9yvk/Irt7rO5S4yE7dPxX8AH3VRdqAd1NHjBLJE8GA0TYvhUdgHSg+TXaMObTIZKxvre8xsj2txbPviukYxyAj7hHUaxquDyNTpii7OEfufyVnazW3M7M30kULvZ5G2CpJK6iqRXCCieI9PMUdPaNLSsOvyvAYjeWpUvOOf8AI+b5h8plyocHbaW6E+TBFX+nGnsB9rfWPadFSSVEBlJt1YCCEgVp307taYdwo148d6A1Hs1ph//Z'>";

                        $photo .= "</div></div>";

                        return $photo;
                    })
                    ->addColumn('areas', function($row){
                        return $row->region. " | " .$row->province;
                    });

            $dt->rawColumns(['photo']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function newagent($program_id)
    {
        try {
            $checkAgent = \DB::connection('mysql2')
                                    ->table('users')
                                    ->select('users.id', 'users.firstname', 'users.lastname', 'users.email')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
                                    ->join('user_programs', 'user_programs.user_id', 'user_details.user_id')
                                    ->leftJoin('users_areas', 'users_areas.user_id', 'users.id')
                                    ->where('user_details.IS_id', \Auth::user()->id)
                                    ->whereNull('users_areas.user_id')
                                    ->where('user_programs.program_id', $program_id)
                                    ->get();

            $dt = DataTables::of($checkAgent)
                    ->addColumn('photo', function($row){
                        $photo = "<div class=avatar-icon-wrapper avatar-icon-sm'>";
                        $photo .= "<div class='avatar-icon'>";
                        $photo .= "<img src='data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMfaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkExQjJCNTVFRUNGMDExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkExQjJCNTVERUNGMDExRThBNjRDQzQyMTE5Mjk5QTQ0IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IE1hY2ludG9zaCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJGQTNDMzBENTkxNUNENDY3Qjg0REZERUVBM0VDRkYwMyIgc3RSZWY6ZG9jdW1lbnRJRD0iRkEzQzMwRDU5MTVDRDQ2N0I4NERGREVFQTNFQ0ZGMDMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYGCAsMCgoLCgoMEAwMDAwMDBAMDg8QDw4MExMUFBMTHBsbGxwfHx8fHx8fHx8fAQcHBw0MDRgQEBgaFREVGh8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx//wAARCABAAEADAREAAhEBAxEB/8QAlQAAAgMAAwEAAAAAAAAAAAAABQYEBwgBAgMAAQADAQEBAQAAAAAAAAAAAAADBAUBAgAGEAACAQMDAQUDCgYDAAAAAAABAgMRBAUAEgYhMWEiEwdBUXKBscEyQlIjFBYIkWIzQ2MVcaGyEQACAQIFAQYGAwAAAAAAAAAAAQIRAyExQRIEcVGBkTMkBWEiMlIjNMGSE//aAAwDAQACEQMRAD8AZ+RYq3TBu9OoAoffrjlW0rKfQ5tSrMnel1hH/pR09p1C5EcR628Dy9SuU5LAR4/F4KJZs1lGfZRRK0MKDq/l+9iaAt0HbrOHx1cbcvpQST7MypORr6p5lqSS5R0XogZ3jSlaHwqVXs1VhatxWCRw4zYJxnOPVTgk6zNNcy2aEGTGZNGubKRPutvqyfErCmulC3LSL7gc4ySxL0w3qrxr1B9N7y4t7OPHZ6xZFv8AGoAfKLN4ZY3AXdFIo+Q9D7zm1KcaKgGjozNvNemVm730xIyJ6WDFY4gELFh4QNGbSVWejCUnRKppDk4X9OyfCvzjXPL/AF/6gLX1kn0rdBhiX/ppuZ/hWpP/AENQuSh+1kD/AEzxEt/LleWZIFstnblnDn+1ZqaQwpXsUKBUadhapFRWSGbcqVZYklpCo2q5NR8mvSgtDuM2xW5ZiLO6tHhkRZo2BEsLgGqkUI66VmqOqGYOqxKX9L+KWmL5FzgoZB+QtoYbFa0j/LzykkMPtMpQBdUbc921km7DbuQgc66ZWX49GkAhkTsFUi0PfofM8sf9q89GguT1/Tkp/wAY+jR+QvT+BIt+YcemzyfpHIMnWRbe42jv2NqLdxkkULeQcwN/DjuJ4+42gl4vBG1fGygkgBakmi+zVSlXRBtCdgOXDM2M95NapbiCMTJsZiGiYVUjeFNWHs0K40q1zQSEcqPCQvXXLv8AYTvA8EFurKZLWrv5zqG2daqEru8I69ugXLe6G6gaMtsttcRUwyyLyrlqKhET4y2aRqUo4m6f+jonGyQnzM2Upz5aZWb4tOTE4ZBLiYVprIN1BJqNB9w8hlT2JV5UUzQHJYSeJyv/AIQfm09ej6fuRAtv8i6kf0mZ2wMhUb2ik8xY/vbGqF+XUSE6XVUr8dpPHUecalquNBk2Qm28wOQKLGQTvAr2Cp05twCr6qES6ucatpdxMy27tAzkU6tX2kCvU+7Q5wrBh4uk1qDsFFjb/FNURSSIm8KQpDgHtr29D79Kwi2mM3cGgSttAY8zNHHtkZyZZvvBYwgB/wCCdE4qe9CnLaVmXa/4M5eoi7crL8WqVwkW8iXxI/jWR/mPzaDz1+Blb2H9uPU0dkorm+4nLDBC0ha3C1HvoNUab+PRZuKPnK7Z1ejBfpXHNZ2ssMg2MrtVT2jrr5/lWZReKKVmaksA5lshbRDJYiZtjXBF5AR0JjcqSyV7dki0bRuPN3LfxTG1Kjqz0FiLSyiJZ8klySIrtpTBId/9uRY020HZ07fbpmTW3IbszT1p3VFjIy2nFr5b++uSty6yUhUhbaKNlCH2bmp39a6RrVvA6vSXcN0WAubbg0uRu0aG+vt15cwN02CX6iFfYVSle/VGzYUYrtI1++5t/boZW9SgRlpfi0S6CtZHtxI/jWXxfRoPO8hlX2N+rh1NgcMewGJit2ZWZVo1addE4t9uzF6pEu/bUZtBuHD4WJ2eOCJGb6xUAV/hpS+97rJnVuKisBH5WnC+V5G949YXKyZnj6hr17YEPaPcfVTzKbG3bCHj699DreNaUK01CqVRUtr3nvH0eyu8YM5ZIp/KXds4Q7utBLE5BHuqDTRrsVSoa1daBNtxfK5XIy8l5VEjT2kTSY7Dq3mRp5QLoZ27HckUUDoO86nTuJYRGYxcnVjNxP1osPUjhGSkhsZMfkbMrDkLN28xVLgsjpJRaqdhHiAII1Z/0jlqyMoSp0M6epwplJD7zrLptnI+4i341l8f0aDzf130Knsr9XDqW9fLyji3Onx9jc0wMoEsSz9Qgbo4Vz2BToHElJRa+0mTt75fEZ8p+4TgXHIEtfPlzubjA8y2x4DQpIPsyXLUjHft3ayNmdzFraEbUcFiV5+3DktovKeUWt2wGUzkoyMT1r5mx5GljUnt2+bu01d+VrsyO7GKa1NA3Qh8ojYW302he/Q7jwCQWJX3q1y2HhvEZ7tUDZG7JtsdCexrh1NWP8sS+I/JpRWN8qaajMr2xV8DKnGOUcj4zkJMhiLw29xMjR3SsA8U6MasssbeFupqPcezVLavAmVJWb5LPnZPOvIkguPtPFXYe/aakfx1s1uMh8oU4vkrCG4tEluEj2uKs9VHXvOhctN2WlnQf9quRhyYSk6RqDs9yvk/Irt7rO5S4yE7dPxX8AH3VRdqAd1NHjBLJE8GA0TYvhUdgHSg+TXaMObTIZKxvre8xsj2txbPviukYxyAj7hHUaxquDyNTpii7OEfufyVnazW3M7M30kULvZ5G2CpJK6iqRXCCieI9PMUdPaNLSsOvyvAYjeWpUvOOf8AI+b5h8plyocHbaW6E+TBFX+nGnsB9rfWPadFSSVEBlJt1YCCEgVp307taYdwo148d6A1Hs1ph//Z'>";

                        $photo .= "</div></div>";

                        return $photo;
                    })
                    ->addColumn('areas', function($row){
                        return null;
                    });

            $dt->rawColumns(['photo']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function vendor_agents($user_id = null)
    {

        try {

            if (is_null($user_id)) {

                $vendors = UserDetail::select('vendor_id')->where('user_id', \Auth::id())->first();

                $checkAgent = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                        ->where('user_details.vendor_id', $vendors->vendor_id)
                                        ->where('users.profile_id', 2)
                                        ->get();

                $dt = DataTables::of($checkAgent)
                                    ->addColumn('action', function($row){
                                        $btn = '<button class="btn btn-sm btn-primary btn-shadow update-data" data-value="'.$row->user_id.'" data-is_id="'.$row->IS_id.'" data-vendor_id="'.$row->vendor_id.'" title="Update">Edit</button> ';
                                        $btn .= '<button class="btn btn-sm btn-shadow btn-danger disable_btn" data-name="'.$row->name.'" data-value="'.$row->user_id.'" data-is_id="'.$row->IS_id.'" data-vendor_id="'.$row->vendor_id.'" title="Disable">Disable</button> ';
                                        $btn .= '<button class="btn btn-sm btn-shadow btn-secondary offboard_btn" data-name="'.$row->name.'" data-value="'.$row->user_id.'" data-is_id="'.$row->IS_id.'" data-vendor_id="'.$row->vendor_id.'" title="Disable">Offboard</button>';

                                        return $btn;
                                    });
            } else {
                $vendors = UserDetail::select('vendor_id')->where('user_id', \Auth::id())->first();

                $checkAgent = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                        ->where('user_details.vendor_id', $vendors->vendor_id)
                                        ->where('users.profile_id', 2)
                                        ->where('user_details.IS_id', $user_id)
                                        ->get();

                $dt = DataTables::of($checkAgent)
                                    ->addColumn('action', function($row){
                                        return '<button class="btn btn-sm btn-primary get_supervisor" data-user_id="'.$row->user_id.'" data-profile_id="'.$row->profile_id.'" data-is_id="'.$row->IS_id.'" data-name="'.$row->name.'" data-vendor_id="'.$row->vendor_id.'" title="Update"><i class="fa fa-edit"></i></button>';
                                    });
            }


            $dt->rawColumns(['action']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function vendor_supervisors()
    {
        try {
            $checkSupervisor = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                    ->where('user_details.IS_id', \Auth::id())
                                    ->where('users.profile_id', 3)
                                    ->get();

            $dt = DataTables::of($checkSupervisor)
                                ->addColumn('number_agent', function($row){
                                    $agents = UserDetail::select('user_id')->where('IS_id', $row->user_id)->get();
                                    return count($agents);
                                })
                                ->addColumn('action', function($row){
                                    $btn = '<button class="btn btn-sm btn-shadow btn-danger disable_btn" data-name="'.$row->name.'" data-value="'.$row->user_id.'" data-is_id="'.$row->IS_id.'" data-vendor_id="'.$row->vendor_id.'" title="Disable">Disable</button> ';
                                    $btn .= '<button class="btn btn-sm btn-shadow btn-secondary offboard_btn" data-name="'.$row->name.'" data-value="'.$row->user_id.'" data-is_id="'.$row->IS_id.'" data-vendor_id="'.$row->vendor_id.'" title="Disable">Offboard</button>';

                                    return $btn;
                                });

            $dt->rawColumns(['action']);

            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function vendor_employees()
    {
        try {
            $checkSupervisor = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                    ->where('user_details.IS_id', \Auth::id())
                                    ->where('users.profile_id', 1)
                                    ->get();

            $dt = DataTables::of($checkSupervisor)
                            ->addColumn('number_agent', function($row){
                                $agents = UserDetail::select('user_id')->where('IS_id', $row->user_id)->get();
                                return count($agents);
                            });

            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function get_agent_of_supervisor($user_id)
    {
        try {
            $getAgentOfSupervisor = UserDetail::select('users.firstname', 'users.lastname', 'users.email', 'users_areas.lgu', 'users_areas.province', 'users_areas.region')
                                    ->join('users', 'user_details.user_id', 'users.id')
                                    ->leftJoin('users_areas', 'users_areas.user_id', 'users.id')
                                    ->where('user_details.IS_id', $user_id)
                                    // ->where('users.profile_id', 3)
                                    ->get();

            return response()->json(["error" => false, "message" => $getAgentOfSupervisor]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(["error" => true, "message" => $th->getMessage()]);
        }
    }

    public function get_region()
    {
        try {
            $is_location = \DB::connection('mysql2')
                                ->table('user_details')
                                ->join('users_areas', 'users_areas.user_id', 'user_details.IS_id')
                                // ->where('user_details.user_id', \Auth::user()->id)
                                ->where('user_details.IS_id', \Auth::user()->id)
                                ->first();

                                // dd($is_location);

            if(!is_null($is_location)){
                $region = \DB::connection('mysql2')
                                ->table('location_regions')
                                ->where('region_name', $is_location->region)
                                ->get();
                
                if (count($region) < 1) {
                    $region = \DB::connection('mysql2')
                                    ->table('location_regions')
                                    ->get();
                }
            } else {
                $region = \DB::connection('mysql2')
                                ->table('location_regions')
                                ->get();
            }
            return response()->json(['error' => false, 'message' => $region]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_location($location_id, $location_type)
    {
        try {
            if($location_type == "region") {
                $table = 'location_provinces';
            } else if($location_type == "province") {
                $table = 'location_lgus';
            }
            $location = \DB::connection('mysql2')->table($table)->where($location_type."_id", $location_id)->get();

            return response()->json(['error' => false, 'message' => $location]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function assign_agent_site(Request $request)
    {
        try {
            $provinces = collect();
            $lgus = collect();

            $validate = Validator::make($request->all(), array(
                'region' => 'required',
                'province' => 'required'
            ));

            if (!$validate->passes()) {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            } else {
                $region = preg_replace("/[\[\]']+/m", "", preg_replace('/(?:\[[^][]*])(*SKIP)(*F)|[^][(){}]+/m', '', $request->input('region')));
    
                $province = preg_replace("/[\[\]']+/m", "", preg_replace('/(?:\[[^][]*])(*SKIP)(*F)|[^][(){}]+/m', '', $request->input('province')));
    
                $lgus = preg_replace("/[\[\]']+/m", "", preg_replace('/(?:\[[^][]*])(*SKIP)(*F)|[^][(){}]+/m', '', $request->input('lgu')));
    
    
                $lgu_validator = in_array('all', $province) ? '' : 'required';
                $lgu = in_array('all', $province) ? ['all'] : $lgus;
    
                $validate = Validator::make($request->all(), array(
                    'region' => 'required',
                    'province' => 'required',
                    'lgu' => $lgu_validator
                ));
    
                if($validate->passes()){
                    UsersArea::create([
                        'user_id' => $request->input('user_id'),
                        'region' => $region,
                        'province' => in_array('all', $province) ? '%' : implode(", ", $province),
                        'lgu' => in_array('all', $lgu) ? '%' : implode(", ", $lgu),
                    ]);
                    return response()->json(['error' => false, 'message' => "Successfully assigned agent site."]);
                } else {
                    return response()->json(['error' => true, 'message' => $validate->errors() ]);
                }
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function loi_template($sam_id = "", $sub_activity_id = "")
    {
        try {

            $sub_activity_files = SubActivityValue::where('sam_id', $sam_id)
                                                        ->where('sub_activity_id', $sub_activity_id)
                                                        ->where('user_id', \Auth::id())
                                                        ->orderBy('date_created', 'desc')
                                                        ->first();
            if(is_null($sub_activity_files)){
                $content = "<img src='".asset('images/globe-logo.png')."' width='150px'><br>";
                $content .= "<p>October 1, 2019</p>";
                $content .= "<p>ROSELIO R. ARAN DIA AND YOLANDA DC. ARANDIA</p>";
                $content .= "<p>Arandia Academy, Airport Village, Barangay Moonwalk, Paranque City</p>";
                $content .= "<p>Subject: <b>NOTICE TO PROCEED</b></p>";
                $content .= "<p>Dear <b>Sir/Ma'am</b></p>";
                $content .= "<p>We would like to seek for your approval to allow Globe Telecom, Inc., its employees, agents or representatives to commence with the enhancement of facilities, equipment and appurtenances located at Arandia Academy, Airport Village, Barangay Moonwalk, Paranque City.</p>";

                $content .= "<p>Kindly signify your confirmation by affixing your signature in the space provided below. Thank you</p>";


                return response()->json(['error' => false, 'message' => $content]);
            } else {
                return response()->json(['error' => false, 'message' => $sub_activity_files->value]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function download_pdf(Request $request)
    {
        try {
            $sub_act = SubActivityValue::where('sam_id', $request->input("sam_id"))
                                        ->where('sub_activity_id', $request->input("sub_activity_id"))
                                        ->where('user_id', \Auth::id())
                                        ->first();

                                        // dd($sub_act);
            if(is_null($sub_act)){
                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'sub_activity_id' => $request->input("sub_activity_id"),
                    'value' => $request->input("editordata"),
                    'user_id' => \Auth::id(),
                    'status' => "pending",
                ]);
            } else {
            //     abort(403, 'Unable to print this to pdf.');
                SubActivityValue::where('id', $sub_act->id)
                                    ->update([
                                        'value' => $request->input("editordata"),
                                        'status' => "pending",
                                    ]);
            }

            $pdf = \App::make('dompdf.wrapper');
            $pdf = PDF::loadHTML($request->input('editordata'));
            $pdf->setPaper('a4');
            $pdf->download();
            return $pdf->stream();

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            abort(403, $th->getMessage());
        }
    }

    public function fileupload(Request $request)
    {

        try {
            $validate = Validator::make($request->all(), array(
                'file' => 'required',
            ));

            // return response()->json(['error' => true, 'message' => $request->all() ]);

            if($validate->passes()){
                if($request->hasFile('file')) {

                    // Upload path
                    $destinationPath = 'files/';

                    // Get file extension
                    $extension = $request->file('file')->getClientOriginalExtension();

                    // Rename file
                    // $fileName = time().$request->file('file')->getClientOriginalName() .'.' . $extension;
                    $fileName = time().$request->file('file')->getClientOriginalName();

                    // Uploading file to given path
                    $request->file('file')->move($destinationPath, $fileName);

                    return response()->json(['error' => false, 'message' => "Successfully uploaded a file.", "file" => $fileName]);

                }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()->all()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function upload_my_file(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'file_name' => 'required',
            ));

            $new_file = $this->rename_file($request->input("file_name"), $request->input("sub_activity_name"), $request->input("sam_id"), $request->input("site_category"));

            \Storage::move( $request->input("file_name"), $new_file );

            // sub_activity_name
            if($validate->passes()){

                $sub_activities = SubActivity::select('requires_validation', 'requirements')
                                                ->where('activity_id', $request->input("activity_id"))
                                                ->where('program_id', $request->input("program_id"))
                                                ->where('category', $request->input("site_category"))
                                                ->where('sub_activity_id', $request->input("sub_activity_id"))
                                                ->first();

                if ( $sub_activities->requirements == "required" ) {
                    if ( is_null($sub_activities->requires_validation) ) {
                        $file_status = "approved";
                    } else {
                        $file_status = "pending";
                    }
                } else {
                    $file_status = "approved";
                }

                $stage_activities = \DB::connection('mysql2')
                                ->table('stage_activities')
                                ->select('id', 'activity_type', 'approver_profile_id_1')
                                ->where('program_id', $request->input('program_id'))
                                ->where('activity_id', $request->input('activity_id'))
                                ->where('category', $request->input("site_category"))
                                ->first();

                if ($stage_activities->activity_type == 'doc upload') {

                    $stage_activities_approvers = \DB::connection('mysql2')
                                ->table('stage_activities_approvers')
                                ->select('approver_profile_id')
                                ->where('stage_activities_id', $stage_activities->id)
                                ->get();

                    if ( count($stage_activities_approvers) < 1 ) {
                        return response()->json(['error' => true, 'message' => "No approver found."]);
                    }

                    $approvers_collect = collect();

                    foreach ($stage_activities_approvers as $stage_activities_approver) {
                        $approvers_collect->push([
                            'profile_id' => $stage_activities_approver->approver_profile_id,
                            'status' => $file_status == 'approved' ? 'approved' : 'pending'
                        ]);
                    }

                    $array_data = [
                        'file' => $new_file,
                        'active_profile' => $file_status == 'approved' ? '' : $stage_activities_approvers[0]->approver_profile_id,
                        'active_status' => $file_status == 'approved' ? 'approved' : 'pending',
                        'validator' => $file_status == 'approved' ? 0 : count($approvers_collect->all()),
                        'validators' => $approvers_collect->all()
                    ];

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($array_data),
                        'user_id' => \Auth::id(),
                        'type' => 'doc_upload',
                        'status' => $file_status,
                    ]);

                } else if ($stage_activities->activity_type != 'doc upload') {

                    $array_data = [
                        'file' => $new_file
                    ];

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($array_data),
                        'user_id' => \Auth::id(),
                        'type' => 'doc_upload',
                        'status' => $file_status,
                    ]);

                    $sub_activities = SubActivity::where('activity_id', $request->input("activity_id"))
                                                ->where('program_id', $request->input("program_id"))
                                                ->where('category', $request->input("site_category"))
                                                ->where('requirements', 'required')
                                                ->get();

                    $array_sub_activity = collect();

                    foreach ($sub_activities as $sub_activity) {
                        $array_sub_activity->push($sub_activity->sub_activity_id);
                    }

                    $sub_activity_value = SubActivityValue::select('sub_activity_id')
                                                            ->whereIn('sub_activity_id', $array_sub_activity->all())
                                                            ->where('sam_id', $request->input("sam_id"))
                                                            // ->where('status', 'pending')
                                                            ->where('type', 'doc_upload')
                                                            ->groupBy('sub_activity_id')
                                                            ->get();

                    if (count($array_sub_activity->all()) <= count($sub_activity_value) ) {
                        $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", [$request->input("site_category")], [$request->input("activity_id")]);
                    }
                }

                return response()->json(['error' => false, 'message' => "Successfully uploaded a file."]);
            } else {
                return response()->json(['error' => true, 'message' => "Please upload a file."]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }


    public function rename_file($filename_data, $sub_activity_name, $sam_id, $site_category = null)
    {
        $ext = pathinfo($filename_data, PATHINFO_EXTENSION);

        $file_name = strtolower($sam_id."-".str_replace(" ", "-", $sub_activity_name)).".".$ext;

        if (file_exists( public_path()."/files/".$file_name )) {

            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);

            $exploaded_name = explode("-", $withoutExt);

            if ( is_numeric( end( $exploaded_name) ) ) {
                $counter =  end( $exploaded_name) + "01";
            } else {
                $counter =  strtolower(str_replace(" ", "-", $sub_activity_name))."-01";
            }

            $imploded_name = implode("-", array_slice($exploaded_name, 0, -1));

            $cat = $site_category == 'none' ? "-" : "-".$site_category."-";

            $new_file = $imploded_name .$cat. $counter . "." .$ext;

            while (file_exists( public_path()."/files/". $new_file)) {
                $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $new_file);

                $exploaded_name = explode("-", $withoutExt);

                if ( is_numeric( end( $exploaded_name) ) ) {
                    $counter =  end( $exploaded_name) + "01";
                } else {
                    $counter =  "01";
                }

                $imploded_name = implode("-", array_slice($exploaded_name, 0, -1));

                $new_file = $imploded_name . "-" . $counter . "." .$ext;
            }

            return $new_file = $new_file;

        } else {
            return $new_file = $file_name;
        }
    }


    public function add_site_candidates (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'lessor' => 'required',
                'contact_number' => 'required',
                'address' => 'required',
                'region' => 'required',
                'province' => 'required',
                'lgu' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'distance_from_nominal_point' => 'required',
                'site_type' => 'required',
                'building_no_of_floors' => 'required',
                'area_size' => 'required',
                'lease_rate' => 'required',
                'property_use' => 'required',
                'right_of_way_access' => 'required',
                'certificate_of_title' => 'required',
                'tax_declaration' => 'required',
                'tax_clearance' => 'required',
                'mortgaged' => 'required',
                'tower_structure' => 'required',
                'tower_height' => 'required',
                'swat_design' => 'required',
                'with_neighbors' => 'required',
                'with_history_of_opposition' => 'required',
                'with_hoa_restriction' => 'required',
                'with_brgy_restriction' => 'required',
                'tap_to_lessor' => 'required',
                'tap_to_neighbor' => 'required',
                'distance_to_tapping_point' => 'required',
                'meralco' => 'required',
                'localcoop' => 'required',
                'genset_availability' => 'required',
                'distance_to_nearby_transmission_line' => 'required',
                'distance_from_creek_river' => 'required',
                'distance_from_national_road' => 'required',
                'demolition_of_existing_structure' => 'required',

            ));

            if ($validate->passes()) {

                // if (!is_null($request->input("file"))) {
                //     $file = collect();
                //     for ($i=0; $i < count($request->input("file")); $i++) {
                //         $new_file = $this->rename_file($request->input("file")[$i], $request->input("sub_activity_name"), $request->input("sam_id"));

                //         \Storage::move( $request->input("file")[$i], $new_file );

                //         $file->push($new_file);
                //     }
                // }

                $json = array(
                    'lessor' => $request->input('lessor'),
                    'contact_number' => $request->input('contact_number'),
                    'address' => $request->input('address'),
                    'region' => $request->input('region'),
                    'province' => $request->input('province'),
                    'lgu' => $request->input('lgu'),
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'distance_from_nominal_point' => $request->input('distance_from_nominal_point'),
                    'site_type' => $request->input('site_type'),
                    'building_no_of_floors' => $request->input('building_no_of_floors'),
                    'area_size' => $request->input('area_size'),
                    'lease_rate' => $request->input('lease_rate'),
                    'property_use' => $request->input('property_use'),
                    'right_of_way_access' => $request->input('right_of_way_access'),
                    'certificate_of_title' => $request->input('certificate_of_title'),
                    'tax_declaration' => $request->input('tax_declaration'),
                    'tax_clearance' => $request->input('tax_clearance'),
                    'mortgaged' => $request->input('mortgaged'),
                    'tower_structure' => $request->input('tower_structure'),
                    'tower_height' => $request->input('tower_height'),
                    'swat_design' => $request->input('swat_design'),
                    'with_neighbors' => $request->input('with_neighbors'),
                    'with_history_of_opposition' => $request->input('with_history_of_opposition'),
                    'with_hoa_restriction' => $request->input('with_hoa_restriction'),
                    'with_brgy_restriction' => $request->input('with_brgy_restriction'),
                    'tap_to_lessor' => $request->input('tap_to_lessor'),
                    'tap_to_neighbor' => $request->input('tap_to_neighbor'),
                    'distance_to_tapping_point' => $request->input('distance_to_tapping_point'),
                    'meralco' => $request->input('meralco'),
                    'localcoop' => $request->input('localcoop'),
                    'genset_availability' => $request->input('genset_availability'),
                    'distance_to_nearby_transmission_line' => $request->input('distance_to_nearby_transmission_line'),
                    'distance_from_creek_river' => $request->input('distance_from_creek_river'),
                    'distance_from_national_road' => $request->input('distance_from_national_road'),
                    'demolition_of_existing_structure' => $request->input('demolition_of_existing_structure'),

                );

                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'type' => $request->input("type"),
                    'sub_activity_id' => $request->input("sub_activity_id"),
                    'value' => json_encode($json),
                    'user_id' => \Auth::id(),
                    'status' => "pending",
                ]);

                return response()->json(['error' => false, 'message' => "Successfully Added Site Candidate." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_my_uploade_file(Request $request)
    {
        try {
            $sub_activity_files = SubActivityValue::where('sam_id', $request->input('sam_id'))
                                                        ->where('sub_activity_id', $request->input('sub_activity_id'))
                                                        ->where('user_id', \Auth::id())
                                                        ->orderBy('date_created', 'desc')
                                                        ->get();

            return response()->json(['error' => false, 'message' => $sub_activity_files]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_my_uploaded_site ($sub_activity_id, $sam_id)
    {
        try {
            $sub_activity_files = SubActivityValue::where('sam_id', $sam_id)
                                                        // ->where('sub_activity_id', $sub_activity_id)
                                                        // ->where('type', "jtss_add_site")
                                                        ->where('user_id', \Auth::id())
                                                        ->where('type', "advanced_site_hunting")
                                                        // ->where('type', "jtss_add_site")
                                                        ->orderBy('date_created', 'desc')
                                                        ->get();

            $dt = DataTables::of($sub_activity_files)
                                // ->addColumn('sitename', function($row){
                                //     json_decode($row->value);
                                //     if (json_last_error() == JSON_ERROR_NONE){
                                //         $json = json_decode($row->value, true);

                                //         return $json['site_name'];
                                //     } else {
                                //         return $row->value;
                                //     }
                                // })
                                ->addColumn('lessor', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return $json['lessor'];
                                    } else {
                                        return $row->value;
                                    }
                                })
                                ->addColumn('address', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return $json['address'];
                                    } else {
                                        return $row->value;
                                    }
                                })
                                ->addColumn('latitude', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return $json['latitude'];
                                    } else {
                                        return $row->value;
                                    }
                                })
                                ->addColumn('longitude', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return $json['longitude'];
                                    } else {
                                        return $row->value;
                                    }
                                })
                                ;
            return $dt->make(true);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }


    public function add_ssds (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'site_name' => 'required',
                'lessor' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'file' => 'required',
            ));

            if ($validate->passes()) {

                if (!is_null($request->input("file"))) {
                    $file = collect();
                    for ($i=0; $i < count($request->input("file")); $i++) {
                        $new_file = $this->rename_file($request->input("file")[$i], $request->input("sub_activity_name"), $request->input("sam_id"));

                        \Storage::move( $request->input("file")[$i], $new_file );

                        $file->push($new_file);
                    }
                }

                $json = array(
                    "site_name" => $request->input('site_name'),
                    "lessor" => $request->input('lessor'),
                    "address" => $request->input('address'),
                    "latitude" => $request->input('latitude'),
                    "longitude" => $request->input('longitude'),
                    "file" => $file,
                );

                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'type' => $request->input("type"),
                    'sub_activity_id' => $request->input("sub_activity_id"),
                    'value' => json_encode($json),
                    'user_id' => \Auth::id(),
                    'status' => "pending",
                ]);

                return response()->json(['error' => false, 'message' => "Successfully added sites." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function add_create_pr(Request $request)
    {
        try {

            $validate = Validator::make($request->all(), array(
                'pr_file' => 'required',
                'reference_number' => 'required',
            ));

            if($validate->passes()){

                $sub_activity = SubActivityValue::where('sam_id', $request->input("sam_id"))
                                                    ->where('sub_activity_id', $request->input("activity_id"))
                                                    ->where('type', "create_pr")
                                                    ->where('status', "pending")
                                                    ->first();

                SiteEndorsementEvent::dispatch($request->input('sam_id'));

                // $email_receiver = User::select('users.*')
                //                 ->join('user_details', 'users.id', 'user_details.user_id')
                //                 ->join('user_programs', 'user_programs.user_id', 'users.id')
                //                 ->join('program', 'program.program_id', 'user_programs.program_id')
                //                 ->where('user_details.vendor_id', $request->input('vendor'))
                //                 ->where('user_programs.program_id', $request->input('data_program'))
                //                 ->get();

                // for ($j=0; $j < count($email_receiver); $j++) {
                //     $email_receiver[$j]->notify( new SiteEndorsementNotification($request->input('sam_id'), $request->input('activity_name'), "") );
                // }

                if (is_null($sub_activity)) {
                    $new_file = $this->rename_file($request->input("pr_file"), $request->input("activity_name"), $request->input("sam_id"));

                    \Storage::move( $request->input("pr_file"), $new_file );

                    $json = array(
                        "pr_file" => $new_file,
                        "reference_number" => $request->input('reference_number'),
                        "prepared_by" => $request->input('prepared_by'),
                        "vendor" => $request->input('vendor'),
                        "pr_date" => $request->input('pr_date'),
                        // "po_number" => $request->input('po_number'),
                    );

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        // 'sub_activity_id' => $request->input("activity_id"),
                        'type' => "create_pr",
                        'value' => json_encode($json),
                        'user_id' => \Auth::id(),
                        'status' => "pending",
                    ]);

                    \DB::connection('mysql2')->table("site")
                                                ->where("sam_id", $request->input("sam_id"))
                                                ->update([
                                                    'site_vendor_id' => $request->input('vendor'),
                                                    'site_pr' => $request->input('reference_number'),
                                                ]);

                    // a_update_data(SAM_ID, PROFILE_ID, USER_ID, true/false)
                    $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "'."true".'")');

                    return response()->json(['error' => false, 'message' => "Successfully created a PR."]);
                } else {

                    $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "'."true".'")');

                    return response()->json(['error' => false, 'message' => "Successfully created a PR."]);
                }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    // public function schedule_jtss(Request $request)
    // {
    //     try {
    //         $validate = Validator::make($request->all(), array(
    //             $request->input('activity_name') => 'required',
    //             'remarks' => 'required',
    //         ));

    //         if ($validate->passes()) {

    //             $jtss_schedule_data = SubActivityValue::where('sam_id', $request->input('sam_id'))
    //                                                         ->where('type', $request->input('activity_name'))
    //                                                         ->first();


    //             SiteEndorsementEvent::dispatch($request->input('sam_id'));

    //             if (is_null($jtss_schedule_data)) {

    //                 if ($request->input('activity_name') == "jtss_schedule") {
    //                     $message_info = "Successfully scheduled JTSS.";
    //                 } else {
    //                     $message_info = "Successfully scheduled site.";
    //                 }
    //                 SubActivityValue::create([
    //                     'sam_id' => $request->input("sam_id"),
    //                     'type' => $request->input('activity_name'),
    //                     'value' => json_encode($request->all()),
    //                     'user_id' => \Auth::id(),
    //                     'status' => "pending",
    //                 ]);

    //                 $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');

    //                 return response()->json(['error' => false, 'message' => $message_info ]);
    //             } else {

    //                 $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');

    //                 return response()->json(['error' => false, 'message' => $message_info ]);
    //             }
    //         } else {
    //             return response()->json(['error' => true, 'message' => $validate->errors() ]);
    //         }


    //     } catch (\Throwable $th) {
    //         return response()->json(['error' => true, 'message' => $th->getMessage()]);
    //     }
    // }

    public function approve_reject_pr (Request $request)
    {
        try {

            $data_action = $request->input('data_action') == "false" ? "denied" : "approved";

            SubActivityValue::where('id', $request->input('id'))
                            ->update([
                                'status' => $data_action,
                                'approver_id' => \Auth::id(),
                                'date_approved' => Carbon::now()->toDate(),
                            ]);

            SiteEndorsementEvent::dispatch($request->input('sam_id'));

            if ($request->input('activity_name') != 'Vendor Awarding') {
                return response()->json(['error' => false, 'message' => "Successfully " .$data_action. " a PR."]);
            } else {
                return response()->json(['error' => false, 'message' => "Successfully awarded."]);
            }

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }


    public function set_approve_site (Request $request)
    {

        try {
            SubActivityValue::where('type', 'jtss_ssds')
                            ->where('value->id', $request->get('id'))
                            ->update([
                                'status' => "approved",
                                'approver_id' => \Auth::id(),
                                'date_approved' => Carbon::now()->toDate(),
                            ]);
                            
            // Site::where('sam_id', $request->input('sam_id'))
            //         ->update([
            //             ''
            //         ]);
            // SiteEndorsementEvent::dispatch($request->input('sam_id'));

            $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", [$request->input("site_category")], [$request->input("activity_id")]);

            if ($request->input('activity_name') == 'Set Approved Site') {
                return response()->json(['error' => false, 'message' => "Successfully set a approved site."]);
            } else if ($request->input('activity_name') != 'Vendor Awarding') {
                return response()->json(['error' => false, 'message' => "Successfully approved a SSDS."]);
            } else {
                return response()->json(['error' => false, 'message' => "Successfully awarded."]);
            }

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_my_site($sub_activity_id, $sam_id)
    {
        try {
            $sub_activity_files = SubActivityValue::where('sam_id', $sam_id)
                                                        ->where('sub_activity_id', $sub_activity_id)
                                                        ->where('user_id', \Auth::id())
                                                        ->where('type', 'jtss_add_site')
                                                        ->orderBy('date_created', 'desc')
                                                        ->get();

                        

            $dt = DataTables::of($sub_activity_files)
                                // ->addColumn('sitename', function($row){
                                //     json_decode($row->value);
                                //     if (json_last_error() == JSON_ERROR_NONE){
                                //         $json = json_decode($row->value, true);

                                //         return $json['site_name'];
                                //     } else {
                                //         return $row->value;
                                //     }
                                // })
                                ->addColumn('lessor', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return $json['lessor'];
                                    } else {
                                        return $row->value;
                                    }
                                })
                                ->addColumn('address', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return $json['address'];
                                    } else {
                                        return $row->value;
                                    }
                                })
                                ->addColumn('latitude', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return $json['latitude'];
                                    } else {
                                        return $row->value;
                                    }
                                })
                                ->addColumn('longitude', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return $json['longitude'];
                                    } else {
                                        return $row->value;
                                    }
                                })
                                ->addColumn('distance', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return $json['distance_from_nominal_point'] . " meters";
                                    } else {
                                        return $row->value;
                                    }
                                })
                                ;
            return $dt->make(true);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function get_datatable_columns($program_id, $table_name, $profile_id)
    {

        $cols = \DB::connection('mysql2')
                    ->table("table_fields")
                    ->where('program_id', $program_id)
                    ->where('table_name', $table_name)
                    ->orderBy('field_sort', 'asc')
                    ->get();

                    
                    

        return $cols;

    }

    public function get_doc_validations($program_id)
    {
        $sites = \DB::connection('mysql2')
                    ->table("view_doc_validation")
                    ->get();

        $dt = DataTables::of($sites);
        return $dt->make(true);

    }

    // public function doc_validation_approvals($id, $action)
    public function doc_validation_approvals_old(Request $request)
    {
        try {
            
            $required = "";
            if ($request->input('action') == "rejected") {
                $required = "required";
            }

            $validate = Validator::make($request->all(), array(
                'reason' => $required
            ));

            if ($validate->passes()) {
                
                $activities_check = \DB::connection('mysql2')
                                        ->table('stage_activities')
                                        ->where('activity_id', $request->input("activity_id"))
                                        ->where('program_id', $request->input("program_id"))
                                        ->where('category', $request->input("site_category"))
                                        ->first();

                $sub_activity_value_check = SubActivityValue::where('id', $request->input('id'))->first();
                                        
                SubActivityValue::where('id', $request->input('id'))
                                ->update([
                                    'reason' => $request->input('action') == "rejected" ? $request->input('reason') : null,
                                ]);

                if ( is_null($sub_activity_value_check->approver_id) ) {
                    SubActivityValue::where('id', $request->input('id'))
                                    ->update([
                                        'approver_id' => \Auth::id(),
                                        'date_approved' => Carbon::now()->toDate(),
                                    ]);
                } else if ( !is_null($sub_activity_value_check->approver_id) && is_null($sub_activity_value_check->approver_id2) ) {
                    SubActivityValue::where('id', $request->input('id'))
                                    ->update([
                                        'approver_id2' => \Auth::id(),
                                        'date_approved2' => Carbon::now()->toDate(),
                                    ]);
                } else if ( !is_null($sub_activity_value_check->approver_id2) && is_null($sub_activity_value_check->approver_id3) ) {
                    SubActivityValue::where('id', $request->input('id'))
                                        ->update([
                                            'approver_id3' => \Auth::id(),
                                            'date_approved3' => Carbon::now()->toDate(),
                                        ]);
                }  else if ( !is_null($sub_activity_value_check->approver_id3) && is_null($sub_activity_value_check->approver_id4) ) {
                    SubActivityValue::where('id', $request->input('id'))
                                        ->update([
                                            'approver_id4' => \Auth::id(),
                                            'date_approved4' => Carbon::now()->toDate(),
                                        ]);
                }

                if ( !is_null($activities_check->approver_profile_id_1) && !is_null($sub_activity_value_check->approver_id) ) {

                    SubActivityValue::where('id', $request->input('id'))
                                    ->update([
                                        'status' => $request->input('action') == "rejected" ? "denied" : "approved"
                                    ]);

                } else if ( 
                    ( !is_null($activities_check->approver_profile_id_1) && is_null($activities_check->approver_profile_id_2) ) &&
                    ( !is_null($sub_activity_value_check->approver_id) && !is_null($sub_activity_value_check->approver_id2) )
                    ) {

                    SubActivityValue::where('id', $request->input('id'))
                                    ->update([
                                        'status' => $request->input('action') == "rejected" ? "denied" : "approved"
                                    ]);

                } else if ( 
                    ( !is_null($activities_check->approver_profile_id_2) && is_null($activities_check->approver_profile_id_3) ) &&
                    ( !is_null($sub_activity_value_check->approver_id2) && !is_null($sub_activity_value_check->approver_id3) )
                    ) {

                    SubActivityValue::where('id', $request->input('id'))
                                    ->update([
                                        'status' => $request->input('action') == "rejected" ? "denied" : "approved"
                                    ]);
                            
                } else if ( 
                    ( !is_null($activities_check->approver_profile_id_3) && is_null($activities_check->approver_profile_id_4) ) &&
                    ( !is_null($sub_activity_value_check->approver_id3) && !is_null($sub_activity_value_check->approver_id4) )
                    ) {

                    SubActivityValue::where('id', $request->input('id'))
                                    ->update([
                                        'status' => $request->input('action') == "rejected" ? "denied" : "approved"
                                    ]);
                            
                }

                $sub_activity_files = SubActivityValue::find($request->input('id'));
                $user = User::find($sub_activity_files->user_id);

                $sub_activities = SubActivity::where('activity_id', $request->input("activity_id"))
                                                ->where('program_id', $request->input("program_id"))
                                                ->where('category', $request->input("site_category"))
                                                ->where('requires_validation', '1')
                                                ->get();

                $array_sub_activity = collect();

                foreach ($sub_activities as $sub_activity) {
                    $array_sub_activity->push($sub_activity->sub_activity_id);
                }

                if ( is_null($activities_check->approver_profile_id_2) ) {

                    $sub_activity_value = SubActivityValue::select('sub_activity_id')
                                                        ->whereIn('sub_activity_id', $array_sub_activity->all())
                                                        ->where('status', 'approved')
                                                        ->where('sam_id', $request->input("sam_id"))
                                                        ->whereNotNull('approver_id')
                                                        ->groupBy('sub_activity_id')
                                                        ->get();
                } else if ( !is_null($activities_check->approver_profile_id_2) && is_null($activities_check->approver_profile_id_3) ) {
                    
                    $sub_activity_value = SubActivityValue::select('sub_activity_id')
                                                        ->whereIn('sub_activity_id', $array_sub_activity->all())
                                                        ->where('status', 'approved')
                                                        ->where('sam_id', $request->input("sam_id"))
                                                        ->whereNotNull('approver_id2')
                                                        ->groupBy('sub_activity_id')
                                                        ->get();
                } else if ( !is_null($activities_check->approver_profile_id_3) && is_null($activities_check->approver_profile_id_4) ) {
                    
                    $sub_activity_value = SubActivityValue::select('sub_activity_id')
                                                        ->whereIn('sub_activity_id', $array_sub_activity->all())
                                                        ->where('status', 'approved')
                                                        ->where('sam_id', $request->input("sam_id"))
                                                        ->whereNotNull('approver_id3')
                                                        ->groupBy('sub_activity_id')
                                                        ->get();
                }

                if ( count($array_sub_activity->all()) <= count($sub_activity_value) ) {
                    $asd = $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", [$request->input("site_category")], [$request->input("activity_id")]);
                }

                return response()->json(['error' => false, 'message' => "Successfully ".$request->input('action')." docs." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function doc_validation_approvals(Request $request)
    {
        try {
            
            $required = "";
            if ($request->input('action') == "rejected") {
                $required = "required";
            }

            $validate = Validator::make($request->all(), array(
                'reason' => $required
            ));

            if ($validate->passes()) {

                $sub_activity_files = SubActivityValue::find($request->input('id'));

                $validators = json_decode($sub_activity_files->value)->validators;
                $file = json_decode($sub_activity_files->value)->file;

                $approvers_collect = collect();
                $approvers_pending_collect = collect();

                foreach ($validators as $validator) {
                    if ( $validator->profile_id == \Auth::user()->profile_id ) {
                        $new_array = array(
                            'profile_id' => $validator->profile_id,
                            'status' => $request->get('action'),
                            'user_id' => \Auth::id(),
                            'approved_date' => Carbon::now()->toDateString(),
                        );

                        $approvers_collect->push($new_array);
                    } else {
                        if ( isset($validator->user_id) ) {
                            $new_array = array(
                                'profile_id' => $validator->profile_id,
                                'status' => $request->get('action') == "rejected" ? "rejected" : $validator->status,
                                'user_id' => $validator->user_id,
                                'approved_date' => $validator->approved_date,
                            );
                        } else {
                            $new_array = array(
                                'profile_id' => $validator->profile_id,
                                'status' => $request->get('action') == "rejected" ? "rejected" : $validator->status,
                            );
                            $approvers_pending_collect->push($validator->profile_id);
                        }

                        $approvers_collect->push($new_array);
                    }
                }

                $array_data = [
                    'file' => $file,
                    'active_profile' => isset($approvers_pending_collect->all()[0]) ? $approvers_pending_collect->all()[0] : "",
                    'active_status' => count($approvers_pending_collect->all()) < 1 ? "approved" : "pending",
                    'validator' => count($approvers_pending_collect->all()),
                    'validators' => $approvers_collect->all()
                ];

                if ($request->input('action') != "rejected") {
                                                            
                    if ( !is_null($sub_activity_files) ) {
                        // return response()->json(['error' => true, 'message' => $array_data]);

                        if ( count($approvers_pending_collect) < 1 ) {
                            $current_status = $request->input('action') == "rejected" ? "rejected" : "approved";

                            SubActivityValue::where('id', $request->input('id'))
                                    ->update([
                                        'reason' => $request->input('action') == "rejected" ? $request->input('reason') : null,
                                        'status' => $current_status,
                                    ]);
                        } else {
                            $current_status = $sub_activity_files->status;

                            SubActivityValue::where('id', $request->input('id'))
                                    ->update([
                                        'reason' => $request->input('action') == "rejected" ? $request->input('reason') : null,
                                    ]);
                        }

                        $sub_activity_files->update([
                            'value' => json_encode($array_data),
                            'status' => $current_status
                        ]);

                    } else {
                        return response()->json(['error' => true, 'message' => "No data found."]);
                    }

                    $sub_activities = SubActivity::where('activity_id', $request->input("activity_id"))
                                                ->where('program_id', $request->input("program_id"))
                                                ->where('category', $request->input("site_category"))
                                                ->where('requires_validation', '1')
                                                ->get();

                    $array_sub_activity = collect();

                    foreach ($sub_activities as $sub_activity) {
                        $array_sub_activity->push($sub_activity->sub_activity_id);
                    }

                    
                    $sub_activity_value = SubActivityValue::select('sub_activity_id')
                                                        ->whereIn('sub_activity_id', $array_sub_activity->all())
                                                        ->where('sam_id', $request->input('sam_id'))
                                                        // ->where('status', 'pending')
                                                        ->where('status', 'approved')
                                                        ->where('type', 'doc_upload')
                                                        ->groupBy('sub_activity_id')
                                                        ->get();

                    if ( count($array_sub_activity->all()) <= count($sub_activity_value) ) {
                        $asd = $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", [$request->input("site_category")], [$request->input("activity_id")]);
                    }

                } else {
                    $current_status = $request->input('action') == "rejected" ? "rejected" : "approved";

                    $sub_activity_files->update([
                        'value' => json_encode($array_data),
                        'status' => $current_status,
                        'remarks' => $request->input('reason')
                    ]);

                    SubActivityValue::where('id', $request->input('id'))
                                ->update([
                                    'reason' => $request->input('action') == "rejected" ? $request->input('reason') : null,
                                    'status' => $current_status,
                                ]);
                }

                return response()->json(['error' => false, 'message' => "Successfully ".$request->input('action')." docs." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function doc_validation_approval_reviewer(Request $request)
    {
        try {
            
            $required = "";
            if ($request->input('action') == "rejected") {
                $required = "required";
            }

            $validate = Validator::make($request->all(), array(
                'reason' => $required
            ));

            if ($validate->passes()) {
                
                // $activities_check = \DB::connection('mysql2')
                //                         ->table('stage_activities')
                //                         ->where('activity_id', $request->input("activity_id"))
                //                         ->where('program_id', $request->input("program_id"))
                //                         ->where('category', $request->input("site_category"))
                //                         ->first();

                // $sub_activity_value_check = SubActivityValue::where('id', $request->input('id'))->first();
                                        
                SubActivityValue::where('id', $request->input('id'))
                                ->update([
                                    'reason' => $request->input('action') == "rejected" ? $request->input('reason') : null,
                                    'status' => $request->input('action') == "rejected" ? "rejected" : "approved",
                                    'approver_id' => \Auth::id(),
                                ]);

                // if ( is_null($sub_activity_value_check->reviewer_id) ) {
                //     SubActivityValue::where('id', $request->input('id'))
                //                     ->update([
                //                         'reviewer_id' => \Auth::id(),
                //                         'reviewer_approved' => Carbon::now()->toDate(),
                //                         'status' => $request->input('action') == "rejected" ? "denied" : "approved"
                //                     ]);
                // } else if ( !is_null($sub_activity_value_check->reviewer_id) && is_null($sub_activity_value_check->reviewer_id_2) ) {
                //     SubActivityValue::where('id', $request->input('id'))
                //                     ->update([
                //                         'reviewer_id_2' => \Auth::id(),
                //                         'reviewer_approved_2' => Carbon::now()->toDate(),
                //                         'status' => $request->input('action') == "rejected" ? "denied" : "approved"
                //                     ]);
                // }

                return response()->json(['error' => false, 'message' => "Successfully ".$request->input('action')." docs." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_site_approvals($program_id, $profile_id)
    {
        $sites = \DB::connection('mysql2')
                    // ->table("site_milestone")
                    ->table("milestone_tracking_2")
                    ->select("program_id, sam_id, stage_name, activity_name, activity_type, activity_complete, profile_id, stage_id, pending_count, site_name, site_fields, site_agent")
                    ->where('program_id', $program_id)
                    ->where('activity_complete', 'false')
                    ->where('profile_id', $profile_id)
                    ->get();

        $dt = DataTables::of($sites);
        return $dt->make(true);

    }

    public function get_site_milestones($program_id, $profile_id, $activity_type)
    {
        if($activity_type == 'all'){
            $sites = \DB::connection('mysql2')
                            ->table("view_site")
                            ->where('program_id', $program_id)
                            ->whereNotNull('activity_name');

            if($program_id == 3){                
                $sites->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id')
                      ->select("view_site.*", "program_coloc.nomination_id", "program_coloc.pla_id", "program_coloc.highlevel_tech",  "program_coloc.technology", "program_coloc.site_type");
            }
            elseif($program_id == 4){
                $sites->leftJoin('program_ibs', 'view_site.sam_id', 'program_ibs.sam_id');
            }
            
            $sites->get();
        }

        elseif($activity_type == 'mine'){

            $sites = \DB::connection('mysql2')
            // ->table("site_milestone")
            ->table("view_assigned_sites")
            // ->join("site_users", "site_users.sam_id", "view_sites_activity_3.sam_id")
            ->where('program_id', $program_id)
            ->where('agent_id', \Auth::id())
            // ->where('activity_complete', 'false')
            // ->where("site_agent_id", \Auth::id())
            // ->whereJsonContains("site_agent", [
            //     'user_id' => \Auth::id()
            // ])
            ->get();
        }

        elseif($activity_type == 'mine_completed'){
            // $sites = \DB::connection('mysql2')
            //                 ->table("completed_sites")
            //                 ->where('program_id', $program_id)
            //                 ->distinct()
            //                 ->get();
                            
            // $last_act = \DB::connection('mysql2')
            //                 ->table("stage_activities")
            //                 ->select('activity_id')
            //                 ->where('program_id', $program_id)
            //                 ->orderBy('activity_id', 'desc')
            //                 ->first();

            // $sites = \DB::connection('mysql2')
            //                     ->table("site")
            //                     ->leftjoin("vendor", "site.site_vendor_id", "vendor.vendor_id")
            //                     ->leftjoin("location_regions", "site.site_region_id", "location_regions.region_id")
            //                     ->leftjoin("location_provinces", "site.site_province_id", "location_provinces.province_id")
            //                     ->leftjoin("location_lgus", "site.site_lgu_id", "location_lgus.lgu_id")
            //                     ->leftjoin("location_sam_regions", "location_regions.sam_region_id", "location_sam_regions.sam_region_id")
            //                     ->where('site.program_id', $program_id)
            //                     ->where('activities->activity_id', $last_act->activity_id)
            //                     ->get();

            $sites = \DB::connection('mysql2')
                                ->table("view_site")
                                ->where('program_id', $program_id)
                                ->where('activity_type', 'complete');

            if ( $program_id == 3 ) {
                                    
                $sites->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id')
                ->select("view_site.*", "program_coloc.nomination_id", "program_coloc.pla_id", "program_coloc.highlevel_tech", "program_coloc.technology",  "program_coloc.site_type");

            }

            $sites->get();

        }

        elseif($activity_type == 'is'){
            
            // $getAgentOfSupervisor = UserDetail::select('users.id')
            //                                     ->join('users', 'user_details.user_id', 'users.id')
            //                                     ->leftJoin('users_areas', 'users_areas.user_id', 'users.id')
            //                                     ->where('user_details.IS_id', \Auth::id())
            //                                     ->get()
            //                                     ->pluck('id');
            
            $sites = \DB::connection('mysql2')
                        ->table("view_vendor_assigned_sites")
                        ->where('program_id', $program_id)
                        ->where('IS_id', \Auth::user()->id);

            if($program_id == 3){

                $sites->leftJoin('program_coloc', 'view_vendor_assigned_sites.sam_id', 'program_coloc.sam_id')
                ->select("view_vendor_assigned_sites.*", "program_coloc.nomination_id", "program_coloc.pla_id", "program_coloc.highlevel_tech", "program_coloc.technology",  "program_coloc.site_type");

            }                        

            $sites->get();

        }

        elseif($activity_type == 'vendor'){

            $sites = \DB::connection('mysql2')
            // ->table("site_milestone")
            ->table("milestone_tracking_2")
            ->distinct()
            ->where('program_id', $program_id)
            ->where('activity_complete', 'false')
            ->where("profile_id", "2")
            ->get();

        }

        elseif($activity_type == 'set site value'){

            $sites = \DB::connection('mysql2')
                    ->table("milestone_tracking_2")
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_type', 'set site value')
                    ->where('profile_id', \Auth::user()->profile_id)
                    ->where('activity_complete', 'false')
                    ->get();

        }

        elseif($activity_type == 'rtb declaration'){

            // $sites = \DB::connection('mysql2')
            //         ->table("milestone_tracking")
            //         ->distinct()
            //         ->where('program_id', $program_id)
            //         ->where('activity_type', 'rtb declaration')
            //         ->where('activity_complete', 'false')
            //         ->where('profile_id', \Auth::user()->profile_id)
            //         ->get();

            // if ($program_id == 1 && \Auth::user()->profile_id == 6) {
            //     $sites = \DB::connection('mysql2')
            //         ->table("view_sites_activity")
            //         ->select('site_name', 'sam_id', 'site_category', 'activity_id', 'program_id', 'site_endorsement_date', 'id', 'site_vendor_id', 'activity_name', 'program_endorsement_date')
            //         ->where('program_id', $program_id)
            //         ->where('activity_id', 22)
            //         ->where('profile_id', \Auth::user()->profile_id)
            //         ->get();
            // } else if ($program_id == 1 && \Auth::user()->profile_id == 7) {
            //     $sites = \DB::connection('mysql2')
            //         ->table("view_sites_activity")
            //         ->select('site_name', 'sam_id', 'site_category', 'activity_id', 'program_id', 'site_endorsement_date',  'id', 'site_vendor_id', 'activity_name', 'program_endorsement_date')
            //         ->where('program_id', $program_id)
            //         ->where('activity_id', 23)
            //         ->where('profile_id', \Auth::user()->profile_id)
            //         ->get();

            // } else if ($program_id == 3 && \Auth::user()->profile_id == 9) {
            //     $sites = \DB::connection('mysql2')
            //         ->table("view_sites_activity")
            //         ->select('site_name', 'sam_id', 'site_category', 'activity_id', 'program_id', 'site_endorsement_date',  'id', 'site_vendor_id', 'activity_name', 'program_endorsement_date')
            //         ->where('program_id', $program_id)
            //         ->where('activity_id', 17)
            //         ->where('profile_id', \Auth::user()->profile_id)
            //         ->get();

            // } else if ($program_id == 4 && \Auth::user()->profile_id == 7) {
            //     $sites = \DB::connection('mysql2')
            //         ->table("view_sites_activity")
            //         ->select('site_name', 'sam_id', 'site_category', 'activity_id', 'program_id', 'site_endorsement_date',  'id', 'site_vendor_id', 'activity_name', 'program_endorsement_date')
            //         ->where('program_id', $program_id)
            //         ->where('activity_id', 18)
            //         ->where('profile_id', \Auth::user()->profile_id)
            //         ->get();

            // } else if (\Auth::user()->profile_id == 6) {

            $sites = \DB::connection('mysql2')
                            ->table("view_site")
                            ->whereIn('view_site.activity_type', ['rtb declaration'])
                            ->where('view_site.program_id', $program_id)
                            ->where('view_site.profile_id', \Auth::user()->profile_id);

            if($program_id == 3){

                $sites->leftJoin('program_coloc', 'program_coloc.sam_id', 'view_site.sam_id');
                $sites->select("view_site.*", "program_coloc.nomination_id", "program_coloc.pla_id", "program_coloc.highlevel_tech", "program_coloc.technology", "program_coloc.site_type");

            }
                
            $sites->get();


            // } 
            // else {
            //     if ($program_id == 2) {
            //         $sites = \DB::connection('mysql2')
            //                     ->table("view_sites_per_program")
            //                     ->where('view_sites_per_program.program_id', $program_id)
            //                     ->where('view_sites_per_program.profile_id', \Auth::user()->profile_id)
            //                     ->whereIn('view_sites_per_program.activity_id', [13, 14, 10, 11])
            //                     ->distinct()
            //                     ->get();
            //     }                            
            //     elseif ($program_id == 4) {
            //         $sites = \DB::connection('mysql2')
            //                     ->table("view_sites_per_program")
            //                     ->where('view_sites_per_program.program_id', $program_id)
            //                     ->where('view_sites_per_program.profile_id', \Auth::user()->profile_id)
            //                     ->whereIn('view_sites_per_program.activity_id', [14])
            //                     ->distinct()
            //                     ->get();
            //     } else {
            //         $sites = \DB::connection('mysql2')
            //                     ->table("view_sites_per_program")
            //                     ->leftjoin('stage_activities', 'stage_activities.activity_id', 'view_sites_per_program.activity_id')
            //                     ->where('view_sites_per_program.program_id', $program_id)
            //                     ->whereIn('stage_activities.activity_type', ['rtb declaration'])
            //                     ->where('view_sites_per_program.profile_id', \Auth::user()->profile_id)
            //                     // ->whereIn('view_sites_per_program.activity_id', [16])
            //                     ->distinct()
            //                     ->get();
            //     }
            // }

        }

        elseif($activity_type == 'site approval'){

                $sites = \DB::connection('mysql2')
                                ->table("view_site")
                                // ->leftjoin('stage_activities', 'stage_activities.activity_id', 'view_sites_per_program.activity_id')
                                ->where('view_site.program_id', $program_id)
                                // ->whereIn('stage_activities.activity_type', ['doc approval', 'site approval'])
                                ->where('view_site.profile_id', \Auth::user()->profile_id);
                                if ( $program_id == 1 ) {
                                    $sites->whereIn('view_site.activity_id', [16, 17, 26, 28])
                                    ->get();
                                } else if ( $program_id == 2 ) {

                                    $sites->whereIn('view_site.activity_id', [17, 20, 14, 17])
              
                                    ->get();

                                } else if ( $program_id == 3 ) {
                                    
                                    $sites->whereIn('view_site.activity_id', [15, 22, 23, 28, 29]);
                                    $sites->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id')
                                    ->select("view_site.*", "program_coloc.nomination_id", "program_coloc.pla_id", "program_coloc.highlevel_tech", "program_coloc.technology", "program_coloc.site_type")              
                                            ->get();

                                    // return dd($sites->get());
                                } else if ( $program_id == 4 ) {
                                    if(\Auth::user()->profile_id == 8){

                                        $sites->whereIn('view_site.activity_id', [8, 11, 16, 19, 22, 25])
                                        ->get();

                                    }
                                    elseif(\Auth::user()->profile_id == 10){

                                        $sites->whereIn('view_site.activity_id', [9, 12, 17, 20, 23, 26])
                                        ->get();

                                    }
                                } else if ( $program_id == 5 ) {
                                    $sites->whereIn('view_site.activity_id', [19, 24, 27, 30])
                                    ->get();
                                }
        }

        elseif($activity_type == 'vendor awarding'){
            $sites = \DB::connection('mysql2')
                            // ->table("view_pr_memo")
                            ->table("view_pr_memo_v2")
                            ->where('status', '!=', 'denied');
                            if ( $program_id == 1 ) {
                                $sites->whereIn('activity_id', [6])
                                    ->get();
                            } else if ( $program_id == 5 ) {
                                $sites->whereIn('activity_id', [9])
                                    ->get();
                            }
        }

        elseif($activity_type == 'pr issuance'){
            $sites = \DB::connection('mysql2')
                            ->table("view_pr_memo")
                            ->where('status', '!=', 'denied');
                            if ( $program_id == 1 ) {
                                $sites->whereIn('activity_id', [5])
                                    ->get();
                            } else if ( $program_id == 5 ) {
                                $sites->whereIn('activity_id', [8])
                                    ->get();
                            }

        }

        elseif($activity_type == 'pr memo'){
            $sites = \DB::connection('mysql2')
                            ->table("view_pr_memo");
                            // ->where('status', '!=', 'denied');

                            if ($program_id == 1) {
                                if (\Auth::user()->profile_id == 8) {
                                    $sites->where('activity_id', '>', 3)
                                    ->get();
                                } else if (\Auth::user()->profile_id == 9) {
                                    $sites->where('activity_id', 3)
                                            ->where('status', '!=', 'denied')
                                            ->get();
                                } else if (\Auth::user()->profile_id == 10) {
                                    $sites->where('activity_id', 4)
                                    ->where('status', '!=', 'denied')->get();
                                }
                            } else if ($program_id == 5) {
                                if (\Auth::user()->profile_id == 8) {
                                    $sites->where('activity_id', '>', 4)
                                    ->get();
                                } else if (\Auth::user()->profile_id == 9) {
                                    $sites->where('activity_id', 6)
                                            ->where('status', '!=', 'denied')
                                            ->get();
                                } else if (\Auth::user()->profile_id == 10) {
                                    $sites->where('activity_id', 7)
                                    ->where('status', '!=', 'denied')->get();
                                }
                            }

        }

        elseif($activity_type == 'pr memo pending approval'){
            $sites = \DB::connection('mysql2')
                            ->table("view_pr_memo")
                            ->where('status', '!=', 'denied');

                            if ($program_id == 1) {
                                if (\Auth::user()->profile_id == 10) {
                                    $sites->whereIn('activity_id', [2, 3, 4, 5, 6, 7])
                                        ->whereIn('profile_id', [8, 9, 10])
                                        ->get();
                                } else if (\Auth::user()->profile_id == 9) {
                                    $sites->whereIn('activity_id', [4])
                                            ->whereIn('profile_id', [8, 10])
                                            ->get();
                                } else if (\Auth::user()->profile_id == 8) {
                                    $sites->whereIn('activity_id', [3])
                                            ->whereIn('profile_id', [9, 10])
                                            ->get();
                                }
                            } else if ($program_id == 5) {
                                if (\Auth::user()->profile_id == 10) {
                                    $sites->whereIn('activity_id', [2, 3, 4, 5, 6, 7])
                                        ->whereIn('profile_id', [8, 9, 10])
                                        ->get();
                                } else if (\Auth::user()->profile_id == 9) {
                                    $sites->whereIn('activity_id', [7])
                                            ->whereIn('profile_id', [8, 10])
                                            ->get();
                                } else if (\Auth::user()->profile_id == 8) {
                                    $sites->whereIn('activity_id', [6])
                                            ->whereIn('profile_id', [9, 10])
                                            ->get();
                                }
                            }
        }

        elseif($activity_type == 'pr memo approved'){
            $sites = \DB::connection('mysql2')
                            ->table("view_pr_memo_v2");
                            // ->whereIn('profile_id', [8, 9, 10]);

                            if (\Auth::user()->profile_id == 10) {
                                $sites->where(function($q) {
                                    $q->where('activity_id', '>', '4')
                                        ->orWhere('activity_id', -1);
                                    })
                                    ->get();
                            } else if (\Auth::user()->profile_id == 9) {
                                $sites->where(function($q) {
                                        $q->where('activity_id', '>', '4')
                                            ->orWhere('activity_id', -1);
                                        })
                                        ->get();
                            } else if (\Auth::user()->profile_id == 8) {
                                // $sites->where('activity_id', '>', '2')
                                $sites->where(function($q) {
                                        $q
                                            ->where('activity_id', '>', '4')
                                            // ->where('activity_id', '<', '7')
                                            ->orWhere('activity_id', -1);
                                        })
                                        ->get();
                            }
        }

        elseif($activity_type == 'new clp'){
            $sites = \DB::connection('mysql2')
                                ->table("view_sites_per_program")
                                ->where('program_id', $program_id);
                                if ($program_id == 1) {
                                    $sites->whereIn('activity_id', [2])
                                    ->get();
                                } else if ($program_id == 5) {
                                    $sites->whereIn('activity_id', [5])
                                    ->get();
                                }

        }

        elseif($activity_type == 'site hunting validation'){
            $sites = \DB::connection('mysql2')
                                ->table("view_site_hunting")
                                ->get();

                                // ->table("site")
                                // ->leftjoin("vendor", "site.site_vendor_id", "vendor.vendor_id")
                                // ->leftjoin("location_regions", "site.site_region_id", "location_regions.region_id")
                                // ->leftjoin("location_provinces", "site.site_province_id", "location_provinces.province_id")
                                // ->leftjoin("location_lgus", "site.site_lgu_id", "location_lgus.lgu_id")
                                // ->leftjoin("location_sam_regions", "location_regions.sam_region_id", "location_sam_regions.sam_region_id")
                                // ->where('site.program_id', $program_id)
                                // ->where('activities->activity_id', '11')
                                // ->where('activities->profile_id', '8')

                            // -leftjoin("pr_memo_site", 'pr_memo_site.sam_id', 'site.site_id')
                            // ->select('pr_memo_site.*', 'site.site_pr', 'site.sam_id', 'site.site_province_id', 'site.site_region_id', 'site.site_lgu_id', 'site.site_vendor_id')
                            // ->get();

        }

        elseif($activity_type == 'schedule jtss'){
            $sites = \DB::connection('mysql2')
                                ->table("view_newsites_jtss_schedule_requests")
                                ->get();
        }

        elseif($activity_type == 'jtss'){

            $sites = \DB::connection('mysql2')
                    ->table("view_jtss_aepm")
                    ->where('program_id', $program_id)
                    ->get();

                    // dd($sites);

        }

        elseif($activity_type == 'ssds'){

            $sites = \DB::connection('mysql2')
                    ->table("site")
                    ->leftjoin("vendor", "site.site_vendor_id", "vendor.vendor_id")
                    ->leftjoin("location_regions", "site.site_region_id", "location_regions.region_id")
                    ->leftjoin("location_provinces", "site.site_province_id", "location_provinces.province_id")
                    ->leftjoin("location_lgus", "site.site_lgu_id", "location_lgus.lgu_id")
                    ->leftjoin("location_sam_regions", "location_regions.sam_region_id", "location_sam_regions.sam_region_id")
                    ->where('site.program_id', $program_id)
                    ->where('activities->activity_id', '14')
                    ->where('activities->profile_id', '8')
                    ->get();

                    // dd($sites);

        }

        elseif($activity_type == 'site-hunting'){

            $sites = \DB::connection('mysql2')
                    ->table("site")
                    ->where('program_id', $program_id)
                    ->whereJsonContains('activities->activity_id', '11')
                    // ->orwhereJsonContains('activities->activity_id', '22')
                    ->whereJsonContains('activities->profile_id', '8')

                    ->get();

                    // dd($sites);

        }

        elseif($activity_type == 'doc validation'){

            $sites = \DB::connection('mysql2')->table("site");
                // ->where('program_id', $program_id)
                // ->where('active_profile', \Auth::user()->profile_id);
                // ->whereNull('approver_id')
                // ->whereNull('approver_id2')
                // ->whereNull('approver_id3')
                // ->whereNot('status', 'rejected')

            if($program_id == 3){

                $site->get();

            }


        }

        elseif($activity_type == 'doc validation 2'){

            $sites = \DB::connection('mysql2')->table("view_doc_validation")
                ->where('program_id', $program_id)
                ->whereNotNull('approver_id')
                ->whereNull('approver_id2')
                ->whereNull('approver_id3')
                ->get();                

        }

        elseif($activity_type == 'doc validation 3'){

            $sites = \DB::connection('mysql2')->table("view_doc_validation")
                ->where('program_id', $program_id)
                ->whereNotNull('approver_id')
                ->whereNotNull('approver_id2')
                ->whereNull('approver_id3')
                ->get();

        }

        elseif($activity_type == 'new endorsements globe'){

            // $sites = \DB::connection('mysql2')
            //         ->table("view_sites_activity")
            //         ->whereIn('activity_id', [7])
            //         ->where('profile_id', \Auth::user()->profile_id)
            //         ->get();

            $sites = \DB::connection('mysql2')
                    ->table("view_site")
                    ->where('program_id', $program_id)
                    ->where('activity_type', "endorsement")
                    ->where('profile_id', \Auth::user()->profile_id);


                    if($program_id == 3){
                        $sites->leftJoin('program_coloc', 'program_coloc.sam_id', 'view_site.sam_id')
                              ->select('view_site.*', 'program_coloc.nomination_id', 'program_coloc.pla_id', 'program_coloc.highlevel_tech',  'program_coloc.technology', 'program_coloc.site_type');
                    }



                    // if ($program_id == 3 && \Auth::user()->profile_id == 1) {
                    //     $sites->where('activity_id', 5);
                    // } else if ($program_id == 4 && \Auth::user()->profile_id == 6) {
                    //     $sites->where('activity_id', 2);
                    // } else if ($program_id == 4 && \Auth::user()->profile_id == 7) {
                    //     $sites->where('activity_id', 3);
                    // } else if ($program_id == 4 && \Auth::user()->profile_id == 8) {
                    //     $sites->where('activity_id', 4);
                    // } else if ($program_id == 5 && \Auth::user()->profile_id == 6) {
                    //     $sites->where('activity_id', 2);
                    // } else if ($program_id == 5 && \Auth::user()->profile_id == 7) {
                    //     $sites->where('activity_id', 3);
                    // } else if ($program_id == 5 && \Auth::user()->profile_id == 8) {
                    //     $sites->where('activity_id', 4);
                    // } else if ($program_id == 1 && \Auth::user()->profile_id == 6) {
                    //     $sites->where('activity_id', 1);
                    // } else if ($program_id == 1 && \Auth::user()->profile_id == 7) {
                    //     $sites->where('activity_id', 1);
                    // }

                    $sites->get();

        }

        elseif($activity_type == 'new endorsements apmo'){

            $sites = \DB::connection('mysql2')
                    ->table("view_APMO_New_Endorsements")
                    ->where('program_id', $program_id)
                    // ->take(4000)
                    ->get();

        }

        elseif($activity_type == 'new endorsements vendor'){

            $sites = \DB::connection('mysql2')
                    ->table("view_sites_activity")
                    ->select('site_name', 'sam_id', 'site_category', 'activity_id', 'program_id', 'site_endorsement_date',  'id', 'site_vendor_id', 'activity_name')
                    ->where('program_id', $program_id);

                    if ($program_id == 1) {
                        $sites->where('activity_id', 7);
                    } else if ($program_id == 3 && \Auth::user()->profile_id == 3) {
                        $sites->where('activity_id', 7);
                    } else if ($program_id == 5 && \Auth::user()->profile_id == 3) {
                        $sites->where('activity_id', 11);
                    }

                    $sites->where('profile_id', \Auth::user()->profile_id)
                            ->get();

        }

        elseif($activity_type == 'new endorsements vendor accept'){

            $sites = \DB::connection('mysql2')
                    ->table("view_sites_activity")
                    ->leftjoin("location_regions", "view_sites_activity.site_region_id", "location_regions.region_id")
                    ->leftjoin("location_sam_regions", "location_regions.region_id", "location_sam_regions.sam_region_id")
                    ->leftjoin("location_provinces", "view_sites_activity.site_province_id", "location_provinces.province_id")
                    ->select('site_name', 'sam_id', 'site_category', 'activity_id', 'program_id', 'site_endorsement_date',  'id', 'site_vendor_id', 'activity_name', "site_region_id", "location_regions.region_name", "location_sam_regions.sam_region_name", "location_provinces.province_name")
                    
                    ->where('program_id', $program_id);

                    if ($program_id == 1) {
                        $sites->where('activity_id', 7);
                    } else if ($program_id == 3 && \Auth::user()->profile_id == 3) {
                        $sites->where('activity_id', 6);
                    } else if ($program_id == 4 && \Auth::user()->profile_id == 3) {
                        $sites->where('activity_id', 5);
                    } else if ($program_id == 2 && \Auth::user()->profile_id == 3) {
                        $sites->where('activity_id', 4);
                    } else if ($program_id == 5 && \Auth::user()->profile_id == 3) {
                        $sites->where('activity_id', 10);
                    }   

                    $sites->where('profile_id', \Auth::user()->profile_id)
                            ->get();

        }

        elseif($activity_type == 'unassigned sites'){

            $sites = \DB::connection('mysql2')
                ->table("view_site")
                ->where('program_id', $program_id);
                if ($program_id == 1) {
                    $sites->where('activity_id', 8);
                } else if ($program_id == 3 && \Auth::user()->profile_id == 1) {
                    $sites->where('activity_id', 6);
                } else if ($program_id == 3 && \Auth::user()->profile_id == 3) {
                    $sites->where('activity_id', 7);
                } else if ($program_id == 4 && \Auth::user()->profile_id == 3) {
                    $sites->where('activity_id', 6);
                } else if ($program_id == 2 && \Auth::user()->profile_id == 3) {
                    $sites->where('activity_id', 5);
                }
                $sites->where('profile_id', \Auth::user()->profile_id)
                            ->get();

        } else if ($activity_type == 'all-site-issues') {
            $sites = \DB::connection('mysql2')
                            ->table("site_issue")
                            ->leftjoin('view_site', 'view_site.sam_id', 'site_issue.sam_id')
                            ->join('issue_type', 'issue_type.issue_type_id', 'site_issue.issue_type_id')
                            ->where('view_site.program_id', $program_id)
                            ->whereNull('site_issue.date_resolve');
                            // if (\Auth::user()->profile_id == 2) {
                            //     $sites->where('site_issue.user_id', \Auth::id());
                            // } else if (\Auth::user()->profile_id == 3) {
                            //     $getAgentOfSupervisor = UserDetail::select('users.id')
                            //                                 ->join('users', 'user_details.user_id', 'users.id')
                            //                                 ->leftJoin('users_areas', 'users_areas.user_id', 'users.id')
                            //                                 ->where('user_details.IS_id', \Auth::id())
                            //                                 ->get()
                            //                                 ->pluck('id');

                            //     $sites->whereIn('site_issue.user_id', $getAgentOfSupervisor);
                            // }
                            $sites->get();
        }

        else {

            $sites = \DB::connection('mysql2')
                    ->table("milestone_tracking_2")
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_complete', 'false')
                    ->where('profile_id', $profile_id)
                    ->where('activity_type', $activity_type)
                    ->get();

        }

        $dt = DataTables::of($sites);
        return $dt->make(true);
    }

    public function get_site_doc_validation($program_id, $profile_id, $activity_type)
    {
        $sites = \DB::connection('mysql2')
                    // ->table("site_milestone")
                    ->table("milestone_tracking_2")
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_complete', 'false')
                    ->where('pending_count', '>', 0)
                    ->get();

        $dt = DataTables::of($sites);
        return $dt->make(true);

    }

    public function sub_activity_view($sam_id, $sub_activity, $sub_activity_id, $program_id, $site_category, $activity_id)
    {
    // dd($sub_activity);
        if($sub_activity == 'SSDS'){

            $jtss_add_site = SubActivityValue::where('sam_id', $sam_id)
                                                    ->where('type', 'jtss_add_site')
                                                    ->get();

            $what_component = "components.subactivity-ssds";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
                'check_if_added' => $jtss_add_site,
            ])
            ->render();

        }

        else if($sub_activity == 'Set Approved Site'){

            $jtss_add_site = SubActivityValue::where('sam_id', $sam_id)
                                                    ->where('type', 'jtss_add_site')
                                                    ->get();

            $what_component = "components.set-approved-site";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
                'check_if_added' => $jtss_add_site,
            ])
            ->render();

        }

        else if($sub_activity == 'Lessor Negotiation' || $sub_activity == 'LESSOR ENGAGEMENT' || $sub_activity == 'Lessor Engagement'){
            // elseif($sub_activity == 'Lessor Negotiation' || $sub_activity == 'LESSOR ENGAGEMENT' || $sub_activity == 'Lessor Engagement'){

            $what_component = "components.subactivity-lessor-engagement";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
            ])
            ->render();

        }
        elseif($sub_activity == 'LESSOR ENGAGEMENT'){

            $what_component = "components.subactivity-lessor-engagement";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
            ])
            ->render();

        }
        elseif($sub_activity == 'Set Site Category'){

            $what_component = "components.set-site-category";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
            ])
            ->render();

        }
        elseif($sub_activity == 'Schedule Advanced Site Hunting'){

            $what_component = "components.schedule-advance-site-hunting";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
            ])
            ->render();

        }
        elseif($sub_activity == 'Set Survey Representatives'){

            $datas = SubActivityValue::where('sam_id', $sam_id)
                                        ->where('type', 'jtss_representative')
                                        ->get();

            $site = Site::select('site_name')
                            ->where('sam_id', $sam_id)
                            ->first();

            $what_component = "components.set-survey-representatives";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
                'site_name' => $site->site_name,
                'is_done' => count($datas) > 0 ? 'done' : 'not_done',
            ])
            ->render();

        }
        elseif($sub_activity == 'Add Site Candidates'){

            $jtss_add_site = SubActivityValue::where('sam_id', $sam_id)
                                                    ->where('type', 'jtss_add_site')
                                                    ->get();

            $site_np = Site::select('NP_latitude', 'NP_longitude', 'site_region_id', 'site_province_id', 'site_lgu_id')
                        ->where('sam_id', $sam_id)
                        ->first();

            $what_component = "components.add-site-prospects";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
                'check_if_added' => $jtss_add_site,
                'NP_latitude' => $site_np->NP_latitude,
                'NP_longitude' => $site_np->NP_longitude,
                'site_region_id' => $site_np->site_region_id,
                'site_province_id' => $site_np->site_province_id,
                'site_lgu_id' => $site_np->site_lgu_id
            ])
            ->render();

        }
        elseif($sub_activity == 'JTSS Sched Confirmation'){

            $np = \DB::table('site')
                ->where('sam_id', $sam_id)
                ->select('NP_latitude', 'NP_longitude')
                ->get();


            $what_component = "components.jtss-sched-confirmation";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
            ])
            ->render();

        }
        elseif($sub_activity == 'Site Survey Deliberation Sheet'){

            $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('sam_id', $sam_id)
                                        ->get();

            $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('sam_id', $sam_id)
                                        ->get();

            $what_component = "components.ssds";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
                'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
            ])
            ->render();

        }
        elseif($sub_activity == 'SSDS Ranking'){

            $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('sam_id', $sam_id)
                                        ->get();

            $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('sam_id', $sam_id)
                                        ->get();

            $what_component = "components.ssds-ranking";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
                'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
                'count_ssds' => count($jtss_ssds),
            ])
            ->render();

        }
        elseif($sub_activity == 'Approved SSDS'){

            $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('sam_id', $sam_id)
                                        ->get();

            $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('sam_id', $sam_id)
                                        ->get();

            $what_component = "components.approved-ssds";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
                'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
            ])
            ->render();

        }
        elseif($sub_activity == 'SSDS NTP'){

            $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('sam_id', $sam_id)
                                        ->get();

            $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('sam_id', $sam_id)
                                        ->get();

            $what_component = "components.ssds-ntp";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
                'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
            ])
            ->render();

        }
        elseif($sub_activity == 'Lease Details'){

            $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('sam_id', $sam_id)
                                        ->get();

            $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('sam_id', $sam_id)
                                        ->get();

            $what_component = "components.lease-details";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
                'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
            ])
            ->render();

        }
        else {

            $what_component = "components.subactivity-doc-upload";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $sub_activity,
                'sam_id' => $sam_id,
                'sub_activity_id' => $sub_activity_id,
                'program_id' => $program_id,
                'site_category' => $site_category,
                'activity_id' => $activity_id,
            ])
            ->render();
        }

    }

    public function modal_view_site_components($sam_id, $component)
    {
        try{

            if($component == 'site-status'){

                $what_modal = "components.site-status";
                return \View::make($what_modal)
                        ->with([
                            'sam_id' => $sam_id,
                            'site_name' => "test",
                        ])
                        ->render();

            }
            elseif($component == 'agent-activities'){

                $what_modal = "components.agent-activity-list";
                return \View::make($what_modal)
                        ->render();

            }
            elseif($component == 'agent-progress'){

                $what_modal = "components.site-progress";
                return \View::make($what_modal)
                        ->render();

            }
            elseif($component == 'tab-content-activities'){

                $what_modal = "components.site-activities";
                return \View::make($what_modal)
                        ->with([
                            'sam_id' => $sam_id,
                            'site_name' => "test",
                        ])
                        ->render();

            }
            elseif($component == 'tab-content-files'){

                $what_modal = "components.site-files";
                return \View::make($what_modal)
                        ->with([
                            'sam_id' => $sam_id,
                        ])
                        ->render();

            }
            elseif($component == 'site-modal-site_fields'){

                // $sites = \DB::connection('mysql2')
                // ->table("site_milestone")
                // ->select('site_fields')
                // ->distinct()
                // ->where('sam_id', $sam_id)
                // ->where('activity_complete', 'false')
                // ->get();
                // $sites = \DB::connection('mysql2')
                //             ->table("milestone_tracking_2")
                //             ->select('site_fields')
                //             ->distinct()
                //             ->where('sam_id', $sam_id)
                //             ->where('activity_complete', 'false')
                //             ->get();

                $programs = \DB::connection('mysql2')
                                ->table('site')
                                ->where('sam_id', $sam_id)
                                ->first();

                if ($programs->program_id == 3) {
                    $table = 'program_coloc';
                } else if ($programs->program_id == 4) {
                    $table = 'program_ibs';
                } else if ($programs->program_id == 2) {
                    $table = 'program_ftth';
                } else if ($programs->program_id == 1) {
                    $table = 'program_newsites';
                } else if ($programs->program_id == 5) {
                    $table = 'program_mwan';
                }

                $sites = \DB::connection('mysql2')
                            ->table($table)
                            ->where('sam_id', $sam_id)
                            ->get();

                $what_modal = "components.site-fields";
                
                return \View::make($what_modal)
                        ->with([
                            'sam_id' => $sam_id,
                            // 'sitefields' => json_decode($sites[0]->site_fields),
                            'sitefields' => $sites,
                        ])
                        ->render();

            }




        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_PRMemo (Request $request)
    {
        try {

            $what_modal = "components.pr-memo-approval";

            return \View::make($what_modal)
            ->with([
                'pr_memo' => $request->input('pr_memo'),
                'activity' => $request->input('activity'),
                'program_id' => $request->input('program_id')
            ])
            ->render();

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }


    public function get_all_docs(Request $request)
    {
        // return "test";
        $documents = array("RTB Docs Validation", "RTB Docs Approval", "PAC Approval");
        $doc_preview_main_activities = array("Document Validation");
        $site_view_main_actiivities = array("Program Sites", "Assigned Sites");
        $rtb = array("RTB Declaration", "RTB Declaration Approval");
        $vendor_profiles = array(2, 3);

        // dd( $request->all() );
        try {
            $site = \DB::connection('mysql2')
                    // ->table('site_milestone')
                    ->table('view_site')
                    ->distinct()
                    ->where('sam_id', $request['sam_id'])
                    // ->where('activity_complete', "=", 'false')
                    // ->where('activity_id', $request['activity_id'])
                    ->get();

            // if ( count($site) < 1 ) {
            //     $site_fields = "";
            // } else {
            //     $site_fields = json_decode($site[0]->site_fields);
            // }

            if($request['main_activity'] == "doc_validation"){
                $mainactivity = "Document Validation";
            } else {
                $mainactivity = $request['main_activity'];
            }



            if($request['vendor_mode']){

                $rtbdeclaration = SubActivityValue::where('sam_id', $request->input('sam_id'))
                ->where('status', "pending")
                ->where('type', "rtb_declaration")
                ->first();

                $what_modal = "components.modal-vendor-activity";
                
                return \View::make($what_modal)
                ->with([
                    'site' => $site,
                    'sam_id' => $request['sam_id'],
                    'rtbdeclaration' => $rtbdeclaration,
                    'activity_id' => $request['activity_id'],
                    'main_activity' => $mainactivity,
                ])
                ->render();

            } else {

                if($mainactivity != "") {
                    
                    $what_modal = "components.modal-view-site";
                    return \View::make($what_modal)
                    ->with([
                        'site' => $site,
                        'sam_id' => $request['sam_id'],
                        'main_activity' => $mainactivity,
                    ])
                    ->render();


                } else {

                    if ($request->input('activity') == "Vendor Awarding of Sites" || $request->input('activity') == "Set Ariba PR Number to Sites" || $request->input('activity') == "NAM PR Memo Approval" || $request->input('activity') == "RAM Head PR Memo Approval") {

                        $pr_memo = SubActivityValue::where('sam_id', $request->input('sam_id'))
                        ->where('type', 'create_pr')
                        ->first();
    
                        $what_modal = "components.pr-memo-approval";
    
                        return \View::make($what_modal)
                        ->with([
                            'pr_memo' => $pr_memo,
                            'activity' => $request->input('activity'),
                            'samid' => $request['sam_id'],
                            'site_name' => count($site) < 1 ? "" : $site[0]->site_name
                        ])
                        ->render();
                    }
    
                    // else if ($request->input('activity') == 'SSDS RAM Validation') {
                    //     $what_modal = "components.s-s-d-s-ram-ranking";
    
                    //     $jtss_sites = SubActivityValue::select('sam_id')
                    //                                         ->where('sam_id', $request->input('sam_id'))
                    //                                         ->where('type', 'jtss_add_site')
                    //                                         ->get();
    
                    //     $jtss_sites_json = SubActivityValue::select('sam_id')
                    //                                         ->where('sam_id', $request->input('sam_id'))
                    //                                         ->where('type', 'jtss_add_site')
                    //                                         ->where('value->rank_number', '!=', 'null')
                    //                                         ->get();
    
                    //     return \View::make($what_modal)
                    //     ->with([
                    //         'jtss_sites' => $jtss_sites,
                    //         'jtss_sites_json' => $jtss_sites_json,
                    //         'activity_id' => $site[0]->activity_id,
                    //         'site_category' => $site[0]->site_category,
                    //         'activity' => $request->input('activity'),
                    //         'sam_id' => $request->input('sam_id'),
                    //         'program_id' => $request->input('program_id'),
                    //         'site_name' => count($site) < 1 ? "" : $site[0]->site_name
                    //     ])
                    //     ->render();
                    // }
    
                    // else if ($request->input('activity') == "Approved SSDS / SSDS NTP Validation" && \Auth::user()->profile_id == 8) {
    
                    //     $data = SubActivityValue::where('sam_id', $request['sam_id'])
                    //                                 ->where('status', 'approved')
                    //                                 ->where('type', 'jtss_add_site')
                    //                                 ->first();
    
                    //     $what_modal = "components.site-approved-ssds-ntp-validation";
    
                    //     return \View::make($what_modal)
                    //     ->with([
                    //         'sam_id' => $request['sam_id'],
                    //         'site_name' => $site[0]->site_name,
                    //         'program_id' => $site[0]->program_id,
                    //         'site_category' => $site[0]->site_category,
                    //         'activity_id' => $site[0]->activity_id,
                    //         'sub_activity' => $request->input('activity'),
                    //         'data' => $data,
                    //         'activity' => $request->input('activity')
                    //     ])
                    //     ->render();
    
                    // }
    
                    // else if ($request->input('activity') == "eLAS Approved" && \Auth::user()->profile_id == 8) {
    
                    //     $data = SubActivityValue::where('sam_id', $request['sam_id'])
                    //                                 ->where('status', 'approved')
                    //                                 ->where('type', 'jtss_add_site')
                    //                                 ->first();
    
                    //     $what_modal = "components.elas-approved";
    
                    //     return \View::make($what_modal)
                    //     ->with([
                    //         'sam_id' => $request['sam_id'],
                    //         'site_name' => $site[0]->site_name,
                    //         'program_id' => $site[0]->program_id,
                    //         'site_category' => $site[0]->site_category,
                    //         'activity_id' => $site[0]->activity_id,
                    //         'sub_activity' => $request->input('activity'),
                    //         'data' => $data,
                    //         'activity' => $request->input('activity')
                    //     ])
                    //     ->render();
    
                    // }
    
                    // else if ($request->input('activity') == "AEPM Validation and Scheduling" && \Auth::user()->profile_id == 26) {
    
                    //     $datas = SubActivityValue::select('sam_id')
                    //                         ->where('sam_id', $request['sam_id'])
                    //                         ->where('type', 'jtss_add_site')
                    //                         ->where('status', 'Scheduled')
                    //                         ->get();
    
                    //     $what_modal = "components.aepm-schedule-validation";
    
                    //     return \View::make($what_modal)
                    //     ->with([
                    //         'sam_id' => $request['sam_id'],
                    //         'site_name' => $site[0]->site_name,
                    //         'program_id' => $site[0]->program_id,
                    //         'site_category' => $site[0]->site_category,
                    //         'activity_id' => $site[0]->activity_id,
                    //         'activity' => $request->input('activity'),
                    //         'count' => count($datas),
                    //         'mode' => 'editor'
                    //     ])
                    //     ->render();
    
                    // }
    
                    // else if ($request->input('activity') == "Joint Technical Site Survey" && \Auth::user()->profile_id == 26) {
    
                    //     $datas = SubActivityValue::select('sam_id')
                    //                         ->where('sam_id', $request['sam_id'])
                    //                         ->where('type', 'jtss_add_site')
                    //                         ->where('status', 'Scheduled')
                    //                         ->get();
    
                    //     $what_modal = "components.aepm-schedule-validation";
    
                    //     return \View::make($what_modal)
                    //     ->with([
                    //         'sam_id' => $request['sam_id'],
                    //         'site_name' => $site[0]->site_name,
                    //         'program_id' => $site[0]->program_id,
                    //         'site_category' => $site[0]->site_category,
                    //         'activity_id' => $site[0]->activity_id,
                    //         'activity' => $request->input('activity'),
                    //         'count' => count($datas),
                    //         'mode' => 'viwer'
                    //     ])
                    //     ->render();
    
                    // }
    
                    else {
                        
                        $pr_memo = SubActivityValue::where('sam_id', $request->input('sam_id'))
                        ->where('type', 'create_pr')
                        ->first();
    
                        $pr = SubActivityValue::select('users.name', 'sub_activity_value.*')
                        ->join('users', 'users.id', 'sub_activity_value.user_id')
                        ->where('sub_activity_value.sam_id', $request->input('sam_id'))
                        // ->where('sub_activity_value.status', "pending")
                        ->where('sub_activity_value.type', "create_pr")
                        ->first();
    
    
                        $rtbdeclaration = SubActivityValue::where('sam_id', $request->input('sam_id'))
                        ->where('status', "pending")
                        ->where('type', "rtb_declaration")
                        ->first();
    
                        $what_modal = "components.modal-view-site";
                        return \View::make($what_modal)
                        ->with([
                            'site' => $site,
                            'pr' => $pr,
                            'pr_memo' => $pr_memo,
                            'sam_id' => $request['sam_id'],
                            'rtbdeclaration' => $rtbdeclaration,
                            'main_activity' => $mainactivity,
                        ])
                        ->render();
                    }                    

                }



            }




        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }



        // if(in_array( $request['main_activity'], $doc_preview_main_activities )){

        //     try {
        //         $site = \DB::connection('mysql2')
        //                 ->table('site_milestone')
        //                 ->distinct()
        //                 ->where('sam_id', '=', $request['sam_id'])
        //                 ->where('activity_complete', "=", 'false')
        //                 ->get();

        //         $site_fields = json_decode($site[0]->site_fields);

        //         if($request['main_activity'] == "doc_validation"){
        //             $mainactivity = "Document Validation";
        //         }

        //         return \View::make('components.modal-document-preview')
        //             ->with([
        //                 'site' => $site,
        //                 'sam_id' => $request['sam_id'],
        //                 'site_fields' => $site_fields,
        //                 'main_activity' => $request['main_activity']
        //             ])

        //             // ->with(['file_list' => $data,  'mode'=>$request['mode'],  'activity'=>$request['activity'],  'site'=>$request['site']])
        //             ->render();

        //         // return response()->json(['error' => false, 'message' => $data ]);

        //     } catch (\Throwable $th) {
        //         return response()->json(['error' => true, 'message' => $th->getMessage()]);
        //     }



        // }

        // elseif(in_array( $request['main_activity'], $site_view_main_actiivities )){

        //     // VIEW SITE MAKER
        //     try{

        //         $site = \DB::connection('mysql2')
        //         ->table('site_milestone')
        //         ->distinct()
        //         ->where('activity_complete', "=", 'false')
        //         ->where('sam_id', "=", $request['sam_id'])
        //         ->get();

        //         $site_fields = json_decode($site[0]->site_fields);

        //         return \View::make('components.modal-view-site')
        //                 ->with([
        //                     'site' => $site,
        //                     'sam_id' => $request['sam_id'],
        //                     'site_fields' => $site_fields,
        //                     'main_activity' => $request['main_activity']
        //                 ])
        //                 ->render();


        //     } catch (\Throwable $th) {
        //         return response()->json(['error' => true, 'message' => $th->getMessage()]);
        //     }


        // }

        // else {

        //     if((in_array($request['activity'], $documents) && in_array(\Auth::user()->profile_id, $vendor_profiles) == false)){

        //         try {
        //             $site = \DB::connection('mysql2')
        //                     ->table('site_milestone')
        //                     ->distinct()
        //                     ->where('sam_id', '=', $request['sam_id'])
        //                     ->where('activity_complete', "=", 'false')
        //                     ->get();

        //             $site_fields = json_decode($site[0]->site_fields);

        //             return \View::make('components.modal-document-preview')
        //                 ->with([
        //                     'site' => $site,
        //                     'sam_id' => $request['sam_id'],
        //                     'site_fields' => $site_fields,
        //                     'main_activity' => $request['main_activity']
        //                 ])

        //                 // ->with(['file_list' => $data,  'mode'=>$request['mode'],  'activity'=>$request['activity'],  'site'=>$request['site']])
        //                 ->render();

        //             // return response()->json(['error' => false, 'message' => $data ]);

        //         } catch (\Throwable $th) {
        //             return response()->json(['error' => true, 'message' => $th->getMessage()]);
        //         }
        //     }

        //     elseif(in_array($request['activity'], $rtb) && in_array(\Auth::user()->profile_id, $vendor_profiles) == false){

        //         try{

        //             return \View::make('components.modal-site-rtb')
        //                     ->with(['mode'=>$request['mode'],  'activity'=>$request['activity'],  'site'=>$request['site']])
        //                     ->render();


        //         } catch (\Throwable $th) {
        //             return response()->json(['error' => true, 'message' => $th->getMessage()]);
        //         }


        //     }

        //     else {


        //         // VIEW SITE MAKER
        //         try{

        //             $site = \DB::connection('mysql2')
        //             ->table('site_milestone')
        //             ->distinct()
        //             ->where('activity_complete', "=", 'false')
        //             ->where('sam_id', "=", $request['sam_id'])
        //             ->get();

        //             $site_fields = json_decode($site[0]->site_fields);

        //             return \View::make('components.modal-view-site')
        //                     ->with([
        //                         'site' => $site,
        //                         'sam_id' => $request['sam_id'],
        //                         'site_fields' => $site_fields,
        //                         'main_activity' => $request['main_activity']

        //                     ])
        //                     ->render();


        //         } catch (\Throwable $th) {
        //             return response()->json(['error' => true, 'message' => $th->getMessage()]);
        //         }

        //     }


        // }


    }

    public function get_site_issues ($issue_id, $what_table)
    {
        try {

            $site = \DB::connection('mysql2')
                            ->table('site_issue')
                            ->join('issue_type', 'issue_type.issue_type_id', 'site_issue.issue_type_id')
                            ->where('site_issue.issue_id', $issue_id)
                            ->first();

            $what_modal = "components.site-issue-validation";

            return response()->json(['error' => false, 'site' => $site  ]);

            // return \View::make($what_modal)
            // ->with([
            //     'site' => $site,
            //     'main_activity' => "Issue Validation",
            //     'what_table' => $what_table,
            //     'issue_id' => $issue_id,
            // ])
            // ->render();
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function resolve_issues($issue_id)
    {
        try {
            $site = \DB::connection('mysql2')
                            ->table('site_issue')
                            ->where('issue_id', $issue_id)
                            ->update([
                                'date_resolve' => Carbon::now()->toDate(),
                                'approver_id' => \Auth::id(),
                            ]);


            return response()->json(['error' => false, 'message' => "Successfully resolve an issue." ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function approve_reject_docs($data_id, $data_action)
    {
        try {
            SubActivityValue::where('id', $data_id)
                            ->update([
                                'status' => $data_action,
                                'approver_id' => \Auth::id(),
                                'date_approved' => Carbon::now()->toDate(),
                            ]);

            return response()->json(['error' => false, 'message' => "Successfully " .$data_action. "."]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_issue($issue_name)
    {
        try {
            $issue_type = IssueType::where('issue_type', $issue_name)->get();
            return response()->json(['error' => false, 'message' => $issue_type ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_issue_callouts($issue_name)
    {
        try {
            $issue_type = IssueType::where('issue', $issue_name)->get();
            return response()->json(['error' => false, 'message' => $issue_type ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function add_issue(Request $request)
    {
        try {
            // return response()->json(['error' => true, 'message' => $request->all() ]);



            $validate = Validator::make($request->all(), array(
                'issue_type' => 'required',
                'issue' => 'required',
                'issue_details' => 'required'
            ));

            if($validate->passes()){
                $issue_type = Issue::create([
                    // 'issue_type_id' => $request->input('issue'),
                    'issue_type_id' => $request->input('issue_callout'),
                    'sam_id' => $request->input('hidden_sam_id'),
                    'start_date' => $request->input('start_date'),
                    'issue_details' => $request->input('issue_details'),
                    'issue_status' => "active",
                    'user_id' => \Auth::id(),
                ]);
                return response()->json(['error' => false, 'message' => "Successfully added issue." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }


        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_my_issue($sam_id)
    {
        try {
            // if (\Auth::user()->profile_id == 2) {
            //     $data = Issue::join('issue_type', 'issue_type.issue_type_id', 'site_issue.issue_type_id')
            //                         ->join('users', 'users.id', 'site_issue.user_id')
            //                         ->where('site_issue.user_id', \Auth::id())
            //                         ->where('site_issue.sam_id', $sam_id)
            //                         ->get();
            // } else if (\Auth::user()->profile_id == 3) {
            //     $agents = \DB::connection('mysql2')
            //                             ->table('users')
            //                             ->select('users.id')
            //                             ->join('user_details', 'user_details.user_id', 'users.id')
            //                             ->where('user_details.IS_id', \Auth::user()->id)
            //                             ->get();

            //     $array_id = collect();

            //     foreach ($agents as $agent) {
            //         $array_id->push($agent->id);
            //     }

            //     $data = Issue::join('issue_type', 'issue_type.issue_type_id', 'site_issue.issue_type_id')
            //                     ->join('users', 'users.id', 'site_issue.user_id')
            //                     ->whereIn('site_issue.user_id', $array_id->all())
            //                     ->where('site_issue.sam_id', $sam_id)
            //                     ->get();
            // } else {
                $data = Issue::join('issue_type', 'issue_type.issue_type_id', 'site_issue.issue_type_id')
                                ->join('users', 'users.id', 'site_issue.user_id')
                                ->where('site_issue.user_id', \Auth::id())
                                ->where('site_issue.sam_id', $sam_id)
                                ->get();
            // }

            $dt = DataTables::of($data);

            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function get_issue_details($issue_id)
    {
        try {
            $data = IssueType::join('site_issue', 'site_issue.issue_type_id', 'issue_type.issue_type_id')
                            ->where('site_issue.issue_id', $issue_id)
                            ->first();

            return response()->json(['error' => false, 'message' => $data ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function cancel_issue($issue_id)
    {
        try {
            Issue::where('issue_id', $issue_id)
                        ->update([
                            'issue_status' => "cancelled"
                        ]);

            return response()->json(['error' => false, 'message' => "Successfully cancelled issue." ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function chat_send(Request $request)
    {
        try {
            $chat = Chat::create([
                'sam_id' => $request->input('sam_id'),
                'user_id' => \Auth::id(),
                'comment' => $request->input('comment'),
            ]);

            $chat_data = Chat::join('users', 'users.id', 'chat.user_id')
                                ->join('profiles', 'profiles.id', 'users.profile_id')
                                ->where('chat.id', $chat->id)
                                ->first();

            return response()->json(['error' => false, 'message' => "Successfully send a message.", "chat" => $chat_data ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function declare_rtb(Request $request)
    {
        try {

            // return response()->json(['error' => true, 'message' => $request->all() ]);
            $validate = \Validator::make($request->all(), array(
                'rtb_declaration_date' => 'required',
                'rtb_declaration' => 'required',
            ));

            if ($validate->passes()){

                $rtb = SubActivityValue::where('sam_id', $request->input('sam_id'))
                                        ->where('user_id', \Auth::id())
                                        ->where('status', "pending")
                                        ->where('type', "rtb_declaration")
                                        ->first();

                if (is_null($rtb)){

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'status' => "pending",
                        'type' => "rtb_declaration",
                    ]);

                    $asd = $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", $request->input('site_category'), $request->input('activity_id'));

                    return response()->json(['error' => false, 'message' => "Successfully declared RTB."]);
                } else {

                    $asd = $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", $request->input('site_category'), $request->input('activity_id'));
                    
                    return response()->json(['error' => false, 'message' => "Successfully declared RTB."]);
                }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function approve_reject_rtb (Request $request)
    {
        try {
            $required = "";
            if ($request->input('action') == "false" ) {
                $required = "required";
            }

            $validate = \Validator::make($request->all(), array(
                'remarks' => $required,
            ));

            if ($validate->passes()) {

                $rtb = SubActivityValue::where('sam_id', $request->input('sam_id'))
                                        ->where('type', "rtb_declaration")
                                        ->update([
                                            'status'=> $request->input('action') == "false" ? "denied" : "approved",
                                            'reason'=> $request->input('remarks'),
                                            'approver_id'=> \Auth::id(),
                                            'date_approved'=> Carbon::now()->toDate(),
                                        ]);

                $this->move_site([$request->input('sam_id')], $request->input('program_id'), $request->input('action'), $request->input('site_category'), $request->input('activity_id'));

                $message = $request->input('action') == "false" ? "rejected" : "approved";
                return response()->json(['error' => false, 'message' => "Successfully " .$message. " RTB."]);

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_my_uploade_file_data($sub_activity_id, $sam_id)
    {
        try {

            if (\Auth::user()->getUserProfile()->id == 3) {
                $user_to_gets = UserDetail::where('IS_id', \Auth::id())->get();

                $array_id = collect();

                foreach ($user_to_gets as $user_to_get) {
                    $array_id->push($user_to_get->user_id);
                }
            } else {
                $array_id = collect(\Auth::id());
            }
            $sub_activity_files = SubActivityValue::where('sam_id', $sam_id)
                                                        ->where('sub_activity_id', $sub_activity_id)
                                                        ->whereNull('type')
                                                        ->whereIn('user_id', $array_id)
                                                        ->orderBy('date_created', 'desc')
                                                        ->get();

            $dt = DataTables::of($sub_activity_files)
                                ->addColumn('value', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return isset($json['lessor_remarks']) ? $json['lessor_remarks'] : $json['file'];
                                        // return $json['lessor'];
                                        // return $json['lessor_remarks'];
                                    } else {
                                        return $row->value;
                                    }
                                })
                                ->addColumn('method', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return isset($json['lessor_method']) ? "" : "";
                                    } else {
                                        return $row->value;
                                    }
                                });
            return $dt->make(true);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function get_engagement($sub_activity_id, $sam_id)
    {
        try {

            if (\Auth::user()->getUserProfile()->id == 3) {
                $user_to_gets = UserDetail::where('IS_id', \Auth::id())->get();

                $array_id = collect();

                foreach ($user_to_gets as $user_to_get) {
                    $array_id->push($user_to_get->user_id);
                }
            } else {
                $array_id = collect(\Auth::id());
            }
            $sub_activity_files = SubActivityValue::where('sam_id', $sam_id)
                                                        // ->where('sub_activity_id', $sub_activity_id)
                                                        ->where('type', 'lessor_engagement')
                                                        ->whereIn('user_id', $array_id)
                                                        ->whereJsonContains("value", [
                                                            "sub_activity_id" => $sub_activity_id
                                                        ])
                                                        ->orderBy('date_created', 'desc')
                                                        ->get();

            $dt = DataTables::of($sub_activity_files)
                                ->addColumn('value', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return $json['lessor_remarks'];
                                    } else {
                                        return $row->value;
                                    }
                                })
                                ->addColumn('method', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return $json['lessor_method'];
                                    } else {
                                        return $row->value;
                                    }
                                });
            return $dt->make(true);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function save_engagement(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                "lessor_approval" => "required",
                "lessor_remarks" => "required",
            ));

            // return response()->json(['error' => true, 'message' => $request->all() ]);

            if ($validate->passes()) {
                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'sub_activity_id' => !is_null($request->input("log")) ? null : $request->input("sub_activity_id"),
                    'value' => json_encode($request->all()),
                    'user_id' => \Auth::id(),
                    'status' => $request->input('lessor_approval'),
                    'type' => 'lessor_engagement',
                ]);

                if ( $request->input('lessor_approval') == "approved" && !in_array($request->input("sub_activity_id"), [213, 255]) ) {
                    $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", $request->input('site_category'), $request->input('activity_id'));
                } else if (
                    $request->input('lessor_approval') == "approved" && 
                    in_array($request->input("sub_activity_id"), [213, 255])
                    ) {
                    $datas = \DB::connection('mysql2')
                                    ->table('sub_activity')
                                    ->select('sub_activity_id')
                                    ->where('activity_id', $request->input('activity_id')[0])
                                    ->where('program_id', $request->input('program_id'))
                                    ->where('category', $request->input('site_category')[0])
                                    ->where('requirements', 'required')
                                    ->whereIn('action', ['doc upload', 'lessor negotiation'])
                                    ->groupBy('sub_activity_id')
                                    ->get();

                    $sub_activity_id_collect = collect();
                    $sub_activity_values_collect = collect();

                    foreach ($datas as $data) {
                        $sub_activity_id_collect->push($data->sub_activity_id);
                    }

                    $sub_activity_values = \DB::connection('mysql2')
                                                ->table('sub_activity_value')
                                                ->where('sam_id', $request->input('sam_id'))
                                                ->whereIn('sub_activity_id', $sub_activity_id_collect->all())
                                                ->where('status', '!=', 'denied')
                                                ->get();

                    foreach ($sub_activity_values as $sub_activity_value) {
                        $sub_activity_values_collect->push($sub_activity_value->status);
                    }

                    if ( count($datas) > 0 && count($datas) <= count($sub_activity_values) ) {
                        $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", $request->input('site_category'), $request->input('activity_id'));
                    }
                }


                // $email_receiver = User::select('users.*')
                //                 ->join('user_details', 'users.id', 'user_details.user_id')
                //                 ->join('user_programs', 'user_programs.user_id', 'users.id')
                //                 ->where('user_details.vendor_id', $request->input('site_vendor_id'))
                //                 ->where('user_programs.program_id', $request->input('program_id'))
                //                 ->get();

                // SiteEndorsementEvent::dispatch($request->input('sam_id'));

                // for ($j=0; $j < count($email_receiver); $j++) {
                //     $email_receiver[$j]->notify( new SiteEndorsementNotification($request->input('sam_id'), "lessor_approval", "", $request->input('site_name')) );
                // }

                return response()->json(['error' => false, 'message' => "Successfully saved engagement."]);

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_agent_based_program($program_id)
    {
        try {
            $agents = \DB::connection('mysql2')
                                        ->table('users')
                                        ->select('users.*')
                                        ->join('user_details', 'user_details.user_id', 'users.id')
                                        ->join('user_programs', 'user_programs.user_id', 'users.id')
                                        ->where('user_details.IS_id', \Auth::user()->id)
                                        ->where('user_programs.program_id', $program_id)
                                        ->get();


            return response()->json(['error' => false, 'message' => $agents ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function agent_based_program($program_id)
    {
        try {
            $agents = \DB::connection('mysql2')
                                        ->table('users')
                                        ->select('users.*')
                                        ->join('user_programs', 'user_programs.user_id', 'users.id')
                                        ->where('user_programs.program_id', $program_id)
                                        ->get();


            return response()->json(['error' => false, 'message' => $agents ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }


    public function get_my_sub_act_value($sub_activity_id, $sam_id)
    {
        try {
            $sub_activity_ids = SubActivityValue::where('sub_activity_id', $sub_activity_id)
                                        ->where('sam_id', $sam_id)
                                        ->get();

            $dt = DataTables::of($sub_activity_ids)
                                ->addColumn('value', function($row) {
                                    $json = json_decode($row->value, true);
                                    return $json['file'];
                                });
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }


    public function get_uploaded_files($sub_activity_id, $sam_id)
    {
        try {
            $sub_activity_ids = SubActivityValue::where('sub_activity_id', $sub_activity_id)
                                        ->where('sam_id', $sam_id)
                                        ->where('type', 'doc_upload')
                                        ->get();

            $dt = DataTables::of($sub_activity_ids);
                                if (\Auth::user()->profile_id == 3 || \Auth::user()->profile_id == 28 || \Auth::user()->profile_id == 8) {
                                    $dt->addColumn('value', function($row) {
                                        if (json_last_error() == JSON_ERROR_NONE){
                                            $json = json_decode($row->value, true);
                    
                                            return $json['file'];
                                        } else {
                                            return $row->value;
                                        }

                                    })
                                    ->addColumn('status', function($row) {
                                        if (json_last_error() == JSON_ERROR_NONE){
                                            $json = json_decode($row->value, true);

                                            if ( isset($json['validators']) ) {
                                                for ($i=0; $i < count($json['validators']); $i++) { 
                                                    if ( $json['validators'][$i]['profile_id'] == \Auth::user()->profile_id ) {
                                                        return $json['validators'][$i]['status'];
                                                    }
                                                }
                                            } else {
                                                return $row->status;
                                            }
                    
                                        } else {
                                            return $row->value;
                                        }

                                    });
                                } else if (\Auth::user()->profile_id == 2 || \Auth::user()->profile_id == 9) {
                                    $dt->addColumn('value', function($row) {
                                        if (json_last_error() == JSON_ERROR_NONE){
                                            $json = json_decode($row->value, true);
                    
                                            return $json['file'];
                                        } else {
                                            return $row->value;
                                        }
                                    })
                                    ->addColumn('status', function($row) {
                                        if (json_last_error() == JSON_ERROR_NONE){
                                            $json = json_decode($row->value, true);
                    
                                            return isset($json['status']) ? $json['status'] : $row->status;
                                        } else {
                                            return $row->value;
                                        }
                                    })
                                    ;
                                }
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function set_site_category(Request $request)
    {
        try {

            $profile_id = \Auth::user()->profile_id;
            $id = \Auth::id();

            $get_category = \DB::connection('mysql2')->table("site")
                                ->select('site_category')
                                ->where("sam_id", $request->input("sam_id"))
                                ->first();

            $activities = \DB::connection('mysql2')
                    ->table('stage_activities')
                    ->select('next_activity')
                    ->where('activity_id', $request->input("activity_id"))
                    ->where('program_id', $request->input('program_id'))
                    ->where('category', $get_category->site_category)
                    ->first();

            SiteStageTracking::where('sam_id', $request->input('sam_id'))
                                                ->where('activity_complete', 'false')
                                                ->where('activity_id', $request->input("activity_id")[0])
                                                ->update([
                                                    'activity_complete' => "true"
                                                ]);

            SiteStageTracking::create([
                'sam_id' => $request->input('sam_id'),
                'activity_id' => $activities->next_activity,
                'activity_complete' => 'false',
                'user_id' => \Auth::id()
            ]);

            \DB::connection('mysql2')->table("site")
                                    ->where("sam_id", $request->input("sam_id"))
                                    ->update([
                                        'site_category' => $request->input('site_category'),
                                    ]);

            $get_next_activities = \DB::connection('mysql2')
                        ->table('stage_activities')
                        ->select('activity_name', 'profile_id')
                        ->where('activity_id', $activities->next_activity)
                        ->where('program_id', $request->input('program_id'))
                        ->where('category', $request->input('site_category'))
                        ->first();
                        
            $array = array(
                'activity_id' => $activities->next_activity,
                'activity_name' => $get_next_activities->activity_name,
                'profile_id' => $get_next_activities->profile_id,
                'category' => $request->input('site_category'),
                'activity_created' => Carbon::now()->toDateString(),
            );

            Site::where('sam_id', $request->input("sam_id"))
                    ->update([
                        'activities' => json_encode($array)
                    ]);

            return response()->json(['error' => false, 'message' => "Successfully set site category."]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_user_data ($user_id, $vendor_id, $is)
    {
        try {
            $vendor_program = VendorProgram::join('program', 'program.program_id', 'vendor_programs.programs')
                                                ->where('vendor_programs.vendors_id', $vendor_id)
                                                ->get();

            $user_data = UserProgram::select('program_id')->where('user_id', $user_id)->get();

            $supervisor = User::select('users.*')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
                                    ->where('vendor_id', $vendor_id)
                                    ->where('designation', 3)
                                    ->get();

            return response()->json(['error' => false, 'user_data' => $user_data, 'vendor_program' => $vendor_program, 'supervisor' => $supervisor ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function update_user_data(Request $request)
    {
        try {

            // return response()->json(['error' => true, 'message' => $request->all()]);

            UserProgram::where('user_id', $request->input('user_id'))
                                                ->delete();

            for ($i=0; $i < count($request->input('program')); $i++) {
                UserProgram::create([
                    'user_id' => $request->input('user_id'),
                    'program_id' => $request->input('program')[$i],
                ]);
            }

            $supervisor = UserDetail::where('user_id', $request->input('user_id'))
                                    ->update([
                                        'IS_id' => $request->input('is_id')
                                    ]);

            return response()->json(['error' => false, 'message' => "Successfully updated data." ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_supervisor ($user_id, $vendor_id)
    {
        try {
            $supervisor = User::select('users.*')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
                                    ->where('vendor_id', $vendor_id)
                                    ->where('designation', 3)
                                    ->get();

            return response()->json(['error' => false, 'supervisor' => $supervisor ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function change_supervisor($user_id, $is_id)
    {
        try {
            $supervisor = UserDetail::where('user_id', $user_id)
                                    ->update([
                                        'IS_id' => $is_id
                                    ]);

            return response()->json(['error' => false, 'message' => "Successfully changed supervisor." ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_site_issue_remarks($issue_id)
    {
        try {
            $issue_remakrs = \DB::connection('mysql2')
                                        ->table('site_issue_remarks')
                                        ->where('site_issue_id', $issue_id)
                                        ->get();

            $dt = DataTables::of($issue_remakrs);

            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function add_remarks(Request $request)
    {
        try {
            $validate = \Validator::make($request->all(), array(
                'remarks' => 'required',
                'date_engage' => 'required',
            ));

            if ($validate->passes()) {
                IssueRemark::create($request->all());
                Issue::where('issue_id', $request->input('site_issue_id'))
                        ->update([
                            'issue_status' => $request->input('status'),
                        ]);
                return response()->json(['error' => false, 'message' => "Successfully added remarks."]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function subactivity_step($sub_activity_id, $sam_id, $sub_activity)
    {
        try {
            // $substeps = \DB::connection('mysql2')->table('sub_activity_step')->where('sub_activity_id', $sub_activity_id)->get();
            $substeps = \Auth::user()->subactivity_step($sub_activity_id);

            $what_component = "components.site-sub-step";
            return \View::make($what_component)
            ->with([
                'substeps' => $substeps,
                'sam_id' => $sam_id,
                'sub_activity' => $sub_activity
            ])
            ->render();
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function submit_subactivity_step(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                "date" => "required",
                "remarks" => "required",
            ));

            if ($validate->passes()) {
                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'value' => json_encode($request->all()),
                    'user_id' => \Auth::id(),
                    'type' => "substep",
                    'status' => "approved",
                ]);

                return response()->json([ 'error' => false, 'message' => "Successfully saved." ]);
            } else {
                return response()->json([ 'error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }


    ///////////////////////////////////////////////////
    //                                               //
    //                PR / PO Module                 //
    //                                               //
    ///////////////////////////////////////////////////

    // public function get_fiancial_analysis ($sam_id, $vendor)
    public function get_fiancial_analysis (Request $request)
    {
        try {
            $sam_id = $request->input('sam_id');
            $vendor = $request->input('vendor');

            $sites_collect = collect();
            $sites_fsa = collect();

            for ($i=0; $i < count($sam_id); $i++) {
                $sites_data = \DB::connection('mysql2')
                            ->table('site')
                            ->where('sam_id', $sam_id[$i])
                            ->first();

                $line_items = FsaLineItem::join('fsaq', 'fsaq.fsaq_id', 'site_line_items.fsa_id')
                                ->where('site_line_items.sam_id', $sam_id[$i])
                                ->where('site_line_items.status', '!=', 'denied')
                                ->get();

                if (count($line_items) > 0) {
                    
                    // FsaLineItem::where('sam_id', $sam_id[$i])
                    //                 ->where('status', '!=', 'denied')
                    //                 ->update([
                    //                     'is_include' => 1
                    //                 ]);
                } else {
                
                    $fsa_data = \DB::connection('mysql2')
                                    ->table('fsaq')
                                    ->where('vendor_id', $vendor)
                                    ->where('region_id', $sites_data->site_region_id)
                                    ->where('province_id', $sites_data->site_province_id)
                                    ->where('lgu_id', $sites_data->site_lgu_id)
                                    ->where('site_type', "ROOFTOP")
                                    ->where('account_type', "BAU")
                                    ->where('solution_type', "MACRO")
                                    ->get();

                    // Works up to LGU
                    if(count($fsa_data)>0){
                    } else {

                        $fsa_data = \DB::connection('mysql2')
                                            ->table('fsaq')
                                            ->where('vendor_id', $vendor)
                                            ->where('region_id', $sites_data->site_region_id)
                                            ->where('province_id', $sites_data->site_province_id)
                                            ->whereNull('lgu_id')
                                            ->where('site_type', "ROOFTOP")
                                            ->where('account_type', "BAU")
                                            ->where('solution_type', "MACRO")
                                            ->get();

                        // Works up to province
                        if(count($fsa_data)>0){

                        } else {

                            $fsa_data = \DB::connection('mysql2')
                                                ->table('fsaq')
                                                ->where('vendor_id', $vendor)
                                                ->where('region_id', $sites_data->site_region_id)
                                                ->whereNull('province_id')
                                                ->whereNull('lgu_id')
                                                ->where('site_type', "ROOFTOP")
                                                ->where('account_type', "BAU")
                                                ->where('solution_type', "MACRO")
                                                ->get();

                            if(count($fsa_data)>0){

                            } else {

                            }
                        }

                    }

                    // GET PENDING FSA LINE ITEMS
                    $fsa_line_items = FsaLineItem::where('sam_id', $sam_id[$i])->where('status', '=', 'pending')->get();

                    // CLEANUP PENDING
                    if (count($fsa_line_items) > 0) {
                        FsaLineItem::where('sam_id', $sam_id[$i])
                                        ->where('status', 'pending')
                                        ->delete();
                    }

                    foreach ($fsa_data as $fsa) {
                        FsaLineItem::create([
                            'sam_id' => $sam_id[$i],
                            'fsa_id' => $fsa->fsaq_id,
                            'status' => 'pending',
                        ]);
                    }

                }
                // return response()->json(['error' => true, 'message' => $fsa_line_items]);

                $sites = FsaLineItem::select('site.site_name', 'site.site_address', 'site.sam_id', 'location_regions.region_name', 'location_provinces.province_name', 'fsaq.amount')
                            ->leftjoin('site', 'site.sam_id', 'site_line_items.sam_id')
                            ->leftjoin('fsaq', 'fsaq.fsaq_id', 'site_line_items.fsa_id')
                            ->leftjoin('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->leftjoin('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->leftjoin('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.sam_id', $sam_id[$i])
                            ->where('site_line_items.status', '!=', 'denied')
                            ->where('site_line_items.is_include', 1)
                            ->get();


                if (count($sites) > 1) {
                    $sites_collect->push($sites);
                }

                // $pricings = FsaLineItem::select('fsaq.price')
                //             ->join('fsa_table', 'fsa_table.fsa_id', 'site_line_items.fsa_id')
                //             ->where('site_line_items.sam_id', $sam_id[$i])
                //             ->where('site_line_items.status', '!=', 'denied')
                //             ->get();

                $pricings = FsaLineItem::select('fsaq.amount')
                            ->join('fsaq', 'fsaq.fsaq_id', 'site_line_items.fsa_id')
                            ->where('site_line_items.status', '!=', 'denied')
                            ->where('site_line_items.is_include', 1)
                            ->where('site_line_items.sam_id', '=', $sam_id[$i])
                            ->get();

                if (count($pricings) > 1) {
                    foreach ($pricings as $pricing) {

                        $amount = (float)$pricing->amount;

                        $sites_fsa->push($amount);
                    }
                }



            }



            return response()->json([ 'error' => false, 'message' => $sites_collect, 'sites_fsa' => array_sum($sites_fsa->all()) ]);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function remove_fiancial_analysis($sam_id)
    {
        try {
            FsaLineItem::where('sam_id', $sam_id)->delete();
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_line_items($sam_id, $vendor)
    {
        try {
            // $line_items = FsaLineItem::rightjoin('fsa_table', 'fsa_table.fsa_id', 'site_line_items.fsa_id')
            //                                 ->where('site_line_items.sam_id', $sam_id)
            //                                 ->get();

            // $sites = \DB::connection('mysql2')
            //                 ->table('site')
            //                 ->where('sam_id', $sam_id)
            //                 ->first();


            // $line_items = \DB::connection('mysql2')
            //                     ->table('fsaq')
            //                     ->select('vendor_id')
            //                     ->where('vendor_id', $vendor)
            //                     ->where('region_id', $sites->site_region_id)
            //                     ->where('province_id', $sites->site_province_id)
            //                     ->where('lgu_id', $sites->site_lgu_id)
            //                     ->where('site_type', '=', 'ROOFTOP')
            //                     ->where('account_type', '=', 'BAU')
            //                     ->where('solution_type', '=', 'MACRO')
            //                     ->get();

            // return response()->json([ 'error' => false, 'message' => $line_items ]);
            // if(count($line_items) > 0){

                // $site_items = FsaLineItem::where('sam_id', $sam_id)->where('status', '!=', 'denied')
                // ->get();

                // return response()->json([ 'error' => false, 'message' => $line_items->groupBy('category'), 'site_items' => $site_items ]);

                
                $line_items = FsaLineItem::join('fsaq', 'fsaq.fsaq_id', 'site_line_items.fsa_id')
                                            ->where('site_line_items.sam_id', $sam_id)
                                            ->where('site_line_items.status', '!=', 'denied')
                                            ->get();

                return response()->json([ 'error' => false, 'message' => $line_items->groupBy('category') ]);

            // } else {

            //     $fsaq_regions = \DB::connection('mysql2')
            //                         ->table('fsaq')
            //                         ->select('vendor', \DB::raw('count(`fsaq_id`) as counter'))
            //                         ->groupBy('vendor')
            //                         ->where('vendor_id', $vendor)
            //                         ->where('region_id', $sites->site_region_id)
            //                         ->where('fsaq.site_type', '=', 'ROOFTOP')
            //                         ->where('fsaq.account_type', '=', 'BAU')
            //                         ->where('fsaq.solution_type', '=', 'MACRO')
            //                         ->get();

            //     if(count($fsaq_regions) > 0){

            //         $fsaq_provinces = \DB::connection('mysql2')
            //                         ->table('fsaq')
            //                         ->select('vendor', \DB::raw('count(`fsaq_id`) as counter'))
            //                         ->groupBy('vendor')
            //                         ->where('vendor_id', $vendor)
            //                         ->where('region_id', $sites->site_region_id)
            //                         ->where('province_id', $sites->site_province_id)
            //                         ->whereNull('lgu_id')
            //                         ->where('fsaq.site_type', '=', 'ROOFTOP')
            //                         ->where('fsaq.account_type', '=', 'BAU')
            //                         ->where('fsaq.solution_type', '=', 'MACRO')
            //                     ->get();

            //         if(count($fsaq_provinces) > 0){

            //             $line_items = \DB::connection('mysql2')
            //                             ->table('fsaq')
            //                             ->where('vendor_id', 9)
            //                             ->where('region_id', $sites->site_region_id)
            //                             ->where('province_id', $sites->site_province_id)
            //                             ->whereNull('lgu_id')
            //                             ->where('fsaq.site_type', '=', 'ROOFTOP')
            //                             ->where('fsaq.account_type', '=', 'BAU')
            //                             ->where('fsaq.solution_type', '=', 'MACRO')
            //                             ->get();

            //             // return dd($line_items);

            //             $site_items = FsaLineItem::where('sam_id', $sam_id)->where('status', '!=', 'denied')
            //             ->get();

            //             return response()->json([ 'error' => false, 'message' => $line_items->groupBy('category'), 'site_items' => $site_items ]);

            //         } else {

            //             return response()->json(['error' => true, 'message' => "No FSAQ data in province: " . $sites->site_province_id . " lgu: " . $sites->site_lgu_id . " for vendor id: " . $vendor ]);

            //         }

            //     } else {
            //         return response()->json(['error' => true, 'message' => "No FSAQ data in region: " . $sites->site_region_id . " for vendor id: " . $vendor ]);
            //     }

            // }




        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function save_line_items(Request $request)
    {
        try {
            FsaLineItem::where('sam_id', $request->input('sam_id'))
                        ->whereNotIn('fsa_id', $request->input('line_item_id'))
                        ->where('status', '!=', 'denied')
                        ->update([
                            'is_include' => 0
                        ]);

            FsaLineItem::where('sam_id', $request->input('sam_id'))
                        ->whereIn('fsa_id', $request->input('line_item_id'))
                        ->where('status', '!=', 'denied')
                        ->update([
                            'is_include' => 1
                        ]);

            // for ($i=0; $i < count($request->input('line_item_id')); $i++) {
            //     FsaLineItem::create([
            //         'sam_id' => $request->input('sam_id'),
            //         'fsa_id' => $request->input('line_item_id')[$i],
            //         'status' => 'pending',
            //     ]);
            // }

            return response()->json([ 'error' => false, 'message' => "Successfully saved line items." ]);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function add_pr_po(Request $request)
    {
        try {

            $validate = \Validator::make($request->all(), array(
                'budget_source' => 'required',
                'date_created' => 'required',
                'department' => 'required',
                'division' => 'required',
                'from' => 'required',
                'group' => 'required',
                'recommendation' => 'required',
                'requested_amount' => 'required',
                'subject' => 'required',
                'thru' => 'required',
                'to' => 'required',
            ));

            if ($validate->passes()) {

                $last_pr_memo = PrMemoTable::orderBy('pr_memo_id', 'desc')->first();

                $generated_pr = "PR-MEMO-00000".(!is_null($last_pr_memo) ? $last_pr_memo->pr_memo_id + 1 : 0 + 1);

                $current = \Carbon::now()->format('YmdHs');

                $file_name = 'create-pr-memo-'.$current.'.pdf';

                $sites = \DB::connection('mysql2')
                                ->table('site')
                                ->select('site_line_items.fsa_id', 'site.site_name', 'site.site_address', 'site.sam_id', 'location_regions.region_name', 'location_provinces.province_name', 'fsaq.amount')
                                ->leftjoin('site_line_items', 'site_line_items.sam_id', 'site.sam_id')
                                ->leftjoin('fsaq', 'fsaq.fsaq_id', 'site_line_items.fsa_id')
                                ->leftjoin('location_regions', 'location_regions.region_id', 'site.site_region_id')
                                ->leftjoin('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                                ->whereIn('site.sam_id', $request->input("sam_id"))
                                ->where('site_line_items.status', '!=', 'denied')
                                ->get();

                $view = \View::make('components.create-pr-po-pdf')
                    ->with([
                        'budget_source' => $request->input("budget_source"),
                        'date_created' => $request->input("date_created"),
                        'department' => $request->input("department"),
                        'division' => $request->input("division"),
                        'from' => $request->input("from"),
                        'group' => $request->input("group"),
                        'recommendation' => $request->input("recommendation"),
                        'requested_amount' => $request->input("requested_amount"),
                        'subject' => $request->input("subject"),
                        'thru' => $request->input("thru"),
                        'to' => $request->input("to"),
                        'sites' => $sites->groupBy('sam_id'),
                        'generated_pr' => $generated_pr,
                    ])
                    ->render();

                $pdf = \App::make('dompdf.wrapper');
                $pdf = PDF::loadHTML($view);
                $pdf->setPaper('a4', 'landscape');
                $pdf->download();

                \Storage::put('pdf/'.$file_name, $pdf->output());

                $pr_memo_table = PrMemoTable::create([
                    'budget_source' => $request->input("budget_source"),
                    'department' => $request->input("department"),
                    'division' => $request->input("division"),
                    'from' => $request->input("from"),
                    'group' => $request->input("group"),
                    'recommendation' => $request->input("recommendation"),
                    'requested_amount' => $request->input("requested_amount"),
                    'subject' => $request->input("subject"),
                    'thru' => $request->input("thru"),
                    'to' => $request->input("to"),
                    'file_name' => $file_name,
                    'generated_pr_memo' => $generated_pr,
                    'activity_id' => $request->input("activity_id"),
                    'site_category' => $request->input("site_category"),
                    'vendor_id' => $request->input("vendor"),
                    'user_id' => \Auth::id(),
                    'status' => "pending",
                ]);

                for ($i=0; $i < count($request->input("sam_id")); $i++) {

                    $array_data = array(
                        'budget_source' => $request->input("budget_source"),
                        'date_created' => $request->input("date_created"),
                        'department' => $request->input("department"),
                        'division' => $request->input("division"),
                        'from' => $request->input("from"),
                        'group' => $request->input("group"),
                        'recommendation' => $request->input("recommendation"),
                        'requested_amount' => $request->input("requested_amount"),
                        'subject' => $request->input("subject"),
                        'thru' => $request->input("thru"),
                        'to' => $request->input("to"),
                        'file_name' => $file_name,
                        'sam_id' => $request->input("sam_id")[$i],
                        'vendor' => $request->input('vendor'),
                        'generated_pr_memo' => $generated_pr,
                        'activity_id' => $request->input("activity_id"),
                        'site_category' => $request->input("site_category"),
                        'vendor_id' => $request->input("vendor"),
                        'user_id' => \Auth::id(),
                    );

                    PrMemoSite::create([
                        'sam_id' => $request->input("sam_id")[$i],
                        'pr_memo_id'=> $generated_pr
                    ]);

                    \DB::connection('mysql2')->table("site")
                                    ->where("sam_id", $request->input("sam_id")[$i])
                                    ->update([
                                        'site_vendor_id' => $request->input('vendor'),
                                    ]);

                    $check_sub_act = SubActivityValue::where('sam_id', $request->input("sam_id")[$i])
                                                            ->where('type', 'create_pr')
                                                            ->where('status', 'pending')
                                                            ->first();
                    if (is_null($check_sub_act)) {
                        SubActivityValue::create([
                            'sam_id' => $request->input("sam_id")[$i],
                            'value' => json_encode($array_data),
                            'user_id' => \Auth::id(),
                            'type' => "create_pr",
                            'status' => "pending",
                        ]);
                    } else {
                        $check_sub_act->delete();

                        SubActivityValue::create([
                            'sam_id' => $request->input("sam_id")[$i],
                            'value' => json_encode($array_data),
                            'user_id' => \Auth::id(),
                            'type' => "create_pr",
                            'status' => "pending",
                        ]);
                    }

                    $activities = \DB::connection('mysql2')
                                                ->table('stage_activities')
                                                ->select('next_activity', 'activity_name', 'return_activity')
                                                ->where('activity_id', $request->input("activity_id"))
                                                ->where('program_id', $request->input("program_id"))
                                                ->where('category', $request->input("site_category"))
                                                ->first();

                    $get_activitiess = \DB::connection('mysql2')
                                                ->table('stage_activities')
                                                ->select('next_activity', 'activity_name', 'profile_id', 'activity_id')
                                                ->where('activity_id', $activities->next_activity)
                                                ->where('program_id', $request->input("program_id"))
                                                ->where('category', $request->input("site_category"))
                                                ->first();

                    $activity_name = $get_activitiess->activity_name;
                    $activity = $get_activitiess->activity_id;

                    SiteStageTracking::where('sam_id', $request->input("sam_id")[$i])
                                                ->where('activity_complete', 'false')
                                                ->where('activity_id', $request->input("activity_id"))
                                                ->update([
                                                    'activity_complete' => "true"
                                                ]);

                    $site_check = SiteStageTracking::select('sam_id')
                                        ->where('sam_id', $request->input("sam_id")[$i])
                                        ->where('activity_id', $activity)
                                        ->where('activity_complete', "false")
                                        // ->where('user_id', \Auth::id())
                                        ->get();

                    if ( count($site_check) < 1 ) {

                        SiteStageTracking::create([
                            'sam_id' => $request->input("sam_id")[$i],
                            'activity_id' => $activity,
                            'activity_complete' => 'false',
                            'user_id' => \Auth::id()
                        ]);
                    }

                    $array = array(
                        'activity_id' => $activity,
                        'activity_name' => $activity_name,
                        'profile_id' => $get_activitiess->profile_id,
                        'category' => $request->input("site_category"),
                        'activity_created' => Carbon::now()->toDateString(),
                    );

                    Site::where('sam_id', $request->input("sam_id")[$i])
                    ->update([
                        'activities' => json_encode($array)
                    ]);
                }

                return response()->json([ 'error' => false, 'message' => "Successfully added PR Memo.", "file_name" => $file_name ]);
            } else {
                return response()->json([ 'error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_create_pr_memo ($program_id)
    {
        try {

            $what_modal = "components.create-pr-memo";

            $vendors = \DB::table("fsaq_vendors")
                                ->select("fsaq_vendors.vendor_sec_reg_name", "fsaq_vendors.vendor_id", "fsaq_vendors.vendor_acronym")
                                ->orderBy('vendor_sec_reg_name', 'ASC')
                                ->get();

            // $sites = \DB::connection('mysql2')
            //                     ->table("site")
            //                     ->leftjoin("vendor", "site.site_vendor_id", "vendor.vendor_id")
            //                     ->leftjoin("location_regions", "site.site_region_id", "location_regions.region_id")
            //                     ->leftjoin("location_provinces", "site.site_province_id", "location_provinces.province_id")
            //                     ->leftjoin("location_lgus", "site.site_lgu_id", "location_lgus.lgu_id")
            //                     ->leftjoin("location_sam_regions", "location_regions.sam_region_id", "location_sam_regions.sam_region_id")
            //                     ->leftjoin("new_sites", "new_sites.sam_id", "site.sam_id")
            //                     ->where('site.program_id', 1)
            //                     ->where('activities->activity_id', '2')
            //                     ->where('activities->profile_id', '8')
            //                     ->orderBy('search_ring', 'asc')
            //                     ->get();

            // if ($program_id == 1) {
            // $sites = \DB::connection('mysql2')
            //                     ->table("view_sites_per_program")
            //                     ->where('program_id', $program_id)
            //                     ->where('activity_id', 2)
            //                     ->orderBy('site_name')
            //                     ->get();
            // } else if ($program_id == 5) {
            //     $sites = \DB::connection('mysql2')
            //                         ->table("view_sites_per_program")
            //                         ->where('program_id', $program_id)
            //                         ->where('activity_id', 5)
            //                         ->orderBy('site_name')
            //                         ->get();
            // }

            return \View::make($what_modal)
            ->with([
                'vendors' => $vendors,
                // 'sites' => $sites,
                'program_id' => $program_id
            ])
            ->render();
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function print_to_pdf_pr_po (Request $request)
    {
        try {

            $sites = \DB::connection('mysql2')
                            ->table('new_sites')
                            ->whereIn('sam_id', $request->input("sam_id"))
                            ->get();

            $view = \View::make('components.create-pr-po-pdf')
                ->with([
                    'budget_source' => $request->input("budget_source"),
                    'date_created' => $request->input("date_created"),
                    'department' => $request->input("department"),
                    'division' => $request->input("division"),
                    'from' => $request->input("from"),
                    'group' => $request->input("group"),
                    'recommendation' => $request->input("recommendation"),
                    'requested_amount' => $request->input("requested_amount"),
                    'subject' => $request->input("subject"),
                    'thru' => $request->input("thru"),
                    'to' => $request->input("to"),
                    'sites' => $sites,
                ])
                ->render();

            $pdf = \App::make('dompdf.wrapper');
            $pdf = PDF::loadHTML($view);
            $pdf->setPaper('a4', 'landscape');
            // $pdf->setWarnings(false);

            // $file_name = $this->rename_file($request->input("file_name"), $request->input("sub_activity_name"), $request->input("sam_id"));

            \Storage::put('pdf/'.$request->input("file_name"), $pdf->output());
            return $pdf->stream();

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            abort(403, $th->getMessage());
        }
    }

    public function reject_site (Request $request)
    {
        try {
            $validate = \Validator::make($request->all(), array(
                'remarks' => 'required'
            ));

            if ($validate->passes()) {
                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'value' => json_encode($request->all()),
                    'user_id' => \Auth::id(),
                    'type' => $request->input("type"),
                    'status' => "denied",
                ]);

                return response()->json(['error' => false, 'message' => "Successfully rejected site." ]);
            } else {
                return response()->json([ 'error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function approve_reject_pr_memo (Request $request)
    {
        try {
            $required = $request->input("data_action") == "false" ? "required" : "";

            $validate = \Validator::make($request->all(), array(
                'remarks' => $required
            ));

            if ($validate->passes()) {
                $sites = PrMemoSite::where('pr_memo_id', $request->input('pr_memo'))->get();
                $sam_id = collect();
                $activity_id = collect();
                $site_category = collect();

                PrMemoTable::where('generated_pr_memo', $request->input('pr_memo'))
                                ->update([
                                    'status' => $request->input("data_action") == "false" ? "denied" : "approved"
                                ]);

                foreach ($sites as $site) {
                    $sam_id->push($site->sam_id);
                    if ($request->input("program_id") == 1) {
                        if ($request->input("activity_name") == "NAM PR Memo Approval") {
                            $activity_id->push('4');
    
                            // SubActivityValue::where('sam_id', $site->sam_id)
                            //                 ->where('type', "recommend_pr")
                            //                 ->update([
                            //                     'value' => $request->input("recommendation_site"),
                            //                     'user_id' => \Auth::id(),
                            //                     'approver_id' => \Auth::id(),
                            //                     'status' => "pending",
                            //                     'date_created' => Carbon::now()->toDate(),
                            //                 ]);
    
                            if (!is_null($request->input('recommendation_site'))) {
                                SubActivityValue::create([
                                    'sam_id' => $site->sam_id,
                                    'type' => "recommend_pr",
                                    'value' => $request->input("recommendation_site"),
                                    'user_id' => \Auth::id(),
                                    'status' => "pending",
                                ]);
                            }
                        } else if ($request->input("activity_name") == "RAM Head PR Memo Approval") {
                            $activity_id->push('3');
                        }
                    } else {

                        if ($request->input("activity_name") == "NAM PR Memo Approval") {
                            $activity_id->push('7');
    
                            // SubActivityValue::where('sam_id', $site->sam_id)
                            //                 ->where('type', "recommend_pr")
                            //                 ->update([
                            //                     'value' => $request->input("recommendation_site"),
                            //                     'user_id' => \Auth::id(),
                            //                     'approver_id' => \Auth::id(),
                            //                     'status' => "pending",
                            //                     'date_created' => Carbon::now()->toDate(),
                            //                 ]);
    
                            if (!is_null($request->input('recommendation_site'))) {
                                SubActivityValue::create([
                                    'sam_id' => $site->sam_id,
                                    'type' => "recommend_pr",
                                    'value' => $request->input("recommendation_site"),
                                    'user_id' => \Auth::id(),
                                    'status' => "pending",
                                ]);
                            }
                        } else if ($request->input("activity_name") == "RAM Head PR Memo Approval") {
                            $activity_id->push('6');
                        }
                    }
                    $site_category->push('none');

                    SubActivityValue::where('sam_id', $site->sam_id)
                                        ->where('type', "create_pr")
                                        ->update([
                                            'approver_id' => \Auth::id(),
                                            'reason' => $request->input("data_action") == "false" ? $request->input("remarks") : NULL,
                                            'status' => $request->input("data_action") == "false" ? "denied" : "approved",
                                            'date_approved' => $request->input("data_action") == "false" ? NULL : Carbon::now()->toDate(),
                                        ]);

                    FsaLineItem::where('sam_id', $site->sam_id)->where('status', '!=', 'rejected')
                                        ->update([
                                            'status' => $request->input("data_action") == "false" ? "denied" : "approved"
                                        ]);
                }

                    // if ($request->input("data_action") == "false") {
                        // $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$site->sam_id.'", '.\Auth::user()->profile_id.', '.\Auth::id().', "false")');
                    // }
                $asd = $this->move_site( $sam_id->all(), $request->input("program_id"), $request->input("data_action"), $site_category->all(), $activity_id->all() );
                // return response()->json([ 'error' => true, 'message' => $asd ]);

                $message_action = $request->input("data_action") == "false" ? "rejected" : "approved";
                return response()->json(['error' => false, 'message' => "Successfully ".$message_action." PR Memo." ]);

            } else {
                return response()->json([ 'error' => true, 'message' => $validate->errors() ]);
            }

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function vendor_awarding_sites (Request $request)
    {
        try {
            $validate = \Validator::make($request->all(), array(
                'po_number' => 'required'
            ));

            if ($validate->passes()) {

                // $pr_memo = PrMemoSite::select('pr_memo_id')->where('sam_id', $request->input('sam_id'))->first();

                // $sites = PrMemoSite::where('pr_memo_id', $pr_memo->pr_memo_id)->get();

                // $samid_collect = collect();
                $samid_collect = json_decode($request->input('sam_id'));
                $sitecategory_collect = collect();
                $activityid_collect = collect();

                // foreach ($sites as $site) {
                for ($i=0; $i < count($samid_collect); $i++) {
                    SiteEndorsementEvent::dispatch($samid_collect[$i]);

                    \DB::connection('mysql2')->table("site")
                                        ->where("sam_id", $samid_collect[$i])
                                        ->update([
                                            'site_po' => $request->input('po_number'),
                                        ]);

                    if ($request->input('program_id') == 1) {
                        $activityid_collect->push(6);
                    } else {
                        $activityid_collect->push(9);
                    }
                    $sitecategory_collect->push("none");
                    // $new_endorsements = \DB::connection('mysql2')->statement('call `a_update_data`("'.$site->sam_id.'", '.\Auth::user()->profile_id.', '.\Auth::id().', "'.$request->input("data_action").'")');
                }
                // }
                $sam_id = $samid_collect;
                $site_category = $sitecategory_collect->all();
                $activity_id = $activityid_collect->all();
                $program_id = $request->input('program_id');


                $this->move_site($sam_id, $program_id, "true", $site_category, $activity_id);

                return response()->json(['error' => false, 'message' => "Successfully awarded a site." ]);

            } else {
                return response()->json([ 'error' => true, 'message' => $validate->errors() ]);
            }

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function export_line_items($generated_pr)
    {
        return Excel::download(new PerSheetPrExport($generated_pr), strtolower($generated_pr).'.xlsx');
    }

    public function add_remarks_file (Request $request)
    {
        try {

            $validate = \Validator::make($request->all(), array(
                'remarks' => 'required',
            ));

            if ($validate->passes()) {

                $remarks = SubActivityValue::where('type', 'remarks_file')
                                                ->whereJsonContains('value', [
                                                    "id" => $request->input("id"),
                                                ])
                                                ->first();

                if (is_null($remarks)) {

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'type' => "remarks_file",
                        'status' => "pending",
                    ]);

                    return response()->json(['error' => false, 'message' => "Successfully added remarks." ]);
                } else {

                    SubActivityValue::where('id', $remarks->id)
                    ->update([
                        'sam_id' => $request->input("sam_id"),
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'type' => "remarks_file",
                        'status' => "pending",
                    ]);

                    return response()->json(['error' => false, 'message' => "Successfully updated remarks." ]);
                }

            } else {
                return response()->json([ 'error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_remarks_file ($id, $sam_id)
    {
        try {
            $remarks_file = SubActivityValue::where('sam_id', $sam_id)
                        ->where('type', 'remarks_file')
                        ->whereJsonContains("value", [
                            "id" => $id
                        ])
                        ->first();

            return response()->json([ 'error' => false, 'message' => is_null($remarks_file) ? null : $remarks_file ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    //******************** E N D ********************//
    //                                               //
    //                PR / PO Module                 //
    //                                               //
    //***********************************************//



    public function endorse_atrb(Request $request)
    {
        try {
            for ($i=0; $i < count($request->input('sam_id')); $i++) {
                $activity = \DB::connection('mysql2')->table('stage_activities')
                                        ->where('program_id', $request->input('data_program'))
                                        ->orderby('activity_id', 'desc')
                                        ->take(1)
                                        ->get();

                SiteStageTracking::where('sam_id', $request->input('sam_id')[$i])
                                    ->update(['activity_complete' => 'true']);

                SiteStageTracking::create([
                    'sam_id' => $request->input('sam_id')[$i],
                    'activity_id' => $activity[0]->activity_id,
                    'activity_complete' => 'true',
                    'user_id' => \Auth::id(),
                ]);
            }

            return response()->json(['error' => false, 'message' => "This ARTB site move to completed."]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_coloc_filter($site_type, $program, $technology)
    {
        try {

            $sites = \DB::connection('mysql2')
                    ->table("view_sites_activity")
                    ->select('site_name', 'sam_id', 'site_category', 'activity_id', 'program_id', 'site_endorsement_date', 'site_fields', 'id', 'site_vendor_id', 'activity_name', 'program_endorsement_date')
                    ->where('program_id', $program)
                    ->where('profile_id', \Auth::user()->profile_id);

            if($site_type != '-'){
                $sites = $sites->whereJsonContains("site_fields", [
                    "field_name" => 'site_type',
                    "value" => $site_type,
                ]);
            } else if($program != '-') {
                $sites = $sites->whereJsonContains("site_fields", [
                    "field_name" => 'program',
                    "value" => $program,
                ]);
            } else if($technology != '-') {
                $sites = $sites->whereJsonContains("site_fields", [
                    "field_name" => 'technology',
                    "value" => $technology,
                ]);
            }

            $sites->get();

            $dt = DataTables::of($sites);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function get_program_fields ($sam_id, $program)
    {
        try {
            if ($program == 3) {
                $table = 'program_coloc';
            } else if ($program == 4) {
                $table = 'program_ibs';
            } else if ($program == 2) {
                $table = 'program_ftth';
            } else if ($program == 1) {
                $table = 'program_newsites';
            } else if ($program == 5) {
                $table = 'program_mwan';
            }
            $datas = \DB::connection('mysql2')
                            ->table($table)
                            ->where('sam_id', $sam_id)
                            ->get();

            return response()->json(['error' => false, 'message' => $datas]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_site_memo ($value)
    {
        try {

            if ($value == 'PR Memo Creation') {
                $sites = \DB::connection('mysql2')
                            ->table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->whereJsonContains('site.activities->activity_id', '2')
                            ->get();
            } else if ($value == 'RAM Head Approval') {
                $sites = \DB::connection('mysql2')
                            ->table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->whereJsonContains('site.activities->activity_id', '3')
                            ->get();
            } else if ($value == 'NAM Approval') {
                $sites = \DB::connection('mysql2')
                            ->table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->whereJsonContains('site.activities->activity_id', '4')
                            ->get();
            } else if ($value == 'Arriba PR No Issuance') {
                $sites = \DB::connection('mysql2')
                            ->table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->whereJsonContains('site.activities->activity_id', '5')
                            ->get();
            } else if ($value == 'Vendor Awarding') {
                $sites = \DB::connection('mysql2')
                            ->table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->whereJsonContains('site.activities->activity_id', '6')
                            ->get();
            } else if ($value == 'Completed') {
                $sites = \DB::connection('mysql2')
                            ->table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->whereJsonContains('site.activities->activity_id', '7')
                            ->get();
            } else if ($value == 'Total Sites') {
                $sites = \DB::connection('mysql2')
                            ->table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->get();
            }

            $what_modal = "components.view-pr-memo-site";
            
            return \View::make($what_modal)
            ->with([
                'value' => $value,
                'sites' => $sites,
            ])
            ->render();

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_site_candidate ($sam_id, $status)
    {
        try {
            $datas = SubActivityValue::where('sam_id', $sam_id);

            if ($status == "jtss_schedule_site") {
                $datas->where('type', 'jtss_schedule_site')
                        ->where('status', 'pending');
            } else if ( $status == 'rejected_schedule' ) {
                $datas->where('type', 'jtss_schedule_site')
                        ->where('status', 'rejected');
            } else if ( $status == 'rejected' ) {
                $datas->where('type', 'jtss_add_site')
                        ->where('status', $status);
            } else if ( $status == 'jtss_ssds' ) {
                $datas->where('type', 'jtss_ssds')
                        ->where('type', $status)
                        ->where('status', 'Done');
            } else if ( $status == 'jtss_ssds_ranking' ) {
                $datas->where('type', 'jtss_ssds')
                        ->where('type', 'jtss_ssds');
            } else if ( $status == 'assds_lease_rate' ) {
                $datas->where('type', 'jtss_ssds')
                        ->where('type', 'jtss_ssds');
            } else if ( $status == 'jtss_schedule_site_approved' ) {
                $datas->where('type', 'jtss_ranking')
                        ->where('status', 'pending');
            } else if ( $status == 'jtss_approved' ) {
                $datas->where('type', 'jtss_approved')
                        ->where('status', 'pending');
            } else {
                $datas->where('type', 'jtss_add_site');
            }
            
            $datas->get();

            $dt = DataTables::of($datas)
                ->addColumn('lessor', function($row){
                    json_decode($row->value);
                    if (json_last_error() == JSON_ERROR_NONE){
                        $json = json_decode($row->value, true);

                        return $json['lessor'];
                    } else {
                        return $row->value;
                    }
                })
                ->addColumn('address', function($row){
                    json_decode($row->value);
                    if (json_last_error() == JSON_ERROR_NONE){
                        $json = json_decode($row->value, true);

                        return $json['address'];
                    } else {
                        return $row->value;
                    }
                })
                ->addColumn('latitude', function($row){
                    json_decode($row->value);
                    if (json_last_error() == JSON_ERROR_NONE){
                        $json = json_decode($row->value, true);

                        return $json['latitude'];
                    } else {
                        return $row->value;
                    }
                })
                ->addColumn('longitude', function($row){
                    json_decode($row->value);
                    if (json_last_error() == JSON_ERROR_NONE){
                        $json = json_decode($row->value, true);

                        return $json['longitude'];
                    } else {
                        return $row->value;
                    }
                })
                ->addColumn('distance', function($row){
                    json_decode($row->value);
                    if (json_last_error() == JSON_ERROR_NONE){
                        $json = json_decode($row->value, true);

                        return $json['distance_from_nominal_point'] . "";
                    } else {
                        return $row->value;
                    }
                });

                if ($status == "jtss_schedule_site") {
                    $dt->addColumn('schedule', function($row){
                        json_decode($row->value);
                        if (json_last_error() == JSON_ERROR_NONE){
                            $json = json_decode($row->value, true);
    
                            // return date('M d, Y', strtotime($json['jtss_schedule']));
                            return $json['jtss_schedule'];
                        } else {
                            return $row->value;
                        }
                    })
                    ->addColumn('status', function($row) use ($sam_id) {
                        if (json_last_error() == JSON_ERROR_NONE){
                            $json = json_decode($row->value, true);
    
                            $datas = SubActivityValue::select('status')
                                                    ->where('type', 'jtss_ssds')
                                                    ->where('value->id', $json['id'])
                                                    ->first();

                            if (!is_null($datas)) {
                                if ($datas->status == 'pending') {
                                    return '<span class="badge badge-secondary">Pending</span>';
                                } else {
                                    return '<span class="badge badge-success">Done</span>';
                                }
                            } else {
                                return '<span class="badge badge-secondary">Pending</span>';
                            }
                        } else {
                            return $row->status;
                        }
                    });
                } else if ($status == "jtss_schedule_site_approved") {
                    $dt->addColumn('assds', function($row) {
                        if (json_last_error() == JSON_ERROR_NONE){
                            $json = json_decode($row->value, true);

                            // return $json['assds'];
                            if (isset($json['assds'])) {
                                if ($json['assds'] == 'no') {
                                    return '<span class="badge badge-secondary">No</span>';
                                } else {
                                    return '<span class="badge badge-success">Yes</span>';
                                }
                            } else {
                                return '<span class="badge badge-secondary">No</span>';
                            }
                        } else {
                            return $row->status;
                        }
                    })
                    ->addColumn('rank', function($row) {
                        if (json_last_error() == JSON_ERROR_NONE){
                            $json = json_decode($row->value, true);

                            // return $json['assds'];
                            if (isset($json['rank'])) {
                                return $json['rank'];
                            } else {
                                return $json['rank'];
                            }
                        } else {
                            return $json['rank'];
                        }
                    })
                    ->addColumn('assds', function($row) use ($sam_id) {
                        $datas = SubActivityValue::select('value')
                                                    ->where('sam_id', $sam_id)
                                                    ->where('type', 'jtss_approved')
                                                    ->where('value->hidden_id', $row->id)
                                                    ->first();

                        if (is_null($datas)){
                            return "no";
                        } else {
                            return "yes";
                        }
                    });
                } else if ($status == "jtss_approved") {
                    $dt->addColumn('assds', function($row) {
                        if (json_last_error() == JSON_ERROR_NONE){
                            $json = json_decode($row->value, true);

                            // return $json['assds'];
                            if (isset($json['assds'])) {
                                if ($json['assds'] == 'no') {
                                    return '<span class="badge badge-secondary">No</span>';
                                } else {
                                    return '<span class="badge badge-success">Yes</span>';
                                }
                            } else {
                                return '<span class="badge badge-secondary">No</span>';
                            }
                        } else {
                            return $row->status;
                        }
                    })
                    ->addColumn('rank', function($row) {
                        if (json_last_error() == JSON_ERROR_NONE){
                            $json = json_decode($row->value, true);

                            // return $json['assds'];
                            if (isset($json['rank'])) {
                                return $json['rank'];
                            } else {
                                return $json['rank'];
                            }
                        } else {
                            return $json['rank'];
                        }
                    });
                } else if ($status == "rejected_schedule") {
                    $dt->addColumn('schedule', function($row){
                        json_decode($row->value);
                        if (json_last_error() == JSON_ERROR_NONE){
                            $json = json_decode($row->value, true);
    
                            // return date('M d, Y', strtotime($json['jtss_schedule']));
                            return $json['jtss_schedule'];
                        } else {
                            return $row->value;
                        }
                    })
                    ->addColumn('reason', function($row){
                        return $row->reason;
                    })
                    ->addColumn('status', function($row){
                        return ucfirst($row->status);
                    })
                    ->addColumn('date_approved', function($row){
                        return date('M d, Y ', strtotime($row->date_approved)). ' at ' .date('h:m:a', strtotime($row->date_approved));
                    });
                } else if ($status == "jtss_ssds") {
                    $dt->addColumn('rank', function($row){
                        json_decode($row->value);
                        if (json_last_error() == JSON_ERROR_NONE){
                            $json = json_decode($row->value, true);
    
                            return isset($json['rank']) ? $json['rank'] : "Not yet ranked." ;
                        } else {
                            return $row->value;
                        }
                    })
                    ->addColumn('status', function($row){
                        if ($row->status == 'pending') {
                            return '<span class="badge badge-secondary">Pending</span>';
                        } else {
                            return '<span class="badge badge-success">Done</span>';
                        }
                    });
                } else if ($status == "pending") {
                    $dt->addColumn('status', function($row){
                        if ($row->status == 'pending') {
                            return '<span class="badge badge-secondary">Not Yet Scheduled</span>';
                        } else {
                            return '<span class="badge badge-success">Scheduled</span>';
                        }
                    });
                } else if ($status == "jtss_ssds_ranking") {
                    $dt->addColumn('rank', function($row){

                        $datas = SubActivityValue::select('value')
                                                    ->where('type', 'jtss_ranking')
                                                    ->where('value->hidden_id', $row->id)
                                                    ->first();
                        if (!is_null($datas)) {
                            $json = json_decode($datas->value, true);
                            return isset($json['rank']) ? $json['rank'] : 'No rank yet.';
                        } else {
                            return 'No rank yet.';
                        }                 
                    });
                }
                                
            $dt->rawColumns(['status', 'assds']);
            return $dt->make(true);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function set_schedule(Request $request)
    {
        try {

            $validate = Validator::make($request->all(), array(
                'jtss_schedule' => 'required',
            ));

            if (!$validate->passes()) {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            } else {
                if ($request->get('data_value') == 'all') {

                    $sub_activity_values = SubActivityValue::where('sam_id', $request->get('sam_id'))
                                                                ->where('type', 'jtss_add_site')
                                                                ->get();

                    foreach ($sub_activity_values as $sub_activity_value) {
                        $check_if_added = SubActivityValue::where('type', 'jtss_schedule_site')
                                                        ->where('value->id', $sub_activity_value->id)
                                                        ->first();

                        SubActivityValue::where('id', $sub_activity_value->id)
                            ->update([
                                'status' => 'Scheduled'
                            ]);

                        $new_json = json_decode($sub_activity_value->value, true);

                        $json = [
                            "id" => $sub_activity_value->id,
                            "jtss_schedule" => $request->get('jtss_schedule'),
                            "lessor" => $new_json['lessor'],
                            "contact_number" => $new_json['contact_number'],
                            "address" => $new_json['address'],
                            "region" => $new_json['region'],
                            "province" => $new_json['province'],
                            "lgu" => $new_json['lgu'],
                            "latitude" => $new_json['latitude'],
                            "longitude" => $new_json['longitude'],
                            "distance_from_nominal_point" => $new_json['distance_from_nominal_point'],
                            "site_type" => $new_json['site_type'],
                            "building_no_of_floors" => $new_json['building_no_of_floors'],
                            "area_size" => $new_json['area_size'],
                            "lease_rate" => $new_json['lease_rate'],
                            "property_use" => $new_json['property_use'],
                            "right_of_way_access" => $new_json['right_of_way_access'],
                            "certificate_of_title" => $new_json['certificate_of_title'],
                            "tax_declaration" => $new_json['tax_declaration'],
                            "tax_clearance" => $new_json['tax_clearance'],
                            "mortgaged" => $new_json['mortgaged'],
                            "tower_structure" => $new_json['tower_structure'],
                            "tower_height" => $new_json['tower_height'],
                            "swat_design" => $new_json['swat_design'],
                            "with_neighbors" => $new_json['with_neighbors'],
                            "with_history_of_opposition" => $new_json['with_history_of_opposition'],
                            "with_hoa_restriction" => $new_json['with_hoa_restriction'],
                            "with_brgy_restriction" => $new_json['with_brgy_restriction'],
                            "tap_to_lessor" => $new_json['tap_to_lessor'],
                            "tap_to_neighbor" => $new_json['tap_to_neighbor'],
                            "distance_to_tapping_point" => $new_json['distance_to_tapping_point'],
                            "meralco" => $new_json['meralco'],
                            "localcoop" => $new_json['localcoop'],
                            "genset_availability" => $new_json['genset_availability'],
                            "distance_to_nearby_transmission_line" => $new_json['distance_to_nearby_transmission_line'],
                            "distance_from_creek_river" => $new_json['distance_from_creek_river'],
                            "distance_from_national_road" => $new_json['distance_from_national_road'],
                            "demolition_of_existing_structure" => $new_json['demolition_of_existing_structure']
                        ];

                        // return response()->json(['error' => true, 'message' => is_null($check_if_added) ]);

                        if ( !is_null($check_if_added) ) {
                            SubActivityValue::where('type', 'jtss_schedule_site')
                                    ->where('value->id', $sub_activity_value->id)
                                    ->update([
                                        'type' => 'jtss_schedule_site',
                                        'sam_id' => $sub_activity_value->sam_id,
                                        'value' => json_encode($json),
                                        'status' => 'pending',
                                        'user_id' => \Auth::id()
                                    ]);
                        } else {
                            SubActivityValue::create([
                                'type' => 'jtss_schedule_site',
                                'sam_id' => $sub_activity_value->sam_id,
                                'value' => json_encode($json),
                                'status' => 'pending',
                                'user_id' => \Auth::id()
                            ]);
                        }
                    }

                    return response()->json(['error' => false, 'message' => 'Successfully updated a schedule' ]);

                    
                } else {
                    $sub_activity_value = SubActivityValue::where('id', $request->get('id'))->first();
    
                    SubActivityValue::where('id', $request->get('id'))
                                    ->update([
                                        'status' => 'Scheduled'
                                    ]);
    
                    $new_json = json_decode($sub_activity_value->value, true);
                    
                    $json = [
                        "id" => $sub_activity_value->id,
                        "jtss_schedule" => $request->get('jtss_schedule'),
                        "lessor" => $new_json['lessor'],
                        "contact_number" => $new_json['contact_number'],
                        "address" => $new_json['address'],
                        "region" => $new_json['region'],
                        "province" => $new_json['province'],
                        "lgu" => $new_json['lgu'],
                        "latitude" => $new_json['latitude'],
                        "longitude" => $new_json['longitude'],
                        "distance_from_nominal_point" => $new_json['distance_from_nominal_point'],
                        "site_type" => $new_json['site_type'],
                        "building_no_of_floors" => $new_json['building_no_of_floors'],
                        "area_size" => $new_json['area_size'],
                        "lease_rate" => $new_json['lease_rate'],
                        "property_use" => $new_json['property_use'],
                        "right_of_way_access" => $new_json['right_of_way_access'],
                        "certificate_of_title" => $new_json['certificate_of_title'],
                        "tax_declaration" => $new_json['tax_declaration'],
                        "tax_clearance" => $new_json['tax_clearance'],
                        "mortgaged" => $new_json['mortgaged'],
                        "tower_structure" => $new_json['tower_structure'],
                        "tower_height" => $new_json['tower_height'],
                        "swat_design" => $new_json['swat_design'],
                        "with_neighbors" => $new_json['with_neighbors'],
                        "with_history_of_opposition" => $new_json['with_history_of_opposition'],
                        "with_hoa_restriction" => $new_json['with_hoa_restriction'],
                        "with_brgy_restriction" => $new_json['with_brgy_restriction'],
                        "tap_to_lessor" => $new_json['tap_to_lessor'],
                        "tap_to_neighbor" => $new_json['tap_to_neighbor'],
                        "distance_to_tapping_point" => $new_json['distance_to_tapping_point'],
                        "meralco" => $new_json['meralco'],
                        "localcoop" => $new_json['localcoop'],
                        "genset_availability" => $new_json['genset_availability'],
                        "distance_to_nearby_transmission_line" => $new_json['distance_to_nearby_transmission_line'],
                        "distance_from_creek_river" => $new_json['distance_from_creek_river'],
                        "distance_from_national_road" => $new_json['distance_from_national_road'],
                        "demolition_of_existing_structure" => $new_json['demolition_of_existing_structure']
                    ];
    
                    $check_if_added = SubActivityValue::where('type', 'jtss_schedule_site')
                                                            ->where('value->id', $request->get('id'))
                                                            ->where('status', 'pending')
                                                            ->get();
            
                    if ( count($check_if_added) < 1 ) {
                        SubActivityValue::create([
                            'type' => 'jtss_schedule_site',
                            'sam_id' => $sub_activity_value->sam_id,
                            'value' => json_encode($json),
                            'status' => 'pending',
                            'user_id' => \Auth::id()
                        ]);
        
                        return response()->json(['error' => false, 'message' => 'Successfully added a schedule to ' .$new_json['lessor'] ]);
                    } else {
                        SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('value->id', $request->get('id'))
                                        ->update([
                                            'type' => 'jtss_schedule_site',
                                            'sam_id' => $sub_activity_value->sam_id,
                                            'value' => json_encode($json),
                                            'status' => 'pending',
                                            'user_id' => \Auth::id()
                                        ]);
    
                        return response()->json(['error' => false, 'message' => 'Successfully updated a schedule to ' .$new_json['lessor'] ]);
                    } 
                }                       
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_jtss_schedule($id)
    {
        try {
            $datas = SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('value->id', $id)
                                        ->where('status', 'pending')
                                        ->first();

            if ( is_null($datas) ) {
                $datas = SubActivityValue::where('id', $id)
                                            ->first();
            }

            return response()->json(['error' => false, 'message' => $datas]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_ssds_schedule($id)
    {
        try {
            $datas = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('value->id', $id)
                                        ->where('status', 'Done')
                                        ->first();
            
            if ( is_null($datas) ) {
                $datas = SubActivityValue::where('id', $id)
                                            ->first();

                $is_null = 'yes';
            } else {
                $is_null = 'no';
            }

            $json_new = json_decode($datas->value);

            $location_regions = \DB::connection('mysql2')
                                        ->table('location_regions')
                                        ->select('region_name')
                                        ->where('region_id', $json_new->region)
                                        ->first();

            $location_provinces = \DB::connection('mysql2')
                                        ->table('location_provinces')
                                        ->select('province_name')
                                        ->where('province_id', $json_new->province)
                                        ->first();

            $location_lgus = \DB::connection('mysql2')
                                        ->table('location_lgus')
                                        ->select('lgu_name')
                                        ->where('lgu_id', $json_new->lgu)
                                        ->first();

            return response()->json(['error' => false, 'message' => $datas, 'is_null' => $is_null, 'location_regions' => $location_regions, 'location_provinces' => $location_provinces, 'location_lgus' => $location_lgus]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }


    public function get_sub_activity_value($id)
    {
        try {
            $datas = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('value->id', $id)
                                        ->first();

            if ( is_null($datas) ) {
                $datas = SubActivityValue::where('id', $id)
                                            ->first();
            }

            return response()->json(['error' => false, 'message' => $datas]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }


    public function get_agent_activity_timeline()
    {
        try {

            $timeline = \DB::table('view_assigned_sites_with_timeline')
                    ->where('agent_id', \Auth::user()->id)
                    ->get();

            return response()->json(['error' => false, 'message' => $timeline]);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
        
    }

    public function submit_ssds (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                '*' => 'required',
            ));

            if ($validate->passes()) {
                $check_if_added = SubActivityValue::where('type', 'jtss_ssds')
                                                        ->where('sam_id', $request->get('sam_id'))
                                                        ->where('value->id', $request->get('id'))
                                                        ->where('status', 'pending')
                                                        ->first();

                if ( is_null($check_if_added) ) {
                    SubActivityValue::create([
                        'sam_id' => $request->get('sam_id'),
                        'sub_activity_id' => $request->get('sub_activity_id'),
                        'type' => 'jtss_ssds',
                        'status' => 'pending',
                        'user_id' => \Auth::id(),
                        'value' => json_encode($request->all())
                    ]);
                } else {
                    SubActivityValue::where('type', 'jtss_ssds')
                                    ->where('sam_id', $request->get('sam_id'))
                                    ->where('value->id', $request->get('id'))
                                    ->update([
                                        'value' => json_encode($request->all())
                                    ]);
                }

                SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('sam_id', $request->get('sam_id'))
                                        ->where('value->id', $request->get('id'))
                                        ->update([
                                            'status' => 'Done'
                                        ]);

                $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('sam_id', $request->get('sam_id'))
                                        ->get();

                $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('sam_id', $request->get('sam_id'))
                                        ->get();

                $is_match = count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match";

                return response()->json(['error' => false, 'message' => "Successfully submitted a ssds.", 'is_match' => $is_match ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function jtss_representative ($sam_id)
    {
        try {

            $datas = SubActivityValue::where('sam_id', $sam_id)
                                        ->where('type', 'jtss_representative')
                                        ->get();

            $dt = DataTables::of($datas)
                ->addColumn('name', function($row){
                    json_decode($row->value);
                    if (json_last_error() == JSON_ERROR_NONE){
                        $json = json_decode($row->value, true);

                        return $json['name'];
                    } else {
                        return $row->value;
                    }
                })
                ->addColumn('email', function($row){
                    json_decode($row->value);
                    if (json_last_error() == JSON_ERROR_NONE){
                        $json = json_decode($row->value, true);

                        return $json['email'];
                    } else {
                        return $row->value;
                    }
                })
                ->addColumn('designation', function($row){
                    json_decode($row->value);
                    if (json_last_error() == JSON_ERROR_NONE){
                        $json = json_decode($row->value, true);

                        return $json['designation'];
                    } else {
                        return $row->value;
                    }
                });
                                
            $dt->rawColumns(['status']);
            return $dt->make(true);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function add_representative (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'email' => [ 'required', 'email' ],
                'name' => 'required',
                'designation' => 'required'
            ));

            if ($validate->passes()) {
                $json = [
                    'email' => $request->get('email'),
                    'name' => $request->get('name'),
                    'designation' => $request->get('designation'),
                ];

                SubActivityValue::create([
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'type' => 'jtss_representative',
                    'value' => json_encode($json),
                    'user_id' => \Auth::id(),
                    'status' => 'pending'
                ]);
                
                return response()->json(['error' => false, 'message' => "Successfully added a new representative." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function done_adding_representative (Request $request)
    {
        try {
            $email_collect = collect();

            $datas = SubActivityValue::where('sam_id', $request->get('sam_id'))
                                        ->where('type', 'jtss_representative')
                                        ->get();

            $url = url('/');

            foreach ($datas as $data) {
                if (json_last_error() == JSON_ERROR_NONE){
                    $json = json_decode($data->value, true);

                    $email = $json['email'];
                    $name = $json['name'];
                } else {
                    $email = $data->value;
                    $name = $data->value;
                }

                Mail::to($email)->send(new RepresentativeInvitation( $request->get('site_name'), $name, $url ));
            }
            return response()->json(['error' => false, 'message' => "Successfully added representatives."]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function submit_ranking (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'rank' => 'required'
            ));

            if ($validate->passes()) {
                $datas = SubActivityValue::where('type', 'jtss_ranking')
                                        ->where('value->hidden_id', $request->get('hidden_id'))
                                        ->where('status', 'pending')
                                        ->first();
                                       
                if (is_null($datas)) {
                    SubActivityValue::create([
                        'sam_id' => $request->get('sam_id'),
                        'sub_activity_id' => $request->get('sub_activity_id'),
                        'type' => 'jtss_ranking',
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'status' => 'pending',
                    ]);
                } else {
                    $json = json_decode($datas->value, true);

                    if ($request->get('rank') == $json['rank']) {
                        return response()->json(['error' => true, 'message' => 'Please select other rank, rank ' .$request->get('rank'). ' is already exist.']);
                    } else {
                        SubActivityValue::where('id', $datas->id)
                                            ->update([
                                                'value' => json_encode($request->all())
                                            ]);

                        return response()->json(['error' => false, 'message' => "Successfully updated a rank for this site." ]);
                    }
                }
                
                return response()->json(['error' => false, 'message' => "Successfully ranked a site." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function submit_assds (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                // 'assds' => 'required'
            ));

            if ($validate->passes()) {
                $datas = SubActivityValue::where('type', 'jtss_approved')
                                        ->where('value->hidden_id', $request->get('hidden_id'))
                                        ->where('status', 'pending')
                                        ->first();

                if (is_null($datas)) {
                    SubActivityValue::create([
                        'sam_id' => $request->get('sam_id'),
                        'sub_activity_id' => $request->get('sub_activity_id'),
                        'type' => 'jtss_approved',
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'status' => 'pending',
                    ]);

                    return response()->json(['error' => false, 'message' => "ASSDS Configured" ]);
                } else {

                    if ($request->get('assds') == 'yes') {
                        SubActivityValue::where('id', $datas->id)
                                            ->update([
                                                'value' => json_encode($request->all()),
                                                'status' => 'pending'
                                            ]);
                    } else {
                        SubActivityValue::where('id', $datas->id)
                                            ->update([
                                                'value' => json_encode($request->all()),
                                                'status' => 'rejected'
                                            ]);
                    }


                    return response()->json(['error' => false, 'message' => "ASSDS Configured" ]);
                }
                
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_DAR_dashboard($program_id)
    {
        try {
            $data = \DB::connection('mysql2')
                        ->table('view_DAR_dashboard')->skip(0)->take(100)
                        ->where('program_id', $program_id)
                        ->orderBy('date_created', 'desc')
                        ->get();

            $dt = DataTables::of($data);
            return $dt->make(true);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function get_new_clp_site ($vendor_id)
    {
        try {
            // $sites = \DB::connection('mysql2')->select('call `get_fsaq`("'.$vendor_id.'")');

            $regions = \DB::connection('mysql2')
                            ->table('fsaq')
                            ->select('region_id')
                            ->where('vendor_id', $vendor_id)
                            ->distinct()
                            ->get()
                            ->pluck('region_id');

            $provinces = \DB::connection('mysql2')
                            ->table('fsaq')
                            ->select('province_id')
                            ->whereIn('region_id', $regions)
                            ->distinct()
                            ->get()
                            ->pluck('province_id');

            $lgus = \DB::connection('mysql2')
                            ->table('fsaq')
                            ->select('lgu_id')
                            ->whereIn('province_id', $provinces)
                            ->distinct()
                            ->get()
                            ->pluck('lgu_id');

            $sites = \DB::connection('mysql2')
                        ->table('view_site')
                        ->select('sam_id', 'site_name')
                        ->whereIn('lgu_id', $lgus)
                        ->where('vendor_id', $vendor_id)
                        ->where('program_id', 1)
                        ->where('activity_id', 2)
                        ->get();

            return response()->json(['error' => false, 'message' => $sites ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

}

