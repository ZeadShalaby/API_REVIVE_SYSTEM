<?php
namespace App\Traits;

use App\Models\Role;
use App\Mail\Weather;
use App\Models\Machine;
use App\Models\Tourism;
use Illuminate\Support\Facades\Mail;

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

    // todo return info of tourist areas but format fci &&d coastal & tourism
    protected function formatdata($datatourist){
      $tourism = [];
      $coastal = [];
      $fci = [];
      
      foreach ($datatourist as $item) {
          //? Retrieve degree and humidity information for the current machine
          $datainfo = $this->calculate_degree_humidity($item->id);
  
          //? If datainfo is not null, proceed
          if ($datainfo !== null) {
              //? Assign degree and humidity to the current item
              $item->degree = $datainfo['degree'];
              $item->humidity = $datainfo['humidity'];
  
              //? Determine the type of the current item and push it to the corresponding array
              if ($item->type == 4) {
                  $coastal[] = $item;
              } elseif ($item->type == 5) {
                  $tourism[] = $item;
              } elseif ($item->type == 7) {
                  $fci[] = $item;
              }
          } else {
              //? Handle the case where datainfo is null (degree and humidity information not available)
              //? You may log an error or handle it differently based on your application's requirements
          }
      }
  
      //? Construct the final associative array with separated data
      $finalData = ['tourism' => $tourism, 'coastal' => $coastal, 'fci' => $fci];
      return $finalData;
  }
  
  // todo add degree and humidity for this machine into tourist areas
  protected function calculate_degree_humidity($machine_id){
      //? Retrieve degree and humidity information for the specified machine
      $data = Tourism::where("machine_id", $machine_id)->latest()->first();
  
      //? If data is not null, return degree and humidity information
      if ($data !== null) {
          return ['degree' => $data->degree, 'humidity' => $data->humidity];
      } else {
          //? If data is null, return default values (0 for both degree and humidity)
          return ['degree' => 0, 'humidity' => 0];
      }
  }
   
}