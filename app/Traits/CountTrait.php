<?php
namespace App\Traits;

use App\Models\SavedPosts;

trait CountTrait

{  
    //todo count of Orders for users
    protected function countposts($element){
       $count =0;
      foreach ($element as $element) {
        
        $count++;
      }
      return $count;

    }

    //todo count of Favouritess for users
    protected function countfavourite($element){
        $count =0;
       foreach ($element as $element) {
         
        $count++;
       }
       return $count;
 
     }

    //todo count of commit for users
    protected function countcommit($element){
        $count =0;
      foreach ($element as $element) {
        
        $count++;
      }
      return $count;

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