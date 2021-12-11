<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\InvitationMail;

class ApiController extends Controller
{
    public function send_invitation (Request $request)
    {
        $url = $request->get('url');
        $name = $request->get('name');
        $company = $request->get('company');
        $email = $request->get('email');

        Mail::to($email)->send(new InvitationMail($url, $name, $company));

        return "Success";
    }
}
