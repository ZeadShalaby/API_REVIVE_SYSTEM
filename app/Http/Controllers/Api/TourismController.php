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
     * todo Show the form for creating a new resource.
     * !only admin do this
     */
    public function newtourism()
    {
        //
    }

    /**
     * todo Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //! rules
       $rules = [
        "machineids" => 'required',
        "co2" => 'required',
        "co" => 'required',
        "degree" => 'required',
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
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * todo Remove the specified resource from storage.
     * ! oonly admin can do this
     */
    public function destroy(string $id)
    {
        //
    }

    
    /**
     * todo restore index the specified resource from storage.
     */
    public function restoreindex()
    {
       //
    }

     /**
     * todo  restore the specified resource from storage.
     */
    public function restore()
    {
       //
    }

    /**
     * todo Autocomplete Search the specified resource from storage.
     */
    public function autocolmpletesearch()
    {
       //
    }

}
