<?php
namespace App\Traits;

use Exception;
use Validator;
use Carbon\Carbon;
use App\Models\Machine;
use App\Traits\MethodconTrait;
use App\Models\footprintperson;
use App\Models\footprintfactory;
use App\Traits\Requests\TestAuth;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;

trait MachineLearningTrait

{  
  use TestAuth , MethodconTrait;
    //todo count of Orders for users
    protected function sendDataPy( $data , $path ){
  
    $path = $this->codePath($path);    
    $pythonScriptPath = base_path($path[1]);
    
        // Check if the script file exists
    if (file_exists($pythonScriptPath)) {
        
        $jsonData = json_encode($data);
        Storage::disk('json')->put('data.json', $jsonData);
        // Execute the Python script
        exec('python ' . escapeshellarg($pythonScriptPath), $output, $returnCode);
        return $output;
        }
  
  }

   //todo count of Orders for users
   protected function codePath($code){

    switch($code) {
        //? return path test python
        case 1:
          return array('PATH_PYTHON_test','/public/code_python/code_model/python.py'); 
          break;
        //? return path Dioxide ratio python footprint person
        case 2:
          return array("PATH_PYTHON_dioxide","/public/code_python/code_model/dioxide_ratio.py");
          break;
        //? return path Training data python
        case 3:
          return array("PATH_PYTHON_training","/public/code_python/code_model/training_data.py");
          break;
        //? return path Weather python
        case 4:
          return array("PATH_PYTHON_weather","/public/code_python/code_model/weather.py");
          break; 
        //? return path Chat python
        case 5:
          return array("PATH_PYTHON_chat","/public/code_python/code_model/chat.py");
          break; 
        //? return path carbon_footprint factory for product python
        case 6:
          return array("PATH_PYTHON_footprint_factory","/public/code_python/code_model/carbon_footprint.py");
          break; 
        //? return path training carbon footprint for person python
        case 7:
          return array("PATH_PYTHON_training_footprint_person","/public/code_python/code_model/trainng_footprint_person.py");
          break; 
          //? return path carbon footprint for factory python
        case 8:
          return array("PATH_PYTHON_training_footprint_factory","/public/code_python/code_model/trainng_footprint_factory.py");
          break; 
        //? return path default python
        default:
          return array("PATH_PYTHON_test","/public/code_python/code_model/python.py"); 
    }

   }

    // todo check the old ratio biger then new ratio or not //
    protected function check_rcp_person($user , $ratio){
      $this->insertcfpperson($user->id , $ratio);
      if(isset($user->carbon_footprint) && $user->carbon_footprint != null){
          if($user->carbon_footprint >= $ratio){
            return "Your Safe Sir : $user->username your Carbon footprint its perfect";
          }
          else{       
            return "Your Are In Dangerous Sir : $user->username your Carbon footprint it's bigger in usually";
          }}
      else{return "Its your First Time To Check CarbonFootprint Enjoying Sir : $user->username";}

    }
   
   
    // todo insert carpon footprint for person  //
    protected function insertcfpperson($user , $ratio) {
      if((isset($user) && isset($ratio)) && ($user != 0 && $ratio != 0)){
       $footprint_person = footprintperson::create([
           "user_id" => $user,
           "carbon_footprint" => $ratio,
       ]);
      }
    } 

    // todo insert carpon footprint for person  //
    protected function insertcfpfactory($machine , $ratio) {
       if((isset($machine) && isset($ratio)) && ($machine != 0 && $ratio != 0)){
       $footprint_factory = footprintfactory::create([
           "machine_id" => $machine,
           "carbon_footprint" => $ratio,
       ]);
    } }

       
    // todo format date to Know what i search it year or month or weak 
    protected function formatdate($date)
    {
        $searchTerm = $date;
        //? Extract numeric value and string part from the search term
        preg_match('/(\d+)(\D+)/', $searchTerm, $matches);

        if (!empty($matches)) {
            $numericValue = $matches[1]; //? Extract numeric value
            $query = $this->QuerySearch($matches[2]); //? Extract string part
            
            return array('num' => "$numericValue",'where' => $query);

        } else {
            //! Invalid search term provided
            return response()->json(['error' => 'Invalid search term'], 400);
        }
    }

    // todo check query where year or month or weak 
    protected function QuerySearch($string) {
      if(strtolower($string) == "y"){
         return "whereYear";
      }elseif(strtolower($string) == "m"){
         return "whereMonth";
      }else{return null;}
      
    }

    // todo check Regality and type of this machine 
    protected function CheckRegality($machineids) {
      $machine = Machine::find($machineids);
      $typemachine = $this->checkRoleMachine($machine->type);
      if($machine->owner_id == auth()->user()->id){
        return array("bool"=>true , "table"=>$typemachine);
      }else{return array("bool"=>false , "table"=>$typemachine);}
    }

}    