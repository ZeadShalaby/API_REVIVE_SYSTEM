<?php
namespace App\Traits\Barter;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Machine;
use App\Models\PurchingCFP;


trait BarterTrait

{  
    //todo search about any Machine Have A Role GreenTree (GreenTree = " Its A Garden have many trees")
    protected function RBO() {
        
        $machines = Machine::where("owner_id", auth()->user()->id)->pluck('id');
        $barters = PurchingCFP::whereIn('machine_seller_id', $machines)
                              ->onlyTrashed()
                              ->orwhereIn('machine_buyer_id',$machines)
                              ->onlyTrashed()
                              ->get();
        return $barters;
    }

    // todo search about any Barter in this machines (Owner have any Barther or not) 
    protected function RBA(){
        $barter = PurchingCFP::onlyTrashed()->get();
        return $barter;
    }

    // todo check if Barter daily end or not
    protected function BarterDaily(){

        $currentDate = Carbon::now();
        $barter = PurchingCFP::selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as ymd, expire,time,id')->get();
        $formattedDate = $currentDate->format('Y-m-d');    
        $barter_format = $this->formatDate($barter);
        foreach ($barter_format as $bar) {
            if($bar -> ymd <= $formattedDate ){
            $destbar = PurchingCFP::find($bar->id) ;
            $destbar->delete();}
        }

    }

    // todo format date to check expiration date of Barter //
    protected function formatDate($barter) {

        // todo Iterate through each item and add num of  months || week || day to the date
        $barter->transform(function ($item) {
            if ($item->time === "month") {
                $item->ymd = Carbon::parse($item->ymd)->addMonths($item->expire)->format('Y-m-d');
            } elseif ($item->time === "week") {
                $item->ymd = Carbon::parse($item->ymd)->addWeeks($item->expire)->format('Y-m-d');
            } else {
                $item->ymd = Carbon::parse($item->ymd)->addDays($item->expire)->format('Y-m-d');
            }
            return $item;
        });
            return $barter;
    }

}