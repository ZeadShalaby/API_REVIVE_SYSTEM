<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Symfony\Component\Process\Process;
use robertogallea\LaravelPython\Services\LaravelPython;
use Symfony\Component\Process\Exception\ProcessFailedException;

class MachineLearningController extends Controller
{
    //
    use ResponseTrait;

    //! finally its work //
    public function sayhellow(Request $request)
    {
    
        $process = new Process(['python', base_path() . Role::PATH_PYTHON]);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();

    }


   


  //! dioxide ratio (Co2) //
  public function dioxide_ratio(Request $request)
  {
  
      $process = new Process(['python', base_path() . Role::PATH_PYTHON_dioxide]);
      $process->run();
      if (!$process->isSuccessful()) {
          throw new ProcessFailedException($process);
      }
      return $process->getOutput();

  }



    //! Training Data classfication , model //
    public function tranining(Request $request)
    {
    
        $process = new Process(['python', base_path() . Role::PATH_PYTHON_training]);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();

    }





}
