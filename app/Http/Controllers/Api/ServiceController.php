<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class ServiceController extends Controller
{
    use ResponseTrait;

    // social service //
    public function redirect($service){
        return  $this->returnData("data",Socialite::driver($service)->redirect());
        if(isset($service))
        return Socialite::driver($service)->redirect();
        else return 'null';
    }


       //! githup //
       public function githubcallback(){
        $user =  Socialite::driver('github')->user();
        $users=$user;
        return  $this->returnData("data",$users);


      /*  
        $finduser = User::where('social_id',$users->id)->get()->value('social_id');
        $findemail = User::where('email',$user->email)->get()->value('email');
      if($finduser>0){
           $checkuser = $this->checkservice($users);
           if($checkuser==true){return Redirect::route('homepage');}
           else{return back()->with('error', 'Wrong Login Details');}
       }
        else{
            if($user->email==$findemail){
                return view("errors.error");
            }
           User::create([
               'name'=> $users->name,
               'email'=> $users->email,
               'gmail'=>$users->email,
               'profile_photo'=>$users->avatar,
               'phone'=>self::increment(),
               'password'=> $users->id,
               'role'=>Role::CUSTOMER,
               'remember_token' => $users->token,
               'social_id'=>$users->id,
               'social_type'=>'githup',
            ]);        
            
            $checkuser = $this->checkservice($users);
            if($checkuser==true){return Redirect::route('homepage');}
            else{return back()->with('error', 'Wrong Login Details');}
            
       }  */ 

   }




      //! google 
      public function callback(){
        $user =  Socialite::driver('google')->user();
        $users=$user;
        $finduser = User::where('social_id',$users->id)->get()->value('social_id');
        $findemail = User::where('email',$user->email)->get()->value('email');
        if($finduser>0){
           $checkuser = $this->checkservice($users);
           if($checkuser==true){return Redirect::route('homepage');}
           else{return back()->with('error', 'Wrong Login Details');}
       }
        else{
           if($user->email==$findemail){
               return view("errors.error");
           }
           User::create([
               'name'=> $users->name,
               'email'=> $users->email,
               'gmail'=>$users->email,
               'profile_photo'=>$users->avatar,
               'phone'=>self::increment(),
               'password'=> $users->id,
               'role'=>Role::CUSTOMER,
               'remember_token' => Str::random(10),
               'social_id'=>$users->id,
               'social_type'=>'google',
            ]);        
            
            $checkuser = $this->checkservice($users);
            if($checkuser==true){return Redirect::route('homepage');}
            else{return back()->with('error', 'Wrong Login Details');}
            
       }   

   }

}
