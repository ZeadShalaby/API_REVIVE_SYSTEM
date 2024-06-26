<?php

namespace App\Http\Controllers\Api;


use Auth;
use Exception;
use Validator;
use App\Models\Role;
use App\Mail\Weather;
use App\Models\Machine;
use App\Models\Tourism;
use App\Traits\ErrorTrait;
use App\Traits\ReportTrait;
use App\Traits\MachineTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Traits\validator\ValidatorTrait;

class TourismController extends Controller
{
    use ResponseTrait , TestAuth , ReportTrait , MachineTrait , ErrorTrait , ValidatorTrait;

     /**
     * todo Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // todo search by 
        
        if(auth()->user()->role !=Role::ADMIN){
            $filterResult = Tourism::where('machine_id', $request->machineid)->where('expire','!=',Role::EXPIRE)->with("machine","user")->get(); 
        if(isset($filterResult)&& $filterResult->count() != 0){if($machine->user->id != auth()->user()->id){return $this->returnError("403" , "Something Wrong Try again latter");}}
        return $this->returnData("data",$filterResult);
        }
        $query = $request->get('query');
        $filterResult = Tourism::where('machine_id', $request->machineid)->with("machine","user")->get();
       
        return $this->returnData("data",$filterResult);

    }

    /**
     * todo Store a newly created resource in storage.
     * ! hard can do this but type (tc) //
     */
    public function store(Request $request)
    {
        // ! valditaion
        $rules = $this->rulesTourism();
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        //?to check readings & type of machine its correct or not //
        $checkreadings = $this->checkreadings($request,Role::REVIVE);
        $checktype = $this->checktype($request->machineids,Role::REVIVE);
        if($checktype == true){return $this->returnError("EM403","Machine type not :");}
            
        // ? calculate o2 ratio //
        $o2 = (25 - ($request->co + $request->co2 ));
        
        $posts = Tourism::create([
            "machine_id" => $request->machineids,
            "co2" => $request->co2,
            "co" => $request->co,
            "o2" => $o2,
            "degree" => $request->degree,
            "humidity" => $request->humidity
        ]); $weather = $this->weather($request->machineids); 
        $msg = " insert successfully :)...!";
        return $this->returnSuccessMessage($msg);
    
    }

    /**
     * todo Display the specified resource.
     * 
     */
    public function show(Request $request)
    {
       // ! valditaion
       $rules = $this->rulesdate();
       $validator = $this->validate($request,$rules);
       if($validator !== true){return $validator;}

       // ? show data revive by date //
       $datamachines = Tourism::where('machine_id',$request->machineid)->whereDate("created_at",$request->created_at)->with("machine",['user' => function ($query) {$query->withTrashed(); }])->get();
    
       if(isset($datamachines) && $datamachines->count() != 0){if($machine->user->id != auth()->user()->id){return $this->returnError("403" , "Something Wrong Try again latter");}}
       return $this->returnData("Data",$datamachines);
    }

    // ! all users can do this //
    // todo return info of tourist areas 
    public function touristareas(Request $request){

        $machine = Machine::select('id','name','location','carbon_footprint','type')->where("type",Role::TOURISM)->orwhere("type",Role::COASTAL)->orwhere("type",Role::FCI)->get();
        $data = $this->formatdata($machine);
        return $this->returnData("Data",$data);
        
    }

}
