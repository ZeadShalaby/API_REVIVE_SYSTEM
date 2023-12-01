<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Traits\LoginTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class ServiceController extends Controller
{
    use ResponseTrait , LoginTrait;

    // social service //
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
      public function googlecallback(){
        $user =  Socialite::driver('google')->user();
        $checkuser = $this->CheckLogin($user,Role::GOOGLE);
        return $this->returnData("users",$checkuser);
   }

   /*
        return $this->returnData("users",$user);
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
 */

}
