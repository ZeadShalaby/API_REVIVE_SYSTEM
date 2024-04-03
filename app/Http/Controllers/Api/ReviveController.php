<?php

namespace App\Http\Controllers\Api;


use Auth;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Revive;
use App\Models\Machine;
use App\Models\Tourism;
use App\Traits\ErrorTrait;
use App\Traits\ReportTrait;
use App\Traits\MachineTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;
use App\Traits\validator\ValidatorTrait;

class ReviveController extends Controller
{
    use ResponseTrait,TestAuth ,ReportTrait , MachineTrait , ErrorTrait , ValidatorTrait;

     //!
     /**
     * todo Display a listing of the resource.
     */ // ? return all machine of this person //
     public function machineindex(Request $request)
     {
         // ? choise machine of owner to sho it and then show data // 
         if(auth()->user()->role !=Role::ADMIN ){
             $machineid = Machine::where('owner_id',auth()->user()->id)->with("user")->get();             
             return $this->returnData("data",$machineid);
         }
         $machines = Machine::with("user")->get();
         return $this->returnData("data",$machines);
     }

    //!
     /**
     * todo Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ? show data not expire //
        if(auth()->user()->role !=Role::ADMIN ){
            $filterResult = Revive::where('machine_id' , $request -> machineid)->where('expire','!=',Role::EXPIRE)->get();
            foreach ($filterResult as $belong) {
                $machine = $belong->machine; 
                $machines = $machine->user; 
            }
       if(isset($filterResult)&& $filterResult->count() != 0){if($machine->user->id != auth()->user()->id){return $this->returnError("403" , "Something Wrong Try again latter");}}
            return $this->returnData("data",$filterResult);
        }
        $filterResult = Revive::where('machine_id' , $request -> machineid)->get();
        foreach ($filterResult as $belong) {
            $machine = $belong->machine; 
            $machines = $machine->user; 
        }
        return $this->returnData("data",$filterResult);

    }

    /**
     *todo Store a newly created resource in storage.
     * !hardware to do this insert 
     */
    public function store(Request $request)
    {
        // ! valditaion
        $rules = $this->rulesRevive();
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? calculate o2 ratio //
        $o2 = (100 - ($request->co + $request->co2 )-20);

        //! //
        //?to check readings & type of machine its correct or not //
        $checktype = $this->checktype($request->machineids,Role::REVIVE);
        if($checktype == false){return $this->returnError("EM403","Machine type not : Revive");}
        $checkreadings = $this->checkreadings($request,Role::REVIVE);
        $posts = Revive::create([
            "machine_id" => $request->machineids,
            "co2" => $request->co2,
            "co" => $request->co,
            "o2" => $o2,
            "degree" => $request->degree,
            "humidity" => $request->humidity
        ]);

        $msg = " insert successfully :)...!";
        return $this->returnSuccessMessage($msg);
        
    }

    /**
     * todo Display the specified resource with date not id.
     */
    public function show(Request $request)
    {
        // ! valditaion
        $rules = $this->rulesdate();
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? show data revive by date //
        $datarevive = Revive::where('machine_id',$request->machineid)->whereDate("created_at",$request->created_at)->get();
        foreach ($datarevive as $belong) {
            $machine = $belong->machine; 
            $machines = $machine->user; 
        }
       if(isset($datarevive) && $datarevive->count() != 0){if($machine->user->id != auth()->user()->id){return $this->returnError("403" , "Something Wrong Try again latter");}}
        return $this->returnData("Data",$datarevive);
    }
   

}

// ? return date now //
// $now = Carbon::now();
// return $this->returnData("now",$now);