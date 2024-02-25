<?php

namespace App\Http\Controllers\Api;

use Exception;
use Validator;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\Requests\TestSms;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;

class SmsController extends Controller
{
    use TestSms , TestAuth , ResponseTrait;
    // todo send Sms 

    public function sendsms(Request $request)
    {
       
        //! rules
        $rules = $this->rulessms();
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }

        $info = $this->checkphone($request->phone);

        $this->SMS($info , $request->country_code);

    }

    public function SMS($user , $code ){

        // ! send message sms //
        $basic  = new \Vonage\Client\Credentials\Basic("bded8f1b", "ofThoKpzOaXT5Ufk");
        $client = new \Vonage\Client($basic);
        
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("+$code $user->phone ", 'Revive' ,"Hy Sir $user->username , Your Code is : $user->code  Valid 1 minute  Revive")
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }
}
