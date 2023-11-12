<?php
namespace App\Traits;

use App\Models\Machine;

trait MachineTrait

{  
    //todo count of machinevalidate for machine to insert data
    protected function machinevalidate($element){
      $all_machine = Machine::get('id');
      foreach ($all_machine as $data) {
        if($data->id == $element){
            return $data->id;
            break;
        }
      }
      return "oops";
    }

   
}