<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index($id)
    {
        return view("training");
    }
}
