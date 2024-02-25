<?php

namespace App\Traits;

use App\Models\Post;
use App\Models\Role;
use App\Models\Follow;
use App\Models\Favourite;
use App\Traits\ImageTrait;
use App\Traits\ResponseTrait;


trait MethodconTrait

{  
   use ResponseTrait , ImageTrait;
   // todo only post following
   public function postfollowers($posts , $folowers)
   {
   $postfollow = array();

   foreach ($posts as $post) {

      foreach ($folowers as $follower) {
         // ? return following posts //
          if($post->user_id == $follower->following_id)
          {
             //todo push post in array ;
             array_push($postfollow, $post);
          }

         // ? return all my posts //
         if(($post->user_id == auth()->user()->id))
         {
            //todo push post in array ;
            array_push($postfollow, $post);
         } 

      }} 
      return $postfollow;
   }

   // todo check the person cant be follow it self //
   public function checkfollow($following , $followers){
      
      $follow = Follow::where("following_id",$following)->where("followers_id",$followers)->get();
      if(($followers == $following)||($following == Role::ADMIN)||(isset($follow)&&$follow->count() != 0)){
        return FALSE;
      }
      else{
         return TRUE;
      }

   }   

   // todo check if i can add comment in this post  //
   public function checkfollowing($postid){

      $followers = Follow::where('followers_id',auth()->user()->id)->get();
      $posts = Post::find($postid);

      foreach ($followers as $follower) {
         // ? check if i follow this person to do insert comment //
          if($posts->user_id == $follower->following_id)
          {
              return true;
          }
      }
      return false ;
      
   }   
   
   // todo check if i can add comment in this post  //
   public function checkfav($postid , $userid){

      $favourite = Favourite::where('posts_id',$postid)->where("user_id",$userid)->get();
         // ? check if i follow this person to do insert comment //
         foreach ($favourite as $fav) {
            if( isset($fav->id) )
            {
               return false;
            }
         }
      return true ;
      
   }   

   // todo check type of machine (tcr) //
   public function checkTypeMachine($checktype){

      if($checktype == "TOURISM" || "Tourism" || "tourism"){
         return Role::TOURISM;
      }
      elseif ($checktype == "COASTAL" || "Coastal" || "coastal") {
         return Role::COASTAL;
      }
      elseif ($checktype == "REVIVE" || "Revive" || "revive") {
         return Role::REVIVE;
      }
      elseif ($checktype == "FCI" || "Fci" || "fci") {
         return Role::FCI;
      }
      elseif ($checktype == "WEATHER" || "Weather" || "weather") {
         return Role::FCI;
      }
      elseif ($checktype == "OTHER" || "Other" || "other") {
         return Role::FCI;
      }

   }


   // todo check type of machine (tcr) //
   public function checkTypeUsers($checktype){

      if($checktype == "ADMIN" || "Admin" || "admin"){
         return Role::ADMIN;
      }
      elseif ($checktype == "OWNER" || "Owner" || "owner") {
         return Role::OWNER;
      }
      elseif ($checktype == "CUSTOMER" || "Customer" || "customer") {
         return Role::CUSTOMER;
      }
      else{return FALSE;}

   }


   // todo check type of path owner || admin (tcr) //
   public function checkpath($gender , $role){
      $funreturn = "reviveimageusers";
      if($gender == "MALE" || $gender == "male" || $gender == "Male"){
         if($role == "ADMIN"){
            $randomElement = $this->random(array('admin.jpg', 'maleadmin.jpg','maleadmin1.jpg'),$funreturn);
            return $randomElement; 
         }
         elseif ($role == "OWNER") {
            $randomElement = $this->random(array('maleowner.jpg'),$funreturn);
            return $randomElement; 
         }
      }
      elseif ($gender == "FEMALE" || $gender == "female" || $gender == "Female") {
         if($role == "ADMIN"){
            $randomElement = $this->random(array('femaleadmin.jpg'),$funreturn);
            return $randomElement; 
         }
         elseif ($role == "OWNER") {
            $randomElement = $this->random(array('femaleowner.jpg'),$funreturn);
            return $randomElement; 
         }
      }
      else{return FALSE;}

   }


   // todo check type of path owner || admin (tcr) //
   public function checkuserpaths($gender){

      $funreturn = "reviveimageusers";
      if($gender == "MALE" || $gender == "male" || $gender == "Male"){
         $randomElement = $this->random(array('male.jpg', 'male1.png','male2.png'),$funreturn);
         return $randomElement;        
      }
      elseif ($gender == "FEMALE" || $gender == "female" || $gender == "Female" ) {
         $randomElement = $this->random(array('female.png','female1.png','female2.png','female3.png','female4.png','female5.png'),$funreturn); 
         return $randomElement;      
      } 
      else{return FALSE;}
   }
}

