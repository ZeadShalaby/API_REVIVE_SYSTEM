<?php
namespace App\Traits\Requests;

use App\Models\User;

trait TestSms

{ 

    protected function checkphone($phone){
        $userid = User::where("phone",$phone)->value('id');
        $info = User::find($userid);
        if ($userid > 0){
            $info->code = random_int(100000, 999999);
            return  $info;
        }else {return null;}
    }

    


}