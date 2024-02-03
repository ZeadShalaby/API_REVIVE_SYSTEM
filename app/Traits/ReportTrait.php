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
use Illuminate\Support\Facades\Mail;

trait ReportTrait

{  
    // todo check if data less then last data // (warning must co2 less then last co2 data)//
    protected function checkreadings($request,$model){
      if($model == Role::REVIVE){
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
      // todo belongs to with model orders //
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

   
}