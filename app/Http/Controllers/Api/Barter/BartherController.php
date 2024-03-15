<?php

namespace App\Http\Controllers\Api\Barter;

use Exception;
use Validator;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Machine;
use App\Models\PurchingCFP;
use App\Traits\MachineTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\Requests\TestAuth;
use App\Traits\Barter\BarterTrait;
use App\Http\Controllers\Controller;
use App\Traits\validator\ValidatorTrait;

class BartherController extends Controller
{
    use ResponseTrait , BarterTrait , ValidatorTrait , TestAuth , MachineTrait;
    /**
     * ! only Admins can show this 
     * todo show all Barter process (عمليات المقايضه) 
    */
    public function index(Request $request){

        $barter = PurchingCFP::get();
        foreach ($barter as $belong) {
            $seller = $belong -> machineseller;
            $buyer  = $belong -> machinebuyer;
            $users  = $seller -> user;
            $userb  = $buyer  -> user;
        }
        return $this->returnData("Barter",$barter);

    } 

    /**
     * ! only Owner can show this 
     * todo show All My Barter process (عمليات المقايضه) 
    */
    public function ShowBarter(Request $request){

        // ! validate //machineid//
        $rules = ["machineid" => "required|exists:machines,id"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

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
        
        // ! valditaion
        $rules = ["barterid" => "required|exists:purching_c_f_p_s,id"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

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

        // ! valditaion
        $rules = $this->rulesBarterstore();
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        $machineId = $this->nameMachine($request->Nmachine_Seller,$request->Nmachine_Buyer); 
        $time = strtolower($request->get('time'));
        if($machineId['ownerid'][0] != auth()->user()->id){return $this->returnError("U403","Something Wrongs OOPS :(...!");}
        
        $machines = PurchingCFP::create([
            "machine_seller_id" => $machineId['Mseller_id'][0],
            "machine_buyer_id"  => $machineId['Mbuyer_id'][0],
            "carbon_footprint"  => $request->carbon_footprint,
            "expire" => $request->expire,
            "time" => $time,
        ]);

        $msg = " Create : Barter Successfully . ,"."Footprint : ".$request->carbon_footprint." in : ".$request->expire." ".$time ;
        return $this->returnSuccessMessage($msg);
    } 

    /**
     * ! only Admin can do this 
     * todo edit My Barter process by id (عمليه المقايضه) 
    */
    public function edit(Request $request){

       // ! valditaion
       $rules = ["id" => "required|exists:purching_c_f_p_s,id"];
       $validator = $this->validate($request,$rules);
       if($validator !== true){return $validator;}

       // ? return data info for user
       $barter = PurchingCFP::find($request->id);
       $seller = $barter -> machineseller;
       $buyer  = $barter -> machinebuyer;
       
       return  $this->returnData("Barter" , $barter);
    } 

    /**
     * ! only Admin can do this 
     * todo update My Barter process by id (عمليه المقايضه) 
    */
    public function update(Request $request){

        // ! valditaion
        $rules = $this->rulesbarterupdate();
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}
  
        // ? update machine //
        $barter = PurchingCFP::find($request->id); 
        $machineId = $this->nameMachine($request->Nmachine_Seller,$request->Nmachine_Buyer); 
        $time = strtolower($request->get('time'));
        
        $barter->update([
            "carbon_footprint"  => $request->carbon_footprint,
            "expire" => $request->expire,
            "time" => $time,
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

        // ! valditaion
        $rules = ["id" => "required|exists:purching_c_f_p_s,id"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? delete posts //
        $barter = PurchingCFP::find($request->id) ;
        if(!isset($barter) || $barter->count() == 0){return $this->returnError('B404','Error Some Thing Wrong :(...!');}
        $buyer  = $barter -> machinebuyer;

        if($barter->machinebuyer->owner_id != auth()->user()->id){return $this->returnError('U403','Error Some Thing Wrong :(...!');} 
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
        //! Validate the request
        $rules = ["id" => "required|exists:purching_c_f_p_s,id"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        $barter = PurchingCFP::withTrashed()->find($request->id);
        if(!$barter){return $this->returnError('P404', 'Error: Something went wrong.');}
        $barter->restore();
    
        return $this->returnSuccessMessage("Restore Barter process Successfully.");
    }
    
   

    /**
     * todo Autocomplete Search the specified resource from storage.
     */
    public function autocolmpletesearch(Request $request)
    {
        // ! valditaion
        $rules = ["query" => "required",];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? search by created_at || carbon_footprint  // 
        $query = $request->get('query');
        $filterResult = PurchingCFP::where('created_at', 'LIKE', '%'. $query. '%')
        ->orwhere('carbon_footprint', 'LIKE', '%'. $query. '%')->get();
        return $this->returnData("filterResult",$filterResult);
    }
}
