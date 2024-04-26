<?php
namespace App\Traits\Requests;

trait TestAuth
{  


    // todo rules of login for users
    protected function rulesLogin($field){
      if($field == "email"){
      return [
        "field" => "required|exists:users,email",
        "password" => "required"
    ];}
    else{
      return [
        "field" => "required|exists:users,username",
        "password" => "required"
    ];
    }
    }
  
    // todo rules of users registers
    protected function rulesRegist(){
      return [
        "name" => "required|min:4|max:20",
        "username" => "required|unique:users,username",
        "password" => "required|min:8",
        "birthday" => "required",
        "gender" => "required"
    ];
    }
    // todo rules of store posts 
    protected function rulesPosts(){
      return [
        'description' => 'required|min:5|max:250',
        'file' => 'required|file|max:30000|mimes:doc,docx,pdf,jpeg,png,jpg',
    ];
    }

     // todo rules store of machine revive
     protected function rulesRevive(){
      return [
        "machineids" => 'required|integer|exists:machines,id',
        "co2" => 'required|integer',
        "co" => 'required|integer',
        "degree" => 'required|integer',
        "humidity" => 'required|integer'
    ];
    }

    // todo rules of machine revive
    protected function rulesMachineUpdate(){
      return  [
        "name" => "required|min:4|max:20",
        "owner_id" => "required|exists:users,id",
        "location" => "required",
        "type" => 'required|min:5|max:10',
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
      'name' => 'required|min:4|max:20',
      "phone" => "required|numeric|digits:10",
      'birthday' => "required",
      "Personal_card" => "integer",
      'gender' => "required",
      'gmail' => "required|email"
  ];
  }

  // todo rules update users
  protected function rulessocialusers(){
    return  [
      'name' => 'required|min:4|max:20',
      "phone" => "required|numeric|digits:10",
      'birthday' => "required",
      'gender' => "required",
  ];
  }

    // todo rules Tcr Machines
    protected function rulestcr(){
      return  [
        "name" => "required|unique:machines,name",
        "owner_id" => "required|exists:users,id",
        "location" => "required|unique:machines,location",
        "type" => 'required|min:5|max:10',
       ];
    }

    // todo rules Tcr Machines
    protected function rulesservice(){
      return  [
        "name" => "required|unique:users,name",
        "email" => "required|unique:users,email",
        "gmail" => "required|unique:users,gmail",
        'profile_photo' => 'required',
        "password" => 'required|min:8'
       ];
    }

     // todo rules show bydate readings machines
     protected function rulesdate(){
      return  [
        "machineid" => "required|exists:machines,id",
        "created_at" => "required|date",
        
       ];
    }


    // todo rules store comments 
    protected function rulesComment(){
      return  [
        'posts_id' => 'required|exists:posts,id',
        'comment' => 'required|min:5|max:200',
      ];
    }

    // todo rules store comments 
    protected function rulescfpperson(){
    return  [
      'user_id' => 'required|exists:users,id',
      'carbon_footprint' => 'required|integer',
      ];
    } 
 
    // todo rules store comments 
    protected function rulescfpfactory(){
      return  [
        'machine_id' => 'required|exists:machines,id',
        'carbon_footprint' => 'required|integer',
      ];
    }


    // todo rules store comments 
    protected function rulessms(){
      return  [
        'country_code'  => 'required|integer|digits_between:2,3',
        'phone' => 'required|numeric|digits:10|exists:users,phone'
      ];
    }

    // todo rules of type for users todo send mail
    protected function rulestype(){
      return [
        "type" => "required|max:12",
        ];
    }

    // todo rules of type for users todo send mail
    protected function rulesBarterstore(){
      return [
        "Nmachine_Seller" => "required|exists:machines,name",
        "Nmachine_Buyer" => "required|exists:machines,name",
        "carbon_footprint" => "required|integer|digits_between:2,3",
        "expire" => 'required|digits_between:1,2',       
        "time" => 'required|max:5|min:3'         
       ];
    }

    // todo rules of type for users todo send mail
    protected function rulesbarterupdate(){
      return [
        'id' => 'required|exists:purching_c_f_p_s,id',
        "carbon_footprint" => "required|integer|digits_between:2,3",
        "expire" => 'required|digits_between:1,2',       
        "time" => 'required|max:5|min:3'       
       ];

    }

    // todo rules of calculate carbon footprint for factory
    protected function rulesfactory(){
      return [
        'country'          =>   'required|string',
        'num_people'       =>   'required|integer|digits_between:1,4',
        'Electricity_consumption' =>   'required|integer|digits_between:1,4',
        'clean_energy'     =>   'required|integer|digits_between:1,3',
        'num_cars'         =>   'required|integer|digits_between:1,3',
        'factory_size'        =>   'required|integer|digits_between:1,3',
        'local_products?'    =>   'required|string',
        'buy _environmentally_companies?'     =>   'required|string',
        'HANDLE WASTE?'     =>   'required|string',
        'Heating energy'          =>   'required|string',
        'gasoline'         =>   'required|integer|digits_between:1,4',
        'natural gas '      =>  'required|integer|digits_between:1,3',
        'water consumtion'       =>  'required|integer|digits_between:1,4',
        'waste quantity'       =>  'required|integer|digits_between:1,4',
      //'Carbon_tones'     =>  'required|decimal:2,4',
       ];

    }

    // todo rules of calculate carbon footprint for person
    protected function rulesperson(){
      return [
        'country'          =>  'required|string',
        'num_people'       =>  'required|integer|digits_between:1,4',
        'size_house'       =>  'required|integer|digits_between:1,4',
        'type_house'       =>  'required|string',
        'Electricity_consumption' =>  'required|integer|digits_between:1,4',
        'clean_energy'     =>  'required|integer|digits_between:1,3',
        'Heating energy'          =>  'required|string',
        'IntercityTrain_avghours'      =>  'required|integer|digits_between:1,3',
        'Subway_avghours'     =>  'required|integer|digits_between:1,3',
        'IntercityBus_avghours'        =>  'required|integer|digits_between:1,3',
        'City Bus_avghours'    =>  'required|integer|digits_between:1,3',
        'Tram_avghours'       =>  'required|integer|digits_between:1,3',
        'Bike/walk_avghours'       =>  'required|integer|digits_between:1,3',
        'plane_verylong'      =>  'required|integer|digits_between:1,3',
        'plane_long'       =>  'required|integer|digits_between:1,3',
        'plane_medium'        =>  'required|integer|digits_between:1,3',
        'plane_short'      =>  'required|integer|digits_between:1,3',
        'household preferred diet'   =>  'required|string',
        'local_products?'    =>  'required|string',
        'buy _environmentally_companies?'     =>  'required|string',
        'How many times a week does your family eat out?'          =>  'required|integer|digits_between:1,3',
        'HANDLE WASTE?'     =>  'required|string',
        'gasoline'         =>  'required|integer|digits_between:1,3',
        'natural gas '      =>  'required|integer|digits_between:1,3',
        'water consumtion'       =>  'required|integer|digits_between:1,3',
        'waste quantity'       =>  'required|integer|digits_between:1,3',
        'ferune'            =>  'required|integer|digits_between:1,3',
        'fruite out of season'            =>  'required|integer|digits_between:1,3',
      //  'Carbon_tones'     =>  'required|decimal:1,4',
       ];

    }





    
   

}
