<?php

namespace App\Http\Controllers\Api;

use App\Models\Machine;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;

class ReviveController extends Controller
{
    use ResponseTrait;
    //
     /**
     * todo Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * todo Show the form for creating a new resource.
     * ! only admin can add a new revive hardware
     */
    public function newrevive()
    {
        //
    }

    /**
     *todo Store a newly created resource in storage.
     * !hardware to do this insert 
     */
    public function store(Request $request)
    {
    
        //! rules
        $rules = [
            'description' => 'required',
            'file' => 'required|file',
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
        
    }

    /**
     * todo Display the specified resource with date not id.
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
     * ! only admin can do this
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
