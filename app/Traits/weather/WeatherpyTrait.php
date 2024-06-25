<?php
namespace App\Traits\weather;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Comment;
use App\Models\Machine;
use App\Models\Tourism;
use App\Models\Favourite;
use App\Models\SavedPosts;
use App\Traits\ResponseTrait;
use App\Mail\WeatherCondition;
use App\Events\WeatherConditions;
use App\Traits\MachineLearningTrait;
use Illuminate\Support\Facades\Mail;

trait WeatherpyTrait

{  
    use MachineLearningTrait , ResponseTrait;

//?.///
     //! Training Data Weather classfication , model //
     public function weather($machineid)
     {
        $machine = Machine::find($machineid);
        $machine->user;
        
        $readingsmachine = Tourism::where('machine_id',$machine->id)->latest()->first();
        unset($readingsmachine['machine_id'],$readingsmachine['id'],$readingsmachine['expire'],$readingsmachine['created_at']);
        
        $output = $this->sendDataPy($readingsmachine , Role::WEATHERPY);
       // strtolower($output[0]);
        $machine->condation = $output[0];//$output;
        event(new WeatherConditions($machine));
        $machine->date = Carbon::now()->format('Y,M,D');
        // todo send mail to owner of machine weather 
        if($machine->type == Role::WEATHER && $output[0] != $machine->weather){ Mail::to($machine->user->gmail)->send(new WeatherCondition($machine));}
        return true;
     }
    }