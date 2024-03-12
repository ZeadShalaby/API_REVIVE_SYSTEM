<?php
namespace App\Barter\Traits;

use App\Models\Role;
use App\Models\Machine;


trait BarterTrait

{  
    //todo search about any Machine Have A Role GreenTree (GreenTree = " Its A Garden have many trees")
    protected function GreenTree($user){
       
    $grentree = Machine::where("owner_id",$user->id)->where("type",Role::GreenTree)->get();
    return $greentree;

    }

    // todo search about any Barter in this machines (Owner have any Barther or not) 
    protected function BarterProcess($element){
       

    }

}