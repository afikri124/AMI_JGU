<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StandardController extends Controller
{
    public function index(Request $request) {
        return view('standard_audit.index');
    }

    
}


