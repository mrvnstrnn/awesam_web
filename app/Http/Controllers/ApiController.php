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

}
