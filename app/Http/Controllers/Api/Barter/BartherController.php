<?php

namespace App\Http\Controllers\Api\Barter;

use Exception;
use Validator;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Machine;
use App\Models\PurchingCFP;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\Barter\BarterTrait;
use App\Http\Controllers\Controller;

class BartherController extends Controller
{
    use ResponseTrait , BarterTrait;
    /**
     * ! only Admins can show this 
     * todo show all Barter process (عمليات المقايضه) 
    */
    public function index(Request $request){
        $barter = PurchingCFP::get();
        return $this->returnData("Barter",$barter);
    } 

    /**
     * ! only Owner can show this 
     * todo show All My Barter process (عمليات المقايضه) 
    */
    public function ShowBarter(Request $request){
        // ! validate //machineid//
        $barterSeller = PurchingCFP::where("machine_seller_id",$request->machineid)->get();
        $barterBuyer  = PurchingCFP::where("machine_buyer_id",$request->machineid)->get();
        $result = array(
            'barterSeller' => $barterSeller,
            'barterBuyer' => $barterBuyer
        ); 
    
        return $result;
    } 

    /**
     * ! only Owner & Admin can show this 
     * todo show  My Barter process by id (عمليه المقايضه) 
    */
    public function Show(Request $request){
        
        $barter = PurchingCFP::Where('id',$request->barterid)->get();
        foreach ($barter as $belong) {
            $seller = $belong -> machineseller;
            $buyer  = $belong -> machinebuyer;
            $users  = $seller -> user;
            $userb  = $buyer  -> user;
        }
        return $this->returnData("Barter" , $barter);
    } 

    /**
     * ! only Owner Seller can do this 
     * todo Add My Barter process  (عمليه المقايضه) 
    */
    public function Store (Request $request){

        //! rules
        $rules = $this->rulesBarterstore();
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }
        $machines = PurchingCFP::create([
            "machine_id" => $request->machine_id,
            "seller_id" => $request->sellerid,
            "carbon_footprint" => $request->carbon_footprint,
            "buyer_id" => $request->buyerid,
            "expire" => $request->expire,
            "time" => $request->time,
        ]);

        $msg = " Create : Barter Successfully . ,"."Footprint : ".$request->carbon_footprint." in : ".$request->expire." ".$request->time ;
        return $this->returnSuccessMessage($msg);
    } 

    /**
     * ! only Admin can do this 
     * todo edit My Barter process by id (عمليه المقايضه) 
    */
    public function edit(Request $request){

       // ? return data info for user
       $barter = PurchingCFP::find($request->id);
       return  $this->returnData("Barter" , $barter);
    } 

    /**
     * ! only Admin can do this 
     * todo update My Barter process by id (عمليه المقايضه) 
    */
    public function update(Request $request){

        // ? update machine //
        $barter = PurchingCFP::find($request->barterid); 
        $rules = $this->rulesbarterupdate();
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        $barter->update([
            "machine_id" => $request->machine_id,
            "seller_id" => $request->sellerid,
            "carbon_footprint" => $request->carbon_footprint,
            "buyer_id" => $request->buyerid,
            "expire" => $request->expire,
            "time" => $request->time,
            "updated_at" => Carbon::now(),
            
        ]);
             
        $msg = " Update : " .$request->name . " machine " ."successfully .";
        return $this->returnSuccessMessage($msg);

    } 

    /**
     * ! only Owner Buyer can do this 
     * todo destroy  My Barter process by id (عمليه المقايضه) but after expiration this Barter
    */
    public function destroy(Request $request){

        // ? delete posts //
        $barter = PurchingCFP::find($request->id) ;
        $machine = Machine::find($barter->machine_buyer_id);
        if($machine->owner_id != auth()->user()->id){return $this->returnError('U303','Error Some Thing Wrong :(...!');} 
        $barter->delete();
        return $this->returnSuccessMessage("Delete Barter Successfully .");

    } 

    /**
     * ! only Owner & Admin can show this 
     * todo show all My Barter process  destroyed (عمليات المقايضه) 
    */
    public function restoreindex(Request $request){
    $barter = "";
    if(auth()->user()->role != Role::ADMIN ){
        $barter = $this->RBO();           //? Restore Barter Owner //
        return $this->returnData("Barter",$barter);
    }
        $barter = $this->RBA();           //? Restore Barter Owner //
        return $this->returnData("Barter",$barter);
    } 

    /**
     * ! only Admin can show this 
     * todo restore My Barter process destroyed by id (عمليه المقايضه) 
    */
    public function restore(Request $request){

        $barter = PurchingCFP::withTrashed()->find($request->id);
        if(!$barter->id){return $this->returnError('P404','Error Some Thing Wrong .');}
        PurchingCFP::withTrashed()->find($request->id)->restore();
        return $this->returnSuccessMessage("Restore Barter process Successfully .");

    } 

    /**
     * todo Autocomplete Search the specified resource from storage.
     */
    public function autocolmpletesearch(Request $request)
    {
        // ? search by Seller || location Buyer // 
        $query = $request->get('query');
        $filterResult = PurchingCFP::whereAny(['created_at','carbon_footprint'], 'LIKE', '%'. $query. '%');
        return $this->returnData("users",$filterResult);
    }
}
