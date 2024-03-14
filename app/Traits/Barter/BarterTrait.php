<?php
namespace App\Traits\Barter;

use App\Models\Role;
use App\Models\Machine;
use App\Models\PurchingCFP;


trait BarterTrait

{  
    //todo search about any Machine Have A Role GreenTree (GreenTree = " Its A Garden have many trees")
    protected function RBO(){
       
        $barters = [];
        $machines = Machine::where("owner_id",auth()->user()->id)->get('id');
        foreach($machines as $machine){
            $barter = PurchingCFP::where('machine_seller_id',$machine->id)
            ->orwhere('machine_seller_id',$machine->id)
            ->onlyTrashed()->get();
            array_push($barters, $barter);
        }
        return $barters;
    }

    // todo search about any Barter in this machines (Owner have any Barther or not) 
    protected function RBA(){
        $barter = PurchingCFP::onlyTrashed()->get();
        return $barter;
    }

}