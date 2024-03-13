<?php
namespace App\Traits;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Revive;
use App\Models\Machine;
use App\Models\Tourism;
use App\Mail\AdminReport;
use App\Mail\Reportmailer;
use App\Events\WarningMachine;
use App\Models\CarbonFootprint;
use App\Mail\CarbonFootprintFactory;
use App\Traits\MachineLearningTrait;
use Illuminate\Support\Facades\Mail;

trait ReportTrait 

{  
    // todo check if data less then last data // (warning must co2 less then last co2 data)//
    protected function checkreadings($request,$model){
      if($model == Role::REVIVE){
      $checkgreen = $this->checkGreenTree($request->machineids,$request);   
      if($checkgreen == true){return $checkgreen;}  
      $machine_readings =  Revive::where("machine_id",$request->machineids)->latest()->first();
      $warning = $this->calculatewarning($request , $machine_readings);
      return $warning; 
    }
    else{
      $machine_readings =  Tourism::where("machine_id",$request->machineids)->latest()->first();
      $warning = $this->calculatewarning($request , $machine_readings);
      return $warning; 
    }
  }

  // todo calculate warning and update warning in database //
  protected function calculatewarning($request , $data){
    if (($request->co2 > $data->co2)||($request->co > $data->co)) 
    {
      $machine =  Machine::find($data->machine_id);
      // todo belongs to with model machine //
      $machines = $machine->user;
      
      event(new WarningMachine($machine)); 
      $report =  $this->report($machine);
      return $report;
    }
    else{}
  }

    // todo send report mail to owner and admin //
    protected function report($machines){
      if($machines->warning != null){
      $date = Carbon::now();  
      $machine =  Machine::find($machines->id);
      $machines = $machine->user;
      $machine -> date = $date;
      Mail::to($machine->user->gmail)->send(new Reportmailer($machine));
      if($machine ->warning == 5){Mail::to(env('MAIL_FROM_ADDRESS',Role::MailRevive))->send(new AdminReport($machine));}
    }}


    // todo send report mail to owner and admin for report carbon footprint factory //
    protected function check_rcf_factory($machine ,$ratio){
      return $machine;
      $Barter = $this->checkBarter($machine,$ratio);
      $this->insertcfpfactory($machine->id ,$ratio);
      if($machine->carbon_footprint != null){
      if($machine->carbon_footprint < $ratio){ $this->rcf_factory($machine);}
      else{}}
    }

    // todo send report mail to owner and admin for report carbon footprint factory //
    protected function rcf_factory($machine){
      $date = Carbon::now();  
      $machine -> date = $date;
      Mail::to($machine->user->gmail)->send(new CarbonFootprintFactory($machine));
      Mail::to(env('MAIL_FROM_ADDRESS',Role::MailRevive))->send(new CarbonFootprintFactory($machine));
    }

    // todo send report mail to owner and admin for report readings factory //
    protected function checkGreenTree($machineid , $request){
       $greentree = 0;$count = 0; 
       $machine = Machine::find($machineid);
       $greentrees = Machine::where("type",Role::GREENTREE)->where("owner_id",$machine->owner_id)->get("carbon_footprint");
       if($greentrees->count() !=0 ){return true;}
       return false;
     }
     
     // todo check Barter Process // 
     protected function checkBarter($ratio){

     $Barter = CarbonFootprint::where();



     }

   


    

   
}