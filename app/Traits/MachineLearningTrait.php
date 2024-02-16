<?php
namespace App\Traits;

use Exception;
use Validator;
use App\Models\footprintperson;
use App\Models\footprintfactory;
use App\Traits\Requests\TestAuth;
use Symfony\Component\Process\Process;
use robertogallea\LaravelPython\Services\LaravelPython;
use Symfony\Component\Process\Exception\ProcessFailedException;

trait MachineLearningTrait

{  
  use TestAuth;
    //todo count of Orders for users
    protected function sendDataPy( $data , $path ){

    $path = $this->codePath($path);    
    $jsonData = json_encode($data);
    $process = new Process(['python', base_path() . env($path[0],$path[1])]);
    $process ->setInput($jsonData);
    $process->run();
    if (!$process->isSuccessful()) { throw new ProcessFailedException($process);}
    return $process->getOutput();

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

}    