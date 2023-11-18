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
   public function checktype($checktype){

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

}

