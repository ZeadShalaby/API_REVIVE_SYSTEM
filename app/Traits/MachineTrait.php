<?php
namespace App\Traits;

use App\Models\Machine;

trait MachineTrait

{  
    //todo count of machinevalidate for machine to insert data in (middleware) 
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

     // todo check type of machine //
     protected function checktype($machinetype,$type){
      $typemachine = Machine::find($machinetype);
      if($typemachine->type == $type){
        return true;
      }
      return false;
    }

    // todo recevied name machine and return id of this machine //
    protected function nameMachine($Nmachine_seller , $Nmachine_Buyer){
      
      $machineSeller_id = Machine::where("name",strtolower($Nmachine_seller))->pluck('id');
      $machineBuyer_id = Machine::where("name",strtolower($Nmachine_Buyer))->pluck('id');
      $checkMSeller = Machine::find($machineSeller_id)->pluck('owner_id');

      $data = array(
        "Mseller_id" => $machineSeller_id,
        "Mbuyer_id" => $machineBuyer_id,
        "ownerid" => $checkMSeller
      ); 

      return $data;
    }

   
}