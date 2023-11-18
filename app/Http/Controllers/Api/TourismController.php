<?php

namespace App\Http\Controllers\Api;


use Auth;
use Exception;
use Validator;
use App\Models\Role;
use App\Models\Machine;
use App\Models\Tourism;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;

class TourismController extends Controller
{
    use ResponseTrait;

     /**
     * todo Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // todo search by 
        
        if(auth()->user()->role !=Role::ADMIN){
            $filterResult = Tourism::where('machine_id', $request->machineid)->get();
            foreach ($filterResult as $belong) {
                $machine = $belong->machine; 
                $machines = $machine->user; 
            }    
        return $this->returnData("data",$filterResult);
        }
        $query = $request->get('query');
        $filterResult = Tourism::where('machine_id', 'LIKE', '%'. $query. '%')->get();
        foreach ($filterResult as $belong) {
            $machine = $belong->machine; 
        }
        return $this->returnData("data",$filterResult);

    }

    /**
     * todo Store a newly created resource in storage.
     * ! hard can do this but type (tc) //
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

    $posts = Tourism::create([
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
     * todo Display the specified resource.
     * 
     */
    public function show(Request $request)
    {
        //
        $datarevive = Revive::where('machine_id',$request->machineid)
        ->whereDate('created_at',$request->createat)->get()->toArray();
        return $this->returnData("Data",$datarevive);
    }

   

}
