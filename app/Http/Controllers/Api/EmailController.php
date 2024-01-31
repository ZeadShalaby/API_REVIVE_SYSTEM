<?php

namespace App\Http\Controllers\Api;

use App\Events\MailCode;
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
        event(new MailCode($info));   
        Mail::to($request->gmail)->send(new Emailmailer($info));
        return $this->returnSuccessMessage("Send Successfully sir : ".$info->username." lock in inbox");
    }

    

}
