<?php
namespace App\Traits\Requests;

trait TestAuth

{  
    // todo rules of login for users
    protected function rulesLogin(){
      return [
        "email" => "required|exists:users,email",
        "password" => "required"
    ];
    }
  
    // todo rules of users registers
    protected function rulesRegist(){
      return [
        "name" => "required",
        "username" => "required",
        "email" => "required|unique:users,email",
        "password" => "required",
        "gmail"=> "required|unique:users,gmail",
        "phone"=> "required",
        "Personal_card" => "required",
        "birthday" => "required",
    ];
    }
    // todo rules of store posts 
    protected function rulesPosts(){
      return [
        'description' => 'required|min:5|max:250',
        'file' => 'required|file',
    ];
    }

     // todo rules store of machine revive
     protected function rulesRevive(){
      return [
        "machineids" => 'required|integer|exists:machines,id',
        "co2" => 'required|integer',
        "co" => 'required|integer',
        "degree" => 'required|integer',
    ];
    }

    // todo rules of machine revive
    protected function rulesMachineUpdate(){
      return  [
        "name" => "required",
        "owner_id" => "required|exists:users,id",
        "location" => "required",
        "type" => 'required|integer|min:5|max:7',
    ];
    }
    
   // todo rules store of machine tourism
   protected function rulesTourism(){
    return  [
      "machineids" => 'required|integer|exists:machines,id',
      "co2" => 'required|integer',
      "co" => 'required|integer',
      "degree" => 'required|integer',
  ];
  }
   
   // todo rules update users
   protected function rulesUpdateUsers(){
    return  [
      'name' => 'required|min:5|max:20',
      'username' => 'required|min:5|max:20|unique:users:username',
      "phone" => "required|unique:users,phone",
      'birthday' => "required",
  ];
  }

}