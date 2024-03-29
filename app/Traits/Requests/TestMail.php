<?php
namespace App\Traits\Requests;

use App\Models\Role;
use App\Models\User;
use App\Traits\MethodconTrait;

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


    // todo check sympole regex
    function replaceWordsBetweenSymbols($input, $symbol, $replace) {
        return preg_replace("/@$symbol\b([^@]*)@$symbol/", "@$replace", $input);
    }
    
    // todo change mail of customer or owner depend on role user
    protected function changemail($user , $newrole)  {
    
    if($user->social_id != null){return $user->email;}
    $inputString =$user->email ;
    $symbol = $this->checkroletype($user->role);
    $replaceString = $this->checkroletype($newrole);
    
    //? Adjusting input string to include "@" symbols around "customer"
    $inputString = preg_replace("/@$symbol/", "@$replaceString", $inputString);
    
    $outputString = $this->replaceWordsBetweenSymbols($inputString, $symbol, $replaceString);

    return $outputString;
    }
   


}