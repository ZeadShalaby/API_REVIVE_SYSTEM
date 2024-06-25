<?php
namespace App\Traits;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Auth,Validator,Exception;
use App\Traits\Request\TestAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Traits\validator\ValidatorTrait;
use Illuminate\Support\Facades\Redirect;
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
        $nickname = $this->nickname($element);
        User::create([
            'name'=> $element->name,
            'username'=> $nickname,
            'email'=> $element->email,
            'gmail'=>$element->email,
            'profile_photo'=>$element->avatar,
            'phone',
            'password'=> $element->id,
            'role'=>Role::CUSTOMER,
            'social_id'=>Hash::make($element->id),
            'social_type'=>Role::GITHUB,
            'email_verified_at' => Carbon::now() ,
         ]); 

         $userinfo = $this->login($element);
         return $userinfo;
 
     }

    //todo count of commit for users
    protected function singgoogle($element){
        $nickname = $this->nickname($element);
        User::create([
            'name'=> $element->name,
            'username'=> $nickname,
            'email'=> $element->email,
            'gmail'=>$element->email,
            'profile_photo'=>$element->avatar,
            'password'=> $element->id,
            'role'=>Role::CUSTOMER,
            'social_id'=>Hash::make($element->id),
            'social_type'=>Role::GOOGLE,
            'email_verified_at' => Carbon::now() ,
         ]); 

         $userinfo = $this->login($element);
         return $userinfo;
    }

     //todo add google email for users
     protected function addgoogle($user , $gmail){
        // ! valditaion
        $rules = ["gmail" => "required|unique:users,gmail"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        $user->update([
            'gmail'=>$user->gmail,
        ]); 
         return TRUE;

    }


    //todo add github email for users
    protected function addphone($user , $phone){
        //! validate
        $rules = ["phone" => "required|numeric|digits:10"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}
        

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

     // todo check nickname null or not 
     public function nickname($element){
        $nickname ;
        if($element->nickname){
            $nickname = $element->nickname;
        }else {
            $nickname = $element->name;

        }
        return $nickname;
     }
     
     // todo change type user to array to validate him before signup with service //
     protected function infouser($user){
        $user =  array("name"=>$user->name , "email"=>$user->email , "gmail"=>$user->email,"profile_photo"=>$user->avatar,"password"=>$user->id);
        return $user;
     }
     
     // todo check login with phone or email //
     protected function CheckField($request)
     {
     
         // ?login with phone number or email
         $field = filter_var($request->input('field'),FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
         $credentials = array(
            $field => $request->get('field'),
            'password' => $request->get('password')
        ); 
        return array(
            'credentials' => $credentials ,
            'fields' => $field 
        );
                  
     }   

  
}