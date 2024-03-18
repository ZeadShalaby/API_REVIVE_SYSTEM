<?php
namespace App\Traits;

use App\Models\Comment;
use App\Models\Favourite;
use App\Models\SavedPosts;

trait CountTrait

{  
    //todo count of Orders for users
    protected function infoposts($posts){
      foreach ($posts as $post) {
        $favpost   = Favourite::where('user_id',auth()->user()->id)->where('posts_id',$post->id)->get();
        $commpost  = Comment::where('user_id',auth()->user()->id)->where('posts_id',$post->id)->get();
        $savedpost = $this->checksaved($post->id , auth()->user());
        
        // ? count comment & favourite //
        $countcomm     =  $commpost->count();
        $countfav      =  $favpost->count();
        $post->fav     =  $countfav;
        $post->comment =  $countcomm;
        $post->saved   =  $savedpost;
      }
      return $posts;

    }


    

     //todo count of followers , follwing for users
     protected function follow($follwers,$following){
      $countfollwers =0;$countfollowing =0;
      foreach ($follwers as $follwers) {
        
        $countfollwers++;
      }

      foreach ($following as $following) {
        
        $countfollowing++;
      }

      $data = [$countfollwers ,$countfollowing];
      return $data;

    }  

    
    //todo count of commit for users
    protected function checksaved($posts_id , $user){
      $saved = SavedPosts::where("user_id",$user->id)->where("posts_id" , $posts_id)->get();
      if( $saved->count() != 0 ){
      return true;
    }
      else{return false;}

    }

    
}