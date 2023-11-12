<?php

namespace App\Traits;

use App\Models\Role;


trait MethodconTrait

{   // todo only post following
   public function postfollowers($posts , $folowers)
   {
   $postfollow = array();

   foreach ($posts as $post) {

      foreach ($folowers as $follower) {

          if($post->user_id == $follower->following_id)
          {
             //todo push post in array ;
             array_push($postfollow, $post);
          }
      }} 
      return $postfollow;
   }


}

