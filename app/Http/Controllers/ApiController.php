<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\VendorMail;
use App\Mail\InvitationMail;
use Auth;

use App\Models\Invitation;
use App\Models\VendorProgram;
use App\Models\User;
use App\Models\UserLog;
use App\Models\UserDetail;
use App\Models\SubActivityValue;
use Validator;

class ApiController extends Controller
{
    public function me(Request $request)
    {
        return $request->user();
    }

    public function send_invitation_vendor (Request $request)
    {
        // Mail::to($email)->send(new GTInvitationMail($url, $name, $password, $request->input('mode'), $email));
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i <= 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $url = $url = route('invite.link', [ sha1(time()), $randomString]);
        $name = $request->input('firstname') . ' ' . $request->input('lastname');
        $company = $request->get('company');
        $email = $request->get('email');

        Mail::to($email)->send(new InvitationMail($url, $name, $company));

        return "Success";
    }
    public function send_invitation_vendor_admin (Request $request)
    {
        // Mail::to($email)->send(new GTInvitationMail($url, $name, $password, $request->input('mode'), $email));
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i <= 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $url = $url = route('invite.link', [ sha1(time()), $randomString]);
        $name = $request->input('firstname') . ' ' . $request->input('lastname');
        $vendor_sec_reg_name = $request->get('vendor_sec_reg_name');
        $vendor_acronym = $request->get('vendor_acronym');
        $vendor_admin_email = $request->get('vendor_admin_email');

        Mail::to($vendor_admin_email)->send(new VendorMail($name, $vendor_admin_email, $vendor_sec_reg_name, $vendor_acronym, $randomString));

        return "Success";
    }

    public function for_invitation ()
    {
        $invitations = Invitation::join('vendor', 'vendor.vendor_id', 'invitations.company_id')
                            ->select('vendor.vendor_sec_reg_name', 'invitations.*')
                            ->where('invitations.use', 0)
                            ->orderBy('invitations.sent_email', 'desc')
                            ->get();
                            
        return view('for-invitation')
        ->with('invitations', $invitations);
    }

    public function for_vendor_invitation ()
    {
        $invitations = \DB::table('vendor')
                                // ->join('users', 'users.email', 'vendor.vendor_admin_email')
                                // ->join('user_details', 'user_details.user_id', 'users.id')
                                ->orderBy('vendor.sent_email', 'desc')
                                ->get();
                            
        return view('for-vendor-invitation')
                ->with('invitations', $invitations);
    }

    public function agent_activities (Request $request)
    {
        try {
            
            $user_detail = UserDetail::join('users', 'users.id', 'user_details.user_id')
                                    ->where('user_details.user_id', $request->get('user_id'))
                                    ->first();

            $user_program = \DB::table('program')
                    ->join('user_programs', 'program.program_id', 'user_programs.program_id')
                    // ->where('user_programs.user_id', \Auth::id())
                    ->where('user_programs.user_id', $request->get('user_id'))
                    ->where('user_programs.active', 1)
                    ->orderBy('program.program_id', 'asc')
                    ->first();

            if ( is_null($user_program) ) {
                return response()->json(['message' => "No active program available.", 'code' => 501]);
            }

            $vendor = is_null($user_detail) ? NULL : $user_detail->vendor_id;

            $activities = \DB::table('view_assigned_sites')
                        // ->where('agent_id', \Auth::id())
                        ->where('agent_id', $request->get('user_id'))
                        // ->where('activity_profile_id', $request->get('profile_id'))
                        ->where('site_vendor_id', $vendor)
                        ->where('program_id', $user_program->program_id)
                        ->orderBy('stage_id', 'ASC')
                        ->orderBy('activity_id', 'ASC')
                        ->get();

            return response()->json(['message' => $activities, 'code' => 200]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'code' => 501]);
        }
    }

    public function agent_activities_actions (Request $request)
    {
        try {
            $site = \DB::table('view_site')
                        ->where('sam_id', $request->get('sam_id'))
                        ->first();

            if ( is_null($site) ) {
                return response()->json(['message' => "No site found.", 'code' => 501]);
            } else {
                $sub_activities = \DB::table('sub_activity')
                                ->where('program_id', $site->program_id)
                                ->where('activity_id', $site->activity_id)
                                ->where('category', $site->site_category)
                                ->orderBy('sequential_step')
                                ->orderBy('requires_validation', 'desc')
                                ->get();
    
                return response()->json(['message' => $sub_activities, 'code' => 200]);
            }

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'code' => 501]);
        }
    }

    public function login(Request $request)
    {
        $loginDetails = $request->only('email', 'password');

        if(Auth::attempt($loginDetails)){

            $profile_menu = \Auth::user()->getAllNavigation()
            ->orderBy('menu_sort', 'asc')
            ->orderBy('menu', 'asc')
            ->get();

            $user = User::where('email', $request['email'])->firstOrFail();

            // $token = $user->createToken('auth_token')->plainTextToken;

            UserLog::create([
                'user_id' => \Auth::id(),
                'via' => 'Mobile'
            ]);

            $user_active_program = \DB::table('program')
                    ->join('user_programs', 'program.program_id', 'user_programs.program_id')
                    // ->join('page_route', 'page_route.program_id', 'user_programs.program_id')
                    ->where('user_programs.user_id', \Auth::user()->id)
                    ->where('user_programs.active', 1)
                    ->orderBy('program.program_id', 'asc')
                    ->get();

            $user_programs = \DB::table('user_programs')
                                ->select('user_programs.program_id', 'program.program', 'program.program_name')
                                ->join('program', 'program.program_id', 'user_programs.program_id')
                                ->where('user_programs.user_id', \Auth::user()->id)
                                ->get();

            // return response()->json(['message' => 'login successful', 'code' => 200, 'active_program' => $user_active_program, 'menu' => $profile_menu, 'profile_id' => Auth::user()->profile_id, 'user_id' => Auth::id(), 'user_programs' => $user_programs, 'access_token' => $token, 'token_type' => 'Bearer']);
            return response()->json(['message' => 'login successful', 'code' => 200, 'active_program' => $user_active_program, 'menu' => $profile_menu, 'profile_id' => Auth::user()->profile_id, 'user_id' => Auth::id(), 'user_programs' => $user_programs]);

        } else {

            return response()->json(['message' => 'login failed', 'code' => 501]);

        }

    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

    public function reset($user, array $input)
    {
        try {
            Validator::make($input, [
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', 
                    'confirmed'
                ]
            ])->validate();
    
            $user->forceFill([
                'password' => Hash::make($input['password']),
            ])->save();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'code' => 501]);
        }
    }

    public function current_user(Request $request) {
        try {
            $user = Auth::user();
            return response()->json(['message' => $user, 'code' => 200]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'code' => 501]);
        }
    }

    public function agent_activities_actions_do(Request $request)
    {
        try {
            $site = \DB::table('view_site')
                    ->where('sam_id', $request->get('sam_id'))
                    ->first();

            if ( is_null($site) ) {

            } else {

            }

            if($site->activity_name == 'SSDS'){

                $jtss_add_site = SubActivityValue::where('sam_id', $request->get('sam_id'))
                                                        ->where('type', 'jtss_add_site')
                                                        ->get();

                $what_component = "components.subactivity-ssds";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                    'check_if_added' => $jtss_add_site,
                ])
                ->render();

            }

            else if($site->activity_name == 'Set Approved Site'){

                $jtss_add_site = SubActivityValue::where('sam_id', $request->get('sam_id'))
                                                        ->where('type', 'jtss_add_site')
                                                        ->get();

                $what_component = "components.set-approved-site";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                    'check_if_added' => $jtss_add_site,
                ])
                ->render();

            }

            else if($site->activity_name == 'Lessor Negotiation' || $site->activity_name == 'LESSOR ENGAGEMENT' || $site->activity_name == 'Lessor Engagement' || $site->activity_name == 'Lessor Renewal Negotiation'){

                $what_component = "components.subactivity-lessor-engagement";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                ])
                ->render();

            }

            else if($site->activity_name == 'Commercial Negotiation'){

                $what_component = "components.renewal-commercial-negotiation";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                ])
                ->render();

            }

            elseif($site->activity_name == 'Set Site Category'){

                $what_component = "components.set-site-category";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                ])
                ->render();

            }
            elseif($site->activity_name == 'Schedule Advanced Site Hunting'){

                $what_component = "components.schedule-advance-site-hunting";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                ])
                ->render();

            }
            elseif($site->activity_name == 'Set Survey Representatives'){

                $datas = SubActivityValue::where('sam_id', $request->get('sam_id'))
                                            ->where('type', 'jtss_representative')
                                            ->get();

                $site = Site::select('site_name')
                                ->where('sam_id', $request->get('sam_id'))
                                ->first();

                $what_component = "components.set-survey-representatives";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                    'site_name' => $site->site_name,
                    'is_done' => count($datas) > 0 ? 'done' : 'not_done',
                ])
                ->render();

            }
            elseif($site->activity_name == 'Add Site Candidates'){

                $jtss_add_site = SubActivityValue::where('sam_id', $request->get('sam_id'))
                                                        ->where('type', 'jtss_add_site')
                                                        ->get();

                $site_np = Site::select('NP_latitude', 'NP_longitude', 'site_region_id', 'site_province_id', 'site_lgu_id')
                            ->where('sam_id', $request->get('sam_id'))
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
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
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
            elseif($site->activity_name == 'JTSS Sched Confirmation'){

                $np = \DB::table('site')
                    ->where('sam_id', $request->get('sam_id'))
                    ->select('NP_latitude', 'NP_longitude')
                    ->get();


                $what_component = "components.jtss-sched-confirmation";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                ])
                ->render();

            }
            elseif($site->activity_name == 'Site Survey Deliberation Sheet'){

                $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                            ->where('sam_id', $request->get('sam_id'))
                                            ->get();

                $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                            ->where('sam_id', $request->get('sam_id'))
                                            ->get();
                                            
                $what_component = "components.ssds";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                    'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
                ])
                ->render();

            }
            elseif($site->activity_name == 'SSDS Ranking'){

                $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                            ->where('sam_id', $request->get('sam_id'))
                                            ->get();

                $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                            ->where('sam_id', $request->get('sam_id'))
                                            ->get();

                $what_component = "components.ssds-ranking";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                    'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
                    'count_ssds' => count($jtss_ssds),
                ])
                ->render();

            }
            elseif($site->activity_name == 'Approved SSDS'){

                $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                            ->where('sam_id', $request->get('sam_id'))
                                            ->get();

                $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                            ->where('sam_id', $request->get('sam_id'))
                                            ->get();

                $what_component = "components.approved-ssds";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                    'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
                ])
                ->render();

            }
            elseif($site->activity_name == 'SSDS NTP'){

                $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                            ->where('sam_id', $request->get('sam_id'))
                                            ->get();

                $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                            ->where('sam_id', $request->get('sam_id'))
                                            ->get();

                $what_component = "components.ssds-ntp";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                    'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
                ])
                ->render();

            }
            elseif($site->activity_name == 'Lease Details'){

                $jtss_ssds = SubActivityValue::where('type', 'jtss_ssds')
                                            ->where('sam_id', $request->get('sam_id'))
                                            ->get();

                $jtss_schedule_site = SubActivityValue::where('type', 'jtss_schedule_site')
                                            ->where('sam_id', $request->get('sam_id'))
                                            ->get();

                $what_component = "components.lease-details";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                    'is_match' => count($jtss_ssds) == count($jtss_schedule_site) ? "match" : "not_match",
                ])
                ->render();
            }
            elseif($site->activity_name == 'Create LOI to Renew'){

                $program_renewal = \DB::table('program_renewal')
                                    ->select('site_address', 'lessor', 'expiration')
                                    ->where('sam_id', $request->get('sam_id'))
                                    ->first();

                $what_component = "components.loi-maker";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                    'program_renewal' => $program_renewal,
                ])
                ->render();

            }
            elseif($site->activity_name == 'Savings Computation'){

                $what_component = "components.savings-computation";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                ])
                ->render();

            }
            elseif($site->activity_name == 'Create Lease Renewal Notice'){

                $what_component = "components.lease-renewal-notice";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                ])
                ->render();

            }
            elseif($site->activity_name == 'Schedule of Rental Payment'){

                $what_component = "components.renewal-schedule-of-rental-payment";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                ])
                ->render();

            }
            elseif($site->activity_name == 'Get Send Approved LOI' || $site->activity_name == 'Get Send Approved LRN'){

                if ($site->activity_name == 'Get Send Approved LOI') {
                    $what_component = "components.get-send-approved-loi";

                    $files = SubActivityValue::select('value')
                                    ->where('sub_activity_id', 423)
                                    ->where('sam_id', $request->get('sam_id'))
                                    ->first();

                } else if ($site->activity_name == 'Get Send Approved LRN') {
                    $what_component = "components.get-send-approved-lrn";

                    $files = SubActivityValue::select('value')
                                    ->where('sub_activity_id', 424)
                                    ->where('sam_id', $request->get('sam_id'))
                                    ->first();
                }
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                    'files' => $files,
                ])
                ->render();

            }
            else {

                $what_component = "components.subactivity-doc-upload";
                return \View::make($what_component)
                ->with([
                    'sub_activity' => $site->activity_name,
                    'sam_id' => $request->get('sam_id'),
                    'sub_activity_id' => $request->get('sub_activity_id'),
                    'program_id' => $site->program_id,
                    'site_category' => $site->site_category,
                    'activity_id' => $site->activity_id,
                ])
                ->render();
            }
            
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'code' => 501]);
        }
    }



}
