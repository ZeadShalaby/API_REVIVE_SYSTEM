<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use robertogallea\LaravelPython\Services\LaravelPython;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class MachineLearningController extends Controller
{
    //
    use ResponseTrait;

    public function sayhellowss(Request $request)
    {
        $path = public_path('images/say.py');
        exec('python '.$path.'' , $output , $resultCode);
        var_dump($output);

    }

    public function sayhelslow(Request $request)
    {
        //$path = public_path('images/say.py');
      //  exec('python '.$path.'', $output, $retval);
      $output=null;
      $retval=null;
      exec('whoami', $output, $retval);
      echo "Returned with status $retval and output:\n";
      print_r($output);
    }

    public function sayhellows(LaravelPython $service)
    {
        $result = $service->run('/say.py');
        $parameters = array('par1', 'par2');
        $result = $service->run('/say.py', $parameters);
    }


    public function sayheellow(LaravelPython $service)
    {
        //$process = new Process('python /path/to/your_script.py'); //This won't be handy when going to pass argument
        $process = new Process(['python','/images/say.py']);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();

    }

    public function sayhelloww(LaravelPython $service)
    {
        $process = Process::fromShellCommandline('python D:\my projects\API\API Laravel\Graduation Api Project\Revive\public\images\say.py');
        $process->run(); 

    }


    public function sayhellow(Request $request)
    {
        exec('python ./public/code_python/say.py', $output, $retval);
        echo "Returned with status $retval and output:\n";
        print_r($output);

    }
  







}
