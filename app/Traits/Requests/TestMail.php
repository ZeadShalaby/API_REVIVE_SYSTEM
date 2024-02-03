<?php
namespace App\Traits\Requests;

use App\Models\User;

trait TestMail

{ 

    protected function checkmail($gmail){
        $userid = User::where("gmail",$gmail)->value('id');
        $info = User::find($userid);
        if ($userid > 0){
            $info->code = random_int(100000, 999999);
            return  $info;
        }else {return null;}
    }


}