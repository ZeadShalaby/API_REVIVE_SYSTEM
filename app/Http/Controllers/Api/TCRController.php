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
use App\Traits\MethodconTrait;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;

class TCRController extends Controller
{
    use MethodconTrait,ResponseTrait,TestAuth;



    
     /** 
     * todo Show the form for creating a new resource.
     * ! only admin can add a new revive | tourism hardware
     */// ? tcr mening : Tourism & Revive & Coastal  //
     public function newtcr(Request $request)
     {
          //! rules
          $rules = $this->rulestcr();
         // ! valditaion
         $validator = Validator::make($request->all(),$rules);
     
         if($validator->fails()){
                 $code = $this->returnCodeAccordingToInput($validator);
                 return $this->returnValidationError($code,$validator);
         }
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
        $rules = $this->rulesMachineUpdate();
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }
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
        // ? delete machine //
        $machine = Machine::find($request->machineid);
        if(!isset($machine)){return $this->returnError("M404","Alredy Deleted Machine :)..!");}
        $msg = " delete : " .$machine->name . " machine " ."successfully .";
        $machine ->delete();
        return $this->returnSuccessMessage($msg);

    }


     /**
     * todo Autocomplete Search the specified resource from storage.
     * ! only admin can do this
     */
    public function autocolmpletesearch(Request $request)
    {
        // ? search by name || location machine // 
        $query = $request->get('query');

        if($request->type != NULL){
            $type = $this->checkTypeMachine($request->type);
            $filterResult = Machine::where('type',$type)
            ->whereAny('name', 'LIKE', '%'. $query. '%')
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
       Machine::withTrashed()->find($request->mchrestore)->restore();
       return $this->returnSuccessMessage("Restore Machine Successfully .");
    }
    
}
