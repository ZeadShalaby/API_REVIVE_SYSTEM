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
         // todo search by 
         if(auth()->user()->role !=Role::ADMIN ){
             $machineid = Machine::where('owner_id',auth()->user()->id)->get();
             foreach ($machineid as $belong) {
                 $machine = $belong->user; 
             }
             
             return $this->returnData("data",$machineid);
         }
         $query = $request->get('query');
         $machines = Machine::where('machine_id', 'LIKE', '%'. $query. '%')->get();
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
        // todo search by 
        if(auth()->user()->role !=Role::ADMIN ){
            $filterResult = Revive::where('machine_id' , $request -> machineid)/*->where('expire',Role::EXPIRE)*/->get();
            foreach ($filterResult as $belong) {
                $machine = $belong->machine; 
                $machines = $machine->user; 
            }
            return $this->returnData("data",$filterResult);
        }
        $query = $request->get('query');
        $filterResult = Revive::where('machine_id', 'LIKE', '%'. $query. '%')/*->where('expire',Role::EXPIRE)*/->get();
        foreach ($filterResult as $belong) {
            $machine = $belong->machine; 
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

        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }

        $posts = Revive::create([
            "machine_id" => $request->machineids,
            "co2" => $request->co2,
            "co" => $request->co,
            "o2" => '12',
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
        //
          $datarevive = Revive::where('machine_id',$request->machineid)
          ->whereDate('created_at',$request->createat)->get()->toArray();
          return $this->returnData("Data",$datarevive);
    }


    /** 
     * todo Show the form for creating a new resource.
     * ! only admin can add a new revive | tourism hardware
     */// ? tcr mening : Tourism & Revive & Coastal  //
     public function newtcr(Request $request)
     {
          //! rules
          $rules = [
             "name" => "required|unique:machines,name",
             "owner_id" => "required|exists:users,id",
             "location" => "required|unique:machines,location",
             "type" => 'required|integer|min:5|max:7',
            ];
 
         // ! valditaion
         $validator = Validator::make($request->all(),$rules);
     
         if($validator->fails()){
                 $code = $this->returnCodeAccordingToInput($validator);
                 return $this->returnValidationError($code,$validator);
         }
 
         $machines = Machine::create([
             "name" => $request->name,
             "owner_id" => $request->owner_id,
             "location" => $request->location,
             "type" => $request->type,
         ]);
 
         $msg = " Create : " .$request->name . " machine " ."successfully .";
         return $this->returnSuccessMessage($msg);
     }
 


    /**
     * todo Show the form for editing the specified resource.
     * ! only admin can do this
     */
    public function edit(Request $request)
    {
        //
        $machine = Machine::find($request->machineid);
        return $this->returnData("machine",$machine);

    }

    /**
     * todo Update the specified resource in storage.
     * ! only admin can do this
     */
    public function update(Request $request, string $id)
    {
        //
        $machine = Machine::find($request->machineid);        
        $rules = [
            "name" => "required",
            "owner_id" => "required|exists:users,id",
            "location" => "required",
            "type" => 'required|integer|min:5|max:7',

        ];
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }
        $machine->update([
            "name" => $request->name,
            "owner_id" => $request->owner_id,
            "location" => $request->location,
            "type" => $request->type,
        ]);
             
        $msg = " Update : " .$request->name . " machine " ."successfully .";
        return $this->returnSuccessMessage($msg);
    }

    /**
     * todo Remove the specified resource from storage.
     * ! only admin can do this
     */
    public function destroy(Request $request)
    {
        //
        $machine = Machine::find($request->machineid);
        $machine ->delete();
        $msg = " delete : " .$request->name . " machine " ."successfully .";
        return $this->returnSuccessMessage($msg);

    }

    
    /**
     * todo restore index the specified resource from storage.
     * ! only admin can do this
     */
    public function restoreindex()
    {
       //
    }

     /**
     * todo  restore the specified resource from storage.
     * ! only admin can do this
     */
    public function restore()
    {
       //
    }
    
    /**
     * todo Autocomplete Search the specified resource from storage.
     * ! only admin can do this
     */
    public function autocolmpletesearch()
    {
       //
    }

}
