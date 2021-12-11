<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\InvitationMail;

class ApiController extends Controller
{
    public function send_invitation (Request $request)
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
}
