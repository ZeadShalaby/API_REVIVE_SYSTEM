<?php
namespace App\Traits;

use Auth,Validator,Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

trait LoginTrait

{  
    //todo checklogin for users & sign if not found with service
    protected function CheckLogin($element , $type){
       // ? login service //
       $userinfo = $this->login($element);
       if($userinfo == TRUE){
         $users =  Auth::guard('api')->user();
         $users -> api_token = $userinfo;
       return $users;
    }  
    
    // ? check type sign & call method singgoogle to sinup & login auto //
       elseif($userinfo == FALSE && ($type == Role::GOOGLE)){
         $usersign = $this->singgoogle($element);
       if(asset($usersign)){
         $users =  Auth::guard('api')->user();
         $users -> api_token = $usersign;
         return $users;
    }} 
    
    //? check type sign & call method singgoogle to sinup & login auto //
       elseif($userinfo == FALSE && ($type == Role::GITHUB)){
         $usersign = $this->singithub($element);
       if(asset($usersign)){
         $users =  Auth::guard('api')->user();
         $users -> api_token = $usersign;
         return $users;
     }}


    }

    //todo count of Favouritess for users
    protected function singithub($element){
        User::create([
            'name'=> $element->name,
            'username'=> $element->nickname,
            'email'=> $element->email,
            'gmail'=>$element->email,
            'profile_photo'=>$element->avatar,
            'phone',
            'password'=> $element->id,
            'role'=>Role::CUSTOMER,
            'social_id'=>Hash::make($element->id),
            'social_type'=>Role::GOOGLE,
         ]); 

         $userinfo = $this->login($element);
         return $userinfo;
 
     }

    //todo count of commit for users
    protected function singgoogle($element){
        User::create([
            'name'=> $element->name,
            'username'=> $element->nickname,
            'email'=> $element->email,
            'gmail'=>$element->email,
            'profile_photo'=>$element->avatar,
            'password'=> $element->id,
            'role'=>Role::CUSTOMER,
            'social_id'=>Hash::make($element->id),
            'social_type'=>Role::GOOGLE,
         ]); 

         $userinfo = $this->login($element);
         return $userinfo;
    }

     //todo add google email for users
     protected function addgoogle($user , $gmail){
        $rules = [
            "gmail" => "required|unique:users,gmail"
        ];
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }

        $user->update([
            'gmail'=>$user->gmail,
        ]); 
         return TRUE;

    }


    //todo add github email for users
    protected function addphone($user , $phone){
        $rules = [
            "phone" => "required|unique:users,phone"
        ];
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }

        $user->update([
           'phone'=>$user->phone,
         ]); 
         return TRUE;
     }


     //todo count of commit for users
     protected function login($element){
        $credentials = ([
            'gmail' => $element->email,
            'password'=>$element->id,
        ]);
        $token = Auth::guard('api')->attempt($credentials);
        return $token;
        //return " Email : ".$element->email. " id : ".$element->id;

     }
 

}