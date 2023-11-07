<?php

namespace App\Traits;

use App\Models\Role;


trait methodcon

{   // todo only post followers 
   public function postfollowers($posts , $followers)
   {
   $postfollow = [];
   foreach ($posts as $post) {

      foreach ($followers as $follower) {

          if($post->id == $follower->following_id)
          {
             //$post;
          }

      }} 

   }

   

}

