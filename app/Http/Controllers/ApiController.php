<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\VendorMail;
use App\Mail\InvitationMail;

use App\Models\Invitation;
use App\Models\VendorProgram;

class ApiController extends Controller
{
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
                            ->orderBy('invitations.created_at', 'asc')
                            ->get();
                            
        return view('for-invitation')
        ->with('invitations', $invitations);
    }

    public function for_vendor_invitation ()
    {
        $invitations = \DB::table('vendor')
                                // ->join('users', 'users.email', 'vendor.vendor_admin_email')
                                // ->join('user_details', 'user_details.user_id', 'users.id')
                                ->orderBy('vendor.created_at', 'asc')
                                ->get();
                            
        return view('for-vendor-invitation')
                ->with('invitations', $invitations);
    }
}
