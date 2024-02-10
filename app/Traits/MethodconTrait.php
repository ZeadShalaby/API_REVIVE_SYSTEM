<?php

namespace App\Traits;

use App\Models\Role;
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
      else{return FALSE;}

   }


   // todo check type of path owner || admin (tcr) //
   public function checkpath($gender , $role){

      if($gender == "MALE" || $gender == "male" || $gender == "Male"){
         if($role == "ADMIN"){
            $randomElement = $this->random(array('admin.jpg', 'maleadmin.jpg','maleadmin1.jpg'));
            return $randomElement; 
         }
         elseif ($role == "OWNER") {
            $randomElement = $this->random(array('maleowner.jpg'));
            return $randomElement; 
         }
      }
      elseif ($gender == "FEMALE" || $gender == "female" || $gender == "Female") {
         if($role == "ADMIN"){
            $randomElement = $this->random(array('femaleadmin.jpg'));
            return $randomElement; 
         }
         elseif ($role == "OWNER") {
            $randomElement = $this->random(array('femaleowner.jpg'));
            return $randomElement; 
         }
      }
      else{return FALSE;}

   }


   // todo check type of path owner || admin (tcr) //
   public function checkuserpath($gender){

      if($gender == "MALE" || $gender == "male" || $gender == "Male"){
         $randomElement = $this->random(array('male.jpg', 'male1.png','male2.png'));
         return $randomElement;        
      }
      elseif ($gender == "FEMALE" || $gender == "female" || $gender == "Female" ) {
         $randomElement = $this->random(array('female.png','female1.png','female2.png','female3.png','female4.png','female5.png')); 
         return $randomElement;      
      } 
      else{return FALSE;}

        
   }
}

