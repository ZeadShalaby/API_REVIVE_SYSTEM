<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Revive;
use App\Models\Machine;
use App\Models\Tourism;
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
use App\Traits\validator\ValidatorTrait;
use Symfony\Component\Process\Exception\ProcessFailedException;

class MachineLearningController extends Controller
{
    
    use ResponseTrait , ExellTrait  , MachineLearningTrait , ReportTrait , ValidatorTrait ;

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
        // todo validate footprint peerson //
        // ! valditaion
        $rules = $this->rulesperson();    
        $validator = $this->validatepy($request['question'],$rules);
        if($validator !== true){return $validator;}
   
        $data = $request->question;
        $output = $this->sendDataPy($data , Role::DIOXIDEPY);     
        $report = $this->check_rcp_person(auth()->user() ,$output[0] ); /*$output*/;
        $user = auth()->user(); $user->ratio = $output[0]; // ? ratio in output return code machine //
        $person_footprint = event(new FootprintPeople($user));

        return $this-> returnData("Python Output" , $output[0] ,$report);

    }

     //?.///
     //! training carbon footprint for ( person ) in years or weeak  (tcfpf) => (training carbon footprint person ) //
     public function tcfpperson_years(Request $request)
     {
        //! Validation
        $rules = ["date" => "required|string|regex:/^\d{1,4}[yma]$/"];    
        $validator = $this->validate($request, $rules);
        if($validator !== true) {return $validator;}

        if($request->date == "1a"){$user_footprint = footprintperson::where("user_id", auth()->user()->id)->whereDate('created_at','<=',Carbon::now()->format('Y-m-d'))->get();}
        else{$date = $this->formatdate($request->date);
        //? Determine the method to use based on the condition stored in the $date array
        $method = $date["where"];
        //? Search for the training carbon footprint based on the specified condition
        $user_footprint = footprintperson::where("user_id", auth()->user()->id)->$method("created_at", $date["num"])->get();}
        //?Send data to Python
        $output = $this->sendDataPy($user_footprint , Role::TRAININGFOOTPRINTPERSON); 
        
        return $this->returnData("Python Output" , $output);
       
        
     }

    //?.///
    //! Training Data classfication , model //
    public function tranining(Request $request)
    {
        // ! valditaion
        $rules = ["date" => "required|string|regex:/^\d{1,4}[yma]$/","machineids" => "required|integer"];    
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // todo check regality of this machine or not
        $infomachine = $this->CheckRegality($request->machineids);
        if(auth()->user()->role != Role::ADMIN){
        if($infomachine['bool']!= true ){return $this->returnError("M403" , "OOPS Some thing Wrongs :( ...!");}
        }
        
        // ! owner regality | Admin
        if($request->date == "1a"){if($infomachine['table'] == "Revive"){$factory_footprint = Revive::where("machine_id",$request->machineids )->whereDate('created_at','<=',Carbon::now()->format('Y-m-d'))->get();}
        else{$factory_footprint = Tourism::where("machine_id",$request->machineids )->whereDate('created_at','<=',Carbon::now()->format('Y-m-d'))->get();}}
        else{$date = $this->formatdate($request->date);
        //? Determine the method to use based on the condition stored in the $date array
        $method = $date["where"];
        //? Search for the training carbon footprint based on the specified condition
        if($infomachine['table'] == "Revive"){$factory_footprint = $table::where("machine_id",$request->machineids )->$method("created_at", $date["num"])->get();}else{$factory_footprint = $table::where("machine_id",$request->machineids )->$method("created_at", $date["num"])->get();}}

        $output = $this->sendDataPy($factory_footprint , Role::TRAINGPY);
        return $this-> returnData("Python Output" , $output);

        
    }

    //! dioxide ratio (Co2) footprint for ( factory ) regression , model //
    public function carbon_footprint(Request $request)
    {
        // ! valditaion
        $rules = $this->rulesfactory();    
        $validator = $this->validatepy($request['question'],$rules);
        if($validator !== true){return $validator;}

        try {
        
        $machineids = Machine::where("owner_id",auth()->user()->id)->where("id",$request->maachineid)->value("id");
        $machine = Machine::find($machineids);
        $users = $machine->user;

        $data = $request->question;
        $output = $this->sendDataPy($data , Role::FOOTPRINTFACTORY); 
        $report = $this->check_rcf_factory($machine , $output[0]); /*$output*/;
        $machine ->ratio = $report ;    /*$output*/;
        $carbon_footprint = event(new CarbonFootprint($machine));

        return $this-> returnData("Python Output" , $output[0]);
    } catch (Throwable $th) {
        return $this->returnError("M404","OOPS Apply for the first machine , or contact the officials to find out your problem and help you :)... !");
    }
    
    }

    //! training carbon footprint for ( factory ) in years or weeak  (tcfpf) => (training carbon footprint factory ) //
    public function tcfpfactory_years(Request $request)
    {
        // ! valditaion
        $rules = ["date" => "required|string|regex:/^\d{1,4}[yma]$/","machineids" => "required|integer"];    
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ! Admin
        if(auth()->user()->role == Role::ADMIN){
           
        }

        // !owner
        if($request->date == "1a"){$factory_footprint = footprintfactory::where("machine_id",$request->machineids )->whereDate('created_at','<=',Carbon::now()->format('Y-m-d'))->get();}
        else{$date = $this->formatdate($request->date);
        //? Determine the method to use based on the condition stored in the $date array
        $method = $date["where"];
        //? Search for the training carbon footprint based on the specified condition
        $factory_footprint = footprintfactory::where("machine_id",$request->machineids )->$method("created_at", $date["num"])->get();}
        //?Send data to Python
        $output = $this->sendDataPy($factory_footprint , Role::TRAININGFOOTPRINTFACTORY); 
        
        return $this->returnData("Python Output" , $output);

    }
 

    //! Chat auto and learning from question , libarry //
    public function chat(Request $request)
    {
        // ! valditaion
        $rules = ["question" => "required|string"];    
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        $data = [
            'question' => $request->question,
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
