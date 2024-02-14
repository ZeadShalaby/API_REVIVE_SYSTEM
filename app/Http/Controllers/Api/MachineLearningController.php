<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\Machine;
use App\Traits\ExellTrait;
use App\Traits\ReportTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Events\CarbonFootprint;
use App\Events\FootprintPerson;
use App\Http\Controllers\Controller;
use App\Traits\MachineLearningTrait;
use Symfony\Component\Process\Process;
use robertogallea\LaravelPython\Services\LaravelPython;
use Symfony\Component\Process\Exception\ProcessFailedException;

class MachineLearningController extends Controller
{
    //
    use ResponseTrait , ExellTrait  , MachineLearningTrait , ReportTrait ;

    //! finally its work //
    public function sayhellow(Request $request)
    {
        $data = [
            'name' => 'zead',
            'age' => 22,
            'city' => 'spania'
        ];
        $output = $this->sendDataPy($data , Role::TESTPY);
        return $this-> returnData("Python Output" , $output);
      // return response()->download($filename, $filename, $headers);

    }

  //! dioxide ratio (Co2) footprint for person //
  public function dioxide_ratio(Request $request)
  {
      
        $data = [
            'foodprint' => "yes",
            'co2' => 22 ,
            'co' => 12,
            'o2' => 19,
            'degree' => 32,
        ];
        $output = $this->sendDataPy($data , Role::DIOXIDEPY);
        $report = $this->check_rcp_person(auth()->user() , 45); /*$output*/;
        $user = auth()->user(); $user->ratio = 45; // ? ratio in output return code machine //
        $person_footprint = event(new FootprintPerson($user));
        return $this-> returnData("Python Output" , $output ,$report);

  }



    //! Training Data classfication , model //
    public function tranining(Request $request)
    {
    
        $data = [
            'co2' => 22 ,
            'co' => 12,
            'o2' => 19,
            'degree' => 32,
        ];
        $output = $this->sendDataPy($data , Role::TRAINGPY);
        return $this-> returnData("Python Output" , $output);

    }



     //! Training Data Weather classfication , model //
     public function weather(Request $request)
     {
     
        $data = [
            'storm' => "yes",
            'rain' => "no",
            'sunny' => "no",
        ];
        $output = $this->sendDataPy($data , Role::WEATHERPY);
        return $this-> returnData("Python Output" , $output);
 
     }

      //!  dioxide ratio (Co2) footprint for ( factory ) classfication , model //
      public function carbon_footprint(Request $request)
      {
        
        $machineids = Machine::where("owner_id",auth()->user()->id)->value("id");
        $machine = Machine::find($machineids);
        $users = $machine->user;
        $data = [
             'transport' => "yes",
             'oil' => "yes",
             'day' => "30",
         ];
        $output = $this->sendDataPy($data , Role::FOOTPRINTFACTORY); 
        $report = $this->check_rcf_factory($machine , 37); /*$output*/;
        $machine ->ratio = 37 ;    /*$output*/;
        $carbon_footprint = event(new CarbonFootprint($machine));
         return $this-> returnData("Python Output" , $machine);
      }
 
    //! Chat auto and learning from question , libarry //
    public function chat(Request $request)
    {

        $data = [
            'question' => "weather is good !?",
            'answer'  => "yes its good",
        ];
        $output = $this->sendDataPy($data , Role::CHATPY);
        return $this-> returnData("Python Output" , $output);

    }

     // todo return machine image
     public function imagesmachine(Request $request,$machine){
        if(isset($machine)){
          return $this->returnimagemachine($machine,$machine);}
        else {return 'null';}

    }

}
