<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    public function index(Request $request){
        return view('follow_ups.index');
    }
}
