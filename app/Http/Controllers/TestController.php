<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function submit_test_email (Request $request)
    {
        Mail::to("test@gmail.com")->send(new TestMail());
        $sent = 'Success!';
        return redirect('/permissions')->with('sent', 'Success!');
    }
}
