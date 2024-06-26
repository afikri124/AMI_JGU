<?php

namespace App\Http\Controllers;

use App\Mail\sendEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller{
    public function index(){
        Mail::to("rofiqabdul983@gmail.com")->send(new sendEmail());
        return "Email Sent";
    }
}