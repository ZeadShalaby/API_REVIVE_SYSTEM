<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Role;
use App\Traits\LoginTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class ServiceController extends Controller
{
    use ResponseTrait , LoginTrait ;

    //? social service //
    public function redirect($service){
        if(isset($service))
        return Socialite::driver($service)->redirect();
        else return 'Oops Some Thing Wrong :(!';
    }

    //! githup //
    public function githubcallback(){
    $user =  Socialite::driver('github')->user();
    $checkuser = $this->CheckLogin($user,Role::GITHUB);
    return $this->returnData("users",$checkuser);

    }

    //! google 
    public function googlecallback(){  
    $user =  Socialite::driver('google')->user();
    $checkuser = $this->CheckLogin($user,Role::GOOGLE);
    return $this->returnData("users",$checkuser);

    }

  

}
