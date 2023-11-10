<?php
namespace App\Traits;

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
}