<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use App\Mail\InvitationMail;
use App\Mail\GTInvitationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Vendor;
use App\Models\Invitation;

class InviteController extends Controller
{
    public function send_invitation(Request $request)
    {
        try {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i <= 12; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            if(\Auth::user()->getUserProfile()->profile == 'GT Admin') {
                $unique = 'unique:users';
            } else {
                $unique = '';
            }

            $validate = Validator::make($request->all(), array(
                'email' => ['required', 'email', $unique],
                'firstname' => 'required | max:255',
                'lastname' => 'required | max:255',
            ));
            
            $token = sha1(time());

            if($validate->passes()){
                $name = $request->input('firstname') . ' ' . $request->input('lastname');

                $email = $request->input('email');

                if(\Auth::user()->getUserProfile()->profile == 'GT Admin') {
                    $url = url('/login');

                    $password = strtolower(substr($request->input('firstname'), 0, 1).substr($request->input('lastname'), 0, 1).$request->input('mode').$randomString);

                    $user = User::create([
                        'firstname' => $request->input('firstname'),
                        'lastname' => $request->input('lastname'),
                        'name' => $request->input('firstname'). ' ' .$request->input('lastname'),
                        'email' => $request->input('email'),
                        'email_verified_at' => Carbon::now()->toDate(),
                        'password' => Hash::make($password)
                    ]);

                    UserDetail::create([
                        'user_id' => $user->id,
                        'mode' => $request->input('mode'),
                    ]);

                    Mail::to($email)->send(new GTInvitationMail($url, $name, $password, $request->input('mode'), $email));

                    return response()->json(['error' => false, 'message' => 'Invitation link has been sent.']);
                }
                
                $company = Vendor::where('vendor_id', $request->input('company_hidden'))->first();

                if(is_null($company)){
                    return response()->json(['error' => true, 'message' => "No company found."]);
                }

                $useCheck = Invitation::where('mode', $request->input('mode'))
                                            ->where('company_id', $request->input('company_hidden'))
                                            ->where('email', $request->input('email'))
                                            ->first();

                if(is_null($useCheck)){
                    Invitation::create([
                        'invitation_code' => $randomString,
                        'mode' => $request->input('mode'),
                        'company_id' => $request->input('company_hidden'),
                        'firstname' => $request->input('firstname'),
                        'lastname' => $request->input('lastname'),
                        'email' => $request->input('email'),
                        'token' => $token
                    ]);

                    $url = route('invite.link', [ $token, $randomString]);

                    Mail::to($email)->send(new InvitationMail($url, $name, $company->vendor_sec_reg_name));
                    
                    return response()->json(['error' => false, 'message' => 'Invitation link has been sent.']);
                } else {
                    return response()->json(['error' => true, 'message' => $request->input('email') . ' already invited.']);
                }
            }
            return response()->json(['error' => true, 'message' => $validate->errors() ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function invitation_registration ($token, $invitation_code)
    {
        $invitations = Invitation::join('vendor', 'vendor.vendor_id', 'invitations.company_id')
                                    ->where('invitations.token', $token)
                                    ->where('invitations.invitation_code', $invitation_code)
                                    ->first();

        return view('profiles.registration', compact(
            'invitations'
        ));
    }
}
