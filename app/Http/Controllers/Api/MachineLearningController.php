<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\Machine;
use App\Traits\ExellTrait;
use App\Traits\ReportTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Events\CarbonFootprint;
use App\Events\FootprintPeople;
use App\Models\footprintperson;
use App\Models\footprintfactory;
use App\Http\Controllers\Controller;
use App\Traits\MachineLearningTrait;
use Symfony\Component\Process\Process;
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
        $report = $this->check_rcp_person(auth()->user() , 47); /*$output*/;
        $user = auth()->user(); $user->ratio = 47; // ? ratio in output return code machine //
        $person_footprint = event(new FootprintPeople($user));
        return $this-> returnData("Python Output" , $output ,$report);

    }

     //?.///
     //! training carbon footprint for ( factory ) in years or weeak  (tcfpf) => (training carbon footprint factory ) //
     public function tcfpperson_years(Request $request)
     {
       $user_footprint = footprintperson::where("user_id",auth()->user()->id)->get(); 
       $output = $this->sendDataPy($user_footprint , Role::TRAININGFOOTPRINTPERSON); 
       return $this-> returnData("Python Output" , $output);
       
     }

    //?.///
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

     //?.///
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


    //! dioxide ratio (Co2) footprint for ( factory ) regression , model //
    public function carbon_footprint(Request $request)
    {
        
        $machineids = Machine::where("owner_id",auth()->user()->id)->where("id",$request->maachineid)->value("id");
        $machine = Machine::find($machineids);
        $users = $machine->user;
        $data = [
                'transport' => "yes",
                'oil' => "yes",
                'day' => "30",
            ];
        $output = $this->sendDataPy($data , Role::FOOTPRINTFACTORY); 
        $report = $this->check_rcf_factory($machine , 37); /*$output*/;
        $machine ->ratio = $report ;    /*$output*/;
        $carbon_footprint = event(new CarbonFootprint($machine));
        return $this-> returnData("Python Output" , $output);
    
    }

    //! training carbon footprint for ( factory ) in years or weeak  (tcfpf) => (training carbon footprint factory ) //
    public function tcfpfactory_years(Request $request)
    {
        // ! validation remmember ziad its important 
        if(auth()->user()->role == Role::ADMIN){
           
        }

        $machineids = Machine::where("owner_id",auth()->user()->id)->value("id");
        $footprintfactory = footprintfactory::find($machineids);
        $machines = $footprintfactory->machine;
        $output = $this->sendDataPy($footprintfactory , Role::TRAININGFOOTPRINTFACTORY); 
        return $this-> returnData("Python Output" , $output);

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