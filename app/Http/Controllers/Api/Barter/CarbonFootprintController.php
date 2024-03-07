<?php

namespace App\Http\Controllers\Api\Barter;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;

class CarbonFootprintController extends Controller
{
    use ResponseTrait ;

    /**
     * ! only Admins can show this 
     * todo show all Barter process (عمليات المقايضه) 
    */
    public function index(Request $request){

        return $this->returnData(" barter index done");

    } 

    /**
     * ! only Owner can show this 
     * todo show All My Barter process (عمليات المقايضه) 
    */
    public function ShowBarter(Request $request){

        return $this->returnData(" barter ShowBarter done");

    } 

    /**
     * ! only Owner & Admin can show this 
     * todo show  My Barter process by id (عمليه المقايضه) 
    */
    public function Show(Request $request){
     
        return $this->returnData(" barter Show done");

    } 

    /**
     * ! only Owner can do this 
     * todo Add My Barter process  (عمليه المقايضه) 
    */
    public function Store (Request $request){

        return $this->returnData(" barter Store done");

    } 

    /**
     * ! only Owner can do this 
     * todo edit My Barter process by id (عمليه المقايضه) 
    */
    public function edit(Request $request){

        return $this->returnData(" barter edit done");


    } 

    /**
     * ! only Owner can do this 
     * todo update My Barter process by id (عمليه المقايضه) 
    */
    public function update(Request $request){

        return $this->returnData(" barter update done");


    } 

    /**
     * ! only Owner Seller can do this 
     * todo destroy  My Barter process by id (عمليه المقايضه) but after expiration this Barter
    */
    public function destroy(Request $request){

        return $this->returnData(" barter destroy done");

    } 

    /**
     * ! only Owner & Admin can show this 
     * todo show all My Barter process  destroyed (عمليات المقايضه) 
    */
    public function restoreindex(Request $request){

        return $this->returnData(" barter restoreindex done");


    } 

    /**
     * ! only Owner & Admin can show this 
     * todo restore My Barter process destroyed by id (عمليه المقايضه) 
    */
    public function restore(Request $request){

        return $this->returnData(" barter restore done");


    } 

    /**
     * todo Autocomplete Search the specified resource from storage.
     */
    public function autocolmpletesearch(Request $request)
    {
        return $this->returnData(" barter autocolmpletesearch done");

        // ? search by Seller || location Buyer // 
        $query = $request->get('query');

        if(auth()->user()->role != Role::ADMIN){

        $filterResult = User::where('name', 'LIKE', '%'. $query. '%')
        ->orwhere( 'username', 'LIKE', '%'. $query. '%')
        ->orwhere( 'phone', 'LIKE', '%'. $query. '%')
        ->orwhere( 'Personal_card', 'LIKE', '%'. $query. '%')
        ->values('id');
            return $this->returnData("users",$filterResult);
        }

    }







}
