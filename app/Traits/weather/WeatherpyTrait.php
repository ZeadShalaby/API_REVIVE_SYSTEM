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
        $output = $this->sendDataPy($readingsmachine , Role::WEATHERPY);
        //strtolower($output);
        $machine->condation = "sunny";//$output;
        event(new WeatherConditions($machine));
        $machine->date = Carbon::now()->format('Y,M,D');
        $test = "runny";
        // todo send mail to owner of machine weather 
        if($machine->type == Role::WEATHER && $test /*$output*/!= $machine->weather){ Mail::to("zeadshalaby1@gmail.com")->send(new WeatherCondition($machine));}
        return true;
     }
    }