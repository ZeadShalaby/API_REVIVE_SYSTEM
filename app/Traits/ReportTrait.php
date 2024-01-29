<?php
namespace App\Traits;

trait CountTrait

{  
    //todo count of Orders for users
    protected function report($element){
       $count =0;
      foreach ($element as $element) {
        
        $count++;
      }
      return $count;

    }

   
}