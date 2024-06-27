<?php
namespace App\Traits\Percentage\PercentageTrait;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Machine;
use App\Models\PurchingCFP;


trait PercentageTrait

{  
    //todo restart and begining from new value of Percentage carbon fotprint
    protected function StartNewPercentage() {

        $currentDate = Carbon::now()->format("Y-m-d");

        $machines = Machine::get();
        foreach ($machines as $machine) {
            $this->formatData($currentDate , $machine->created_at->format('Y-m-d'),$machine);
        }

    }

    // todo formatData of machine
    protected function formatData($dateNow, $machineDate,$machine) {
        $dateNow = Carbon::createFromFormat('Y-m-d', $dateNow);
        $machineDate = Carbon::createFromFormat('Y-m-d', $machineDate);
    
        if ($dateNow->greaterThanOrEqualTo($machineDate->addYear())) {
            $machine -> total_CF = 0;
            $machine -> save();
        }
    }
    

}