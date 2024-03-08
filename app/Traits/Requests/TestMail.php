<?php
namespace App\Traits\Requests;

use App\Models\Role;
use App\Models\User;

trait TestMail

{ 
    // todo check gmail and return code to do forget pass //
    protected function checkmail($gmail){
        $userid = User::where("gmail",$gmail)->value('id');
        $info = User::find($userid);
        if ($userid > 0){
            $info->code = random_int(100000, 999999);
            return  $info;
        }else {return null;}
    }

    // todo send mail for every users or every owner or admin or customer //
    protected function checkussersmail($type){
        if($type == ""){
            $user = User::where("role","!=",Role::ADMIN)->get();
            return $user;}
        else{
            $user = User::where("role",$type)->get();
            return $user;}
    }


}