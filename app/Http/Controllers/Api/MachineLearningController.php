<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Traits\ExellTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Symfony\Component\Process\Process;
use robertogallea\LaravelPython\Services\LaravelPython;
use Symfony\Component\Process\Exception\ProcessFailedException;

class MachineLearningController extends Controller
{
    //
    use ResponseTrait , ExellTrait;

    //! finally its work //
    public function sayhellow(Request $request)
    {
        
        $process = new Process(['python', base_path() . env("API_VALIDATION","/public/code_python/code_model/python.py")]);
        $process->run();
        if (!$process->isSuccessful()) { throw new ProcessFailedException($process);}

        return response()->download($filename, $filename, $headers);
       // return $process->getOutput();

    }


   


  //! dioxide ratio (Co2) //
  public function dioxide_ratio(Request $request)
  {
      
      $process = new Process(['python', base_path() . env("PATH_PYTHON_dioxide","/public/code_python/code_model/dioxide_ratio.py")]);
      $process->run();
      if (!$process->isSuccessful()) { throw new ProcessFailedException($process);}
      return $process->getOutput();

  }



    //! Training Data classfication , model //
    public function tranining(Request $request)
    {
    
        $process = new Process(['python', base_path() . env("PATH_PYTHON_training","/public/code_python/code_model/training_data.py")]);
        $process->run();
        if (!$process->isSuccessful()) { throw new ProcessFailedException($process);}
        $this->ReadFile($process->getOutput());
        return $process->getOutput();

    }





}
