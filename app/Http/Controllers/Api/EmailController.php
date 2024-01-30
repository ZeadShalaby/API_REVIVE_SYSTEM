<?php

namespace App\Http\Controllers\Api;

use App\Mail\Emailmailer;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\Requests\TestMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //
    use ResponseTrait , TestMail;
    public function sendmail(Request $request){
        $info = $this->checkmail($request->gmail);
        $msg = "Hey sir : ".$info->username.",Welcome in revive app your code is : ".$info->code." ,Have a nice day";
        Mail::to($request->gmail)->send(new Emailmailer($msg));
        return $this->returnSuccessMessage("Send Successfully sir : ".$info->username." lock in inbox");
    }

}
