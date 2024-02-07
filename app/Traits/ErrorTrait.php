<?php
namespace App\Traits;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Revive;
use App\Models\Machine;
use App\Models\Tourism;
use App\Mail\ErrorMachinemailer;
use Illuminate\Support\Facades\Mail;

trait ErrorTrait

{  

    //todo count of Orders for users
    protected function checkwork(){

       $tourism = Tourism::where('expire','!=',Role::EXPIRE)->orWhere("created_at",Carbon::today()->toDateString())->get()->pluck('machine_id')->toArray();
       $revive = Revive::where('expire','!=',Role::EXPIRE)->orWhere("created_at",Carbon::today()->toDateString())->get()->pluck('machine_id')->toArray();
       $arry_merge = array_merge($tourism,$revive);
       $arry_unique = array_unique($arry_merge); 
       //? id machine not work //
       $imnw = $this->notWork($arry_unique);
       $this->errorMail($imnw);

    }

    // todo call data and return machine id not work 
    protected function notWork($arr){
        $machine = Machine::get()->pluck("id")->toArray();
        $array_diff = array_diff($machine , $arr);
        $machineinfo = $this->machineInfo($array_diff);
        return $machineinfo;
    } 

    // todo call data and return machine not work  information 
    protected function machineInfo($machineid){
        $machineinfo = [];
        foreach ($machineid as $id) {
            $machine = Machine::find($id);
            $machines = $machine->user;
            array_push($machineinfo,$machine);
        }  
        return $machineinfo;
   }

    // todo return mail to admin and Owner of this machine //
    protected function errorMail($machine){
        $date = Carbon::now();
        foreach ($machine as $info) {
            $info->date = $date;
            Mail::to($info->user->gmail)->send(new ErrorMachinemailer($info));
        }
  
   }
   
   
 

}