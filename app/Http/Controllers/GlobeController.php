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
use App\Models\ProgramMapping;

use Notification;
// use Pusher\Pusher;
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
use App\Notifications\SiteMoved;
use App\Notifications\AgentMoveSite;


class GlobeController extends Controller
{
    public function clean_table ()
    {
        return \DB::statement('call `clean_variables`()');
    }

    public function acceptRejectEndorsement(Request $request)
    {
        try {
            if(is_null($request->input('sam_id'))){
                return response()->json(['error' => true, 'message' => "No data selected."]);
            }

            // if ($request->input('activity_name') == "Vendor Awarding" || $request->input('activity_name') == "Set Ariba PR Number to Sites") {
                if ($request->input('activity_name') == "Vendor Awarding") {
                    $validate = Validator::make($request->all(), array(
                        'po_number' => 'required',
                        'po_date' => 'required',
                    ));

                    if (!$validate->passes()) {
                        return response()->json(['error' => true, 'message' => $validate->errors() ]);
                    } else {
                        \DB::table("site")
                            ->where("sam_id", $request->input("sam_id"))
                            ->update([
                                'site_po' => $request->input('po_number'),
                            ]);
                    }

                } else if ($request->input('activity_name') == "Set Ariba PR Number to Sites") {
                    $validate = Validator::make($request->all(), array(
                        'pr_number' => 'required',
                        'pr_date' => 'required',
                    ));
                    if (!$validate->passes()) {
                        return response()->json(['error' => true, 'message' => $validate->errors() ]);
                    }
                }
            // }

            $profile_id = \Auth::user()->profile_id;
            $id = \Auth::user()->id;

            $message = $request->input('data_complete') == 'false' ? 'rejected' : 'accepted';

            if ($request->input('activity_name') == "endorse_site") {

                $notification = "Successfully " .$message. " endorsement.";
                $action = $request->input('data_complete');
                $program_id = $request->input('data_program');
                $site_category = $request->input('site_category');
                $activity_id = is_null($request->input('activity_id')) ? [""] : $request->input('activity_id');

                // return response()->json(['error' => true, 'message' => $activity_id ]);

                $samid = $request->input('sam_id');

                if (\Auth::user()->profile_id == 12) {
                    for ($i=0; $i < count($samid); $i++) {
                        Site::where('sam_id', $samid[$i])->update([
                            'program_endorsement_date' => Carbon::now()
                        ]);
                    }
                }

            } else if ($request->input('activity_name') == "artb_declaration") {

                $notification = "Successfully tagged a site for ARTB.";
                $action = "true";
                $program_id = $request->input('program_id');
                $site_category = [$request->input('site_category')];
                $activity_id = [$request->input('activity_id')];

                $samid = [$request->input('sam_id')];

                $array_data = array(
                    'artb' => 'yes',
                    'artb_date' => Carbon::now()->toDateString()
                );

                SubActivityValue::create([
                    'sam_id' => $request->input('sam_id'),
                    'type' => 'artb_declaration',
                    'status' => 'pending',
                    'user_id' => \Auth::id(),
                    'value' => json_encode($array_data)
                ]);

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

            } else if ($request->input('activity_name') == "pac_approval" || $request->input('activity_name') == "pac_director_approval" || $request->input('activity_name') == "pac_vp_approval" || $request->input('activity_name') == "fac_approval" || $request->input('activity_name') == "fac_director_approval" || $request->input('activity_name') == "fac_vp_approval" || $request->input('activity_name') == "precon_docs_approval" || $request->input('activity_name') == "postcon_docs_approval" || $request->input('activity_name') == "approved_ssds_/_ntp_validation" || $request->input('activity_name') == "approved_moc/ntp_ram_validation" || $request->input('activity_name') == "approval_ms_lead" || $request->input('activity_name') == "approval_ibs_lead" || $request->input('activity_name') == "loi_&_ip_approval_ms_lead" || $request->input('activity_name') == "loi_&_ip_approval_ms_lead" || $request->input('activity_name') == "rt_docs_approval_ms_lead" || $request->input('activity_name') == "rt_docs_approval_ibs_lead" || $request->input('activity_name') == "precon_docs_approval_ms_lead" || $request->input('activity_name') == "precon_docs_approval_ibs_lead" || $request->input('activity_name') == "postcon_docs_approval_ms_lead" || $request->input('activity_name') == "postcon_docs_approval_ibs_lead" || $request->input('activity_name') == "lease_contract_approval" || $request->input('activity_name') == "reject_site") {
                
                $notification = "Site successfully " .$message;
                $action = $request->input('data_complete');
                $site_category = $request->input('site_category');
                $activity_id = $request->input('activity_id');
                $program_id = $request->input('program_id');

                $samid = $request->input('sam_id');

                // return response()->json(['error' => true, 'message' => $activity_id ]);
                if ( $request->input('data_complete') == 'false' ) {

                    $validate = Validator::make($request->all(), array(
                        'remarks' => 'required',
                    ));
                    
                    if (!$validate->passes()) {
                        return response()->json(['error' => true, 'message' => $validate->errors() ]);
                    } else {

                        $get_return_act = \DB::table('stage_activities')
                                        ->select('return_activity')
                                        ->where('program_id', $request->input('program_id'))
                                        ->where('activity_id', $request->input('activity_id')[0])
                                        ->where('category', $request->input('site_category')[0])
                                        ->first();

                        if ( is_null($get_return_act) ) {
                            SubActivityValue::whereIn('sam_id', $samid)
                                        ->where('type', 'doc_upload')
                                        ->where('status', 'approved')
                                        ->update([
                                            'status' => 'prev - approved',
                                            'approver_id' => \Auth::id(),
                                            'date_approved' => Carbon::now()->toDate(),
                                        ]);
                        } else {
                            $get_sub_act = \DB::table('sub_activity')
                                        ->select('sub_activity_id')
                                        ->where('program_id', $request->input('program_id'))
                                        ->where('activity_id', $get_return_act->return_activity)
                                        ->where('category', $request->input('site_category')[0])
                                        ->get()
                                        ->pluck('sub_activity_id');

                            if ( count($get_sub_act) < 1 ) {
                                SubActivityValue::whereIn('sam_id', $samid)
                                            ->where('type', 'doc_upload')
                                            ->where('status', 'approved')
                                            ->update([
                                                'status' => 'prev - approved',
                                                'approver_id' => \Auth::id(),
                                                'date_approved' => Carbon::now()->toDate(),
                                            ]);
                            } else {
                                SubActivityValue::whereIn('sam_id', $samid)
                                            ->where('type', 'doc_upload')
                                            ->where('status', 'approved')
                                            ->whereIn('sub_activity_id', $get_sub_act)
                                            ->update([
                                                'status' => 'prev - approved',
                                                'approver_id' => \Auth::id(),
                                                'date_approved' => Carbon::now()->toDate(),
                                            ]);
                            }
                        }
                        
                        SubActivityValue::create([
                            'sam_id' => $request->input("sam_id")[0],
                            'value' => json_encode($request->all()),
                            'user_id' => \Auth::id(),
                            'type' => $request->input("type"),
                            'status' => "denied",
                        ]);
                    }
                }

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

                        $activities = \DB::table('stage_activities')
                                ->select('return_activity')
                                ->where('activity_id', $activity_id[0])
                                ->where('program_id', $program_id)
                                ->where('category', $site_category[0])
                                ->first();

                        $sub_activities = \DB::table('sub_activity')
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

            } else if ($request->input('activity_name') == "award_to_vendor") {

                $notification = "Site successfully awarded to a vendor.";
                $action = $request->input('data_complete');
                $site_category = $request->input('site_category');
                $activity_id = $request->input('activity_id');
                $program_id = $request->input('program_id');
                $samid = $request->input('sam_id');
                $po_number = $request->input('po_number');
                $vendor = $request->input('vendor');

                $validate = Validator::make($request->all(), array(
                    'folder_url' => 'required',
                ));

                if (!$validate->passes()) {
                    return response()->json(['error' => true, 'message' => $validate->errors() ]);
                } else {

                    SubActivityValue::create([
                        'sam_id' => $samid[0],
                        'type' => 'folder_url',
                        'status' => 'pending',
                        'user_id' => \Auth::id(),
                        'value' => json_encode($request->all())
                    ]);

                    \DB::table('program_renewal')
                        ->where('sam_id', $request->input('sam_id'))
                        ->update([
                            'vendor' => $request->get('vendor_name')
                        ]);

                    Site::where('sam_id', $samid[0])
                            ->update([
                                'site_vendor_id' => $vendor,
                            ]);
                }

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

                    SubActivityValue::create([
                        'sam_id' => $site->sam_id,
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'type' => 'pr_po_details',
                        'status' => 'pending',
                        'date_approved' => \Carbon::now()->toDate(),
                    ]);
                    
                    if($request->input('program_id') == 1){

                        \DB::table("site")
                        ->where("sam_id", $site->sam_id)
                        ->update([
                            'site_pr' => $request->input('pr_number'),
                        ]);

                        $samid_collect->push($site->sam_id);
                        $activity_id_collect->push(5);
                        $sitecategory_collect->push("none");

                    } else {

                        \DB::table("site")
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

            } else if ($request->input('activity_name') == "hard_copy_site_management") {
                $notification = "Successfully approved site.";
                $vendor = $request->input('site_vendor_id');
                $action = $request->input('data_complete');
                $activity_id = $request->input('activity_id');
                $site_category = $request->input('site_category');

                $program_id = $request->input('program_id');
                $samid = $request->input('sam_id');

                
                $view = \View::make('components.renewal-hard-copy-site-management-pdf')
                        ->with([
                            'sam_id' => $samid[0]
                        ])
                        ->render();

                $pdf = \App::make('dompdf.wrapper');
                $pdf = PDF::loadHTML($view);
                $pdf->setPaper('folio', 'portrait');
                $pdf->download();

                \Storage::put( $samid[0].'-renewal-hard-copy-site-management-pdf.pdf', $pdf->output() );

                $array_data = [
                    'file' => $samid[0].'-renewal-hard-copy-site-management-pdf.pdf',
                    'active_profile' => '',
                    'active_status' => 'approved',
                    'validator' => 0,
                    // 'validators' => $approvers_collect->all(),
                    'type' => 'doc_upload'
                ];

                SubActivityValue::create([
                    'sam_id' => $samid[0],
                    'value' => json_encode($array_data),
                    'user_id' => \Auth::id(),
                    'type' => 'doc_upload',
                    'status' => 'approved',
                    'date_approved' => \Carbon::now()->toDate(),
                ]);

                
                // return response()->json(['error' => true, 'message' => $request->all()]);
            } else {
                $notification = "Successfully approved site.";
                $vendor = $request->input('site_vendor_id');
                $action = $request->input('data_complete');
                $activity_id = $request->input('activity_id');
                $site_category = $request->input('site_category');

                $program_id = $request->input('program_id');
                $samid = $request->input('sam_id');
            }

            $asd = $this->move_site($samid, $program_id, $action, $site_category, $activity_id, $request->input('remarks'));

            // return response()->json(['error' => true, 'message' => $asd]);
            return response()->json(['error' => false, 'message' => $notification ]);
        } catch (\Throwable  $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    private function move_site($sam_id, $program_id, $action, $site_category, $activity_id, $remarks = null)
    {
        for ($i=0; $i < count($sam_id); $i++) {

            $get_past_activities = \DB::table('site_stage_tracking')
                                    ->where('sam_id', $sam_id[$i])
                                    ->where('activity_complete', 'false')
                                    ->get();

            if (count($get_past_activities) < 1) {
                $site_check = \DB::table('site')
                                ->where('sam_id',  $sam_id[$i])
                                ->first();

                if ( is_null($site_check->activities) ) {
                    SiteStageTracking::create([
                        'sam_id' => $sam_id[$i],
                        'activity_id' => 1,
                        'activity_complete' => 'false',
                        'user_id' => \Auth::id()
                    ]);
                } else {
                    SiteStageTracking::create([
                        'sam_id' => $sam_id[$i],
                        'activity_id' => 1,
                        'activity_complete' => 'true',
                        'user_id' => \Auth::id()
                    ]);
                    
                    SiteStageTracking::create([
                        'sam_id' => $sam_id[$i],
                        'activity_id' => $activity_id[$i],
                        'activity_complete' => 'false',
                        'user_id' => \Auth::id()
                    ]);
                }

                $get_past_activities = \DB::table('site_stage_tracking')
                                    ->where('sam_id', $sam_id[$i])
                                    ->where('activity_complete', 'false')
                                    ->get();
                
            }

            $past_activities = collect();

            for ($j=0; $j < count($get_past_activities); $j++) {
                $past_activities->push($get_past_activities[$j]->activity_id);
            }

            if ( in_array($activity_id[$i] == null || $activity_id[$i] == "null" || $activity_id[$i] == "undefined" ? 1 : $activity_id[$i], $past_activities->all()) ) {
                $activities = \DB::table('stage_activities')
                                ->select('next_activity', 'activity_name', 'return_activity')
                                ->where('activity_id', $activity_id[$i] == null || $activity_id[$i] == "null" || $activity_id[$i] == "undefined" ? 1 : $activity_id[$i])
                                ->where('program_id', $program_id)
                                ->where('category', is_null($site_category[$i]) || $site_category[$i] == "null" ? "none" : $site_category[$i])
                                ->first();
                                     
                if (!is_null($activities)) {
                    if ($action == "true") {
                        $get_activitiess = \DB::table('stage_activities')
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

                        $check_if_added = \DB::table('site_stage_tracking')
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

                        $get_activitiess = \DB::table('stage_activities')
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

                    $get_stage_activity = \DB::table('stage_activities')
                                                ->select('stage_id')
                                                ->where('activity_id', $activity)
                                                ->where('program_id', $program_id)
                                                ->where('category', $site_category[0])
                                                ->first();

                    if (!is_null($get_stage_activity)) {
                        $get_program_stages = \DB::table('program_stages')
                                                ->select('stage_name')
                                                ->where('stage_id', $get_stage_activity->stage_id)
                                                ->where('program_id', $program_id)
                                                ->first();
                    } else {
                        $get_program_stages = NULL;
                    }

                    $array = array(
                        'stage_id' => !is_null($get_stage_activity) ? $get_stage_activity->stage_id : "",
                        'stage_name' => !is_null($get_program_stages) ? $get_program_stages->stage_name : "",
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

        $notification_settings = \DB::table('notification_settings')
                                    ->where('program_id', $program_id)
                                    ->where('activity_id', is_null($activity_id[0]) || $activity_id[0] == 'null' ? 1 : $activity_id[0])
                                    ->where('category', $site_category[0])
                                    ->where('action', $action_id)
                                    ->first();

        if (!is_null($notification_settings)) {

            $notification_receiver_profiles = \DB::table('notification_receiver_profiles')
                                            ->select('profile_id')
                                            ->where('notification_settings_id', $notification_settings->notification_settings_id)
                                            ->get()
                                            ->pluck('profile_id');

            $receiver_profiles = $notification_receiver_profiles;

            for ($i=0; $i < count($sam_id); $i++) {
                $site_data = \DB::table('site')
                                ->select('site_name', 'site_vendor_id')
                                ->where('sam_id', $sam_id[$i])
                                ->first();

                $site_users = \DB::table('site_users')
                                ->where('sam_id', $sam_id[$i])
                                ->first();

                if($site_count > 1){
                    $title = $notification_settings->title_multi;
                    $body = str_replace("<count>", $site_count, $notification_settings->body_multi);
                } else {
                    $title = $notification_settings->title_single;

                    if ( is_null($site_data) ) {
                        $site_name = $sam_id[$i];
                    } else {
                        $site_name = $site_data->site_name;
                    }

                    if ( $action == "true" ) {
                        $body = str_replace("<site>", $site_name, $notification_settings->body_single);
                    } else {
                        $body_rejected = str_replace("<site>", $site_name, $notification_settings->body_single);
                        $body = str_replace("<reason>", $remarks, $body_rejected);
                    }
                }

                for ($x=0; $x < count($receiver_profiles); $x++) { 

                    if ( $receiver_profiles[$x] == 2 ) {
    
                        if ( !is_null($site_users) ) {
                            $user_agent = User::find($site_users->agent_id);
                            if ( !is_null($user_agent) ) {
                                
                                $notifDataForAgent = [
                                    'user_id' => $site_users->agent_id,
                                    'program_id' => $program_id,
                                    'site_count' => $site_count,
                                    'action' => $action,
                                    'activity_id' => $activity_id,
                                    'title' => $title,	
                                    'body' => $body,
                                    'goUrl' => url($notification_settings->notification_url),
                                ];
                                Notification::send($user_agent, new SiteMoved($notifDataForAgent));
                            }
                        }
                    } else {
                        if ( $receiver_profiles[$x] == 1 || $receiver_profiles[$x] == 2 || $receiver_profiles[$x] == 3 || $receiver_profiles[$x] == 4 || $receiver_profiles[$x] == 5 ) {
                            $userSchema = User::select('users.*', 'user_details.vendor_id')
                                    ->join('user_programs', 'user_programs.user_id', 'users.id')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
    
                                    ->where("user_programs.program_id", $program_id)
    
                                    ->where("profile_id", $receiver_profiles[$x])
                                    ->where('user_details.vendor_id', $site_data->site_vendor_id)
                                    ->get();
                        } else {
                            $userSchema = User::select('users.*', 'user_details.vendor_id')
                                    ->join('user_programs', 'user_programs.user_id', 'users.id')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
    
                                    ->where("user_programs.program_id", $program_id)
    
                                    ->where("profile_id", $receiver_profiles[$x])
                                    ->where('user_programs.program_id', $program_id)
                                    ->get();
                        }
    
                        foreach($userSchema as $user){
                            $notifData = [
                                'user_id' => $user->id,
                                'program_id' => $program_id,
                                'site_count' => $site_count,
                                'action' => $action,
                                'activity_id' => $activity_id,
                                'title' => $title,	
                                'body' => $body,
                                'goUrl' => url($notification_settings->notification_url),
                            ];
                            
                            Notification::send($user, new SiteMoved($notifData));
                        }
                    }
                }

                $site_data = \DB::table('site')
                    ->select('site_name')
                    ->where('sam_id', $sam_id[$i])
                    ->first();

                if ( is_null($site_data) ) {
                    $site_name = $sam_id[$i];
                } else {
                    $site_name = $site_data->site_name;
                }

                if ( !is_null($site_users) ) {
                    $user_agent = User::find($site_users->agent_id);
                    if ( !is_null($user_agent) ) {

                        if ( $action == "true" ) {
                            $body_agent = "Your site has been moved to " . $activity_name;
                        } else {
                            $body_agent = "Your site has been rejected. Reason: ".$remarks;
                        }
                        
                        $notifDataForAgent = [
                            'user_id' => $site_users->agent_id,
                            'program_id' => $program_id,
                            'action' => $action,
                            'activity_id' => $activity_id,
                            'title' => "Site Update for " .$site_name,	
                            'body' => $body_agent,
                            'goUrl' => url('/program-sites'),
                        ];
                        Notification::send($user_agent, new AgentMoveSite($notifDataForAgent));
                    }
                }
            }
            // End of Loop
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
        return \DB::select('call `stage_activites`('.$program_id. ')');
    }

    public function unassignedSites($profile_id, $program_id, $activity_id, $what_to_load)
    {
        try {

            $vendor = \Auth::user()->getUserDetail()->first()->vendor_id;

            $stored_procs = \DB::select('call `a_pull_data`('.$vendor.', ' .  $program_id . ', ' .  $profile_id . ', "' . $activity_id .'", "' . $what_to_load .'", "' . \Auth::user()->id .'")');

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
            $checkAgent = \DB::table('site_users')
                            ->where('sam_id', $request->input('sam_id'))
                            ->where('agent_id', $request->input('agent_id'))
                            ->first();

            $profile_id = \Auth::user()->profile_id;
            $id = \Auth::user()->id;

            if(is_null($checkAgent)) {

                SiteAgent::create([
                    'agent_id' => $request->input('agent_id'),
                    'sam_id' => $request->input('sam_id'),
                ]);

                if ( 
                    ($request->input('data_program') == 3 && $profile_id == 1 && $request->input('activity_id') == 6) ||
                    ($request->input('data_program') == 3 && $profile_id == 3 && $request->input('activity_id') == 7)
                ) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                } else if ($request->input('data_program') == 4 && $profile_id == 3 && $request->input('activity_id') == 6) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                } else if ($request->input('data_program') == 8 && $profile_id == 3 && $request->input('activity_id') == 5) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                } else if ($request->input('data_program') == 2 && $profile_id == 3 && $request->input('activity_id') == 5) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                } else if ($request->input('data_program') == 1 && $profile_id == 3 && $request->input('activity_id') == 8) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                }

                return response()->json(['error' => false, 'message' => "Successfully assigned agent."]);
            } else {

                if ( 
                    ($request->input('data_program') == 3 && $profile_id == 1 && $request->input('activity_id') == 6) ||
                    ($request->input('data_program') == 3 && $profile_id == 3 && $request->input('activity_id') == 7)
                ) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                } else if ($request->input('data_program') == 4 && $profile_id == 3 && $request->input('activity_id') == 6) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                } else if ($request->input('data_program') == 8 && $profile_id == 3 && $request->input('activity_id') == 5) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                } else if ($request->input('data_program') == 2 && $profile_id == 3 && $request->input('activity_id') == 5) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                } else if ($request->input('data_program') == 1 && $profile_id == 3 && $request->input('activity_id') == 8) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                }

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
            $checkAgent = \DB::table('site_users')
                        ->where('sam_id', $request->input('sam_id'))
                        ->where('agent_id', $request->input('agent_id'))
                        ->first();

            $profile_id = \Auth::user()->profile_id;
            $id = \Auth::user()->id;

            if(is_null($checkAgent)) {

                if ($profile_id != 1) {
                    SiteAgent::create([
                        'agent_id' => $request->input('agent_id'),
                        'sam_id' => $request->input('sam_id'),
                    ]);
                }

                if ( 
                    ($request->input('data_program') == 3 && $profile_id == 1 && $request->input('activity_id') == 6) ||
                    ($request->input('data_program') == 3 && $profile_id == 3 && $request->input('activity_id') == 7)
                ) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                } else if ($request->input('data_program') == 4 && $profile_id == 3 && $request->input('activity_id') == 6) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                } else if ($request->input('data_program') == 8 && $profile_id == 3 && $request->input('activity_id') == 5) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                }

                return response()->json(['error' => false, 'message' => "Successfully assigned supervisor."]);
            } else {
                
                if ( 
                    ($request->input('data_program') == 3 && $profile_id == 1 && $request->input('activity_id') == 6) ||
                    ($request->input('data_program') == 3 && $profile_id == 3 && $request->input('activity_id') == 7)
                ) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                } else if ($request->input('data_program') == 4 && $profile_id == 3 && $request->input('activity_id') == 6) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                } else if ($request->input('data_program') == 8 && $profile_id == 3 && $request->input('activity_id') == 5) {
                    $this->move_site([$request->input('sam_id')], $request->input('data_program'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
                }
                
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
                $sites = \DB::table('site')
                            ->join('site_users', 'site_users.sam_id', 'site.sam_id')
                            ->where('program_id', "=", $program_id)
                            ->where('site_users.agent_id', "=", \Auth::user()->id)
                            ->get();
            } else {
                $sites = \DB::table('site')
                            ->join('site_users', 'site_users.sam_id', 'site.sam_id')
                            ->join('user_details', 'user_details.user_id', 'site_users.agent_id')
                            ->where('program_id', "=", $program_id)
                            ->where('IS_id', "=", \Auth::user()->id)
                            ->get();
            }
        } else {

            $sites = \DB::table('site')
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
        $sites = \Schema::getColumnListing('site');
        return $sites;
    }

    public function agents(Request $request)
    {

        try {
            // $checkAgent = \DB::table('users_areas')
            //                 ->select('users.id', 'users.firstname', 'users.lastname', 'users.email', 'users_areas.region', 'users_areas.province', 'user_details.image', 'location_sam_regions.sam_region_name')
            //                 ->join('users', 'users.id', 'users_areas.user_id')
            //                 ->join('user_details', 'user_details.user_id', 'users.id')
            //                 ->join('user_programs', 'user_programs.user_id', 'users.id')
            //                 ->join('location_sam_regions', 'location_sam_regions.sam_region_id', 'users_areas.region')
            //                 ->where('user_details.IS_id', \Auth::user()->id)
            //                 ->where('user_programs.program_id', $request->program_id)
            //                 ->where('users.is_test', 0)
            //                 ->get()
            //                 ->groupBy('users.id');

            $checkAgent = \DB::table('user_details')
                            ->select('users.id', 'users.firstname', 'users.lastname', 'users.email', 'user_details.image')
                            ->join('users', 'users.id', 'user_details.user_id')
                            ->join('user_programs', 'user_programs.user_id', 'users.id')
                            ->where('user_details.IS_id', \Auth::user()->id)
                            ->where('user_programs.program_id', $request->program_id)
                            ->where('users.is_test', 0)
                            ->get();

            $dt = DataTables::of($checkAgent)
                    ->addColumn('firstname', function($row){
                        return $row->firstname;
                    })
                    ->addColumn('lastname', function($row){
                        return $row->lastname;
                    })
                    ->addColumn('email', function($row){
                        return $row->email;
                    })
                    ->addColumn('photo', function($row){
                        if (is_null($row->image)) {
                            return '<img width="42" height="42" class="rounded-circle border border-dark" src="images/no-image.jpg" alt="">';
                        } else {
                            return '<img width="42" height="42" class="rounded-circle border border-dark" src="'.asset('files/'.$row->image).'" alt="">';
                        }
                    })
                    ->addColumn('areas', function($row){
                        $areas = \DB::table('users_areas')
                                ->select('location_sam_regions.sam_region_name')
                                ->join('location_sam_regions', 'location_sam_regions.sam_region_id', 'users_areas.region')
                                ->where('users_areas.user_id', $row->id)
                                ->get();

                        $collect_areas = collect();
                        foreach ($areas as $area) {
                            $collect_areas->push($area->sam_region_name);
                        }
                        return $collect_areas->all();
                    })
                    ->addColumn('action', function($row){
                        $btn = '<button class="btn btn-sm btn-primary btn-shadow update-data" data-value="'.$row->id.'" title="Update" type="button">Update</button>';

                        return $btn;
                    });;

            $dt->rawColumns(['photo', 'action']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function vendor_admin (Request $request)
    {
        try {
            // $vendor = Vendor::select('vendor_id')
            //                 ->where('vendor_admin_email', \Auth::user()->email)
            //                 ->first();

            $user_detail = \Auth::user()->getUserDetail()->first();

            if (!is_null($user_detail) && $user_detail->mode == 'vendor') {
                $vendor = is_null($user_detail) ? NULL : $user_detail->vendor_id;

                
                $checkAgent = \DB::table('users')
                                ->select('users.id', 'users.firstname', 'users.lastname', 'users.email', 'user_details.image')
                                ->join('user_details', 'user_details.user_id', 'users.id')
                                ->join('user_programs', 'user_programs.user_id', 'user_details.user_id')
                                // ->leftJoin('users_areas', 'users_areas.user_id', 'users.id')
                                ->where('users.profile_id', 1)
                                ->where('user_details.vendor_id', $vendor)
                                ->where('user_programs.program_id', $request->get('program_id'))
                                ->where('users.is_test', 0)
                                ->get();
            } else {
                $checkAgent = \DB::table('users')
                                ->select('users.id', 'users.firstname', 'users.lastname', 'users.email', 'user_details.image')
                                ->join('user_details', 'user_details.user_id', 'users.id')
                                ->join('user_programs', 'user_programs.user_id', 'user_details.user_id')
                                // ->leftJoin('users_areas', 'users_areas.user_id', 'users.id')
                                ->where('users.profile_id', 1)
                                ->where('user_programs.program_id', $request->get('program_id'))
                                ->get();
            }

            $dt = DataTables::of($checkAgent)
                    ->addColumn('photo', function($row){
                        if (is_null($row->image)) {
                            return '<img width="42" height="42" class="rounded-circle border border-dark" src="images/no-image.jpg" alt="">';
                        } else {
                            return '<img width="42" height="42" class="rounded-circle border border-dark" src="'.asset('files/'.$row->image).'" alt="">';
                        }
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
            $checkAgent = \DB::table('users')
                                    ->select('users.id', 'users.firstname', 'users.lastname', 'users.email', 'user_details.image')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
                                    ->join('user_programs', 'user_programs.user_id', 'user_details.user_id')
                                    ->leftJoin('users_areas', 'users_areas.user_id', 'users.id')
                                    ->where('user_details.IS_id', \Auth::user()->id)
                                    ->whereNull('users_areas.user_id')
                                    ->where('user_programs.program_id', $program_id)
                                    ->get();

            $dt = DataTables::of($checkAgent)
                    ->addColumn('photo', function($row){
                        if (is_null($row->image)) {
                            return '<img width="42" height="42" class="rounded-circle border border-dark" src="images/no-image.jpg" alt="">';
                        } else {
                            return '<img width="42" height="42" class="rounded-circle border border-dark" src="'.asset('files/'.$row->image).'" alt="">';
                        }
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

    public function vendor_agents(Request $request)
    {

        try {
            $get_user_program_active = \Auth::user()->get_user_program_active()->program_id;


            if (is_null($request->get('user_id'))) {

                $vendors = UserDetail::select('vendor_id')->where('user_id', \Auth::id())->first();

                $checkAgent = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                        ->join('user_programs', 'user_programs.user_id', 'users.id')
                                        ->where('user_details.vendor_id', $vendors->vendor_id)
                                        ->whereIn('users.profile_id', [2, 37, 38])
                                        ->where('user_programs.program_id', $get_user_program_active)
                                        ->where('users.is_test', 0)
                                        ->get();

                $dt = DataTables::of($checkAgent)
                                ->addColumn('profile', function($row){
                                    if (is_null($row->image)) {
                                        return '<img width="42" height="42" class="rounded-circle border border-dark" src="images/no-image.jpg" alt="">';
                                    } else {
                                        return '<img width="42" height="42" class="rounded-circle border border-dark" src="'.asset('files/'.$row->image).'" alt="">';
                                    }
                                })
                                ->addColumn('action', function($row){
                                    $btn = '<button class="btn btn-sm btn-primary btn-shadow update-data" data-value="'.$row->user_id.'" data-is_id="'.$row->IS_id.'" data-vendor_id="'.$row->vendor_id.'" title="Update">Edit</button> ';
                                    // $btn .= '<button class="btn btn-sm btn-shadow btn-danger disable_btn" data-name="'.$row->name.'" data-value="'.$row->user_id.'" data-is_id="'.$row->IS_id.'" data-vendor_id="'.$row->vendor_id.'" title="Disable">Disable</button> ';
                                    // $btn .= '<button class="btn btn-sm btn-shadow btn-secondary offboard_btn" data-name="'.$row->name.'" data-value="'.$row->user_id.'" data-is_id="'.$row->IS_id.'" data-vendor_id="'.$row->vendor_id.'" title="Disable">Offboard</button>';

                                    return $btn;
                                });
            } else {
                $vendors = UserDetail::select('vendor_id')->where('user_id', \Auth::id())->first();

                $checkAgent = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                        ->join('user_programs', 'user_programs.user_id', 'users.id')
                                        ->where('user_details.vendor_id', $vendors->vendor_id)
                                        ->where('users.profile_id', 2)
                                        ->where('user_details.IS_id', $request->get('user_id'))
                                        ->where('user_programs.program_id', $get_user_program_active)
                                        ->where('users.is_test', 0)
                                        ->get();

                $dt = DataTables::of($checkAgent)
                                    ->addColumn('profile', function($row){
                                        if (is_null($row->image)) {
                                            return '<img width="42" height="42" class="rounded-circle border border-dark" src="images/no-image.jpg" alt="">';
                                        } else {
                                            return '<img width="42" height="42" class="rounded-circle border border-dark" src="'.asset('files/'.$row->image).'" alt="">';
                                        }
                                    })
                                    ->addColumn('action', function($row){
                                        return '<button class="btn btn-sm btn-primary get_supervisor" data-user_id="'.$row->user_id.'" data-profile_id="'.$row->profile_id.'" data-is_id="'.$row->IS_id.'" data-name="'.$row->name.'" data-vendor_id="'.$row->vendor_id.'" title="Update"><i class="fa fa-edit"></i></button>';
                                    });
            }


            $dt->rawColumns(['action', 'profile']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function vendor_supervisors()
    {
        try {
            $vendor = \App\Models\UserDetail::select('user_details.vendor_id')
                                                            ->where('user_id', \Auth::id())
                                                            ->first();

            $get_user_program_active = \Auth::user()->get_user_program_active()->program_id;

            if (isset($vendor->vendor_id)) {
                $checkSupervisor = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                        ->join('user_programs', 'user_programs.user_id', 'users.id')
                                        // ->where('user_details.IS_id', \Auth::id())
                                        ->where('user_details.vendor_id', $vendor->vendor_id)
                                        ->where('users.profile_id', 3)
                                        ->where('user_programs.program_id', $get_user_program_active)
                                        ->where('users.is_test', 0)
                                        ->get();
            } else {
                $checkSupervisor = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                        // ->where('user_details.IS_id', \Auth::id())
                                        ->where('users.profile_id', 3)
                                        ->where('users.is_test', 0)
                                        ->get();
            }

            $dt = DataTables::of($checkSupervisor)
                                ->addColumn('number_agent', function($row){
                                    $agents = UserDetail::select('user_id')->where('IS_id', $row->user_id)->get();
                                    return count($agents);
                                })
                                ->addColumn('profile', function($row){
                                    if (is_null($row->image)) {
                                        return '<img width="42" height="42" class="rounded-circle border border-dark" src="images/no-image.jpg" alt="">';
                                    } else {
                                        return '<img width="42" height="42" class="rounded-circle border border-dark" src="'.asset('files/'.$row->image).'" alt="">';
                                    }
                                })
                                ->addColumn('action', function($row){
                                    
                                    $btn = '<button class="btn btn-sm btn-primary btn-shadow update-data-supervisor" data-value="'.$row->user_id.'" data-is_id="'.$row->IS_id.'" data-vendor_id="'.$row->vendor_id.'" title="Update">Edit</button> ';
                                    // $btn .= '<button class="btn btn-sm btn-shadow btn-danger disable_btn" data-name="'.$row->name.'" data-value="'.$row->user_id.'" data-is_id="'.$row->IS_id.'" data-vendor_id="'.$row->vendor_id.'" title="Disable">Disable</button> ';
                                    // $btn .= '<button class="btn btn-sm btn-shadow btn-secondary offboard_btn" data-name="'.$row->name.'" data-value="'.$row->user_id.'" data-is_id="'.$row->IS_id.'" data-vendor_id="'.$row->vendor_id.'" title="Disable">Offboard</button>';

                                    return $btn;
                                });

            $dt->rawColumns(['action', 'profile']);

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
                                    ->where('users.is_test', 0)
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
            $getAgentOfSupervisor = UserDetail::select('users.id', 'users.firstname', 'users.lastname', 'users.email', 'users_areas.lgu', 'users_areas.province', 'users_areas.region')
                                    ->join('users', 'user_details.user_id', 'users.id')
                                    ->leftJoin('users_areas', 'users_areas.user_id', 'users.id')
                                    ->where('user_details.IS_id', $user_id)
                                    ->where('users.is_test', 0)
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
            $is_location = \DB::table('user_details')
                                ->join('users_areas', 'users_areas.user_id', 'user_details.IS_id')
                                ->where('user_details.IS_id', \Auth::user()->id)
                                ->first();

            if(!is_null($is_location)){
                $region = \DB::table('location_regions')
                                ->where('region_name', $is_location->region)
                                ->get();
                
                if (count($region) < 1) {
                    $region = \DB::table('location_regions')
                                    ->get();
                }
            } else {
                $region = \DB::table('location_regions')
                                ->get();
            }
            return response()->json(['error' => false, 'message' => $region]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_sam_region()
    {
        try {
            $user_detail = \DB::table('user_details')
                                ->select('vendor_id')
                                ->where('user_id', \Auth::user()->id)
                                ->first();

                                
            $user_programs = \DB::table('user_programs')
                                ->select('program_id')
                                ->where('user_id', \Auth::user()->id)
                                ->get()
                                ->pluck('program_id');

            if( count($user_programs) > 0){
                $sites = \DB::table('view_site')
                            ->select('sam_region_id')
                            ->where('vendor_id', $user_detail->vendor_id)
                            ->whereIn('program_id', $user_programs)
                            ->get()
                            ->groupBy('sam_region_id');

                if( !is_null($sites) ){
                    $location_sam_regions = \DB::table('location_sam_regions')
                                ->whereIn('sam_region_id', $sites->keys())
                                ->get();

                    return response()->json(['error' => false, 'message' => $location_sam_regions]);
                } else {
                    return response()->json(['error' => true, 'message' => "No region found."]);
                }
            } else {
                return response()->json(['error' => true, 'message' => "No user program found."]);
            }
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
            $location = \DB::table($table)->where($location_type."_id", $location_id)->get();

            return response()->json(['error' => false, 'message' => $location]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function assign_agent_site(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'region' => 'required',
                // 'province' => 'required'
            ));

            if (!$validate->passes()) {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            } else {

                for ($i=0; $i < count($request->get('region')); $i++) {
                    $user_check = UsersArea::where('user_id', $request->get('user_id'))
                                    ->where('region', $request->get('region')[$i])
                                    ->first();

                    if ( is_null($user_check) ) {
                        UsersArea::create([
                            'user_id' => $request->input('user_id'),
                            'region' => $request->get('region')[$i],
                            'province' => '%',
                            'lgu' => '%',
                        ]);
                    }
                }
                return response()->json(['error' => false, 'message' => "Successfully assigned agent site."]);
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
            // return response()->json(['error' => true, 'message' => $request->all() ]);

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

                $stage_activities = \DB::table('stage_activities')
                                ->select('id', 'activity_type')
                                ->where('program_id', $request->input('program_id'))
                                ->where('activity_id', $request->input('activity_id'))
                                ->where('category', $request->input("site_category"))
                                ->first();       

                if ($stage_activities->activity_type == 'doc upload') {

                    $stage_activities_approvers = \DB::table('stage_activities_approvers')
                                ->select('approver_profile_id')
                                ->where('stage_activities_id', $stage_activities->id)
                                ->orderBy('approver_stage', 'asc')
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
                        'validators' => $approvers_collect->all(),
                        'type' => 'doc_upload'
                    ];

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($array_data),
                        'user_id' => \Auth::id(),
                        'type' => 'doc_upload',
                        'status' => $file_status,
                        'date_approved' => $file_status == 'approved' ? \Carbon::now()->toDate() : NULL,
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
                        'date_approved' => $file_status == 'approved' ? \Carbon::now()->toDate() : NULL,
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

                $this->dar_check($request->input("sam_id"), $request->input("sub_activity_id"));

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

            // $validate = Validator::make($request->all(), array(
            //     '*' => 'required'
            // ));

            if ($validate->passes()) {

                // if (!is_null($request->input("file"))) {
                //     $file = collect();
                //     for ($i=0; $i < count($request->input("file")); $i++) {
                //         $new_file = $this->rename_file($request->input("file")[$i], $request->input("sub_activity_name"), $request->input("sam_id"));

                //         \Storage::move( $request->input("file")[$i], $new_file );

                //         $file->push($new_file);
                //     }
                // }

                // $json = array(
                //     'lessor' => $request->input('lessor'),
                //     'contact_number' => $request->input('contact_number'),
                //     'address' => $request->input('address'),
                //     'region' => $request->input('region'),
                //     'province' => $request->input('province'),
                //     'lgu' => $request->input('lgu'),
                //     'latitude' => $request->input('latitude'),
                //     'longitude' => $request->input('longitude'),
                //     'distance_from_nominal_point' => $request->input('distance_from_nominal_point'),
                //     'site_type' => $request->input('site_type'),
                //     'building_no_of_floors' => $request->input('building_no_of_floors'),
                //     'area_size' => $request->input('area_size'),
                //     'lease_rate' => $request->input('lease_rate'),
                //     'property_use' => $request->input('property_use'),
                //     'right_of_way_access' => $request->input('right_of_way_access'),
                //     'certificate_of_title' => $request->input('certificate_of_title'),
                //     'tax_declaration' => $request->input('tax_declaration'),
                //     'tax_clearance' => $request->input('tax_clearance'),
                //     'mortgaged' => $request->input('mortgaged'),
                //     'tower_structure' => $request->input('tower_structure'),
                //     'tower_height' => $request->input('tower_height'),
                //     'swat_design' => $request->input('swat_design'),
                //     'with_neighbors' => $request->input('with_neighbors'),
                //     'with_history_of_opposition' => $request->input('with_history_of_opposition'),
                //     'with_hoa_restriction' => $request->input('with_hoa_restriction'),
                //     'with_brgy_restriction' => $request->input('with_brgy_restriction'),
                //     'tap_to_lessor' => $request->input('tap_to_lessor'),
                //     'tap_to_neighbor' => $request->input('tap_to_neighbor'),
                //     'distance_to_tapping_point' => $request->input('distance_to_tapping_point'),
                //     'meralco' => $request->input('meralco'),
                //     'localcoop' => $request->input('localcoop'),
                //     'genset_availability' => $request->input('genset_availability'),
                //     'distance_to_nearby_transmission_line' => $request->input('distance_to_nearby_transmission_line'),
                //     'distance_from_creek_river' => $request->input('distance_from_creek_river'),
                //     'distance_from_national_road' => $request->input('distance_from_national_road'),
                //     'demolition_of_existing_structure' => $request->input('demolition_of_existing_structure'),

                // );

                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'type' => $request->input("type"),
                    'sub_activity_id' => $request->input("sub_activity_id"),
                    'value' => json_encode($request->all()),
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

                    \DB::table("site")
                            ->where("sam_id", $request->input("sam_id"))
                            ->update([
                                'site_vendor_id' => $request->input('vendor'),
                                'site_pr' => $request->input('reference_number'),
                            ]);

                    // a_update_data(SAM_ID, PROFILE_ID, USER_ID, true/false)
                    $new_endorsements = \DB::statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "'."true".'")');

                    return response()->json(['error' => false, 'message' => "Successfully created a PR."]);
                } else {

                    $new_endorsements = \DB::statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "'."true".'")');

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

    //                 $new_endorsements = \DB::statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');

    //                 return response()->json(['error' => false, 'message' => $message_info ]);
    //             } else {

    //                 $new_endorsements = \DB::statement('call `a_update_data`("'.$request->input('sam_id').'", '.\Auth::user()->profile_id.', '.\Auth::id().', "true")');

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

        $cols = \DB::table("table_fields")
                    ->where('program_id', $program_id)
                    ->where('table_name', $table_name)
                    ->orderBy('field_sort', 'asc')
                    ->get();

                    
                    

        return $cols;

    }

    public function get_doc_validations($program_id)
    {
        $sites = \DB::table("view_doc_validation")
                    ->get();

        $dt = DataTables::of($sites);
        return $dt->make(true);

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

                $validators_type = json_decode($sub_activity_files->value)->type;
                $validators = json_decode($sub_activity_files->value)->validators;
                $file = json_decode($sub_activity_files->value)->file;

                $approvers_collect = collect();
                $approvers_pending_collect = collect();

                foreach ($validators as $validator) {
                    if ( $request->input('action') == "rejected" ) {
                        $new_array = array(
                            'profile_id' => $validator->profile_id,
                            'status' => $request->get('action'),
                            'user_id' => \Auth::id(),
                            'approved_date' => Carbon::now()->toDateString(),
                        );

                        $approvers_collect->push($new_array);
                    } else {
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
                }
                
                if ( $request->get('action') == "rejected" ) {
                    $active_file_status = "rejected";
                } else {
                    $active_file_status = count($approvers_pending_collect->all()) < 1 ? "approved" : "pending";
                }

                $array_data = [
                    'file' => $file,
                    'active_profile' => isset($approvers_pending_collect->all()[0]) ? $approvers_pending_collect->all()[0] : "",
                    // 'active_status' => count($approvers_pending_collect->all()) < 1 ? "approved" : "pending",
                    'active_status' => $active_file_status,
                    'validator' => count($approvers_pending_collect->all()),
                    'validators' => $approvers_collect->all(),
                    'type' => $validators_type
                ];

                $site_users = \DB::table('site_users')
                                ->where('sam_id', $request->input('sam_id'))
                                ->first();
            
                if ( !is_null($site_users) ) {
                    $user_agent = User::find($site_users->agent_id);
                    if ( !is_null($user_agent) ) {
                        if ( $request->get('action') == "rejected" ) {
                            $body_message = "Your uploaded file (" .$request->input('filename'). ") has been rejected by ".\Auth::user()->name. ". Reason: ".$request->input('reason');
                        } else {
                            $body_message = "Your uploaded file (" .$request->input('filename'). ") has been approved by ".\Auth::user()->name. ".";
                        }

                        $site_data = \DB::table('site')
                                ->select('site_name', 'site_vendor_id')
                                ->where('sam_id', $request->input('sam_id'))
                                ->first();

                        $title_name = !is_null($site_data) ? $site_data->site_name : $request->input('sam_id');
                        
                        $notifDataForAgent = [
                            'user_id' => $site_users->agent_id,
                            'action' => $request->get('action'),
                            'title' => "Site Update for " .$title_name,	
                            'body' => $body_message,
                            'goUrl' => url('/activities'),
                        ];
                        Notification::send($user_agent, new AgentMoveSite($notifDataForAgent));
                    }
                }

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

                            if ($validators_type != 'doc_upload') {
                                SubActivityValue::where('sam_id', $request->input('sam_id'))
                                        ->where('type', $validators_type)
                                        ->update([
                                            'reason' => $request->input('action') == "rejected" ? $request->input('reason') : null,
                                            'status' => $current_status,
                                        ]);
                            }
                        } else {
                            $current_status = $sub_activity_files->status;

                            SubActivityValue::where('id', $request->input('id'))
                                    ->update([
                                        'reason' => $request->input('action') == "rejected" ? $request->input('reason') : null,
                                    ]);

                            if ($validators_type != 'doc_upload') {
                                SubActivityValue::where('sam_id', $request->input('sam_id'))
                                        ->where('type', $validators_type)
                                        ->update([
                                            'reason' => $request->input('action') == "rejected" ? $request->input('reason') : null,
                                            'status' => $current_status,
                                        ]);
                            }
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

                    SubActivityValue::where('sam_id', $request->input('sam_id'))
                                ->where('type', $validators_type)
                                ->where('id', $request->input('id'))
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
        $sites = \DB::table("milestone_tracking_2")
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
        $user_area = \DB::table('users_areas')
                                ->select('region')
                                ->where('user_id', \Auth::id())
                                ->get()
                                ->pluck('region');

        $user_detail = \Auth::user()->getUserDetail()->first();

        if($activity_type == 'all'){

            $sites = \DB::table("view_site")
                            ->where('program_id', $program_id);

            if (!is_null($user_detail) && $user_detail->mode == 'vendor') {
                $vendor = is_null($user_detail) ? NULL : $user_detail->vendor_id;

                $sites->where('view_site.vendor_id', $vendor);
            }

            if($program_id == 3){                
                $sites->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id')
                    ->select(
                        "view_site.vendor_acronym", 
                        "view_site.site_name", 
                        "view_site.sam_id", 
                        "view_site.activity_id", 
                        "view_site.program_id", 
                        "view_site.site_category", 
                        "view_site.activity_name", 
                        "view_site.sam_region_name",
                        "view_site.aging",
                        "view_site.site_address",
                        "view_site.program_endorsement_date",
                        "view_site.profile",
                        "program_coloc.nomination_id", 
                        "program_coloc.pla_id", 
                        "program_coloc.highlevel_tech",  
                        "program_coloc.technology", 
                        "program_coloc.site_type",
                        "program_coloc.address",  
                        "program_coloc.vendor",  
                        "program_coloc.region",  
                        "program_coloc.gt_saq_milestone",  
                        "program_coloc.gt_saq_milestone_category"
                    );
            }
            elseif($program_id == 4){
                $sites->leftJoin('program_ibs', 'view_site.sam_id', 'program_ibs.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_ibs.vendor_tw_build",
                            "program_ibs.address",
                            "program_ibs.region",
                            "program_ibs.pla_id",
                            "program_ibs.wireless_project_code",
                            "program_ibs.wireless_solution",
                            "program_ibs.saq_milestone",
                            "program_ibs.sub_saq_milestone",
                        );
            }
            elseif($program_id == 8){
                $sites->leftJoin('program_renewal', 'view_site.sam_id', 'program_renewal.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.profile",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.aging",
                    "program_renewal.*"
                );
            }
            elseif($program_id == 2){
                $sites->leftJoin('program_ftth', 'view_site.sam_id', 'program_ftth.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.profile",
                    "program_ftth.cluster_id",
                    "program_ftth.sam_milestone",
                    "program_ftth.submilestone",
                    "program_ftth.afi_lines",
                    "program_ftth.odn_vendor",
                    "program_ftth.region"
                );
            }
            elseif($program_id == 1){
                $sites->leftJoin('program_newsites', 'view_site.sam_id', 'program_newsites.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.aging",
                    "view_site.profile",
                    "program_newsites.saq_milestone",
                    "program_newsites.serial_number",
                    "program_newsites.saq_bucket",
                    "program_newsites.region",
                );
            }

            if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                $sites->whereIn('view_site.sam_region_id', $user_area);
            }
            
            $sites->get();
        }

        elseif($activity_type == 'mine'){

            // $sites = \DB::table("view_assigned_sites")
            //         ->where('program_id', $program_id)
            //         ->where('agent_id', \Auth::id());

            $sites = \DB::table("view_site")
                        ->leftjoin('site_users', 'site_users.sam_id', 'view_site.sam_id')
                        ->where('view_site.activity_type', '!=', 'complete');

            if (\Auth::user()->profile_id == 2) {
                $sites->where('site_users.agent_id', \Auth::id());
            } else if (\Auth::user()->profile_id == 3) {
                // all agent
            }

            if($program_id == 3){                
                $sites->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_coloc.nomination_id", 
                            "program_coloc.pla_id", 
                            "program_coloc.highlevel_tech",  
                            "program_coloc.technology", 
                            "program_coloc.site_type",
                            "program_coloc.address",  
                            "program_coloc.vendor",  
                            "program_coloc.region",  
                            "program_coloc.gt_saq_milestone",  
                            "program_coloc.gt_saq_milestone_category"
                        );
            }
            elseif($program_id == 4){
                $sites->leftJoin('program_ibs', 'view_site.sam_id', 'program_ibs.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.profile",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "program_ibs.vendor_tw_build",
                            "program_ibs.address",
                            "program_ibs.region",
                            "program_ibs.pla_id",
                            "program_ibs.wireless_project_code",
                            "program_ibs.wireless_solution",
                            "program_ibs.saq_milestone",
                            "program_ibs.sub_saq_milestone",
                        );
            }
            elseif($program_id == 8){
                $sites->leftJoin('program_renewal', 'view_site.sam_id', 'program_renewal.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.profile",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "program_renewal.*"
                );
            }
            elseif($program_id == 2){
                $sites->leftJoin('program_ftth', 'view_site.sam_id', 'program_ftth.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.profile",
                    "program_ftth.cluster_id",
                    "program_ftth.sam_milestone",
                    "program_ftth.submilestone",
                    "program_ftth.afi_lines",
                    "program_ftth.odn_vendor",
                    "program_ftth.region"
                );
            }
            elseif($program_id == 1){
                $sites->leftJoin('program_newsites', 'view_site.sam_id', 'program_newsites.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.site_address",
                    "view_site.profile",
                    "view_site.program_endorsement_date",
                    "program_newsites.saq_milestone",
                    "program_newsites.serial_number",
                    "program_newsites.saq_bucket",
                    "program_newsites.region",
                );
            }

            if (!is_null($user_detail) && $user_detail->mode == 'vendor') {
                $vendor = is_null($user_detail) ? NULL : $user_detail->vendor_id;

                $sites->where('view_site.vendor_id', $vendor);
            }

            if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                // $sites->whereIn('view_assigned_sites.sam_region_name', $user_area);
                $sites->whereIn('view_site.sam_region_id', $user_area);
            }

            $sites->get();


        }

        elseif($activity_type == 'mine_completed'){

            $sites = \DB::table("view_site")
                        ->leftjoin('site_users', 'site_users.sam_id', 'view_site.sam_id')
                        ->where('view_site.program_id', $program_id)
                        ->where('view_site.activity_type', 'complete');

            if (\Auth::user()->profile_id == 2) {
                $sites->where('site_users.agent_id', \Auth::id());
            }  else if (\Auth::user()->profile_id == 3) {
                // all agent
            }

            if($program_id == 3){                
                $sites->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_coloc.nomination_id", 
                            "program_coloc.pla_id", 
                            "program_coloc.highlevel_tech",  
                            "program_coloc.technology", 
                            "program_coloc.site_type",
                            "program_coloc.address",  
                            "program_coloc.vendor",  
                            "program_coloc.region",  
                            "program_coloc.gt_saq_milestone",  
                            "program_coloc.gt_saq_milestone_category"
                        );
            }
            elseif($program_id == 4){
                $sites->leftJoin('program_ibs', 'view_site.sam_id', 'program_ibs.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_ibs.vendor_tw_build",
                            "program_ibs.address",
                            "program_ibs.region",
                            "program_ibs.pla_id",
                            "program_ibs.wireless_project_code",
                            "program_ibs.wireless_solution",
                            "program_ibs.saq_milestone",
                            "program_ibs.sub_saq_milestone",
                        );
            }
            elseif($program_id == 8){
                $sites->leftJoin('program_renewal', 'view_site.sam_id', 'program_renewal.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.profile",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "program_renewal.*"
                );
            }
            elseif($program_id == 2){
                $sites->leftJoin('program_ftth', 'view_site.sam_id', 'program_ftth.sam_id')
                ->select(
                    "view_site.site_name", 
                    "view_site.vendor_acronym", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_type", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name", 
                    "view_site.region_name", 
                    "view_site.province_name", 
                    "view_site.lgu_name",
                    "view_site.aging",
                    "view_site.profile",
                    "view_site.site_address",
                    "program_ftth.cluster_id",
                    "program_ftth.sam_milestone",
                    "program_ftth.submilestone",
                    "program_ftth.afi_lines",
                    "program_ftth.odn_vendor",
                    "program_ftth.region"
                );
            }
            elseif($program_id == 1){
                $sites->leftJoin('program_newsites', 'view_site.sam_id', 'program_newsites.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.profile",
                    "program_newsites.saq_milestone",
                    "program_newsites.serial_number",
                    "program_newsites.saq_bucket",
                    "program_newsites.region",
                );
            }

            if (!is_null($user_detail) && $user_detail->mode == 'vendor') {
                $vendor = is_null($user_detail) ? NULL : $user_detail->vendor_id;

                $sites->where('view_site.vendor_id', $vendor);
            }

            if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                $sites->whereIn('view_site.sam_region_id', $user_area);
            }

            $sites->get();

        }

        elseif($activity_type == 'is'){

            $sites = \DB::table("view_vendor_assigned_sites")
                        ->where('program_id', $program_id)
                        ->where('IS_id', \Auth::user()->id);

            if (!is_null($user_detail) && $user_detail->mode == 'vendor') {
                $vendor = is_null($user_detail) ? NULL : $user_detail->vendor_id;
                $sites->where('view_vendor_assigned_sites.vendor_id', $vendor);
            }

            if($program_id == 3){                
                $sites->leftJoin('program_coloc', 'view_vendor_assigned_sites.sam_id', 'program_coloc.sam_id')
                        ->select(
                            "view_vendor_assigned_sites.sam_id",
                            "view_vendor_assigned_sites.activity_name",
                            "view_vendor_assigned_sites.site_name",
                            "view_vendor_assigned_sites.aging",
                            "view_vendor_assigned_sites.site_category",
                            "view_vendor_assigned_sites.site_address",
                            "program_coloc.nomination_id", 
                            "program_coloc.pla_id", 
                            "program_coloc.highlevel_tech",  
                            "program_coloc.technology", 
                            "program_coloc.site_type",
                            "program_coloc.address",  
                            "program_coloc.vendor",  
                            "program_coloc.region",  
                            "program_coloc.gt_saq_milestone",  
                            "program_coloc.gt_saq_milestone_category"
                        );
            }
            elseif($program_id == 4){
                $sites->leftJoin('program_ibs', 'view_vendor_assigned_sites.sam_id', 'program_ibs.sam_id')
                        ->select(
                            "view_vendor_assigned_sites.sam_id",
                            "view_vendor_assigned_sites.activity_name",
                            "view_vendor_assigned_sites.site_name",
                            "view_vendor_assigned_sites.aging",
                            "view_vendor_assigned_sites.site_category",
                            "view_vendor_assigned_sites.site_address",
                            "program_ibs.vendor_tw_build",
                            "program_ibs.address",
                            "program_ibs.region",
                            "program_ibs.pla_id",
                            "program_ibs.wireless_project_code",
                            "program_ibs.wireless_solution",
                            "program_ibs.saq_milestone",
                            "program_ibs.sub_saq_milestone",
                        );
            }
            elseif($program_id == 8){
                $sites->leftJoin('program_renewal', 'view_vendor_assigned_sites.sam_id', 'program_renewal.sam_id')
                ->select(
                    "view_vendor_assigned_sites.sam_id",
                    "view_vendor_assigned_sites.activity_name",
                    "view_vendor_assigned_sites.site_name",
                    "view_vendor_assigned_sites.aging",
                    "view_vendor_assigned_sites.site_category",
                    "view_vendor_assigned_sites.site_address",
                    "program_renewal.*"
                );
            }
            elseif($program_id == 2){
                $sites->leftJoin('program_ftth', 'view_vendor_assigned_sites.sam_id', 'program_ftth.sam_id')
                ->select(
                    "view_vendor_assigned_sites.sam_id",
                    "view_vendor_assigned_sites.activity_name",
                    "view_vendor_assigned_sites.site_name",
                    "view_vendor_assigned_sites.aging",
                    "view_vendor_assigned_sites.site_category",
                    "view_vendor_assigned_sites.site_address",
                    "program_ftth.cluster_id",
                    "program_ftth.sam_milestone",
                    "program_ftth.submilestone",
                    "program_ftth.afi_lines",
                    "program_ftth.odn_vendor",
                    "program_ftth.region"
                );
            }
            elseif($program_id == 1){
                $sites->leftJoin('program_newsites', 'view_vendor_assigned_sites.sam_id', 'program_newsites.sam_id')
                ->select(
                    "view_vendor_assigned_sites.sam_id",
                    "view_vendor_assigned_sites.activity_name",
                    "view_vendor_assigned_sites.site_name",
                    "view_vendor_assigned_sites.aging",
                    "view_vendor_assigned_sites.site_category",
                    "view_vendor_assigned_sites.site_address",
                    "program_newsites.saq_milestone",
                    "program_newsites.serial_number",
                    "program_newsites.saq_bucket",
                    "program_newsites.region",
                );
            }

            if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                // $sites->whereIn('view_vendor_assigned_sites.sam_region_name', $user_area);
                $sites->whereIn('view_vendor_assigned_sites.sam_region_id', $user_area);
            }

            $sites->get();

        }

        elseif($activity_type == 'vendor'){

            $sites = \DB::table("milestone_tracking_2")
            ->distinct()
            ->where('program_id', $program_id)
            ->where('activity_complete', 'false')
            ->where("profile_id", "2")
            ->get();

        }

        elseif($activity_type == 'set site value'){

            $sites = \DB::table("milestone_tracking_2")
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_type', 'set site value')
                    ->where('profile_id', \Auth::user()->profile_id)
                    ->where('activity_complete', 'false')
                    ->get();

        }

        elseif($activity_type == 'rtb declaration'){

            $sites = \DB::table("view_site")
                            ->whereIn('view_site.activity_type', ['rtb declaration'])
                            ->where('view_site.program_id', $program_id)
                            ->where('view_site.profile_id', \Auth::user()->profile_id);

            if($program_id == 3){                
                $sites->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_coloc.nomination_id", 
                            "program_coloc.pla_id", 
                            "program_coloc.highlevel_tech",  
                            "program_coloc.technology", 
                            "program_coloc.site_type",
                            "program_coloc.address",  
                            "program_coloc.vendor",  
                            "program_coloc.region",  
                            "program_coloc.gt_saq_milestone",  
                            "program_coloc.gt_saq_milestone_category"
                        );
            }
            elseif($program_id == 4){
                $sites->leftJoin('program_ibs', 'view_site.sam_id', 'program_ibs.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.profile",
                    "program_ibs.vendor_tw_build",
                    "program_ibs.address",
                    "program_ibs.region",
                    "program_ibs.pla_id",
                    "program_ibs.wireless_project_code",
                    "program_ibs.wireless_solution",
                    "program_ibs.saq_milestone",
                    "program_ibs.sub_saq_milestone",
                );
            }
            elseif($program_id == 8){
                $sites->leftJoin('program_renewal', 'view_site.sam_id', 'program_renewal.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.profile",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "program_renewal.*"
                );
            }
            elseif($program_id == 2){
                $sites->leftJoin('program_ftth', 'view_site.sam_id', 'program_ftth.sam_id')
                ->select(
                    "view_site.site_name", 
                    "view_site.vendor_acronym", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_type", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name", 
                    "view_site.region_name", 
                    "view_site.province_name", 
                    "view_site.lgu_name", 
                    "view_site.aging",
                    "view_site.profile",
                    "view_site.site_address",
                    "program_ftth.cluster_id",
                    "program_ftth.sam_milestone",
                    "program_ftth.submilestone",
                    "program_ftth.afi_lines",
                    "program_ftth.odn_vendor",
                    "program_ftth.region"
                );
            }
            elseif($program_id == 1){
                $sites->leftJoin('program_newsites', 'view_site.sam_id', 'program_newsites.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.profile",
                    "program_newsites.saq_milestone",
                    "program_newsites.serial_number",
                    "program_newsites.saq_bucket",
                    "program_newsites.region",
                );
            }

            if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                $sites->whereIn('view_site.sam_region_id', $user_area);
            }
                
            $sites->get();

        }

        elseif($activity_type == 'artb declaration'){

            $sites = \DB::table("view_site")
                            ->whereIn('view_site.activity_type', ['artb declaration'])
                            ->where('view_site.program_id', $program_id)
                            ->where('view_site.profile_id', \Auth::user()->profile_id);

            if($program_id == 3){                
                $sites->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id')
                    ->select(
                        "view_site.vendor_acronym", 
                        "view_site.site_name", 
                        "view_site.sam_id", 
                        "view_site.activity_id", 
                        "view_site.program_id", 
                        "view_site.site_category", 
                        "view_site.activity_name", 
                        "view_site.sam_region_name",
                        "view_site.aging",
                        "view_site.site_address",
                        "view_site.program_endorsement_date",
                        "view_site.profile",
                        "program_coloc.nomination_id", 
                        "program_coloc.pla_id", 
                        "program_coloc.highlevel_tech",  
                        "program_coloc.technology", 
                        "program_coloc.site_type",
                        "program_coloc.address",  
                        "program_coloc.vendor",  
                        "program_coloc.region",  
                        "program_coloc.gt_saq_milestone",  
                        "program_coloc.gt_saq_milestone_category"
                    );
            }
            elseif($program_id == 4){
                $sites->leftJoin('program_ibs', 'view_site.sam_id', 'program_ibs.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.profile",
                    "program_ibs.vendor_tw_build",
                    "program_ibs.address",
                    "program_ibs.region",
                    "program_ibs.pla_id",
                    "program_ibs.wireless_project_code",
                    "program_ibs.wireless_solution",
                    "program_ibs.saq_milestone",
                    "program_ibs.sub_saq_milestone",
                );
            }
            elseif($program_id == 8){
                $sites->leftJoin('program_renewal', 'view_site.sam_id', 'program_renewal.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.profile",
                    "program_renewal.*"
                );
            }
            elseif($program_id == 2){
                $sites->leftJoin('program_ftth', 'view_site.sam_id', 'program_ftth.sam_id')
                ->select(
                    "view_site.site_name", 
                    "view_site.vendor_acronym", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_type", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name", 
                    "view_site.region_name", 
                    "view_site.province_name", 
                    "view_site.lgu_name", 
                    "view_site.aging",
                    "view_site.profile",
                    "view_site.site_address",
                    "program_ftth.cluster_id",
                    "program_ftth.sam_milestone",
                    "program_ftth.submilestone",
                    "program_ftth.afi_lines",
                    "program_ftth.odn_vendor",
                    "program_ftth.region"
                );
            }
            elseif($program_id == 1){
                $sites->leftJoin('program_newsites', 'view_site.sam_id', 'program_newsites.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.profile",
                    "program_newsites.saq_milestone",
                    "program_newsites.serial_number",
                    "program_newsites.saq_bucket",
                    "program_newsites.region",
                );
            }

            if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                $sites->whereIn('view_site.sam_region_id', $user_area);
            }
            
            $sites->get();

        }

        elseif($activity_type == 'site approval'){

                $sites = \DB::table("view_site")
                                // ->leftjoin('stage_activities', 'stage_activities.activity_id', 'view_sites_per_program.activity_id')
                                ->where('view_site.program_id', $program_id)
                                // ->whereIn('stage_activities.activity_type', ['doc approval', 'site approval'])
                                ->where('view_site.profile_id', \Auth::user()->profile_id);

                                if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                                    $sites->whereIn('view_site.sam_region_id', $user_area);
                                }
                                if ( $program_id == 1 ) {
                                    $sites->select(
                                        "view_site.vendor_acronym", 
                                        "view_site.site_name", 
                                        "view_site.sam_id", 
                                        "view_site.activity_id", 
                                        "view_site.program_id",
                                        "view_site.activity_name", 
                                        "view_site.sam_region_name",
                                        "view_site.site_category",
                                        "view_site.aging",
                                        "view_site.site_address",
                                        "view_site.program_endorsement_date",
                                        "view_site.profile",
                                        "program_newsites.saq_milestone",
                                        "program_newsites.serial_number",
                                        "program_newsites.saq_bucket",
                                        "program_newsites.region",
                                    )
                                    ->join('program_newsites', 'program_newsites.sam_id', 'view_site.sam_id')
                                    // ->whereIn('view_site.activity_id', [16, 17, 25, 27])
                                    ->where('view_site.activity_type', 'site approval')
                                    ->get();
                                } else if ( $program_id == 2 ) {

                                    $sites->select(
                                        "view_site.site_name", 
                                        "view_site.vendor_acronym", 
                                        "view_site.sam_id", 
                                        "view_site.activity_id", 
                                        "view_site.program_id", 
                                        "view_site.activity_type", 
                                        "view_site.activity_name", 
                                        "view_site.sam_region_name", 
                                        "view_site.region_name", 
                                        "view_site.province_name", 
                                        "view_site.lgu_name", 
                                        "view_site.site_category",
                                        "view_site.aging",
                                        "view_site.profile",
                                        "view_site.site_address",
                                        "program_ftth.cluster_id",
                                        "program_ftth.sam_milestone",
                                        "program_ftth.submilestone",
                                        "program_ftth.afi_lines",
                                        "program_ftth.odn_vendor",
                                        "program_ftth.region"
                                    )
                                    ->join('program_ftth', 'program_ftth.sam_id', 'view_site.sam_id')
                                    // ->whereIn('view_site.activity_id', [17, 20, 14, 18, 21, 27, 34, 30, 23])
                                    ->where('view_site.activity_type', 'site approval')
                                    ->get();

                                } else if ( $program_id == 3 ) {
                                    
                                    $sites->select(
                                        "view_site.vendor_acronym", 
                                        "view_site.site_name", 
                                        "view_site.sam_id", 
                                        "view_site.activity_id", 
                                        "view_site.program_id", 
                                        "view_site.activity_name", 
                                        "view_site.sam_region_name",
                                        "view_site.site_category",
                                        "view_site.aging",
                                        "view_site.site_address",
                                        "view_site.program_endorsement_date",
                                        "view_site.profile",
                                        "program_coloc.nomination_id", 
                                        "program_coloc.pla_id", 
                                        "program_coloc.highlevel_tech",  
                                        "program_coloc.technology", 
                                        "program_coloc.site_type",
                                        "program_coloc.address",  
                                        "program_coloc.vendor",  
                                        "program_coloc.region",  
                                        "program_coloc.gt_saq_milestone",  
                                        "program_coloc.gt_saq_milestone_category"
                                    )
                                    ->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id')
                                    // ->whereIn('view_site.activity_id', [15, 21, 22, 26, 27])
                                    ->where('view_site.activity_type', 'site approval')
                                    ->get();

                                    // return dd($sites->get());
                                } else if ( $program_id == 4 ) {
                                    // if(\Auth::user()->profile_id == 8){

                                    //     $sites->select(
                                    //         "view_site.vendor_acronym", 
                                    //         "view_site.site_name", 
                                    //         "view_site.sam_id", 
                                    //         "view_site.activity_id", 
                                    //         "view_site.program_id", 
                                    //         "view_site.site_category", 
                                    //         "view_site.activity_name", 
                                    //         "view_site.sam_region_name",
                                    //         "view_site.site_category",
                                    //         "view_site.aging",
                                    //         "view_site.site_address",
                                    //         "view_site.program_endorsement_date",
                                    //         "view_site.aging",
                                    //         "program_ibs.vendor_tw_build",
                                    //         "program_ibs.address",
                                    //         "program_ibs.region",
                                    //         "program_ibs.pla_id",
                                    //         "program_ibs.wireless_project_code",
                                    //         "program_ibs.wireless_solution",
                                    //         "program_ibs.saq_milestone",
                                    //         "program_ibs.sub_saq_milestone",
                                    //     )
                                    //     ->leftJoin('program_ibs', 'view_site.sam_id', 'program_ibs.sam_id')
                                    //     ->whereIn('view_site.activity_id', [8, 11, 16, 19, 22, 25])
                                    //     ->get();

                                    // }
                                    // elseif(\Auth::user()->profile_id == 10){

                                        $sites->select(
                                            "view_site.vendor_acronym", 
                                            "view_site.site_name", 
                                            "view_site.sam_id", 
                                            "view_site.activity_id", 
                                            "view_site.program_id", 
                                            "view_site.site_category", 
                                            "view_site.activity_name", 
                                            "view_site.sam_region_name",
                                            "view_site.aging",
                                            "view_site.site_address",
                                            "view_site.program_endorsement_date",
                                            "view_site.profile",
                                            "program_ibs.vendor_tw_build",
                                            "program_ibs.address",
                                            "program_ibs.region",
                                            "program_ibs.pla_id",
                                            "program_ibs.wireless_project_code",
                                            "program_ibs.wireless_solution",
                                            "program_ibs.saq_milestone",
                                            "program_ibs.sub_saq_milestone",
                                        )
                                        ->leftJoin('program_ibs', 'view_site.sam_id', 'program_ibs.sam_id')
                                        // ->whereIn('view_site.activity_id', [9, 12, 17, 20, 23, 26, 39, 29])
                                        ->where('view_site.activity_type', 'site approval')
                                        ->get();

                                    // }
                                } else if ( $program_id == 5 ) {
                                    // $sites->whereIn('view_site.activity_id', [19, 24, 27, 30])
                                    $sites->where('view_site.activity_type', 'site approval')
                                    ->get();
                                } else if ( $program_id == 8 ) {
                                    $sites
                                    ->select(
                                        "view_site.vendor_acronym", 
                                        "view_site.site_name", 
                                        "view_site.sam_id", 
                                        "view_site.activity_id", 
                                        "view_site.program_id", 
                                        "view_site.site_category", 
                                        "view_site.activity_name", 
                                        "view_site.sam_region_name",
                                        "view_site.aging",
                                        "view_site.site_address",
                                        "view_site.program_endorsement_date",
                                        "view_site.profile",
                                        "program_renewal.*"
                                    )
                                    ->leftJoin('program_renewal', 'view_site.sam_id', 'program_renewal.sam_id')
                                    // ->whereIn('view_site.activity_id', [19, 20, 21, 24, 25, 26, 29, 30, 34])
                                    ->where('view_site.activity_type', 'site approval')
                                    ->get();
                                }
        }

        elseif($activity_type == 'refx process'){

                $sites = \DB::table("view_site")
                                ->where('view_site.program_id', $program_id)
                                ->where('view_site.profile_id', \Auth::user()->profile_id)
                                ->whereIn('view_site.activity_id', [32, 33]);
                                
                                if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                    $sites->whereIn('view_site.sam_region_id', $user_area);
                }
                
                $sites->get();
        }

        elseif($activity_type == 'vendor awarding'){
            $sites = \DB::table("view_pr_memo_v2")
                            ->where('status', '!=', 'denied');
                            
                            if ( $program_id == 1 ) {
                                $sites->whereIn('activity_id', [6])
                                    ->get();
                            } else if ( $program_id == 5 ) {
                                $sites->whereIn('activity_id', [9])
                                    ->get();
                            } else if ( $program_id == 8 ) {
                                $sites->whereIn('activity_id', [3])
                                    ->get();
                            }
        }

        elseif($activity_type == 'elas_renewal'){
            $sites = \DB::table('view_site')
                    ->where('program_id',  $program_id)
                    ->where('activity_type', "elas renewal");

                    if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                $sites->whereIn('view_site.sam_region_id', $user_area);
            }


            $sites->leftJoin('program_renewal', 'program_renewal.sam_id', 'view_site.sam_id')
            ->select('view_site.*', 'program_renewal.*');

                    

            $sites->get();

        }

        elseif($activity_type == 'renewal vendor awarding'){
            $sites = \DB::table('view_site')
                    ->where('program_id',  $program_id)
                    ->where('activity_type', "vendor awarding");

                    if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                $sites->whereIn('view_site.sam_region_id', $user_area);
            }

            $sites->leftJoin('program_renewal', 'program_renewal.sam_id', 'view_site.sam_id')
            ->select('view_site.*', 'program_renewal.*');

                    

            $sites->get();

        }

        elseif($activity_type == 'pr issuance'){
            $sites = \DB::table("view_pr_memo")
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
            $sites = \DB::table("view_pr_memo");
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
            $sites = \DB::table("view_pr_memo")
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
            $sites = \DB::table("view_pr_memo_v2");
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
            $sites = \DB::table("view_sites_per_program")
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
            $sites = \DB::table("view_site_hunting");

            if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                $sites->whereIn('view_site_hunting.site_sam_region_id', $user_area);
            }

            $sites->get();

        }

        elseif($activity_type == 'schedule jtss'){
            // $sites = \DB::table("view_newsites_jtss_schedule_requests")
            //                     ->get();

                                
            $sites = \DB::table('view_site')
                            ->where('program_id',  $program_id)
                            ->where('profile_id',  \Auth::user()->profile_id)
                            ->where('activity_type', "sched validation");
        }

        elseif($activity_type == 'jtss'){

            $sites = \DB::table("view_jtss_aepm")
                    ->where('program_id', $program_id);

                    if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                $sites->whereIn('view_jtss_aepm.sam_region_id', $user_area);
            }
                    $sites->get();

                    // dd($sites);

        }

        elseif($activity_type == 'ssds'){

            $sites = \DB::table("site")
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

            $sites = \DB::table("site")
                    ->where('program_id', $program_id)
                    ->whereJsonContains('activities->activity_id', '11')
                    // ->orwhereJsonContains('activities->activity_id', '22')
                    ->whereJsonContains('activities->profile_id', '8')

                    ->get();

                    // dd($sites);

        }

        elseif($activity_type == 'doc validation'){

            $sites = \DB::table("view_site");
                // ->where('program_id', $program_id)
                // ->where('active_profile', \Auth::user()->profile_id);
                // ->whereNull('approver_id')
                // ->whereNull('approver_id2')
                // ->whereNull('approver_id3')
                // ->whereNot('status', 'rejected')

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

        elseif($activity_type == 'doc validation 2'){

            $sites = \DB::table("view_doc_validation")
                ->where('program_id', $program_id)
                ->whereNotNull('approver_id')
                ->whereNull('approver_id2')
                ->whereNull('approver_id3')
                ->get();                

        }

        elseif($activity_type == 'doc validation 3'){

            $sites = \DB::table("view_doc_validation")
                ->where('program_id', $program_id)
                ->whereNotNull('approver_id')
                ->whereNotNull('approver_id2')
                ->whereNull('approver_id3')
                ->get();

        }
        elseif($activity_type == 'set po'){

            $sites = \DB::table("view_site")
                    ->where('program_id', $program_id)
                    ->where('activity_type', "endorsement")
                    ->where('profile_id', \Auth::user()->profile_id);


                    if($program_id == 8){
                        $sites->leftJoin('program_renewal', 'program_renewal.sam_id', 'view_site.sam_id')
                              ->select('view_site.*', 'program_renewal.*');
                    }

                    $sites->get();

        }
        elseif($activity_type == 'new endorsements globe'){

            // $sites = \DB::connection('mysql2')
            //         ->table("view_sites_activity")
            //         ->whereIn('activity_id', [7])
            //         ->where('profile_id', \Auth::user()->profile_id)
            //         ->get();

            $sites = \DB::table("view_site")
                    ->where('program_id', $program_id)
                    ->where('activity_type', "endorsement")
                    ->where('profile_id', \Auth::user()->profile_id);


            if($program_id == 3){                
                $sites->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_coloc.nomination_id", 
                            "program_coloc.pla_id", 
                            "program_coloc.highlevel_tech",  
                            "program_coloc.technology", 
                            "program_coloc.site_type",
                            "program_coloc.address",  
                            "program_coloc.vendor",  
                            "program_coloc.region",  
                            "program_coloc.gt_saq_milestone",  
                            "program_coloc.gt_saq_milestone_category"
                        );
            }
            elseif($program_id == 4){
                $sites->leftJoin('program_ibs', 'view_site.sam_id', 'program_ibs.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.profile",
                    "program_ibs.vendor_tw_build",
                    "program_ibs.address",
                    "program_ibs.region",
                    "program_ibs.pla_id",
                    "program_ibs.wireless_project_code",
                    "program_ibs.wireless_solution",
                    "program_ibs.saq_milestone",
                    "program_ibs.sub_saq_milestone",
                );
            }
            elseif($program_id == 8){
                $sites->leftJoin('program_renewal', 'view_site.sam_id', 'program_renewal.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.profile",
                    "program_renewal.*"
                );
            }
            elseif($program_id == 2){
                $sites->leftJoin('program_ftth', 'view_site.sam_id', 'program_ftth.sam_id')
                ->select(
                    "view_site.site_name", 
                    "view_site.vendor_acronym", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.activity_type", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name", 
                    "view_site.region_name", 
                    "view_site.province_name", 
                    "view_site.lgu_name", 
                    "view_site.site_category",
                    "view_site.aging",
                    "view_site.profile",
                    "view_site.site_address",
                    "program_ftth.cluster_id",
                    "program_ftth.sam_milestone",
                    "program_ftth.submilestone",
                    "program_ftth.afi_lines",
                    "program_ftth.odn_vendor",
                    "program_ftth.region"
                );
            }
            elseif($program_id == 1){
                $sites->leftJoin('program_newsites', 'view_site.sam_id', 'program_newsites.sam_id')
                ->select(
                    "view_site.vendor_acronym", 
                    "view_site.site_name", 
                    "view_site.sam_id", 
                    "view_site.activity_id", 
                    "view_site.program_id", 
                    "view_site.site_category", 
                    "view_site.activity_name", 
                    "view_site.sam_region_name",
                    "view_site.aging",
                    "view_site.site_address",
                    "view_site.program_endorsement_date",
                    "view_site.profile",
                    "program_newsites.saq_milestone",
                    "program_newsites.serial_number",
                    "program_newsites.saq_bucket",
                    "program_newsites.region",
                );
            }

            if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                $sites->whereIn('view_site.sam_region_id', $user_area);
            }

            if (!is_null($user_detail) && $user_detail->mode == 'vendor') {
                $vendor = is_null($user_detail) ? NULL : $user_detail->vendor_id;
                $sites->where('view_site.vendor_id', $vendor);
            }

            $sites->get();

        }

        elseif($activity_type == 'new endorsements apmo'){

            if($program_id == 3) {

                $sites = \DB::table('program_coloc')
                        ->join('view_site','view_site.sam_id', 'program_coloc.sam_id')

                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_coloc.nomination_id", 
                            "program_coloc.pla_id", 
                            "program_coloc.highlevel_tech",  
                            "program_coloc.technology", 
                            "program_coloc.site_type",
                            "program_coloc.address",  
                            "program_coloc.vendor",  
                            "program_coloc.region",  
                            "program_coloc.gt_saq_milestone",  
                            "program_coloc.gt_saq_milestone_category")
                        ->where('view_site.program_id', $program_id)
                        ->whereNull('view_site.activity_id')
                    ->get();
            } elseif($program_id == 4){

                $sites = \DB::table('program_ibs')
                        ->join('view_site','view_site.sam_id', 'program_ibs.sam_id')

                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_ibs.vendor_tw_build",
                            "program_ibs.address",
                            "program_ibs.region",
                            "program_ibs.pla_id",
                            "program_ibs.wireless_project_code",
                            "program_ibs.wireless_solution",
                            "program_ibs.saq_milestone",
                            "program_ibs.sub_saq_milestone",
                        )
                        ->where('view_site.program_id', $program_id)
                        ->whereNull('view_site.activity_id')
                        ->get();

            } elseif($program_id == 8){

                $sites = \DB::table('program_renewal')
                        ->join('view_site','view_site.sam_id', 'program_renewal.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_renewal.*"
                        )
                        ->where('view_site.program_id', $program_id)
                        ->whereNull('view_site.activity_id')
                        ->get();
            } elseif($program_id == 2){

                $sites = \DB::table('program_ftth')
                        ->join('view_site','view_site.sam_id', 'program_ftth.sam_id')
                        ->select(
                            "view_site.site_name", 
                            "view_site.vendor_acronym", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_type", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name", 
                            "view_site.region_name", 
                            "view_site.province_name", 
                            "view_site.lgu_name", 
                            "view_site.aging",
                            "view_site.profile",
                            "view_site.site_address",
                            "program_ftth.cluster_id",
                            "program_ftth.sam_milestone",
                            "program_ftth.submilestone",
                            "program_ftth.afi_lines",
                            "program_ftth.odn_vendor",
                            "program_ftth.region"
                        )
                        ->where('view_site.program_id', $program_id)
                        ->whereNull('view_site.activity_id')
                        ->get();
            } elseif($program_id == 1){

                $sites = \DB::table('program_newsites')
                        ->join('view_site','view_site.sam_id', 'program_newsites.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_newsites.saq_milestone",
                            "program_newsites.serial_number",
                            "program_newsites.saq_bucket",
                            "program_newsites.region",
                        )
                        ->where('view_site.program_id', $program_id)
                        ->whereNull('view_site.activity_id')
                        ->get();
            }
    
        }

        elseif($activity_type == 'site editor'){

            if($program_id == 3){

                $sites = \DB::table('program_coloc')
                        ->join('view_site','view_site.sam_id', 'program_coloc.sam_id')

                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_coloc.nomination_id", 
                            "program_coloc.pla_id", 
                            "program_coloc.highlevel_tech",  
                            "program_coloc.technology", 
                            "program_coloc.site_type",
                            "program_coloc.address",  
                            "program_coloc.vendor",  
                            "program_coloc.region",  
                            "program_coloc.gt_saq_milestone",  
                            "program_coloc.gt_saq_milestone_category"
                        )
                        ->where('view_site.program_id', $program_id)
                        ->whereNull('view_site.activity_id')
                    ->get();
                }
                elseif($program_id == 4){

                    $sites = \DB::table('program_ibs')
                            ->join('view_site','view_site.sam_id', 'program_ibs.sam_id')
    
                            ->select(
                                "view_site.vendor_acronym", 
                                "view_site.site_name", 
                                "view_site.sam_id", 
                                "view_site.activity_id", 
                                "view_site.program_id", 
                                "view_site.site_category", 
                                "view_site.activity_name", 
                                "view_site.sam_region_name",
                                "view_site.aging",
                                "view_site.site_address",
                                "view_site.program_endorsement_date",
                                "view_site.profile",
                                "program_ibs.vendor_tw_build",
                                "program_ibs.address",
                                "program_ibs.region",
                                "program_ibs.pla_id",
                                "program_ibs.wireless_project_code",
                                "program_ibs.wireless_solution",
                                "program_ibs.saq_milestone",
                                "program_ibs.sub_saq_milestone",
                            )
                            ->where('view_site.program_id', $program_id)
                            ->whereNull('view_site.activity_id')
                        ->get();
                    }
    
        }        
        elseif($activity_type == 'new endorsements vendor'){

            $sites = \DB::table("view_sites_activity")
                    ->select('site_name', 'sam_id', 'site_category', 'activity_id', 'program_id', 'site_endorsement_date',  'id', 'site_vendor_id', 'activity_name')
                    ->where('program_id', $program_id);
                    
                    if (!is_null($user_detail) && $user_detail->mode == 'vendor') {
                        $vendor = is_null($user_detail) ? NULL : $user_detail->vendor_id;
                        $sites->where('view_sites_activity.site_vendor_id', $vendor);
                    }
            
                    if ($program_id == 1) {
                        $sites->where('activity_id', 7);
                    } else if ($program_id == 3 && \Auth::user()->profile_id == 3) {
                        $sites->where('activity_id', 7)
                                ->select(
                                    "view_sites_activity.site_name", 
                                    "view_sites_activity.sam_id", 
                                    "view_sites_activity.activity_id", 
                                    "view_sites_activity.program_id", 
                                    "view_sites_activity.activity_name", 
                                    "view_sites_activity.sam_region_name",
                                    "view_sites_activity.site_category",
                                    "view_sites_activity.aging",
                                    "view_sites_activity.site_address",
                                    "view_sites_activity.program_endorsement_date",
                                    "program_coloc.nomination_id", 
                                    "program_coloc.pla_id", 
                                    "program_coloc.highlevel_tech",  
                                    "program_coloc.technology", 
                                    "program_coloc.site_type",
                                    "program_coloc.address",  
                                    "program_coloc.vendor",  
                                    "program_coloc.region",  
                                    "program_coloc.gt_saq_milestone",  
                                    "program_coloc.gt_saq_milestone_category"
                                );
                    } else if ($program_id == 4 && \Auth::user()->profile_id == 3) {
                        $sites->where('activity_id', 6)
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_ibs.vendor_tw_build",
                            "program_ibs.address",
                            "program_ibs.region",
                            "program_ibs.pla_id",
                            "program_ibs.wireless_project_code",
                            "program_ibs.wireless_solution",
                            "program_ibs.saq_milestone",
                            "program_ibs.sub_saq_milestone",
                        );
                    } else if ($program_id == 5 && \Auth::user()->profile_id == 3) {
                        $sites->where('activity_id', 11);
                    }

                    if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                        $sites->whereIn('view_sites_activity.site_sam_region_id', $user_area);
                    }

                    $sites->where('profile_id', \Auth::user()->profile_id)
                            ->get();

        }

        elseif($activity_type == 'new endorsements vendor accept'){

            $sites = \DB::table("view_site")
                    ->where('view_site.program_id', $program_id);

                    if (!is_null($user_detail) && $user_detail->mode == 'vendor') {
                        $vendor = is_null($user_detail) ? NULL : $user_detail->vendor_id;
                        $sites->where('view_site.vendor_id', $vendor);
                    }
                    
                    if ($program_id == 1) {
                        $sites->join('program_newsites', 'program_newsites.sam_id', 'view_site.sam_id')
                        ->select(
                                    "view_site.vendor_acronym", 
                                    "view_site.site_name", 
                                    "view_site.sam_id", 
                                    "view_site.activity_id", 
                                    "view_site.program_id", 
                                    "view_site.site_category", 
                                    "view_site.activity_name", 
                                    "view_site.sam_region_name",
                                    "view_site.aging",
                                    "view_site.site_address",
                                    "view_site.program_endorsement_date",
                                    "view_site.profile",
                                    "program_newsites.saq_milestone",
                                    "program_newsites.serial_number",
                                    "program_newsites.saq_bucket",
                                    "program_newsites.region",
                                )
                                ->where('activity_id', 7);
                    } else if ($program_id == 3 && \Auth::user()->profile_id == 3) {
                        $sites->where('activity_id', 6)
                                ->select(
                                    "view_site.vendor_acronym", 
                                    "view_site.site_name", 
                                    "view_site.sam_id", 
                                    "view_site.activity_id", 
                                    "view_site.program_id", 
                                    "view_site.activity_name", 
                                    "view_site.sam_region_name",
                                    "view_site.site_category",
                                    "view_site.aging",
                                    "view_site.site_address",
                                    "view_site.program_endorsement_date",
                                    "view_site.profile",
                                    "program_coloc.nomination_id", 
                                    "program_coloc.pla_id", 
                                    "program_coloc.highlevel_tech",  
                                    "program_coloc.technology", 
                                    "program_coloc.site_type",
                                    "program_coloc.address",  
                                    "program_coloc.vendor",  
                                    "program_coloc.region",  
                                    "program_coloc.gt_saq_milestone",  
                                    "program_coloc.gt_saq_milestone_category"
                                );
                    } else if ($program_id == 4 && \Auth::user()->profile_id == 3) {
                        $sites->where('activity_id', 5);
                    } else if ($program_id == 2 && \Auth::user()->profile_id == 3) {
                        $sites->join('program_ftth', 'view_site.sam_id', 'program_ftth.sam_id')
                        ->where('view_site.activity_id', 4)
                        ->select(
                            "view_site.site_name", 
                            "view_site.vendor_acronym", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.activity_type", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name", 
                            "view_site.region_name", 
                            "view_site.province_name", 
                            "view_site.lgu_name", 
                            "view_site.site_category",
                            "view_site.aging",
                            "view_site.site_address",
                            "program_ftth.cluster_id",
                            "program_ftth.sam_milestone",
                            "program_ftth.submilestone",
                            "program_ftth.afi_lines",
                            "program_ftth.odn_vendor",
                            "program_ftth.region"
                        );
                    } else if ($program_id == 5 && \Auth::user()->profile_id == 3) {
                        $sites->where('activity_id', 10);
                    } else if ($program_id == 8 && \Auth::user()->profile_id == 3) {
                        $sites->join('program_renewal', 'program_renewal.sam_id', 'view_site.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_renewal.*"
                        )
                        ->where('activity_id', 4);
                    }

                    if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                        $sites->whereIn('view_site.sam_region_id', $user_area);
                    }

                    $sites->where('profile_id', \Auth::user()->profile_id)
                            ->get();

        }

        elseif($activity_type == 'unassigned sites'){

            $vendor = is_null($user_detail) ? NULL : $user_detail->vendor_id;

            $sites = \DB::table("view_site")
                    ->leftJoin('site_users', 'site_users.sam_id', 'view_site.sam_id')
                    // ->where('view_site.vendor_id', $vendor)
                    ->whereNull('site_users.sam_id');
                
                if (\Auth::user()->profile_id == 1) {
                    $activity_id = 6;
                } else {
                    if ( $program_id == 3 ) {
                        $activity_id = 7;
                    } else {
                        $activity_id = 6;
                    }
                }

                if ( $program_id == 3 ) {
                    $sites->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.site_category",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_coloc.nomination_id", 
                            "program_coloc.pla_id", 
                            "program_coloc.highlevel_tech",  
                            "program_coloc.technology", 
                            "program_coloc.site_type",
                            "program_coloc.address",  
                            "program_coloc.vendor",  
                            "program_coloc.region",  
                            "program_coloc.gt_saq_milestone",  
                            "program_coloc.gt_saq_milestone_category"
                        )
                        ->where('view_site.activity_id', '>=', $activity_id);
                        if (\Auth::user()->profile_id == 1) {
                            $sites->where('view_site.profile_id', \Auth::user()->profile_id);
                        }
                        // ->whereNotIn('view_site.sam_id', $site_user_samid);
                        // dd($sites->get());
                } else if($program_id == 4){
                    $sites->leftJoin('program_ibs', 'program_ibs.sam_id', 'view_site.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_ibs.vendor_tw_build",
                            "program_ibs.address",
                            "program_ibs.region",
                            "program_ibs.pla_id",
                            "program_ibs.wireless_project_code",
                            "program_ibs.wireless_solution",
                            "program_ibs.saq_milestone",
                            "program_ibs.sub_saq_milestone",
                        )
                        ->where('activity_id', '>=', 6);
                } else if($program_id == 2){
                    $sites->leftJoin('program_ftth', 'program_ftth.sam_id', 'view_site.sam_id')
                        ->select(
                            "view_site.site_name", 
                            "view_site.vendor_acronym", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_type", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name", 
                            "view_site.region_name", 
                            "view_site.province_name", 
                            "view_site.lgu_name", 
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.profile",
                            "program_ftth.cluster_id",
                            "program_ftth.sam_milestone",
                            "program_ftth.submilestone",
                            "program_ftth.afi_lines",
                            "program_ftth.odn_vendor",
                            "program_ftth.region"
                        )
                        ->where('activity_id', '>=', 5);
                } else if($program_id == 1){
                    $sites->leftJoin('program_newsites', 'program_newsites.sam_id', 'view_site.sam_id')
                        ->select(
                            "view_site.vendor_acronym", 
                            "view_site.site_name", 
                            "view_site.sam_id", 
                            "view_site.activity_id", 
                            "view_site.program_id", 
                            "view_site.site_category", 
                            "view_site.activity_name", 
                            "view_site.sam_region_name",
                            "view_site.aging",
                            "view_site.site_address",
                            "view_site.program_endorsement_date",
                            "view_site.profile",
                            "program_newsites.saq_milestone",
                            "program_newsites.serial_number",
                            "program_newsites.saq_bucket",
                            "program_newsites.region",
                        )
                        ->where('activity_id', '>=', 8);
                } else if ($program_id == 8) {
                    $sites->join('program_renewal', 'program_renewal.sam_id', 'view_site.sam_id')
                    ->select(
                        "view_site.vendor_acronym", 
                        "view_site.site_name", 
                        "view_site.sam_id", 
                        "view_site.activity_id", 
                        "view_site.program_id", 
                        "view_site.site_category", 
                        "view_site.activity_name", 
                        "view_site.sam_region_name",
                        "view_site.aging",
                        "view_site.site_address",
                        "view_site.program_endorsement_date",
                        "view_site.profile",
                        "program_renewal.*"
                    )
                    ->where('view_site.activity_id', '>=', 5);
                }

                if (!is_null($user_detail) && $user_detail->mode == 'vendor') {
                    $sites->where('view_site.vendor_id', $vendor);
                }

                if (\Auth::user()->profile_id != 1 && strtolower($user_detail->mode) != 'globe') {
                    $sites->whereIn('view_site.sam_region_id', $user_area);
                }
    

                $sites->where('view_site.program_id', $program_id)->get();

        } 
        
        else if ($activity_type == 'all-site-issues') {
            $sites = \DB::table("site_issue")
                            ->leftjoin('view_site', 'view_site.sam_id', 'site_issue.sam_id')
                            ->join('issue_type', 'issue_type.issue_type_id', 'site_issue.issue_type_id')
                            ->where('view_site.program_id', $program_id)
                            ->whereNull('site_issue.date_resolve')
                            ->where('site_issue.approvers->active_profile', \Auth::user()->profile_id)
                            ->where('site_issue.approvers->active_status', 'active');
                            $sites->get();
        }

        elseif($activity_type == 'my_approvals'){

            $sites = \DB::select('call GET_MY_APPROVALS(?)', array(\Auth::id()));

        }

        else {

            $sites = \DB::table("milestone_tracking_2")
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
        $sites = \DB::table("milestone_tracking_2")
                    ->distinct()
                    ->where('program_id', $program_id)
                    ->where('activity_complete', 'false')
                    ->where('pending_count', '>', 0)
                    ->get();

        $dt = DataTables::of($sites);
        return $dt->make(true);

    }

    public function sub_activity_view(Request $request)
    {
        // $request->get('sub_activity'), $request->get('sub_activity_id'), $request->get('program_id'), $request->get('site_category'), $request->get('activity_id')
        if($request->get('active_subactivity') == 'SSDS'){

            $jtss_add_site = SubActivityValue::where('sam_id', $request->get('active_sam_id'))
                                                    ->where('type', 'jtss_add_site')
                                                    ->get();

            $what_component = "components.subactivity-ssds";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
                'check_if_added' => $jtss_add_site,
            ])
            ->render();

        }

        else if($request->get('active_subactivity') == 'Set Approved Site'){

            $jtss_add_site = SubActivityValue::where('sam_id', $request->get('active_sam_id'))
                                                    ->where('type', 'jtss_add_site')
                                                    ->get();

            $what_component = "components.set-approved-site";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
                'check_if_added' => $jtss_add_site,
            ])
            ->render();

        }

        else if($request->get('active_subactivity') == 'Lessor Negotiation' || $request->get('active_subactivity') == 'LESSOR ENGAGEMENT' || $request->get('active_subactivity') == 'Lessor Engagement' || $request->get('active_subactivity') == 'Lessor Renewal Negotiation'){ 
            // elseif($request->get('sub_activity') == 'Lessor Negotiation' || $request->get('sub_activity') == 'LESSOR ENGAGEMENT' || $request->get('sub_activity') == 'Lessor Engagement'){

            $what_component = "components.subactivity-lessor-engagement";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
            ])
            ->render();

        }

        else if($request->get('active_subactivity') == 'Commercial Negotiation'){

            $what_component = "components.renewal-commercial-negotiation";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
            ])
            ->render();

        }

        elseif($request->get('active_subactivity') == 'Set Site Category'){

            $what_component = "components.set-site-category";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'Schedule Advanced Site Hunting'){

            $what_component = "components.schedule-advance-site-hunting";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'Set Survey Representatives'){

            $datas = SubActivityValue::where('sam_id', $request->get('active_sam_id'))
                                        ->where('type', 'jtss_representative')
                                        ->get();

            $site = Site::select('site_name')
                            ->where('sam_id', $request->get('active_sam_id'))
                            ->first();

            $what_component = "components.set-survey-representatives";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
                'site_name' => $site->site_name,
                'is_done' => count($datas) > 0 ? 'done' : 'not_done',
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'Add Site Candidates'){

            $jtss_add_site = SubActivityValue::where('sam_id', $request->get('active_sam_id'))
                                                    ->where('type', 'jtss_add_site')
                                                    ->get();

            $site_np = Site::select('NP_latitude', 'NP_longitude', 'site_region_id', 'site_province_id', 'site_lgu_id')
                        ->where('sam_id', $request->get('active_sam_id'))
                        ->first();

            $location_regions = \DB::table('location_regions')
                                        ->select('region_name')
                                        ->where('region_id', $site_np->site_region_id)
                                        ->first();

            $location_provinces = \DB::table('location_provinces')
                                        ->select('province_name')
                                        ->where('province_id', $site_np->site_province_id)
                                        ->first();

            $location_lgus = \DB::table('location_lgus')
                                        ->select('lgu_name')
                                        ->where('lgu_id', $site_np->site_lgu_id)
                                        ->first();

            $what_component = "components.add-site-prospects";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
                'check_if_added' => $jtss_add_site,
                'NP_latitude' => $site_np->NP_latitude,
                'NP_longitude' => $site_np->NP_longitude,
                'site_region_id' => $site_np->site_region_id,
                'site_province_id' => $site_np->site_province_id,
                'site_lgu_id' => $site_np->site_lgu_id,
                'location_regions' => is_null($location_regions) ? "NA" : $location_regions->region_name,
                'location_provinces' => is_null($location_provinces) ? "NA" : $location_provinces->province_name,
                'location_lgus' => is_null($location_lgus) ? "NA" : $location_lgus->lgu_name
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'JTSS Sched Confirmation'){

            $np = \DB::table('site')
                ->where('sam_id', $request->get('active_sam_id'))
                ->select('NP_latitude', 'NP_longitude')
                ->get();


            $what_component = "components.jtss-sched-confirmation";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'Site Survey Deliberation Sheet'){

            $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('sam_id', $request->get('active_sam_id'))
                                        ->get();

            $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('sam_id', $request->get('active_sam_id'))
                                        ->get();
                                        
            $what_component = "components.ssds";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
                'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'SSDS Ranking'){

            $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('sam_id', $request->get('active_sam_id'))
                                        ->get();

            $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('sam_id', $request->get('active_sam_id'))
                                        ->get();

            $what_component = "components.ssds-ranking";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
                'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
                'count_ssds' => count($jtss_ssds),
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'Approved SSDS'){

            $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('sam_id', $request->get('active_sam_id'))
                                        ->get();

            $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('sam_id', $request->get('active_sam_id'))
                                        ->get();

            $what_component = "components.approved-ssds";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
                'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'SSDS NTP'){

            $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('sam_id', $request->get('active_sam_id'))
                                        ->get();

            $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('sam_id', $request->get('active_sam_id'))
                                        ->get();

            $what_component = "components.ssds-ntp";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
                'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'Lease Details'){

            $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                        ->where('sam_id', $request->get('active_sam_id'))
                                        ->get();

            $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                        ->where('sam_id', $request->get('active_sam_id'))
                                        ->get();

            $what_component = "components.lease-details";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
                'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
            ])
            ->render();
        }
        elseif($request->get('active_subactivity') == 'Create LOI to Renew'){

            $program_renewal = \DB::table('program_renewal')
                                ->select('site_address', 'lessor', 'expiration')
                                ->where('sam_id', $request->get('active_sam_id'))
                                ->first();

            $what_component = "components.loi-maker";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
                'program_renewal' => $program_renewal,
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'Savings Computation'){

            $what_component = "components.savings-computation";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'Create Lease Renewal Notice'){

            $what_component = "components.lease-renewal-notice";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'Schedule of Rental Payment'){

            $what_component = "components.renewal-schedule-of-rental-payment";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
            ])
            ->render();

        }
        elseif($request->get('active_subactivity') == 'Get Send Approved LOI' || $request->get('active_subactivity') == 'Get Send Approved LRN'){

            if ($request->get('active_subactivity') == 'Get Send Approved LOI') {
                $what_component = "components.get-send-approved-loi";

                $files = SubActivityValue::select('value')
                                ->where('sub_activity_id', 423)
                                ->where('sam_id', $request->get('active_sam_id'))
                                ->first();

            } else if ($request->get('active_subactivity') == 'Get Send Approved LRN') {
                $what_component = "components.get-send-approved-lrn";

                $files = SubActivityValue::select('value')
                                ->where('sub_activity_id', 424)
                                ->where('sam_id', $request->get('active_sam_id'))
                                ->first();
            }
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
                'files' => $files,
            ])
            ->render();

        }
        else {

            $what_component = "components.subactivity-doc-upload";
            return \View::make($what_component)
            ->with([
                'sub_activity' => $request->get('active_subactivity'),
                'sam_id' => $request->get('active_sam_id'),
                'sub_activity_id' => $request->get('sub_activity_id'),
                'program_id' => $request->get('program_id'),
                'site_category' => $request->get('site_category'),
                'activity_id' => $request->get('activity_id'),
            ])
            ->render();
        }

        /////////////////////////////////////////////////////////////

    }

    // public function modal_view_site_components($sam_id, $component)
    public function modal_view_site_components(Request $request)
    {
        try{

            if($request->get('component') == 'site-status'){

                $what_modal = "components.site-status";
                return \View::make($what_modal)
                        ->with([
                            'sam_id' => $request->get('sam_id'),
                            'site_name' => "test",
                        ])
                        ->render();

            }
            elseif($request->get('component') == 'agent-activities'){

                $what_modal = "components.agent-activity-list";
                return \View::make($what_modal)
                        ->render();

            }
            elseif($request->get('component') == 'agent-progress'){

                $what_modal = "components.site-progress";
                return \View::make($what_modal)
                        ->render();

            }
            elseif($request->get('component') == 'tab-content-activities'){

                $what_modal = "components.site-activities";
                return \View::make($what_modal)
                        ->with([
                            'sam_id' => $request->get('sam_id'),
                            // 'site_name' => "test",
                        ])
                        ->render();

            }
            elseif($request->get('component') == 'tab-content-files'){

                $what_modal = "components.site-files";
                return \View::make($what_modal)
                        ->with([
                            'sam_id' => $request->get('sam_id'),
                        ])
                        ->render();

            }
            elseif($request->get('component') == 'site-modal-site_fields'){

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

                $programs = \DB::table('site')
                                ->select('sam_id', 'program_id')
                                ->where('sam_id', $request->get('sam_id'))
                                ->first();

                // if ($programs->program_id == 3) {
                //     $table = 'program_coloc';
                // } else if ($programs->program_id == 4) {
                //     $table = 'program_ibs';
                // } else if ($programs->program_id == 2) {
                //     $table = 'program_ftth';
                // } else if ($programs->program_id == 1) {
                //     $table = 'program_newsites';
                // } else if ($programs->program_id == 5) {
                //     $table = 'program_mwan';
                // } else if ($programs->program_id == 8) {
                //     $table = 'program_renewal';
                // }

                $program_mappings = ProgramMapping::where('program_id', $programs->program_id)
                                                ->get();
                                                
                // $sites_data = \DB::table($table)
                //             ->where('sam_id', $sam_id)
                //             ->get();

                $what_modal = "components.site-fields";
                
                return \View::make($what_modal)
                        ->with([
                            'sam_id' => $request->get('sam_id'),
                            'program_id' => $programs->program_id,
                            // 'sitefields' => json_decode($sites[0]->site_fields),
                            // 'program_mapping' => $program_mappings,
                            // 'sites_data' => $sites_data,
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

            $pr_memo = \DB::table('pr_memo_site')
                            ->select('sam_id')
                            ->where('pr_memo_id', $request->input('generated_pr_memo'))
                            ->first();

            $site = \DB::table('view_site')
                    ->select('program_id', 'activity_name')
                    ->where('sam_id', $pr_memo->sam_id)
                    ->first();

            return \View::make($what_modal)
            ->with([
                'generated_pr_memo' => $request->input('generated_pr_memo'),
                'activity' => $site->activity_name,
                'program_id' => $site->program_id
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
            $site = \DB::table('view_site')
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

            $site = \DB::table('site_issue')
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

            $action_status = "resolve";

            $approvers = Issue::where('issue_id', $issue_id)->first();

            if ( is_null($approvers) ) {
                return response()->json(['error' => true, 'message' => "No data found."]);
            }

            $validators = json_decode($approvers->approvers)->validators;

            $approvers_collect = collect();
            $approvers_pending_collect = collect();

            foreach ($validators as $validator) {
                if ( $validator->profile_id == \Auth::user()->profile_id ) {
                    $new_array = array(
                        'profile_id' => $validator->profile_id,
                        'status' => $action_status,
                        'user_id' => \Auth::id(),
                        'approved_date' => Carbon::now()->toDateString(),
                    );

                    $approvers_collect->push($new_array);
                } else {
                    if ( isset($validator->user_id) ) {
                        $new_array = array(
                            'profile_id' => $validator->profile_id,
                            'status' => $action_status == "rejected" ? "rejected" : $validator->status,
                            'user_id' => $validator->user_id,
                            'approved_date' => $validator->approved_date,
                        );
                    } else {
                        $new_array = array(
                            'profile_id' => $validator->profile_id,
                            'status' => $action_status == "rejected" ? "rejected" : $validator->status,
                        );
                        $approvers_pending_collect->push($validator->profile_id);
                    }

                    $approvers_collect->push($new_array);
                }
            }

            $array_data = [
                'active_profile' => isset($approvers_pending_collect->all()[0]) ? $approvers_pending_collect->all()[0] : "",
                'active_status' => count($approvers_pending_collect->all()) < 1 ? "resolved" : "active",
                'validator' => count($approvers_pending_collect->all()),
                'validators' => $approvers_collect->all()
            ];

            // if ( !is_null($approvers) ) {

            //     if ( count($approvers_pending_collect) < 1 ) {
            //         $current_status = $action_status == "rejected" ? "rejected" : "approved";

            //         $approvers->where('issue_id', $request->input('id'))
            //                 ->update([
            //                     'reason' => $action_status == "rejected" ? $request->input('reason') : null,
            //                     'status' => $current_status,
            //                 ]);
            //     } else {
            //         $current_status = $approvers->status;

            //         $approvers->where('issue_id', $request->input('id'))
            //                 ->update([
            //                     'reason' => $action_status == "rejected" ? $request->input('reason') : null,
            //                 ]);
            //     }

            //     $approvers->update([
            //         'value' => json_encode($array_data),
            //         'status' => $current_status
            //     ]);

            // } else {
            //     return response()->json(['error' => true, 'message' => "No data found."]);
            // }

            $site = \DB::table('site_issue')
                            ->where('issue_id', $issue_id)
                            ->update([
                                'issue_status' => count($approvers_pending_collect->all()) < 1 ? "resolved" : "active",
                                'date_resolve' => count($approvers_pending_collect->all()) < 1 ? Carbon::now()->toDate() : NULL,
                                'approver_id' => \Auth::id(),
                                'approvers' => json_encode($array_data),
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

                // if ( $request->input('hidden_program_id') == 3 || $request->input('hidden_program_id') == 4 ) {
                    $stage_activities_approvers = \DB::table('stage_activities_approvers')
                                    ->where('stage_activities_id', 0)
                                    ->get();
    
                    if ( count($stage_activities_approvers) < 1 ) {
                        return response()->json(['error' => true, 'message' => "No approver found."]);
                    }

                    $approvers_collect = collect();

                    foreach ($stage_activities_approvers as $stage_activities_approver) {
                        $approvers_collect->push([
                            'profile_id' => $stage_activities_approver->approver_profile_id,
                            'status' => 'pending'
                        ]);
                    }

                    $array_data = [
                        'active_profile' => $stage_activities_approvers[0]->approver_profile_id,
                        'active_status' => 'pending',
                        'validator' => count($approvers_collect->all()),
                        'validators' => $approvers_collect->all()
                    ];
                // }
                $issue_type = Issue::create([
                    // 'issue_type_id' => $request->input('issue'),
                    'issue_type_id' => $request->input('issue_callout'),
                    'sam_id' => $request->input('hidden_sam_id'),
                    'start_date' => $request->input('start_date'),
                    'issue_details' => $request->input('issue_details'),
                    'issue_status' => "active",
                    'user_id' => \Auth::id(),
                    'approvers' => json_encode($array_data)
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

            $chat_data = Chat::select("chat.user_id", "chat.sam_id", "chat.comment", "profiles.profile", "profiles.profile", "users.name", "user_details.image", "chat.created_at")
                    ->join('users', 'users.id', 'chat.user_id')
                    ->join('user_details', 'user_details.user_id', 'users.id')
                    ->join('profiles', 'profiles.id', 'users.profile_id')
                    ->where('chat.id', $chat->id)
                    ->first();

            // $chat_data = Chat::select('users.name', 'profiles.profile', 'profiles.profile', 'chat.comment', 'chat.created_at', 'user_details.image')
            //                 ->join('users', 'users.id', 'chat.user_id')
            //                 ->join('profiles', 'profiles.id', 'users.profile_id')
            //                 ->join('user_details', 'user_details.user_id', 'users.id')
            //                 ->where('chat.id', $chat->id)
            //                 ->first();

            return response()->json(['error' => false, 'message' => "Successfully send a message.", "chat" => $chat_data ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function declare_rtb(Request $request)
    {
        try {
            $required_afi = "";
            if ($request->get('program_id') == 2) {
                $required_afi = "required";
            }

            $validate = \Validator::make($request->all(), array(
                'rtb_declaration_date' => 'required',
                // 'rtb_declaration' => 'required',
                'afi_lines' => $required_afi,
                'afi_type' => $required_afi,
                'solution' => $required_afi,
            ));

            if ($validate->passes()){

                if ($request->get('program_id') == 2 && $request->get('afi_type') == "Partial") {
                    // \DB::table('program_ftth')
                    //     ->where('sam_id', $request->input('sam_id'))
                    //     ->update([
                    //         'afi_lines' => $request->input('afi_lines')
                    //     ]);
                    
                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'status' => "pending",
                        'type' => "rtb_declaration_partial",
                    ]);

                    return response()->json(['error' => false, 'message' => "Successfully declared partial RTB."]);
                } else if ($request->get('program_id') == 2 && $request->get('afi_type') == "Full") {

                    $rtb_values = SubActivityValue::select('value')
                                    ->where('sam_id', $request->input('sam_id'))
                                    ->where('user_id', \Auth::id())
                                    ->where('status', "pending")
                                    ->where('type', "rtb_declaration_partial")
                                    ->get();

                    $collect_value = collect();

                    foreach ( $rtb_values as $rtb_value ) {
                        $json_value = json_decode($rtb_value->value);
                        $collect_value->push($json_value->afi_lines);
                    }

                    $collect_value->push($request->input('afi_lines'));

                    $sum_afi_lines = array_sum($collect_value->all());

                    $array_data = [
                        "activity_id" => $request->get('activity_id'),
                        "activity_name" => $request->get('activity_name'),
                        "afi_lines" => $sum_afi_lines,
                        "afi_type" => $request->get('afi_type'),
                        "program_id" => $request->get('program_id'),
                        "rtb_declaration_date" => $request->get('rtb_declaration_date'),
                        "sam_id" => $request->get('sam_id'),
                        "solution" => $request->get('solution'),
                        "site_category" => $request->get('site_category'),
                    ];

                    SubActivityValue::select('value')
                            ->where('sam_id', $request->input('sam_id'))
                            ->where('user_id', \Auth::id())
                            ->where('status', "pending")
                            ->where('type', "rtb_declaration_partial")
                            ->update([
                                'status' => 'approved',
                                'reason' => 'AFI Lines submitted in full.',
                            ]);

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($array_data),
                        'user_id' => \Auth::id(),
                        'status' => "pending",
                        'type' => "rtb_declaration",
                    ]);

                    $asd = $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", $request->input('site_category'), $request->input('activity_id'));

                    return response()->json(['error' => false, 'message' => "Successfully declared RTB."]);
                }

                
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
            $required_solution = "";
            if ($request->input('action') == "false" ) {
                $required = "required";
            }

            if ( $request->input('program_id') == 2 ) {
                $required_solution = "required";
            }

            $validate = \Validator::make($request->all(), array(
                'remarks' => $required,
                'solution' => $required_solution,
            ));

            if ($validate->passes()) {

                if ( $request->input('action') == "true" && $request->input('program_id') == 2 ) {
                    \DB::table('program_ftth')
                        ->where('sam_id', $request->input('sam_id'))
                        ->update([
                            'afi_lines' => $request->input('afi_lines'),
                            'solution' => $request->input('solution'),
                        ]);
                } else if ( $request->input('action') == "false" && $request->input('program_id') == 2 ) {
                    $rtb = SubActivityValue::where('sam_id', $request->input('sam_id'))
                                ->where('type', "rtb_declaration_partial")
                                ->update([
                                    'status'=> $request->input('action') == "false" ? "denied" : "approved",
                                    'reason'=> $request->input('remarks'),
                                    'approver_id'=> \Auth::id(),
                                    'date_approved'=> Carbon::now()->toDate(),
                                ]);
                }

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
                                })
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
                                ->addColumn('contact_no', function($row){
                                    json_decode($row->value);
                                    if (json_last_error() == JSON_ERROR_NONE){
                                        $json = json_decode($row->value, true);

                                        return $json['contact_no'];
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

            $email_required = '';

            if ($request->input("lessor_method") == 'Email') {
                $email_required = ["required", "email"];
            }

            $validate = Validator::make($request->all(), array(
                "lessor_approval" => "required",
                "lessor_remarks" => "required",
                "lessor_remarks" => "required",
                "email" => $email_required,
                "name" => "required",
                "contact_no" => "required"
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
                // return response()->json(['error' => true, 'message' => $request->input('lessor_approval') == "approved" && !in_array($request->input("sub_activity_id"), [213, 255]) ]);

                if ( $request->input('lessor_approval') == "approved" && !in_array($request->input("sub_activity_id"), [213, 255]) ) {
                    $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", $request->input('site_category'), $request->input('activity_id'));
                } else if (
                    $request->input('lessor_approval') == "approved" && 
                    in_array($request->input("sub_activity_id"), [213, 255])
                    ) {
                    $datas = \DB::table('sub_activity')
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

                    $sub_activity_values = \DB::table('sub_activity_value')
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
            $site_users = \DB::table('site_users')
                            ->get();

            $vendor = UserDetail::select('user_details.vendor_id')
                                            ->where('user_id', \Auth::id())
                                            ->first();

            if (\Auth::user()->profile_id == 1) {
                $profile_id = 3;
            } else {
                $profile_id = 2;
            }

            if (isset($vendor->vendor_id)) {

                if (\Auth::user()->profile_id == 3) {
                    $agents = \DB::table('users')
                            ->select('users.*', \DB::raw('(SELECT COUNT(*) FROM site_users WHERE site_users.agent_id = users.id) as user_id_count'))
                            ->join('user_details', 'user_details.user_id', 'users.id')
                            ->join('user_programs', 'user_programs.user_id', 'users.id')
                            ->where('users.profile_id', $profile_id)
                            ->where('user_programs.program_id', $program_id)
                            ->where('user_details.vendor_id', $vendor->vendor_id)
                            ->where('user_details.IS_id', \Auth::id())
                            ->get();
                } else {
                    $agents = \DB::table('users')
                            ->select('users.*', \DB::raw('(SELECT COUNT(*) FROM site_users WHERE site_users.agent_id = users.id) as user_id_count'))
                            ->join('user_details', 'user_details.user_id', 'users.id')
                            ->join('user_programs', 'user_programs.user_id', 'users.id')
                            ->where('users.profile_id', $profile_id)
                            ->where('user_programs.program_id', $program_id)
                            ->where('user_details.vendor_id', $vendor->vendor_id)
                            ->get();
                }
                            
            } else {
                $agents = \DB::table('users')
                            ->select('users.*', \DB::raw('(SELECT COUNT(*) FROM site_users WHERE site_users.agent_id = users.id) as user_id_count'))
                            ->join('user_details', 'user_details.user_id', 'users.id')
                            ->join('user_programs', 'user_programs.user_id', 'users.id')
                            ->where('users.profile_id', $profile_id)
                            ->where('user_programs.program_id', $program_id)
                            ->get();
            }

            return response()->json(['error' => false, 'message' => $agents ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function agent_based_program($program_id)
    {
        try {
            $agents = \DB::table('users')
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
                                        ->where('type', 'doc_upload')
                                        ->get();

            $dt = DataTables::of($sub_activity_ids)
                                ->addColumn('value', function($row) {
                                    $json = json_decode($row->value, true);

                                    return $json['file'];
                                })
                                ->addColumn('is_temp', function($row) {
                                    $json = json_decode($row->value, true);

                                    if ( isset($json['is_temp']) ) {
                                        return $json['is_temp'];
                                    }

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
                                if (\Auth::user()->profile_id == 3 || \Auth::user()->profile_id == 28 || \Auth::user()->profile_id == 8 || \Auth::user()->profile_id == 31 || \Auth::user()->profile_id == 37 || \Auth::user()->profile_id == 29 || \Auth::user()->profile_id == 32 || \Auth::user()->profile_id == 42 || \Auth::user()->profile_id == 6) {
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
                                                        return ucfirst($json['validators'][$i]['status']);
                                                    }
                                                }
                                            } else {
                                                return $row->status;
                                            }
                    
                                        } else {
                                            return $row->value;
                                        }

                                    });
                                } else if (\Auth::user()->profile_id == 2 || \Auth::user()->profile_id == 9 || \Auth::user()->profile_id == 38) {
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
                    
                                            return isset($json['status']) ? ucfirst($json['status']) : ucfirst($row->status);
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

            $get_category = \DB::table("site")
                                ->select('site_category')
                                ->where("sam_id", $request->input("sam_id"))
                                ->first();

            $activities = \DB::table('stage_activities')
                    ->select('next_activity')
                    ->where('activity_id', $request->input("activity_id")[0])
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

            \DB::table("site")
                ->where("sam_id", $request->input("sam_id"))
                ->update([
                    'site_category' => $request->input('site_category'),
                ]);

            $get_next_activities = \DB::table('stage_activities')
                        ->select('activity_name', 'profile_id', 'stage_id')
                        ->where('activity_id', $activities->next_activity)
                        ->where('program_id', $request->input('program_id'))
                        ->where('category', $request->input('site_category'))
                        ->first();

            if (!is_null($get_next_activities)) {
                $get_program_stages = \DB::table('program_stages')
                                        ->select('stage_name')
                                        ->where('stage_id', $get_next_activities->stage_id)
                                        ->where('program_id', $request->input('program_id'))
                                        ->first();
            }
                        
            $array = array(
                'stage_id' => !is_null($get_next_activities) ? $get_next_activities->stage_id : "",
                'stage_name' => !is_null($get_program_stages) ? $get_program_stages->stage_name : "",
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

    public function tag_artb(Request $request)
    {
        try {
            
            $files_pending_check = \DB::table('sub_activity')
                                        ->select('sub_activity_id')
                                        ->where('category', $request->get('site_category'))
                                        ->where('program_id', $request->get('program_id'))
                                        ->where('activity_id', $request->get('activity_id'))
                                        ->where('requirements', 'required')
                                        ->get();

            $sub_activity_id_array = $files_pending_check->pluck('sub_activity_id');

            $sub_activity_value_check = \DB::table('sub_activity_value')
                                        ->select('sub_activity_id')
                                        ->where('sam_id', $request->get('sam_id'))
                                        ->where('status', '!=', 'rejected')
                                        ->whereIn('sub_activity_id', $sub_activity_id_array)
                                        ->get()
                                        ->groupBy('sub_activity_id');

            if ( count($files_pending_check) - 1 != count($sub_activity_value_check) ) {
                $count_required_files = count($files_pending_check) - 1;
                return response()->json(['error' => true, 'message' => "Your file is not enough for ARTB. ".$count_required_files." files are required." ]);
            } else {

                $sub_activity_value_pending_check = \DB::table('sub_activity_value')
                                        ->select('sub_activity_id')
                                        ->where('sam_id', $request->get('sam_id'))
                                        ->where('status', 'pending')
                                        ->whereIn('sub_activity_id', $sub_activity_id_array)
                                        ->get()
                                        ->groupBy('sub_activity_id');

                if ( count($sub_activity_value_pending_check) > 0 ) {
                    return response()->json(['error' => true, 'message' => "All files should validate before proceeding to ARTB." ]);
                } else {

                    $array_data = array(
                        'artb' => 'yes',
                        'artb_date' => Carbon::now()->toDateString()
                    );
                
                    SubActivityValue::create([
                        'sam_id' => $request->input('sam_id'),
                        'type' => 'artb_declaration',
                        'status' => 'pending',
                        'user_id' => \Auth::id(),
                        'value' => json_encode($array_data)
                    ]);

                    $profile_id = \Auth::user()->profile_id;
                    $id = \Auth::id();

                    $get_category = \DB::table("site")
                                        ->select('site_category')
                                        ->where("sam_id", $request->input("sam_id"))
                                        ->first();

                    $activities = \DB::table('stage_activities')
                            ->select('next_activity')
                            ->where('activity_id', $request->input("activity_id"))
                            ->where('program_id', $request->input('program_id'))
                            ->where('category', $get_category->site_category)
                            ->first();

                    SiteStageTracking::where('sam_id', $request->input('sam_id'))
                                    ->where('activity_complete', 'false')
                                    ->where('activity_id', $request->input("activity_id"))
                                    ->update([
                                        'activity_complete' => "true"
                                    ]);

                    SiteStageTracking::create([
                        'sam_id' => $request->input('sam_id'),
                        'activity_id' => $activities->next_activity,
                        'activity_complete' => 'false',
                        'user_id' => \Auth::id()
                    ]);

                    \DB::table("site")
                        ->where("sam_id", $request->input("sam_id"))
                        ->update([
                            'site_category' => $request->input('site_category'),
                        ]);

                    $get_next_activities = \DB::table('stage_activities')
                                ->select('activity_name', 'profile_id', 'stage_id')
                                ->where('activity_id', $activities->next_activity)
                                ->where('program_id', $request->input('program_id'))
                                ->where('category', $request->input('site_category'))
                                ->first();

                    if (!is_null($get_next_activities)) {
                        $get_program_stages = \DB::table('program_stages')
                                                ->select('stage_name')
                                                ->where('stage_id', $get_next_activities->stage_id)
                                                ->where('program_id', $request->input('program_id'))
                                                ->first();
                    }
                                
                    $array = array(
                        'stage_id' => !is_null($get_next_activities) ? $get_next_activities->stage_id : "",
                        'stage_name' => !is_null($get_program_stages) ? $get_program_stages->stage_name : "",
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
                }
            }

            return response()->json(['error' => false, 'message' => "Successfully tagged a site for ARTB."]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_user_data (Request $request)
    {
        // $user_id, $vendor_id, $is

        // $request->get('is')
        try {
            $user_detail = \Auth::user()->getUserDetail()->first();
            $vendor_program = VendorProgram::join('program', 'program.program_id', 'vendor_programs.programs')
                                                ->where('vendor_programs.vendors_id', $user_detail->vendor_id)
                                                ->get();

                                                
            $user_detail_agent = UserDetail::select('users.firstname', 'users.lastname', 'users.id', 'users.profile_id')
                                    ->join('users', 'users.id', 'user_details.user_id')
                                    ->where('user_details.user_id', $request->get('user_id'))->first();

            $user_data = UserProgram::select('program_id')->where('user_id', $request->get('user_id'))->get();

            $user_areas_data = UsersArea::select('region')->where('user_id', $request->get('user_id'))->get();

            $supervisor = User::select('users.name', 'users.id')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
                                    ->where('vendor_id', $user_detail->vendor_id)
                                    ->where('user_details.user_id', '!=', $request->get('user_id'))
                                    ->where('designation', 3)
                                    ->get();

            return response()->json(['error' => false, 'user_data' => $user_data, 'vendor_program' => $vendor_program, 'supervisor' => $supervisor, 'user_detail' => $user_detail_agent, 'user_areas_data' => $user_areas_data ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function update_user_data(Request $request)
    {
        try {

            $required = "";

            // if ($request->get("profile") == 2) {
            //     $required = "required";
            // }

            $validate = \Validator::make($request->all(), array(
                'region' => 'required',
                'program' => 'required',
            ));

            if ($validate->passes()) {
            //     $asd = UsersArea::where('user_id', $request->input('user_id'))->get();
            // return response()->json(['error' => true, 'message' => $asd]);
            UserProgram::where('user_id', $request->input('user_id'))
                                                ->delete();

                for ($i=0; $i < count($request->input('program')); $i++) {
                    $active = $i == 0 ? 1 : 0;
                    $user_programs = new UserProgram();
                    $user_programs->user_id = $request->input('user_id');
                    $user_programs->program_id = $request->input('program')[$i];
                    $user_programs->active = $active;
                    $user_programs->save();

                    // UserProgram::create([
                    //     'user_id' => $request->input('user_id'),
                    //     'program_id' => $request->input('program')[$i],
                    //     'active' => $active,
                    // ]);
                }

                UsersArea::where('user_id', $request->input('user_id'))
                                                    ->delete();

                for ($i=0; $i < count($request->input('region')); $i++) {

                    $user_programs = new UsersArea();
                    $user_programs->user_id = $request->input('user_id');
                    $user_programs->region = $request->input('region')[$i];
                    $user_programs->save();

                    // UsersArea::create([
                    //     'user_id' => $request->input('user_id'),
                    //     'region' => $request->input('region')[$i],
                    // ]);
                }

                User::where('id', $request->input('user_id'))
                    ->update([
                        'profile_id' => $request->input('profile')
                    ]);

                $supervisor = UserDetail::where('user_id', $request->input('user_id'))
                                        ->update([
                                            'IS_id' => $request->input('profile') == 3 ? NULL : $request->input('is_id'),
                                            'designation' => $request->input('profile')
                                        ]);

                return response()->json(['error' => false, 'message' => "Successfully updated data." ]);

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_supervisor ($user_id, $vendor_id)
    {
        try {
            
            $user_detail = \Auth::user()->getUserDetail()->first();

            $supervisor = User::select('users.*')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
                                    ->where('vendor_id', $vendor_id)
                                    ->where('designation', 3)
                                    ->get();

            return response()->json(['error' => false, 'supervisor' => $supervisor, 'user_detail' => $user_detail ]);
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
            $issue_remakrs = \DB::table('site_issue_remarks')
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
            // $substeps = \DB::table('sub_activity_step')->where('sub_activity_id', $sub_activity_id)->get();
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

                $collect_fsa_data = collect();

                $sites_data = \DB::table('site')
                            ->where('sam_id', $sam_id[$i])
                            ->first();

                $fsa_data_lgu = \DB::table('fsaq')
                        ->where('vendor_id', $vendor)
                        ->where('lgu_id', $sites_data->site_lgu_id)

                        ->where('fsaq.site_type', "EASY")
                        ->where('fsaq.account_type', "BAU")

                        ->get();

                if ( count($fsa_data_lgu) < 1 ) {
                    $fsa_data_province = \DB::table('fsaq')
                            ->where('vendor_id', $vendor)
                            ->where('province_id', $sites_data->site_province_id)
                            ->whereNull('lgu_id')

                            ->where('fsaq.site_type', "EASY")
                            ->where('fsaq.account_type', "BAU")

                            ->get();
                    if ( count($fsa_data_province) < 1 ) {
                        $fsa_data_region = \DB::table('fsaq')
                                ->where('vendor_id', $vendor)
                                ->where('region_id', $sites_data->site_region_id)
                                ->whereNull('province_id')
                                ->whereNull('lgu_id')

                                ->where('fsaq.site_type', "EASY")
                                ->where('fsaq.account_type', "BAU")
    
                                ->get();

                        if ( count($fsa_data_region) < 1 ) {
                            return response()->json(['error' => true, 'message' => "No FSAQ data."]);
                        } else {
                            $fsa_data = $fsa_data_region;
                        }

                    } else {
                        $fsa_data = $fsa_data_province;
                    }
                } else {
                    $fsa_data = $fsa_data_lgu;
                }

                foreach ($fsa_data as $fsaq) {
                    $collect_fsa_data->push($fsaq->fsaq_id);
                }

                $line_items_include = FsaLineItem::where('site_line_items.sam_id', $sam_id[$i])
                                                ->where('site_line_items.status', '!=', 'denied')
                                                ->whereNotIn('site_line_items.fsa_id', $collect_fsa_data->all())
                                                ->where('site_line_items.user_id', \Auth::id())
                                                ->delete();
                                                // return response()->json(['error' => true, 'message' => $collect_fsa_data]);

                $fsa_line_items = FsaLineItem::where('sam_id', $sam_id[$i])
                                        ->where('status', '=', 'pending')
                                        ->where('site_line_items.user_id', \Auth::id())
                                        ->get();
            
                // if (count($fsa_line_items) > 0) {
                //     FsaLineItem::where('sam_id', $sam_id[$i])
                //                     ->where('status', 'pending')
                //                     ->where('is_include', '0')
                //                     ->delete();
                // }

                $line_items = FsaLineItem::join('fsaq', 'fsaq.fsaq_id', 'site_line_items.fsa_id')
                                ->where('site_line_items.sam_id', $sam_id[$i])
                                ->where('site_line_items.status', '!=', 'denied')
                                ->where('site_line_items.user_id', \Auth::id())

                                ->where('fsaq.site_type', "EASY")
                                ->where('fsaq.account_type', "BAU")
    
                                ->get();
                
                if (count($line_items) > 0) {

                } else {

                    // GET PENDING FSA LINE ITEMS
                    $fsa_line_items = FsaLineItem::where('sam_id', $sam_id[$i])->where('status', '=', 'pending')->get();

                    // CLEANUP PENDING
                    if (count($fsa_line_items) > 0) {
                        FsaLineItem::where('sam_id', $sam_id[$i])
                                        ->where('status', 'pending')
                                        ->where('user_id', \Auth::id())
                                        ->delete();
                    }

                    foreach ($fsa_data as $fsa) {
                        FsaLineItem::create([
                            'sam_id' => $sam_id[$i],
                            'fsa_id' => $fsa->fsaq_id,
                            'user_id' => \Auth::id(),
                            'status' => 'pending',
                        ]);
                    }

                }

                $sites = FsaLineItem::select('site.site_name', 'site.site_address', 'site.sam_id', 'location_regions.region_name', 'location_provinces.province_name', 'fsaq.amount')
                            ->leftjoin('site', 'site.sam_id', 'site_line_items.sam_id')
                            ->leftjoin('fsaq', 'fsaq.fsaq_id', 'site_line_items.fsa_id')
                            ->leftjoin('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->leftjoin('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->leftjoin('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.sam_id', $sam_id[$i])
                            ->where('site_line_items.status', '!=', 'denied')
                            ->where('site_line_items.is_include', 1)
                            ->where('site_line_items.user_id', \Auth::id())

                            ->where('fsaq.site_type', "EASY")
                            ->where('fsaq.account_type', "BAU")

                            ->get();


                if (count($sites) > 1) {
                    $sites_collect->push($sites);
                }

                $pricings = FsaLineItem::select('fsaq.amount')
                            ->join('fsaq', 'fsaq.fsaq_id', 'site_line_items.fsa_id')
                            ->where('site_line_items.status', '!=', 'denied')
                            ->where('site_line_items.is_include', 1)
                            ->where('site_line_items.sam_id', '=', $sam_id[$i])
                            ->where('site_line_items.user_id', \Auth::id())

                            ->where('fsaq.site_type', "EASY")
                            ->where('fsaq.account_type', "BAU")

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
            FsaLineItem::where('sam_id', $sam_id)
                        ->where('site_line_items.user_id', \Auth::id())
                        ->delete();

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_line_items($sam_id, $vendor)
    {
        try {
                $line_items = FsaLineItem::join('fsaq', 'fsaq.fsaq_id', 'site_line_items.fsa_id')
                                            ->where('site_line_items.sam_id', $sam_id)
                                            ->where('site_line_items.status', '!=', 'denied')
                                            ->where('site_line_items.user_id', \Auth::id())

                                            ->where('fsaq.site_type', "EASY")
                                            ->where('fsaq.account_type', "BAU")

                                            ->get();

                return response()->json([ 'error' => false, 'message' => $line_items->groupBy('category') ]);


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
                        ->where('user_id', \Auth::id())
                        ->update([
                            'is_include' => 0
                        ]);

            FsaLineItem::where('sam_id', $request->input('sam_id'))
                        ->whereIn('fsa_id', $request->input('line_item_id'))
                        ->where('status', '!=', 'denied')
                        ->where('user_id', \Auth::id())
                        ->update([
                            'is_include' => 1
                        ]);

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

                $sites = \DB::table('site')
                                ->select('site_line_items.fsa_id', 'site.site_name', 'site.site_address', 'site.sam_id', 'location_regions.region_name', 'location_provinces.province_name', 'fsaq.amount')
                                ->leftjoin('site_line_items', 'site_line_items.sam_id', 'site.sam_id')
                                ->leftjoin('fsaq', 'fsaq.fsaq_id', 'site_line_items.fsa_id')
                                ->leftjoin('location_regions', 'location_regions.region_id', 'site.site_region_id')
                                ->leftjoin('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                                ->whereIn('site.sam_id', $request->input("sam_id"))
                                ->where('site_line_items.status', '!=', 'denied')
                                ->where('site_line_items.is_include', 1)
                                ->where('site_line_items.user_id', \Auth::id())
    
                                ->where('fsaq.site_type', "EASY")
                                ->where('fsaq.account_type', "BAU")
    
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

                    \DB::table("site")
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

                    $activities = \DB::table('stage_activities')
                                                ->select('next_activity', 'activity_name', 'return_activity')
                                                ->where('activity_id', $request->input("activity_id"))
                                                ->where('program_id', $request->input("program_id"))
                                                ->where('category', $request->input("site_category"))
                                                ->first();

                    $get_activitiess = \DB::table('stage_activities')
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

            // $vendors = \DB::table("vendor")
            //                     ->select("vendor.vendor_sec_reg_name", "vendor.vendor_id", "vendor.vendor_acronym")
            //                     ->join("vendor_programs", "vendor_programs.vendors_id", "vendor.vendor_id")
            //                     ->where("vendor_programs.programs", 1)
            //                     ->orderBy('vendor_sec_reg_name', 'ASC')
            //                     ->get();

            $vendors = \DB::table("fsaq")
                                // ->distinct("fsaq.vendor_id")
                                ->select("vendor.vendor_sec_reg_name", "vendor.vendor_id", "vendor.vendor_acronym")
                                ->join("vendor", "vendor.vendor_id", "fsaq.vendor_id")
                                // ->join("vendor_programs", "vendor_programs.vendors_id", "vendor.vendor_id")
                                ->distinct("fsaq.vendor_id")
                                // ->where("vendor_programs.programs", 1)
                                ->orderBy('vendor.vendor_sec_reg_name', 'ASC')
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

            $sites = \DB::table('new_sites')
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

    // public function reject_site (Request $request)
    // {
    //     try {
    //         $validate = \Validator::make($request->all(), array(
    //             'remarks' => 'required'
    //         ));

    //         if ($validate->passes()) {
    //             SubActivityValue::create([
    //                 'sam_id' => $request->input("sam_id"),
    //                 'value' => json_encode($request->all()),
    //                 'user_id' => \Auth::id(),
    //                 'type' => $request->input("type"),
    //                 'status' => "denied",
    //             ]);

    //             return response()->json(['error' => false, 'message' => "Successfully rejected site." ]);
    //         } else {
    //             return response()->json([ 'error' => true, 'message' => $validate->errors() ]);
    //         }
    //     } catch (\Throwable $th) {
    //         Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
    //         return response()->json(['error' => true, 'message' => $th->getMessage()]);
    //     }
    // }

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

                    FsaLineItem::where('sam_id', $site->sam_id)
                                ->where('status', '!=', 'rejected')
                                ->where('user_id', \Auth::id())
                                ->update([
                                    'status' => $request->input("data_action") == "false" ? "denied" : "approved"
                                ]);
                }

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
                'po_number' => 'required',
                'po_date' => 'required',
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
                    // SiteEndorsementEvent::dispatch($samid_collect[$i]);

                    SubActivityValue::where('sam_id', $samid_collect[$i])
                                    ->where('type', 'pr_po_details')
                                    ->update([
                                        'value' => json_encode($request->all())
                                    ]);
                    \DB::table("site")
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
                    // $new_endorsements = \DB::statement('call `a_update_data`("'.$site->sam_id.'", '.\Auth::user()->profile_id.', '.\Auth::id().', "'.$request->input("data_action").'")');
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
            $validate = \Validator::make($request->all(), array(
                'sam_id' => 'required',
            ));

            if ($validate->passes()) {
                for ($i=0; $i < count($request->input('sam_id')); $i++) {
                    // $activity = \DB::table('stage_activities')
                    //                         ->where('program_id', $request->input('data_program'))
                    //                         ->orderby('activity_id', 'desc')
                    //                         ->take(1)
                    //                         ->get();

                    SiteStageTracking::where('sam_id', $request->input('sam_id')[$i])
                                        ->update(['activity_complete' => 'true']);

                    SiteStageTracking::create([
                        'sam_id' => $request->input('sam_id')[$i],
                        // 'activity_id' => $activity[0]->activity_id,
                        'activity_id' => 29,
                        'activity_complete' => 'true',
                        'user_id' => \Auth::id(),
                    ]);
                }

                return response()->json(['error' => false, 'message' => "This ARTB site move to completed."]);

            } else {
                return response()->json(['error' => true, 'message' => "No data selected."]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_coloc_filter($site_type, $program, $technology)
    {
        try {

            $sites = \DB::table("view_site")
                            // ->where('program_id', $program_id)
                            ->where('profile_id', \Auth::user()->profile_id)
                            ->leftJoin('program_coloc', 'view_site.sam_id', 'program_coloc.sam_id')
                            ->select("view_site.*", "program_coloc.nomination_id", "program_coloc.pla_id", "program_coloc.highlevel_tech",  "program_coloc.technology", "program_coloc.site_type",                             
                            "program_coloc.gt_saq_milestone",  
                            "program_coloc.gt_saq_milestone_category");

            // $sites = \DB::table("view_sites_activity")
            //         ->select('site_name', 'sam_id', 'site_category', 'activity_id', 'program_id', 'site_endorsement_date', 'site_fields', 'id', 'site_vendor_id', 'activity_name', 'program_endorsement_date')
            //         ->where('program_id', $program)
            //         ->where('profile_id', \Auth::user()->profile_id);

            if($site_type != '-'){
                // $sites = $sites->whereJsonContains("site_fields", [
                //     "field_name" => 'site_type',
                //     "value" => $site_type,
                // ]);

                $sites->where('site_type', $site_type);
            } 
            
            if($program != '-') {
                // $sites = $sites->whereJsonContains("site_fields", [
                //     "field_name" => 'program',
                //     "value" => $program,
                // ]);

                $sites->where('program', $program);
            } 
            
            if($technology != '-') {
                // $sites = $sites->whereJsonContains("site_fields", [
                //     "field_name" => 'technology',
                //     "value" => $technology,
                // ]);

                $sites->where('technology', $technology);
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
            } else if ($program == 8) {
                $table = 'program_renewal';
            }
            
            $datas = \DB::table($table)
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
                $sites = \DB::table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->whereJsonContains('site.activities->activity_id', '2')
                            ->get();
            } else if ($value == 'RAM Head Approval') {
                $sites = \DB::table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->whereJsonContains('site.activities->activity_id', '3')
                            ->get();
            } else if ($value == 'NAM Approval') {
                $sites = \DB::table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->whereJsonContains('site.activities->activity_id', '4')
                            ->get();
            } else if ($value == 'Arriba PR No Issuance') {
                $sites = \DB::table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->whereJsonContains('site.activities->activity_id', '5')
                            ->get();
            } else if ($value == 'Vendor Awarding') {
                $sites = \DB::table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->whereJsonContains('site.activities->activity_id', '6')
                            ->get();
            } else if ($value == 'Completed') {
                $sites = \DB::table('site')
                            ->select('site.site_name', 'location_regions.region_name', 'location_provinces.province_name', 'location_lgus.lgu_name')
                            ->join('location_regions', 'location_regions.region_id', 'site.site_region_id')
                            ->join('location_provinces', 'location_provinces.province_id', 'site.site_province_id')
                            ->join('location_lgus', 'location_lgus.lgu_id', 'site.site_lgu_id')
                            ->where('site.program_id', 1)
                            ->whereJsonContains('site.activities->activity_id', '7')
                            ->get();
            } else if ($value == 'Total Sites') {
                $sites = \DB::table('site')
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

    // public function get_site_candidate ($sam_id, $status)
    public function get_site_candidate (Request $request)
    {
        try {
            $sam_id = $request->get('sam_id');
            $datas = SubActivityValue::where('sam_id', $request->get('sam_id'));

            if ($request->get('status') == "jtss_schedule_site") {
                $datas->where('type', 'jtss_schedule_site')
                        ->where('status', 'pending');
            } else if ( $request->get('status') == 'rejected_schedule' ) {
                $datas->where('type', 'jtss_schedule_site')
                        ->where('status', 'rejected');
            } else if ( $request->get('status') == 'rejected' ) {
                $datas->where('type', 'jtss_add_site')
                        ->where('status', $request->get('status'));
            } else if ( $request->get('status') == 'jtss_ssds' ) {
                $datas->where('type', 'jtss_ssds')
                        ->where('type', $request->get('status'))
                        ->where('status', 'Done');
            } else if ( $request->get('status') == 'jtss_ssds_ranking' ) {
                $datas->where('type', 'jtss_ssds')
                        ->where('type', 'jtss_ssds');
            } else if ( $request->get('status') == 'assds_lease_rate' ) {
                $datas->where('type', 'jtss_ssds')
                        ->where('type', 'jtss_ssds');
            } else if ( $request->get('status') == 'jtss_schedule_site_approved' ) {
                $datas->where('type', 'jtss_ranking')
                        ->where('status', 'pending');
            } else if ( $request->get('status') == 'jtss_approved' ) {
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

                if ($request->get('status') == "jtss_schedule_site") {
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
                } else if ($request->get('status') == "jtss_schedule_site_approved") {
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
                } else if ($request->get('status') == "jtss_approved") {
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
                } else if ($request->get('status') == "rejected_schedule") {
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
                } else if ($request->get('status') == "jtss_ssds") {
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
                } else if ($request->get('status') == "pending") {
                    $dt->addColumn('status', function($row){
                        if ($row->status == 'pending') {
                            return '<span class="badge badge-secondary">Not Yet Scheduled</span>';
                        } else {
                            return '<span class="badge badge-success">Scheduled</span>';
                        }
                    });
                } else if ($request->get('status') == "jtss_ssds_ranking") {
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
                            "demolition_of_existing_structure" => $new_json['demolition_of_existing_structure'],
                            "region_new" => $new_json['region_new'],
                            "province_new" => $new_json['province_new'],
                            "lgu_new" => $new_json['lgu_new']
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

    public function get_jtss_schedule(Request $request)
    {
        try {
            $id = $request->get('id');
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

            $location_regions = \DB::table('location_regions')
                                        ->select('region_name')
                                        ->where('region_id', $json_new->region)
                                        ->first();

            $location_provinces = \DB::table('location_provinces')
                                        ->select('province_name')
                                        ->where('province_id', $json_new->province)
                                        ->first();

            $location_lgus = \DB::table('location_lgus')
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
                    $jtss_approved = SubActivityValue::create([
                        'sam_id' => $request->get('sam_id'),
                        'sub_activity_id' => $request->get('sub_activity_id'),
                        'type' => 'jtss_approved',
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'status' => 'pending',
                    ]);

                    if ($request->get('assds') == 'yes') {
                        SubActivityValue::where('id', $jtss_approved->id)
                                            ->update([
                                                'value' => json_encode($request->all()),
                                                'status' => 'pending'
                                            ]);
                    } else {
                        SubActivityValue::where('id', $jtss_approved->id)
                                            ->update([
                                                'value' => json_encode($request->all()),
                                                'status' => 'rejected'
                                            ]);
                    }

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
            $data = \DB::table('view_DAR_dashboard')->skip(0)->take(100)
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

    // public function get_new_clp_site ($vendor_id)
    public function get_new_clp_site (Request $request)
    {
        try {
            // $sites = \DB::select('call `get_fsaq`("'.$vendor_id.'")');
            $vendor = $request->get('vendor_id');
            // $regions = \DB::table('fsaq')
            //                 ->select('region_id')
            //                 ->where('vendor_id', $request->get('vendor_id'))
            //                 ->whereNull('province_id')
            //                 ->whereNull('lgu_id')
            //                 ->distinct()
            //                 ->get()
            //                 ->pluck('region_id');

            // $provinces = \DB::table('fsaq')
            //                 ->select('province_id')
            //                 ->where('vendor_id', $request->get('vendor_id'))
            //                 ->whereNotNull('region_id')
            //                 ->whereNotNull('province_id')
            //                 ->whereNull('lgu_id')
            //                 ->distinct()
            //                 ->get()
            //                 ->pluck('province_id');

            // $lgus = \DB::table('fsaq')
            //                 ->select('lgu_id')
            //                 ->whereNotNull('region_id')
            //                 ->whereNotNull('province_id')
            //                 ->whereNotNull('lgu_id')
            //                 ->where('vendor_id', $request->get('vendor_id'))
            //                 ->distinct()
            //                 ->get()
            //                 ->pluck('lgu_id');

            $sites = \DB::table('view_site')
                        ->select('sam_id', 'site_name')
                        // ->whereIn('lgu_id', $lgus)
                        // ->whereIn('province_id', $provinces)
                        // ->whereIn('region_id', $regions)
                        ->where(function ($query) use ($vendor) {
                            $regions = \DB::table('fsaq')
                                    ->select('region_id')
                                    ->where('vendor_id', $vendor)
                                    ->distinct()
                                    ->get()
                                    ->pluck('region_id');

                            $provinces = \DB::table('fsaq')
                                            ->select('province_id')
                                            ->whereIn('region_id', $regions)
                                            ->where('vendor_id', $vendor)
                                            ->distinct()
                                            ->get()
                                            ->pluck('province_id');

                            $lgus = \DB::table('fsaq')
                                            ->select('lgu_id')
                                            ->whereIn('province_id', $provinces)
                                            ->where('vendor_id', $vendor)
                                            ->distinct()
                                            ->get()
                                            ->pluck('lgu_id');

                            $query->whereIn('lgu_id', $lgus)
                                ->orWhereIn('province_id', $provinces)
                                ->orWhereIn('region_id', $regions);
                        })
                        ->where('program_id', 1)
                        ->where('activity_id', 2)
                        ->get();

            return response()->json(['error' => false, 'message' => $sites ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    private function dar_check ($sam_id, $sub_activity_id)
    {
        $get_workplans = SubActivityValue::where('sam_id', $sam_id)
                                        // ->where('value->planned_date', Carbon::now()->toDateString())
                                        // ->where('value->method', $request->get('lessor_method'))
                                        ->where('sub_activity_id', $sub_activity_id)
                                        ->where('type', 'work_plan')
                                        ->where('status', 'pending')
                                        ->get();
                                   
        if ( count($get_workplans) > 0 ) {

            foreach ( $get_workplans as $get_workplan ) {
                
                $json = json_decode( $get_workplan->value );

                // if ( $json->planned_date == Carbon::now()->toDateString() || $json->planned_date >= Carbon::now()->toDateString() ) {
                    $get_workplan->update([
                        'status' => 'Done - Missed'
                    ]);
                // } else {
                //     $get_workplan->update([
                //         'status' => 'Delayed - Missed'
                //     ]);
                // }
            }
        }
    }

    public function get_form_generator_view (Request $request)
    {
        if($request->form_generator_type === "savings computation"){
            $what_component = "components.savings-computation-generator";
        }
        elseif($request->form_generator_type === "schedule of rental payment"){
            $what_component = "components.schedule-of-rental-payment-generator";
        }

        return \View::make($what_component)
        ->with($request->all())
        ->render();

    }

    public function get_form ($sub_activity_id, $form_name)
    {
        try {
            $form_data = \DB::table('program_fields_map')
                        ->join('program_fileds_map_profiles', 'program_fileds_map_profiles.program_fields_id', 'program_fields_map.program_fields_id')
                        ->where('program_fileds_map_profiles.sub_activity_id', $sub_activity_id)
                        ->where('program_fields_map.form_name', $form_name)
                        ->orderBy('program_fields_map.sort', 'asc')
                        ->get();

            $form = $this->create_form($form_data, $form_name);
              
            return response()->json(['error' => false, 'message' => $form ]);          

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    private function create_form ($form_datas, $form_name)
    {
        try {
            if ($form_name == "Create LOI to Renew"){
                $button_name = "Save LOI";
            } else if ($form_name == "Create PR") {
                $button_name = "Set PO";
            } else if ($form_name == "Create Lease Renewal Notice") {
                $button_name = "Create LRN";
            } else if ($form_name == "eLAS Renewal") {
                $button_name = "Save eLAS";
            } else if ($form_name == "Savings Computation") {
                // $button_name = "Generate Computation";
                $button_name = "Make Savings Computation";
            } else if ($form_name == "Schedule of Rental Payment") {
                $button_name = "Save Schedule of Rental Payment";
            } else if ($form_name == "Application of Payment") {
                $button_name = "Confirm Application of Payment";
            } else if ($form_name == "eLAS Approval") {
                $button_name = "Confirm eLAS Approval";
                $button_name2 = "Re-Negotiate eLAS";
            } else if ($form_name == "Commercial Negotiation") {
                $button_name = "Save Commercial Negotiation";
                $button_name2 = "Back Commercial Negotiation";
            } else if ($form_name == "Routing of LRN for SAM Head Signature") {
                $button_name = "Route eLAS";
                $button_name2 = "Re-Negotiate eLAS";
            } else {
                $button_name = "Save";
            }
            $fields = '<form class="'.str_replace(" ", "_", strtolower($form_name) ).'_form">';
            foreach ($form_datas as $form_data) {
                $read_only = isset($form_data->readonly) ? $form_data->readonly : "";
                $fields .= '<div class="row border-bottom mb-1 pb-1">';
                $fields .= '<div class="col-md-4"><label for="'.str_replace(" ", "_", strtolower($form_data->program_fields) ).'">' .$form_data->program_fields. '</label></div>';

                if ($form_data->type == 'selection') {
                    $fields .= '<div class="col-md-8">';
                    $fields .= '<select class="form-control" name="' .str_replace(" ", "_", strtolower($form_data->program_fields) ). '" id="' .str_replace(" ", "_", strtolower($form_data->program_fields) ). '" '.$read_only.'>';
                    $new_array = explode("(,)",$form_data->selection);
                    for ($i=0; $i < count($new_array); $i++) { 
                        $fields .= '<option value="'.$new_array[$i].'">'.$new_array[$i].'</option>';
                    }
                    $fields .= '</select>';
                    $fields .= '<small class="' .str_replace(" ", "_", strtolower($form_data->program_fields) ). '-error text-danger"></small>';
                    $fields .= '</div>';
                } else if ($form_data->type == 'textarea') {
                    $class_add = $form_data->type == "date" ? "flatpicker" : "";
                    $fields .= '<div class="col-md-8">';
                    $fields .= '<textarea type="'. $form_data->type. '" name="' .str_replace(" ", "_", strtolower($form_data->program_fields) ). '" id="' .str_replace(" ", "_", strtolower($form_data->program_fields) ). '" value="" class="'.$class_add.' form-control" '.$read_only.'></textarea>';
                    $fields .= '<small class="' .str_replace(" ", "_", strtolower($form_data->program_fields) ). '-error text-danger"></small>';
                    $fields .= '</div>';
                } else {
                    $class_add = $form_data->type == "date" ? "flatpicker" : "";
                    $fields .= '<div class="col-md-8">';
                    $fields .= '<input type="'. $form_data->type. '" name="' .str_replace(" ", "_", strtolower($form_data->program_fields) ). '" id="' .str_replace(" ", "_", strtolower($form_data->program_fields) ). '" value="" class="'.$class_add.' form-control" '.$read_only.'>';
                    $fields .= '<small class="' .str_replace(" ", "_", strtolower($form_data->program_fields) ). '-error text-danger"></small>';
                    $fields .= '</div>';
                }
                $fields .= '</div>';
            }
            // if ($form_name = "Vendor Awarding") {
                $fields .= '<div class="row mb-2">';
                $fields .= '<div class="col-12">';
                $fields .= '<button class="btn btn-lg btn-primary pull-right save_'.str_replace(" ", "_", strtolower($form_name) ).'_btn" id="save_'.str_replace(" ", "_", strtolower($form_name) ).'_btn" type="button" data-action="true">'.$button_name.'</button>';
                if ( isset($button_name2) ) {
                    $fields .= '<button class="btn btn-lg btn-secondary pull-right mr-1 cancel_'.str_replace(" ", "_", strtolower($form_name) ).'_btn" id="cancel_'.str_replace(" ", "_", strtolower($form_name) ).'_btn" type="button" data-action="false">'.$button_name2.'</button>';
                }
                $fields .= '</div></div>';
            // }

            return $fields .= "</form>";
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return $th->getMessage();
        }
    }

    public function get_form_fields (Request $request)
    {
        try {
            if ($request->get('program_id') == 3) {
                $table = 'program_coloc';
            } else if ($request->get('program_id') == 4) {
                $table = 'program_ibs';
            } else if ($request->get('program_id') == 8) {
                $table = 'program_renewal';
            } else if ($request->get('program_id') == 2) {
                $table = 'program_ftth';
            } else if ($request->get('program_id') == 1) {
                $table = 'program_newsites';
            }

            $form_fields = \DB::table($table)
                        ->where('sam_id', $request->get('sam_id'))
                        ->get();

            return response()->json(['error' => false, 'message' => $form_fields ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function get_form_program_data (Request $request)
    {
        try {
            
            if ( $request->get('program_id') == 8) {
                if ( $request->get('type') == "loi" ) {
                    $get_program_data = \DB::table('program_renewal')
                            ->where('sam_id', $request->get('sam_id'))
                            ->first();
                } else if ( $request->get('type') == "commercial_negotiation" ) {
                    $loi = SubActivityValue::where('sam_id', $request->get('sam_id') )
                                        ->where('status', 'approved')
                                        ->where('type', 'loi')
                                        ->first();
                    if ( is_null($loi) ) {
                        $get_program_data = \DB::table('program_renewal')
                                ->where('sam_id', $request->get('sam_id'))
                                ->first();
                    } else {
                        $get_program_data = json_decode($loi->value);
                    }
                } else if ( $request->get('type') == "lrn" ) {
                    $lessor_commercial_engagement = SubActivityValue::where('sam_id', $request->get('sam_id') )
                                        ->where('status', 'approved')
                                        ->where('type', 'lessor_commercial_engagement')
                                        ->first();
                    if ( is_null($lessor_commercial_engagement) ) {
                        $get_program_data = \DB::table('program_renewal')
                                ->where('sam_id', $request->get('sam_id'))
                                ->first();
                    } else {
                        $get_program_data = json_decode($lessor_commercial_engagement->value);
                    }
                } else if ( $request->get('type') == "savings_computation" ) {
                    $lrn = SubActivityValue::where('sam_id', $request->get('sam_id') )
                                        ->where('status', 'approved')
                                        ->where('type', 'lrn')
                                        ->first();
                    if ( is_null($lrn) ) {
                        $get_program_data = \DB::table('program_renewal')
                                ->where('sam_id', $request->get('sam_id'))
                                ->first();
                    } else {
                        $get_program_data = json_decode($lrn->value);
                    }
                } else {
                    $get_program_data = \DB::table('program_renewal')
                            ->where('sam_id', $request->get('sam_id'))
                            ->first();
                }
            }
            return response()->json(['error' => false, 'message' => $get_program_data ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function change_active_program (Request $request)
    {
        try {
            \DB::table('user_programs')
                    ->where('user_id', \Auth::id())
                    ->where('program_id', '!=', $request->get('program_id'))
                    ->update([
                        'active' => 0
                    ]);

            \DB::table('user_programs')
                    ->where('user_id', \Auth::id())
                    ->where('program_id', $request->get('program_id'))
                    ->update([
                        'active' => 1
                    ]);

            return redirect('/');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function get_user_details (Request $request)
    {
        try {
            $user_data = \DB::table('users')
            ->select('firstname', 'lastname', 'email')
                            ->where('id', $request->get('user_id'))
                            ->first();
                            
            $user_areas = \DB::table('users_areas')
                            ->select('region')
                            ->where('user_id', $request->get('user_id'))
                            ->get();
                            
            return response()->json(['error' => false, 'message' => $user_data, 'user_areas' => $user_areas ]);
            
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function update_agent_site (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'region' => 'required',
                // 'province' => 'required'
            ));

            if (!$validate->passes()) {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            } else {

                UsersArea::where('user_id', $request->get('user_id'))
                        ->delete();

                for ($i=0; $i < count($request->get('region')); $i++) {
                    UsersArea::create([
                        'user_id' => $request->input('user_id'),
                        'region' => $request->get('region')[$i],
                        'province' => '%',
                        'lgu' => '%',
                    ]);
                }
                return response()->json(['error' => false, 'message' => "Successfully assigned agent site."]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_link_old_data (Request $request)
    {
        try {
            $link_data = \DB::table('tbl_coloc_files_joined_mapping')
                            ->where('sam_id', $request->get('sam_id'))
                            ->where('sub_activity_id', $request->get('sub_activity_id'))
                            ->first();

            return response()->json(['error' => false, 'message' => $link_data]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

}

