<?php
namespace App\Traits;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Revive;
use App\Models\Machine;
use App\Models\Tourism;
use App\Mail\AdminReport;
use App\Mail\Reportmailer;
use App\Models\PurchingCFP;
use App\Events\WarningMachine;
use App\Mail\CarbonFootprintFactory;
use App\Traits\MachineLearningTrait;
use Illuminate\Support\Facades\Mail;
use App\Traits\weather\WeatherpyTrait;

trait ReportTrait 

{  
  use WeatherpyTrait;

    // todo check if data less then last data // (warning must co2 less then last co2 data)//
    protected function checkreadings($request,$model){
      $machine = Machine::find($request->machineids);
      if($machine->type == Role::REVIVE){
      $checkgreen = $this->checkGreenTree($request->machineids,$request);   
      if($checkgreen == true){return $checkgreen;}  
      $machine_readings =  Revive::where("machine_id",$request->machineids)->latest()->first();
      $warning = $this->calculatewarning($request , $machine_readings);
      return $warning; 
    }
    else{
      if($machine->type == Role::WEATHER){return true;}
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
      $Barter = $this->checkBarter($machine,$ratio);
      $this->insertcfpfactory($machine->id ,$Barter);
      if($machine->carbon_footprint != null){
      if($machine->carbon_footprint < $Barter){ $this->rcf_factory($machine);}
      else{}}
      if($Barter > 0){return $Barter;}else{return $ratio;};
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
     protected function checkBarter($machine , $ratio){
      $buyer = $this->BarterBuyer($machine);
      $seller = $this->BarterSeller($machine);
      $result = abs($buyer - ($seller + $ratio));
      return $result;
     }

    // todo calculate Barter Buyer Process // 
    protected function BarterBuyer($machine){$buyer = 0;
      $Barter_buyer = PurchingCFP::where("machine_buyer_id",$machine->id)->get();
      if($Barter_buyer->count() != 0){
        foreach ($Barter_buyer as $buyers) {
          $buyer += $buyers->carbon_footprint;
        }}
        return $buyer;
    }

    // todo calculate Barter Seller Process // 
    protected function BarterSeller($machine){$seller = 0;
      $Barter_seller = PurchingCFP::where("machine_seller_id",$machine->id)->get();
      if($Barter_seller->count() != 0){
        foreach ($Barter_seller as $sellers) {
          $seller += $sellers->carbon_footprint;

        }}
        return $seller;
    }




   
}