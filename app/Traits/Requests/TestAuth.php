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
    }"sfsdf"
  
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
        'Country'          =>   'required|string',
        'num_people'       =>   'required|integer|digits_between:2,3',
        'electricity_cons' =>   'required|integer|digits_between:2,3',
        'Clean_energy'     =>   'required|integer|digits_between:2,3',
        'Num_cars'         =>   'required|integer|digits_between:2,3',
        'Fact_size'        =>   'required|integer|digits_between:2,3',
        'Local_product'    =>   'required|string',
        'Buy_env_comp'     =>   'required|string',
        'Handle_waste'     =>   'required|string',
        'Heating'          =>   'required|string',
        'Gasoline'         =>   'required|integer|digits_between:2,3',
        'Natural_gas'      =>  'required|integer|digits_between:2,3',
        'Water_cons'       =>  'required|integer|digits_between:2,3',
        'Waste_quan'       =>  'required|integer|digits_between:2,3',
      //'Carbon_tones'     =>  'required|decimal:2,4',
       ];

    }

    // todo rules of calculate carbon footprint for person
    protected function rulesperson(){
      return [
        'Country'          =>  'required|string',
        'num_people'       =>  'required|integer|digits_between:2,3',
        'house_size'       =>  'required|integer|digits_between:2,3',
        'house_type'       =>  'required|string',
        'electricity_cons' =>  'required|integer|digits_between:2,3',
        'Clean_energy'     =>  'required|integer|digits_between:2,3',
        'Heating'          =>  'required|string',
        'Train_hours'      =>  'required|integer|digits_between:2,3',
        'Subway_hours'     =>  'required|integer|digits_between:2,3',
        'Bus_hours'        =>  'required|integer|digits_between:2,3',
        'Citybus_hours'    =>  'required|integer|digits_between:2,3',
        'Tram_hours'       =>  'required|integer|digits_between:2,3',
        'Walk_hours'       =>  'required|integer|digits_between:2,3',
        'Plane_vlong'      =>  'required|integer|digits_between:2,3',
        'Plane_long'       =>  'required|integer|digits_between:2,3',
        'Plane_med'        =>  'required|integer|digits_between:2,3',
        'Plane_short'      =>  'required|integer|digits_between:2,3',
        'household_diet'   =>  'required|string',
        'Local_product'    =>  'required|string',
        'Buy_env_comp'     =>  'required|string',
        'eat_out'          =>  'required|integer|digits_between:2,3',
        'Handle_waste'     =>  'required|string',
        'Gasoline'         =>  'required|integer|digits_between:2,3',
        'Natural_gas'      =>  'required|integer|digits_between:2,3',
        'Water_cons'       =>  'required|integer|digits_between:2,3',
        'Waste_quan'       =>  'required|integer|digits_between:2,3',
        'Ferun'            =>  'required|integer|digits_between:2,3',
        'Fruit'            =>  'required|integer|digits_between:2,3',
      //  'Carbon_tones'     =>  'required|decimal:2,4',
       ];

    }





    
   

}