<?php

namespace App\Traits;

use App\Models\Role;
use App\Traits\ResponseTrait;


trait MethodconTrait

{  
   use ResponseTrait;
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

      if(($followers == $following)||($following == Role::ADMIN)){
        return FALSE;
      }
      else{
         return TRUE;
      }

   }   
   
   // todo check type of machine (tcr) //
   public function checkTypeMachine($checktype){

      if($checktype == "TOURISM"){
         return Role::TOURISM;
      }
      elseif ($checktype == "COASTAL") {
         return Role::COASTAL;
      }
      elseif ($checktype == "REVIVE") {
         return Role::REVIVE;
      }

   }


   // todo check type of machine (tcr) //
   public function checkTypeUsers($checktype){

      if($checktype == "ADMIN"){
         return Role::ADMIN;
      }
      elseif ($checktype == "OWNER") {
         return Role::OWNER;
      }
      elseif ($checktype == "CUSTOMER") {
         return Role::CUSTOMER;
      }

   }


   // todo check type of path owner || admin (tcr) //
   public function checkpath($gender , $role){

      if($gender == "MALE"){
         if($role == "ADMIN"){
            return randomElement(['admin.jpg', 'maleadmin.jpg','maleadmin1.jpg']) ;
         }
         elseif ($role == "OWNER") {
            return randomElement(['maleowner.jpg']) ;
         }
      }
      elseif ($checktype == "FEMALE") {
         if($role == "ADMIN"){
            return randomElement(['femaleadmin.jpg']) ;
         }
         elseif ($role == "OWNER") {
            return randomElement(['femaleowner.jpg']) ;
         }
      }
   }


   // todo check type of path owner || admin (tcr) //
   public function checkuserpath($gender){

      if($gender == "MALE"){
            return randomElement(['male.jpg', 'male1.png','male2.png']) ;
        
      }
      elseif ($checktype == "FEMALE") {
            return randomElement(['female.png','female1.png','female2.png','female3.png','female4.png','female5.png']) ;
      }
         
        
   }
}

