<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Traits\ExellTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Traits\MachineLearningTrait;
use Symfony\Component\Process\Process;
use robertogallea\LaravelPython\Services\LaravelPython;
use Symfony\Component\Process\Exception\ProcessFailedException;

class MachineLearningController extends Controller
{
    //
    use ResponseTrait , ExellTrait  , MachineLearningTrait ;

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
        return $this-> returnData("Python Output" , $output);

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
      
         $data = [
             'transport' => "yes",
             'oil' => "yes",
             'day' => "30",
         ];
         $output = $this->sendDataPy($data , Role::FOOTPRINTFACTORY);
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
