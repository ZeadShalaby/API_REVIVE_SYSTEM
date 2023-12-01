<?php
namespace App\Traits;

use Auth,Validator,Exception;
use App\Models\Role;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Redirect;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

trait LoginTrait

{  
    //todo checklogin for users & sign if not found with service
    protected function CheckLogin($element , $type){
       
       $userinfo = $this->login($element);
       if(asset($userinfo)){
         $users =  Auth::guard('api')->user();
         $users -> api_token = $userinfo;
       return $users;
    }  // ? check type sign & call method singgoogle to sinup & login auto //
       elseif($type == Role::GOOGLE){
         $usersign = $this->singgoogle($element);
       if(asset($usersign)){
         $users =  Auth::guard('api')->user();
         $users -> api_token = $usersign;
       return $users;
    }} //? check type sign & call method singgoogle to sinup & login auto //
       elseif($type == Role::GITHUB){
         $usersign = $this->singithub($element);
       if(asset($usersign)){
         $users =  Auth::guard('api')->user();
         $users -> api_token = $usersign;
        return $users;
     }}


    }

    //todo count of Favouritess for users
    protected function singithub($element){
      
 
     }

    //todo count of commit for users
    protected function singgoogle($element){
        User::create([
            'name'=> $element->name,
            'username'=> $element->username,
            'email'=> $element->email,
            'gmail'=>$element->email,
            'profile_photo'=>$element->avatar,
            'phone'=>self::increment(),
            'password'=> $element->id,
            'role'=>Role::CUSTOMER,
            'social_id'=>$element->id,
            'social_type'=>Role::GOOGLE,
         ]); 

    }


     //todo count of commit for users
     protected function login($element){
      
        $credential = ([
            'gmail' => $element->email,
            'password'=>'admin'
        ]);
        $credentials = $credential->only(['email']);
        //$credentials = array($element->email)->only(['email']);
        $token = Auth::guard('api')->attempt($credentials);
        return $token;

}

}