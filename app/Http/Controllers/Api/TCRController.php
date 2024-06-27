<?php

namespace App\Http\Controllers\Api;

use Auth;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Revive;
use App\Models\Machine;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\MethodconTrait;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;
use App\Traits\validator\ValidatorTrait;

class TCRController extends Controller
{
    use MethodconTrait , ResponseTrait , TestAuth , ValidatorTrait;


     /** 
     * todo Show the form for creating a new resource.
     * ! only admin can add a new revive | tourism  | other hardware
     */// ? tcr mening : Tourism & Revive & Coastal  //
     public function newtcr(Request $request)
     {
         // ! valditaion
         $rules = $this->rulestcr();
         $validator = $this->validate($request,$rules);
         if($validator !== true){return $validator;}

         $type = $this->checkTypeMachine($request->type);
         if($type == null){return $this->returnError("T404","OOPS Write Correct Type :(...!");}
         $machines = Machine::create([
             "name" => $request->name,
             "owner_id" => $request->owner_id,
             "location" => $request->location,
             "type" => $type,
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
        // ! valditaion
        $rules = ["machineid" => "required|exists:machines,id"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? edit machine //
        $machine = Machine::find($request->machineid);
        if(!$machine){return $this->returnError('M001'," Some Thing Wrong :( ..!");}
        $machin = $machine->user; 
        return $this->returnData("machine",$machine);

    }

    /**
     * todo Update the specified resource in storage.
     * ! only admin can do this
     */
    public function update(Request $request, string $id)
    {
        // ? update machine //
        $machine = Machine::find($request->machineid);        
        // ! valditaion
        $rules = $this->rulesMachineUpdate();
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        $type = $this->checkTypeMachine($request->type);
        if($type == null){return $this->returnError("T404","OOPS Write Correct Type :(...!");}
        $machine->update([
            "name" => $request->name,
            "owner_id" => $request->owner_id,
            "location" => $request->location,
            "type" => $type,
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
        // ! valditaion
        $rules = ["machineid" => "required|exists:machines,id"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? delete machine //
        $machine = Machine::find($request->machineid);
        if(!isset($machine)){return $this->returnError("M404","Alredy Deleted Machine :)..!");}
        $msg = " delete : " .$machine->name . " machine " ."successfully .";
        $machine ->delete();
        return $this->returnSuccessMessage($msg);

    }

     /**
     * todo calculate FootPrint percentage of this machine .
     * ! only owner can do this
     */
    public function foot_print_percentage(Request $request)
    {
        // ! valditaion
        $rules = ["machineid" => "required|exists:machines,id"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}
        $machine = Machine::with('user')->find($request->machineid);
        if(Auth()->user()->id != $machine->owner_id){return $this->returnError("A403","oops some thing wrong sir : ".$machine->user->username." :( ..!");}
        $percentage = (Role::free_dioxide - $machine->total_CF)/100;
        $result = [
            'total_CF'=> $machine->total_CF,
            'MCF_actually' => $machine->carbon_footprint,
            'percentage_consumption' => $percentage,
            'remaining_percentage' => 100 - $percentage ,
            'machine have' => "2000 kg free of carbon",
        ];      
        return $this->returnData("percentage",$result);
    }


     /**
     * todo Autocomplete Search the specified resource from storage.
     * ! only admin can do this
     */
    public function autocolmpletesearch(Request $request)
    {
        // ! valditaion
        $rules = ["query" => "required"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? search by name || location machine // 
        $query = $request->get('query');

        if($request->type != NULL){
            $type = $this->checkTypeMachine($request->type);
            $filterResult = Machine::where('type',$type)
            ->where('name', 'LIKE', '%'. $query. '%')
            ->orwhere( 'type',$type and 'location', 'LIKE', '%'. $query. '%')
            ->get();
             return $this->returnData("machine",$filterResult);
        }else{
            $filterResult = Machine::where('type',Role::REVIVE)->where('name', 'LIKE', '%'. $query. '%')
            ->orwhere('location', 'LIKE', '%'. $query. '%')
            ->get();
            return $this->returnData("machines",$filterResult);
        }
    }

    
    /**
     * todo restore index the specified resource from storage.
     * ! only admin can do this
     */
    public function restoreindex(Request $request)
    {
        // ? return all post i deleted it //
        if($request->type){
        $type = $this->checkTypeMachine($request->type);
        $mhrevive = Machine::where('type',$type)->onlyTrashed()->get();
        return $this->returnData("machine",$mhrevive);}
        $mhrevive = Machine::where('type',Role::REVIVE)->onlyTrashed()->get();
        return $this->returnData("machine",$mhrevive);
    }

     /**
     * todo  restore the specified resource from storage.
     * ! only admin can do this
     */
    public function restore(Request $request)
    {
       // ! valditaion
       $rules = ["mchrestore" => "required|exists:machines,id"];
       $validator = $this->validate($request,$rules);
       if($validator !== true){return $validator;}

       Machine::withTrashed()->find($request->mchrestore)->restore();
       return $this->returnSuccessMessage("Restore Machine Successfully .");
    }
    
}
