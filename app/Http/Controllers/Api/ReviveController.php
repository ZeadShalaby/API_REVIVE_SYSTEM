<?php

namespace App\Http\Controllers\Api;


use Auth;
use Exception;
use Validator;
use App\Models\Role;
use App\Models\Revive;
use App\Models\Machine;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;

class ReviveController extends Controller
{
    use ResponseTrait;

     //!
     /**
     * todo Display a listing of the resource.
     */ // ? return all machine of this person //
     public function machineindex(Request $request)
     {
         // ? choise machine of owner to sho it and then show data // 
         if(auth()->user()->role !=Role::ADMIN ){
             $machineid = Machine::where('owner_id',auth()->user()->id)->get();
             foreach ($machineid as $belong) {
                 $machine = $belong->user; 
             }
             
             return $this->returnData("data",$machineid);
         }
         $machines = Machine::get();
         foreach ($machines as $belong) {
             $machine = $belong->user; 
         }
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
            $filterResult = Revive::where('machine_id' , $request -> machineid)/*->where('expire',Role::EXPIRE)*/->get();
            foreach ($filterResult as $belong) {
                $machine = $belong->machine; 
                $machines = $machine->user; 
            }
            return $this->returnData("data",$filterResult);
        }
        $query = $request->get('query');
        $filterResult = Revive::/*->where('expire',Role::EXPIRE)*/get();
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
    
        //! rules
        $rules = [
            "machineids" => 'required|integer|exists:machines,id',
            "co2" => 'required|integer',
            "co" => 'required|integer',
            "degree" => 'required|integer',
        ];
        // ? calculate o2 ratio //
        $o2 = (100 - ($request->co + $request->co2 ));
        //return $this->returnData("o2",$o2);
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }
        $check = $this->report();
        if($check == FALSE){

        }
        $posts = Revive::create([
            "machine_id" => $request->machineids,
            "co2" => $request->co2,
            "co" => $request->co,
            "o2" => $o2,
            "degree" => $request->degree,
        ]);

        $msg = " insert successfully .";
        return $this->returnSuccessMessage($msg);
        
    }

    /**
     * todo Display the specified resource with date not id.
     */
    public function show(Request $request)
    {
        // ? show data revive by date //
          $datarevive = Revive::where('machine_id',$request->machineid)
          ->whereDate('created_at',$request->createat)->get()->toArray();
          return $this->returnData("Data",$datarevive);
    }


   
   

}
