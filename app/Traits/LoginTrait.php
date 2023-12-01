<?php
namespace App\Traits;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Auth,Validator,Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redirect;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

trait LoginTrait

{  
    //todo checklogin for users & sign if not found with service
    protected function CheckLogin($element , $type){

       $userinfo = $this->login($element);
       return $this->returnData("token",$userinfo);
       if(asset($userinfo)){
         $users =  Auth::guard('api')->user();
         $users -> api_token = $userinfo;
       return $users;
    }  // ? check type sign & call method singgoogle to sinup & login auto //
       elseif(!asset($userinfo)&&($type == Role::GOOGLE)){
         $usersign = $this->singgoogle($element);
       if(asset($usersign)){
         $users =  Auth::guard('api')->user();
         $users -> api_token = $usersign;
       return $users;
    }} //? check type sign & call method singgoogle to sinup & login auto //
       elseif(!asset($userinfo)&&($type == Role::GITHUB)){
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
            'username'=> $element->username,
            'email'=> $element->email,
            'gmail'=>$element->email,
            'profile_photo'=>$element->avatar,
            'phone'=>self::increment(),
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
            'username'=> $element->username,
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

     //todo add github email for users
     protected function addgithub($user , $gmail){
        $rules = [
            "gmail" => "required|unique:users,gmail"
            //"phone" => "required|unique:users,phone"
        ];
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }

        $user->update([
            'gmail'=>$user->gmail,
           // 'phone'=>$user->phone,
         ]); 
         return TRUE;
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
        $password = $this->searchuser($element);
        $credentials = ([
            'gmail' => $element->email  ,
            'password'=>$element->id,
        ]);
        $token = Auth::guard('api')->attempt($credentials);
        return $token;

}


    //todo count of commit for users
    protected function searchuser($element){
        $user = User::where("gmail",$element->email )->value('password');
        if($user){return $user;}
        else{return FALSE;}
    }



}