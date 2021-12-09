<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Log;
use PDF;
use Carbon;
use DateTime;
use DataTables;
use App\Models\User;
use App\Models\SiteStageTracking;
use App\Models\StageActivities;
use App\Models\Site;
use App\Models\SubActivityValue;
use App\Models\PrMemoTableRenewal;
use App\Models\PrMemoSite;
use App\Models\SubActivity;

use Notification;
use App\Notifications\SiteMoved;

use App\Mail\LOIMail;
use App\Mail\LrnMail;
use App\Mail\eLasRenewal;
use Illuminate\Support\Facades\Mail;

class RenewalController extends Controller
{
    public function save_loi(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                '*' => 'required',
                'undersigned_email' => 'required | email',
            ]);

            if ($validate->passes()) {

                $samid = $request->input("sam_id");
                $site_category = $request->input("site_category");
                $program_id = $request->input("program_id");
                $activity_id = $request->input("activity_id");
                $action = "true";

                $array = [
                    'lessor' => $request->input("lessor"),
                    'lessor_address' => $request->input("lessor_address"),
                    'cell_site_address' => $request->input("cell_site_address"),
                    'terms_in_years' => $request->input("new_lease_terms_in_years"),
                    'new_terms_start_date' => date('M d, Y', strtotime($request->input("new_terms_start_date"))),
                    // 'new_terms_end_date' => date('M d, Y', strtotime('-1 day', strtotime($request->input("new_terms_end_date")))),
                    'new_terms_end_date' => date('M d, Y', strtotime($request->input("new_terms_end_date"))),
                    // 'date_word' => $date_word,
                    'expiration_date' => date('M d, Y', strtotime($request->input("expiration"))),
                    'undersigned_number' => $request->input("undersigned_number"),
                    'undersigned_email' => $request->input("undersigned_email"),
                    'salutation' => $request->input("salutation"),
                    'lessor_position' => $request->input("lessor_position"),
                    'company' => $request->input("company"),
                    'lessor_surname' => $request->input("lessor_surname"),
                    // 'signatory' => $request->input("signatory"),
                    // 'signatory_position' => $request->input("signatory_position")
                ];

                $sub_activity_value = SubActivityValue::select('sam_id')
                                ->where('sam_id', $request->input("sam_id"))
                                ->where('sub_activity_id', $request->input("sub_activity_id"))
                                ->whereIn('type', ['doc_upload', 'loi'])
                                ->where('status', 'pending')
                                ->first();

                $stage_activities = \DB::table('stage_activities')
                                ->select('id', 'activity_type', 'approver_profile_id_1')
                                ->where('program_id', $request->input('program_id'))
                                ->where('activity_id', $request->input('activity_id'))
                                ->where('category', $request->input("site_category"))
                                ->first();

                $stage_activities_approvers = \DB::table('stage_activities_approvers')
                                ->select('approver_profile_id')
                                ->where('stage_activities_id', $stage_activities->id)
                                ->get();

                $approvers_collect = collect();
                $approvers_collect_no_data = collect();

                foreach ($stage_activities_approvers as $stage_activities_approver) {
                    $approvers_collect->push([
                        'profile_id' => $stage_activities_approver->approver_profile_id,
                        'status' => 'rejected'
                    ]);

                    $approvers_collect_no_data->push([
                        'profile_id' => $stage_activities_approver->approver_profile_id,
                        'status' => 'pending'
                    ]);
                }

                $sub_activity_value_file = SubActivityValue::select('value')
                                ->where('sam_id', $request->input("sam_id"))
                                ->where('sub_activity_id', $request->input("sub_activity_id"))
                                ->where('type', 'doc_upload')
                                ->where('status', 'pending')
                                ->first();
                                
                $file_name = $this->rename_file( strtolower($samid)."-loi-pdf.pdf", "loi", $samid, "" );

                $new_file_name = !is_null($sub_activity_value_file) ? json_decode($sub_activity_value_file->value)->file : $file_name;

                $this->create_pdf($array, $samid, 'loi-pdf', $file_name);
                
                // return response()->json(['error' => true, 'message' => $file_name]);

                $array_data = [
                    'file' => $new_file_name,
                    'active_profile' => $stage_activities_approvers[0]->approver_profile_id,
                    'active_status' => 'rejected',
                    'validator' => 0,
                    'validators' => $approvers_collect->all(),
                    'type' => 'loi'
                ];

                $array_data_no_data = [
                    'file' => $file_name,
                    'active_profile' => $stage_activities_approvers[0]->approver_profile_id,
                    'active_status' => 'pending',
                    'validator' => count($approvers_collect_no_data->all()),
                    'validators' => $approvers_collect_no_data->all(),
                    'type' => 'loi'
                ];

                if (!is_null($sub_activity_value)) {

                    SubActivityValue::select('sam_id')
                                ->where('sam_id', $request->input("sam_id"))
                                ->where('sub_activity_id', $request->input("sub_activity_id"))
                                ->where('type', 'doc_upload')
                                ->where('status', 'pending')
                                ->update([
                                    'value' => json_encode($array_data),
                                    'approver_id' => \Auth::id(),
                                ]);

                    SubActivityValue::select('sam_id')
                                ->where('sam_id', $request->input("sam_id"))
                                ->where('sub_activity_id', $request->input("sub_activity_id"))
                                ->whereIn('type', ['doc_upload', 'loi'])
                                ->where('status', 'pending')
                                ->update([
                                    'status' => 'rejected',
                                    'reason' => 'Old LOI'
                                ]);

                    
                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($array_data_no_data),
                        'user_id' => \Auth::id(),
                        'type' => 'doc_upload',
                        'status' => 'pending',
                    ]);

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'type' => 'loi',
                        'status' => 'pending',
                    ]);

                } else {
                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($array_data_no_data),
                        'user_id' => \Auth::id(),
                        'type' => 'doc_upload',
                        'status' => 'pending',
                    ]);

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'type' => 'loi',
                        'status' => 'pending',
                    ]);
                }
                
                return response()->json(['error' => false, 'message' => "Successfully submitted an LOI." ]);

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function email_loi (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'email' => 'required | email'
            ]);

            if ($validate->passes()) {
                // $url = asset('files/'.$request->input("file_name"));
                Mail::to($request->input("email"))->send(new LOIMail( $request->input("file_name"), $request->input("file")));

                return response()->json(['error' => false, 'message' => "Successfully emailed LOI to " .$request->input("email") ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function email_lrn (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'email' => 'required | email'
            ]);

            if ($validate->passes()) {
                // $url = asset('files/'.$request->input("file_name"));
                Mail::to($request->input("email"))->send(new LrnMail( $request->input("file_name")));

                return response()->json(['error' => false, 'message' => "Successfully emailed LRN to " .$request->input("email") ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function create_pr (Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                '*' => 'required'
            ]);

            if ($validate->passes()) {
                $po_number = $request->get('po_number');
                $po_date = $request->get('po_date');
                $vendor = $request->get('vendor');
                $action = "true";

                $last_pr_memo = PrMemoTableRenewal::orderBy('pr_memo_id', 'desc')->first();

                $generated_pr = "PR-MEMO-00000".(!is_null($last_pr_memo) ? $last_pr_memo->pr_memo_id + 1 : 0 + 1);
                
                PrMemoTableRenewal::create([
                    'po_number' => $request->get('po_number'),
                    'po_date' => $request->get('po_date'),
                    'vendor' => $request->get('vendor'),
                    'generated_pr_memo' => $generated_pr,
                ]);

                for ($i=0; $i < count($request->input('sam_id')); $i++) { 

                    Site::where('sam_id', $request->input("sam_id")[$i])
                        ->update([
                            'site_po' => $request->get('po_number')
                        ]);

                    PrMemoSite::create([
                        'sam_id' => $request->input("sam_id")[$i],
                        'pr_memo_id'=> $generated_pr
                    ]);

                    $sites = \DB::table('view_site')
                                ->select('program_id', 'site_category', 'activity_id')
                                ->where('sam_id', $request->get('sam_id')[$i])
                                ->first();

                    $asd = $this->move_site([$request->input('sam_id')[$i]], $sites->program_id, $action, [$sites->site_category], [$sites->activity_id]);
                }

                return response()->json(['error' => false, 'message' => "Successfully submitted a LOI.", 'program_id' => $request->get('program_id') ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function save_lrn (Request $request)
    {
        try {
            $required = '';
            if ($request->get('lrn') == "One Time Payment") {
                $required = 'required';
            }

            $validate = Validator::make($request->all(), [
                'lrn' => 'required',
                'final_negotiated_amount' => 'required',
                'final_negotiated_advance_rent_months' => 'required',
                'final_negotiated_advance_rent_amount' => 'required',
                'new_terms_tax_application' => 'required',
                'new_lease_terms_in_years' => 'required',
                'lessor_demand_monthly_contract_amount' => 'required',
                'lessor_demand_advance_rent_months' => 'required',
                'lessor_demand_advance_rent_amount' => 'required',
                'lessor_demand_security_deposit_amount' => 'required',
                'lessor_demand_escalation_rate' => 'required',
                'lessor_demand_escalation_year' => 'required',
                'to_be_applied_on' => 'required',
                'number_of_months_advance' => 'required',
                'consideration_for_otp_only' => $required,
            ]);

            if ($validate->passes()) {

                if ($request->get('lrn') == 'No security deposit, Advance Rental, Escalation Rate') {
                    $component = 'lrn-no-security-a-r-e-r-pdf';
                } else if ($request->get('lrn') == 'Advance Rent, Escalation Rate') {
                    $component = 'advance-rent-escalation-rate-pdf';
                } else if ($request->get('lrn') == 'Advance Rent, Security Deposit') {
                    $component = 'advance-rent-security-deposit-pdf';
                } else if ($request->get('lrn') == 'Advance Rent') {
                    $component = 'advance-rent-pdf';
                } else if ($request->get('lrn') == 'Advance Rent, Escalation Rate, Security Deposit') {
                    $component = 'advance-rent-escalation-rate-security-deposit-pdf';
                } else if ($request->get('lrn') == 'Escalation Rate, Security Deposit') {
                    $component = 'escalation-rate-security-deposit-pdf';
                } else if ($request->get('lrn') == 'Escalation Rate') {
                    $component = 'escalation-rate-pdf';
                } else if ($request->get('lrn') == 'Security Deposit') {
                    $component = 'security-deposit-pdf';
                } else if ($request->get('lrn') == 'Free of Charge') {
                    $component = 'free-of-charge-pdf';
                } else if ($request->get('lrn') == 'One Time Payment') {
                    $component = 'one-time-payment-pdf';
                }

                // return response()->json(['error' => true, 'message' => $request->all()]);
                $stage_activities = \DB::table('stage_activities')
                                ->select('id', 'activity_type', 'approver_profile_id_1')
                                ->where('program_id', $request->input('program_id'))
                                ->where('activity_id', $request->input('activity_id'))
                                ->where('category', $request->input("site_category"))
                                ->first();

                $stage_activities_approvers = \DB::table('stage_activities_approvers')
                                ->select('approver_profile_id')
                                ->where('stage_activities_id', $stage_activities->id)
                                ->get();

                $approvers_collect = collect();
                $approvers_collect_no_data = collect();

                foreach ($stage_activities_approvers as $stage_activities_approver) {
                    $approvers_collect->push([
                        'profile_id' => $stage_activities_approver->approver_profile_id,
                        'status' => 'rejected'
                    ]);
                    $approvers_collect_no_data->push([
                        'profile_id' => $stage_activities_approver->approver_profile_id,
                        'status' => 'pending'
                    ]);
                }

                $sub_activity_value_file = SubActivityValue::select('value')
                                ->where('sam_id', $request->input("sam_id"))
                                ->where('sub_activity_id', $request->input("sub_activity_id"))
                                ->where('type', 'doc_upload')
                                ->where('status', 'pending')
                                ->first();
                                
                $file_name = $this->rename_file( strtolower($request->input("sam_id"))."-" . $component . ".pdf", $component, $request->input("sam_id"), "" );

                $this->create_pdf($request->all(), $request->get('sam_id'), $component, $file_name);

                $new_file_name = !is_null($sub_activity_value_file) ? json_decode($sub_activity_value_file->value)->file : $file_name;

                // return response()->json(['error' => true, 'message' => $request->all()]);
                $array_data = [
                    'file' => $new_file_name,
                    'active_profile' => $stage_activities_approvers[0]->approver_profile_id,
                    'active_status' => 'rejected',
                    'validator' => 0,
                    'validators' => $approvers_collect->all(),
                    'type' => 'lrn'
                ];

                $array_data_no_data = [
                    'file' => $file_name,
                    'active_profile' => $stage_activities_approvers[0]->approver_profile_id,
                    'active_status' => 'pending',
                    'validator' => count($approvers_collect_no_data->all()),
                    'validators' => $approvers_collect_no_data->all(),
                    'type' => 'lrn'
                ];

                $sub_activity_value = SubActivityValue::select('sam_id')
                                                        ->where('sam_id', $request->input("sam_id"))
                                                        ->where('sub_activity_id', $request->input("sub_activity_id"))
                                                        ->where('status', 'pending')
                                                        ->whereIn('type', ['doc_upload', 'lrn'])
                                                        ->first();

                if (!is_null($sub_activity_value)) {

                    SubActivityValue::select('sam_id')
                                ->where('sam_id', $request->input("sam_id"))
                                ->where('sub_activity_id', $request->input("sub_activity_id"))
                                ->where('status', 'pending')
                                ->where('type', 'doc_upload')
                                ->update([
                                    'value' => json_encode($array_data),
                                    'approver_id' => \Auth::id(),
                                ]);

                    SubActivityValue::select('sam_id')
                                ->where('sam_id', $request->input("sam_id"))
                                ->where('sub_activity_id', $request->input("sub_activity_id"))
                                ->where('status', 'pending')
                                ->whereIn('type', ['doc_upload', 'lrn'])
                                ->update([
                                    'status' => 'rejected',
                                    'reason' => 'Old LRN',
                                ]);

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($array_data_no_data),
                        'user_id' => \Auth::id(),
                        'type' => 'doc_upload',
                        'status' => 'pending',
                    ]);

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'type' => 'lrn',
                        'status' => 'pending',
                    ]);

                } else {

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($array_data_no_data),
                        'user_id' => \Auth::id(),
                        'type' => 'doc_upload',
                        'status' => 'pending',
                    ]);

                    SubActivityValue::create([
                        'sam_id' => $request->input("sam_id"),
                        'sub_activity_id' => $request->input("sub_activity_id"),
                        'value' => json_encode($request->all()),
                        'user_id' => \Auth::id(),
                        'type' => 'lrn',
                        'status' => 'pending',
                    ]);
                }

                return response()->json(['error' => false, 'message' => "Successfully submitted LRN." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function save_elas (Request $request)
    {
        try {

            $validate = \Validator::make($request->all(),[
                '*' => 'required'
            ]);

            if ($validate->passes()) {

                $activities = \DB::table('stage_activities')
                                ->select('next_activity')
                                ->where('activity_id', $request->input("activity_id"))
                                ->where('program_id', $request->input("program_id"))
                                ->where('category', $request->input("site_category"))
                                ->first();

                if ( !is_null($activities) ) {

                    Mail::to('awesam-finance@globe.com.ph')->send(new eLasRenewal( $request->input("sam_id"), $request->input("program_id"), $request->input("site_category"), $activities->next_activity, $request->input("_token"), $request->input("reference_number"), $request->input("filing_date") ));
    
                    SubActivityValue::create([
                        'sam_id' => $request->input('sam_id'),
                        'type' => 'elas_renewal',
                        'value' => json_encode($request->all()),
                        'status' => 'pending',
                        'user_id' => \Auth::id(),
                    ]);
    
                    $asd = $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", [$request->input('site_category')], [$request->input('activity_id')]);
    
                    return response()->json(['error' => false, 'message' => "Successfully save eLAS." ]);
                } else {
                    return response()->json(['error' => true, 'message' => "No activity found." ]);
                }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function save_saving_computation (Request $request)
    {
        try {
            if ( $request->get('form_generator_type') == "schedule of rental payment" ) {
                $component = 'schedule-of-rental-payment-pdf';
                $type = "schedule_of_rental_payment";
            } else if ( $request->get('form_generator_type') == "savings computation" ) {
                $component = 'savings-computation-generator-pdf';
                $type = "saving_computation";
            }
            

            $stage_activities = \DB::table('stage_activities')
                                ->select('id', 'activity_type')
                                ->where('program_id', $request->input('program_id'))
                                ->where('activity_id', $request->input('activity_id'))
                                ->where('category', $request->input("site_category"))
                                ->first();

            $stage_activities_approvers = \DB::table('stage_activities_approvers')
                            ->select('approver_profile_id')
                            ->where('stage_activities_id', $stage_activities->id)
                            ->get();

            $approvers_collect = collect();
            $approvers_collect_no_data = collect();

            foreach ($stage_activities_approvers as $stage_activities_approver) {
                $approvers_collect->push([
                    'profile_id' => $stage_activities_approver->approver_profile_id,
                    'status' => 'rejected'
                ]);
                
                $approvers_collect_no_data->push([
                    'profile_id' => $stage_activities_approver->approver_profile_id,
                    'status' => 'pending'
                ]);
            }

            $sub_activity_value_file = SubActivityValue::select('value')
                            ->where('sam_id', $request->input("sam_id"))
                            ->where('sub_activity_id', $request->input("sub_activity_id"))
                            ->where('type', 'doc_upload')
                            ->where('status', 'pending')
                            ->first();

            $file_name = $this->rename_file( strtolower($request->input("sam_id"))."-" . $component . ".pdf", $component, $request->input("sam_id"), "" );

            $this->create_savings_computation_pdf($request->all(), $request->get('sam_id'), $component, $file_name);

            $new_file_name = !is_null($sub_activity_value_file) ? json_decode($sub_activity_value_file->value)->file : $file_name;
            
            // return response()->json(['error' => true, 'message' => $request->all()]);
            $array_data = [
                'file' => $new_file_name,
                'active_profile' => "",
                'active_status' => 'rejected',
                'validator' => 0,
                'validators' => $approvers_collect->all(),
                'type' => $type
            ];

            $array_data_no_data = [
                'file' => $file_name,
                'active_profile' => $stage_activities_approvers[0]->approver_profile_id,
                'active_status' => 'pending',
                'validator' => count($approvers_collect_no_data->all()),
                'validators' => $approvers_collect_no_data->all(),
                'type' => $type
            ];

            $sub_activity_value = SubActivityValue::select('sam_id')
                                                    ->where('sam_id', $request->input("sam_id"))
                                                    ->where('sub_activity_id', $request->input("sub_activity_id"))
                                                    ->where('status', 'pending')
                                                    ->whereIn('type', ['doc_upload', $type])
                                                    ->first();

            if ( !is_null($sub_activity_value) ) {

                SubActivityValue::select('sam_id')
                                ->where('sam_id', $request->input("sam_id"))
                                ->where('sub_activity_id', $request->input("sub_activity_id"))
                                ->where('status', 'pending')
                                ->where('type', 'doc_upload')
                                ->update([
                                    'value' => json_encode($array_data),
                                ]);

                SubActivityValue::select('sam_id')
                                ->where('sam_id', $request->input("sam_id"))
                                ->where('sub_activity_id', $request->input("sub_activity_id"))
                                ->where('status', 'pending')
                                ->whereIn('type', ['doc_upload', $type])
                                ->update([
                                    'status' => 'rejected',
                                    'reason' => 'Old Savings Computation',
                                ]);

                SubActivityValue::create([
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'value' => json_encode($request->all()),
                    'type' => $type,
                    'status' => 'pending',
                    'user_id' => \Auth::id(),
                ]);
    
                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'value' => json_encode($array_data_no_data),
                    'user_id' => \Auth::id(),
                    'type' => 'doc_upload',
                    'status' => 'pending',
                ]);
            } else {
                                                        
                SubActivityValue::create([
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'value' => json_encode($request->all()),
                    'type' => $type,
                    'status' => 'pending',
                    'user_id' => \Auth::id(),
                ]);
    
                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'value' => json_encode($array_data_no_data),
                    'user_id' => \Auth::id(),
                    'type' => 'doc_upload',
                    'status' => 'pending',
                ]);
            }
            
            return response()->json(['error' => false, 'message' => "Successfully save computation." ]);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function elas_approval_confirm (Request $request)
    {
        try {
            if ( $request->input('action_file') == "false" ) {
                $required = "";
            } else {
                $required = "required";
            }

            $validate = \Validator::make($request->all(),[
                '*' => 'required',
                'file' => $required,
            ]);

            if ($validate->passes()) {

                if ( $request->input('action_file') == "false" ) {

                    $stage_activity = StageActivities::select('return_activity')
                                    ->where('activity_id', $request->input("activity_id"))
                                    ->where('category', $request->get('site_category'))
                                    ->where('program_id', $request->get('program_id'))
                                    ->first();

                    $sub_activity = SubActivity::select('sub_activity_id')
                                    ->whereBetween('activity_id', [$stage_activity->return_activity, $request->input("activity_id")])
                                    ->where('category', $request->get('site_category'))
                                    ->where('program_id', $request->get('program_id'))
                                    ->get()
                                    ->pluck('sub_activity_id');

                    if ( count($sub_activity) < 1 ) {
                        return response()->json(['error' => true, 'message' => "No activity found."]);
                    } else {

                        
                        SubActivityValue::select('sam_id')
                                ->where('sam_id', $request->input("sam_id"))
                                ->where('type', 'elas_renewal')
                                ->update([
                                    'reason' => $request->get('remarks'),
                                    'status' => $request->input('action_file') == "false" ? "rejected" : "approved",
                                    'date_approved' => \Carbon::now()->toDate(),
                                    'approver_id' => \Auth::id(),
                                ]);
                                
                        SubActivityValue::select('sam_id')
                                ->where('sam_id', $request->input("sam_id"))
                                ->whereIn('sub_activity_id', $sub_activity)
                                ->whereIn('status', ['approved', 'pending'])
                                ->whereIn('type', ['elas_renewal', 'doc_upload', 'saving_computation', 'lrn'])
                                ->update([
                                    'reason' => $request->get('remarks'),
                                    'status' => $request->input('action_file') == "false" ? "rejected" : "approved",
                                    'date_approved' => \Carbon::now()->toDate(),
                                    'approver_id' => \Auth::id(),
                                ]);
                    }
                } else {

                    SubActivityValue::select('sam_id')
                                        ->where('sam_id', $request->input("sam_id"))
                                        ->where('sub_activity_id', $request->input("sub_activity_id"))
                                        ->where('status', 'pending')
                                        ->where('type', 'elas_renewal')
                                        ->update([
                                            'value' => json_encode($request->all()),
                                            'status' => $request->input('action_file') == "false" ? "rejected" : "approved",
                                            'date_approved' => \Carbon::now()->toDate(),
                                        ]);
                }

                $asd = $this->move_site([$request->input('sam_id')], $request->input('program_id'), $request->input('action_file'), [$request->input('site_category')], [$request->input('activity_id')]);

                $message = $request->input('action_file') == "false" ? "rejected" : "confirmed";
                return response()->json(['error' => false, 'message' => "Successfully " .$message." eLAS."]);

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function elas_approval_confirm_sam_head (Request $request)
    {
        try {
            // return response()->json(['error' => true, 'message' => $request->all()]);
            $validate = \Validator::make($request->all(),[
                '*' => 'required',
                'file' => 'required',
            ]);

            if ($validate->passes()) {

                SubActivityValue::select('sam_id')
                                    ->where('sam_id', $request->input("sam_id"))
                                    ->where('sub_activity_id', $request->input("sub_activity_id"))
                                    ->where('type', 'elas_renewal')
                                    ->update([
                                        'value' => json_encode($request->all()),
                                        'status' => "approved"
                                    ]);

                $asd = $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", [$request->input('site_category')], [$request->input('activity_id')]);

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }

            return response()->json(['error' => false, 'message' => "Successfully routed eLAS."]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function save_saving_computation_generated (Request $request)
    {
        try {
            $this->create_pdf($request->all(), $request->get('sam_id'), 'renewal-saving-computation-pdf');
            return response()->json(['error' => false, 'message' => $request->all()]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function save_endorsment_to_sts (Request $request)
    {
        try {
            $validate = \Validator::make($request->all(), array(
                '*' => 'required'
            ));

            if ($validate->passes()) {
                $sub_activity_value = SubActivityValue::create([
                    'sam_id' => $request->get('sam_id'),
                    'type' => 'refx',
                    'status' => 'pending',
                    'user_id' => \Auth::id(),
                    'value' => json_encode($request->all())
                ]);

                $action = "true";

                $asd = $this->move_site([$request->input('sam_id')], $request->input('program_id'), $action, [$request->input('site_category')], [$request->input('activity_id')]);

                return response()->json(['error' => false, 'message' => "Successfull save the data."]);

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function elas_approval($token, $sam_id, $program_id, $site_category, $activity_id, $action)
    {
        try {

            $sub_activity_value = SubActivityValue::where('sam_id', $sam_id)
                                                    ->where('type', 'elas_renewal')
                                                    ->where('value->_token', $token)
                                                    ->first();

            if ( !is_null($sub_activity_value) ) {
                
                $asd = $this->move_site([$sam_id], $program_id, $action, [$site_category], [$activity_id]);

                if ($action == 'false') {
                    $message = "Successfully rejected eLAS.";
                } else {
                    $message = "Successfully approved eLAS.";
                }
    
                return view('elas-approval', [ 'message' => $message, 'error' => false ]);
            } else {
                return view('elas-approval', [ 'message' => 'Unable to process this time.', 'error' => true ]);
            }
            
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return view('elas-approval', [ 'message' => $th->getMessage(), 'error' => true ]);
        }
    }

    public  function approve_schedule_of_payment (Request $request)
    {
        try {
            SubActivityValue::where('sam_id', $request->get('sam_id'))
                            ->where('type', 'refx')
                            ->where('status', 'pending')
                            ->update([
                                'status' => 'approved',
                                'approver_id' => \Auth::id(),
                                'date_approved' => \Carbon::now()->toDateString()
                            ]);

            $asd = $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", [$request->input('site_category')], [$request->input('activity_id')]);

            return response()->json(['error' => false, 'message' => "Successfully confirm Application of Payment."]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function save_commecial_negotiation(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                "*" => "required",
            ));

            if ($validate->passes()) {
                $status = "";
                if ( $request->input('approval') == "Approval not yet secured" ) {
                    $status = "active";
                } else if ( $request->input('approval') == "Approval Secured" ) {
                    $status = "approved";
                } else if ( $request->input('approval') == "Lessor Rejected" ) {
                    $status = "denied";
                }
                
                SubActivityValue::create([
                    'sam_id' => $request->input("sam_id"),
                    'sub_activity_id' => $request->input("sub_activity_id"),
                    'value' => json_encode($request->all()),
                    'user_id' => \Auth::id(),
                    'status' => $status,
                    'type' => 'lessor_commercial_engagement',
                ]);

                if ( $status == "approved" ) {
                    $asd = $this->move_site([$request->input('sam_id')], $request->input('program_id'), "true", [$request->input('site_category')], [$request->input('activity_id')] );
                }

                return response()->json(['error' => false, 'message' => "Successfully saved engagement."]);

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_commercial_engagement($sub_activity_id, $sam_id)
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
                                                        ->where('type', 'lessor_commercial_engagement')
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

                                return $json['remarks'];
                            } else {
                                return $row->value;
                            }
                        })
                        ->addColumn('method', function($row){
                            json_decode($row->value);
                            if (json_last_error() == JSON_ERROR_NONE){
                                $json = json_decode($row->value, true);

                                return $json['method'];
                            } else {
                                return $row->value;
                            }
                        })
                        ->addColumn('lessor_demand_monthly_contract_amount', function($row){
                            json_decode($row->value);
                            if (json_last_error() == JSON_ERROR_NONE){
                                $json = json_decode($row->value, true);

                                return $json['lessor_demand_monthly_contract_amount'];
                            } else {
                                return $row->value;
                            }
                        })
                        ->addColumn('lessor_demand_escalation_rate', function($row){
                            json_decode($row->value);
                            if (json_last_error() == JSON_ERROR_NONE){
                                $json = json_decode($row->value, true);

                                return $json['lessor_demand_escalation_rate'];
                            } else {
                                return $row->value;
                            }
                        })
                        ->addColumn('lessor_demand_escalation_year', function($row){
                            json_decode($row->value);
                            if (json_last_error() == JSON_ERROR_NONE){
                                $json = json_decode($row->value, true);

                                return $json['lessor_demand_escalation_year'];
                            } else {
                                return $row->value;
                            }
                        })
                        ->addColumn('lessor_demand_advance_rent_months', function($row){
                            json_decode($row->value);
                            if (json_last_error() == JSON_ERROR_NONE){
                                $json = json_decode($row->value, true);

                                return $json['lessor_demand_advance_rent_months'];
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

    public function fileupload(Request $request)
    {

        try {
            $validate = Validator::make($request->all(), array(
                'file' => 'required',
            ));

            if($validate->passes()){
                if($request->hasFile('file')) {
                    $destinationPath = 'files/';
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $fileName = time().$request->file('file')->getClientOriginalName();
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

            return response()->json(['error' => false, 'message' => $new_file]);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    private function move_site($sam_id, $program_id, $action, $site_category, $activity_id)
    {
        for ($i=0; $i < count($sam_id); $i++) {


            $get_past_activities = \DB::table('site_stage_tracking')
                                    ->where('sam_id', $sam_id[$i])
                                    ->where('activity_complete', 'false')
                                    ->get();

            if (count($get_past_activities) < 1) {
                SiteStageTracking::create([
                    'sam_id' => $sam_id[$i],
                    'activity_id' => 1,
                    'activity_complete' => 'false',
                    'user_id' => !\Auth::guest() ? \Auth::id() : 0
                ]);

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
                                'user_id' => !\Auth::guest() ? \Auth::id() : 0
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
                                                ->first();

                    if (!is_null($get_stage_activity)) {
                        $get_program_stages = \DB::table('program_stages')
                                                ->select('stage_name')
                                                ->where('stage_id', $get_stage_activity->stage_id)
                                                ->where('program_id', $program_id)
                                                ->first();
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
                                    ->where('program_id', $program_id[0])
                                    ->where('activity_id', $activity_id[0])
                                    ->where('action', $action_id)
                                    ->first();

        if (!is_null($notification_settings)) {
            $notification_receiver_profiles = \DB::table('notification_receiver_profiles')
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

    private function create_savings_computation_pdf ($array, $samid, $component, $file_name)
    {
        $view = \View::make('components.'.$component)
                    ->with($array)
                    ->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf = PDF::loadHTML($view);
        $pdf->setPaper('a4', 'portrait');
        $pdf->download();

        \Storage::put( $file_name, $pdf->output() );
    }

    private function create_pdf ($array, $samid, $component, $file_name)
    {
        $view = \View::make('components.'.$component)
                    ->with([
                        'json_data' => json_encode($array)   
                    ])
                    ->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf = PDF::loadHTML($view);
        $pdf->setPaper('folio', 'portrait');
        $pdf->download();

        \Storage::put( $file_name, $pdf->output() );
    }

    private function rename_file ($filename_data, $sub_activity_name, $sam_id, $site_category = null)
    {
        $ext = pathinfo($filename_data, PATHINFO_EXTENSION);

        // return $file_name = strtolower($sam_id."-".str_replace(" ", "-", $sub_activity_name)).".".$ext;
        $file_name = $filename_data;
        
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
}
