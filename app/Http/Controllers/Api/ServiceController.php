<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Traits\LoginTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Auth,Validator,Exception;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;
use App\Traits\validator\ValidatorTrait;
use Laravel\Socialite\Facades\Socialite;

class ServiceController extends Controller
{
    use ResponseTrait , LoginTrait , TestAuth , ValidatorTrait ;

    //? social service //
    public function redirect($service){
        if(isset($service))
        return Socialite::driver($service)->redirect();
        else return 'Oops Some Thing Wrong :(!';
    }

    //! githup //
    public function githubcallback(){
        $user =  Socialite::driver('github')->user();
        $users = $this->infouser($user);
        // ?check login
        $token = $this->login($user);
        if($token == TRUE){ $userinfo =  Auth::guard('api')->user(); $userinfo -> api_token = $token; return $this->returnData("users",$userinfo);}
        // ! valditaion
        $rules = $this->rulesservice();
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        $checkuser = $this->CheckLogin($user,Role::GITHUB);
        return $this->returnData("users",$checkuser);

    }

    //! google 
    public function googlecallback(){  

        $user =  Socialite::driver('google')->user();
        $users = $this->infouser($user);
        // ?check login
        $token = $this->login($user);
        if($token == TRUE){ $userinfo =  Auth::guard('api')->user(); $userinfo -> api_token = $token; return $this->returnData("users",$userinfo);}
        // ! valditaion
        $rules = $this->rulesservice();
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        $checkuser = $this->CheckLogin($user,Role::GOOGLE);
        return $this->returnData("users",$checkuser);

    }

  

}
