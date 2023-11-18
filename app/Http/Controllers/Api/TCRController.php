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
use App\Http\Controllers\Controller;

class TCRController extends Controller
{
    use MethodconTrait,ResponseTrait;
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
        // ? edit machine //
        $machine = Machine::find($request->machineid);
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
        // ? delete machine //
        $machine = Machine::find($request->machineid);
        $machine ->delete();
        $msg = " delete : " .$request->name . " machine " ."successfully .";
        return $this->returnSuccessMessage($msg);

    }


     /**
     * todo Autocomplete Search the specified resource from storage.
     * ! only admin can do this
     */
    public function autocolmpletesearch(Request $request)
    {
        // ? search by name machine || location // 
        $query = $request->get('query');
        if($request->type){
            $type = $this->checktype($request->type);
            $filterResult = Machine::where('type',$type)->where('name', 'LIKE', '%'. $query. '%')
            ->orwhere('location', 'LIKE', '%'. $query. '%')
            ->get();
             return $this->returnData("machine",$filterResult);
        }else{
            $filterResult = Machine::where('type',Role::REVIVE)->where('name', 'LIKE', '%'. $query. '%')
            ->orwhere('location', 'LIKE', '%'. $query. '%')
            ->get();
            return $this->returnData("machine",$filterResult);
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
        $type = $this->checktype($request->type);
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
       Machine::withTrashed()->find($request->mhreviveid)->restore();
       return $this->returnSuccessMessage("Restore Machine Successfully .");
    }
    
}
