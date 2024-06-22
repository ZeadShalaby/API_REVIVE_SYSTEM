<?php

namespace App\Http\Controllers\Api;

use Exception;
use Validator;
use Carbon\Carbon;
use App\Events\MailCode;
use App\Mail\ReviveMail;
use App\Mail\Emailmailer;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\MethodconTrait;
use App\Mail\ErrorMachinemailer;
use App\Traits\Requests\TestAuth;
use App\Traits\Requests\TestMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Traits\validator\ValidatorTrait;

class EmailController extends Controller
{
    //
    use ResponseTrait , TestMail , TestAuth , MethodconTrait , ValidatorTrait;
    
    // todo send mail when i want forget pass he send code into mail //
    public function sendmail(Request $request){
        // todo check if gmail exists in database //
        $info = $this->checkmail($request->gmail);
        $date = Carbon::now();
        if(!$info){return $this->returnError("E404","Email Not Eists in Revive app");}
        event(new MailCode($info));   
        $info -> date = $date;
        Mail::to($request->gmail)->send(new Emailmailer($info));
        return $this->returnSuccessMessage("Send Successfully sir : ".$info->username." lock in inbox");
    }

    // todo check if machine its work or not & if machine admin stoped him or delete him  //
    public function errormachine(Request $request){
        $info = $this->checkmail($request->gmail);
        Mail::to($request->gmail)->send(new ErrorMachinemailer($info));
        return $this->returnSuccessMessage("Send Successfully sir : ".$info->username." lock in inbox");
    }

    // todo Send Mail For all users or only Owner or Admin or customer in App //
    public function SendAll(Request $request){
        // ! valditaion
        $rules = $this->rulestype();
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}
        
        $type = $this->checkTypeUsers($request->type);
        $users = $this->checkussersmail($type);
        foreach ($users as $info) {
        $date = Carbon::now();
        $info->date = $date;
        $info->message = $request->message;
        Mail::to($info->gmail)->send(new ReviveMail($info));
        }
        return $this->returnSuccessMessage("Send Successfully sir : Admin Revive ");
    }

}
