<?php
namespace App\Traits;

use Symfony\Component\Process\Process;
use robertogallea\LaravelPython\Services\LaravelPython;
use Symfony\Component\Process\Exception\ProcessFailedException;

trait MachineLearningTrait

{  
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
        //? return path Dioxide ratio python
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
        //? return path Chat python
        case 6:
          return array("PATH_PYTHON_footprint_factory","/public/code_python/code_model/carbon_footprint.py");
          break; 
        //? return path default python
        default:
          return array("PATH_PYTHON_test","/public/code_python/code_model/python.py"); 
    }

   }

    // todo check the old ratio biger then new ratio or not //
    protected function check_rcp_person($user , $ratio){

      if(isset($user->carbon_footprint) && $user->carbon_footprint != null){
          if($user->carbon_footprint >= $ratio){
            return "Your Safe Sir : $user->username your Carbon footprint its perfect";
          }
          else{       
            return "Your Are In Dangerous Sir : $user->username your Carbon footprint it's bigger in usually";
          }}
      else{return "Its your First Time To Check CarbonFootprint Enjoying Sir : $user->username";}

    }

}    