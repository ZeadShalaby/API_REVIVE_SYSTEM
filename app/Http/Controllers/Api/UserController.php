<?php

namespace App\Http\Controllers\Api;

use Exception;
use Validator;
use App\Models\Role;
use App\Models\User;
use App\Mail\RoleUser;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\MethodconTrait;
use App\Traits\Requests\TestAuth;
use App\Traits\Requests\TestMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Traits\validator\ValidatorTrait;

////! only admin can do this method on this controller ////
class UserController extends Controller
{
    use ResponseTrait , ImageTrait , MethodconTrait , TestAuth , ValidatorTrait ,TestMail; 

    /** 
     * todo return users with type or deafult all users.
     * todo Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ? return  usres where role == "Admin" | "owner" | "Customer" //
        if($request->type){
            $role = $this->checkTypeUsers($request->type);
            $users = User::where('username','!=',Role::ADMINNAME)->where('role',$role)->get();
        }
         // ? return all usres //
        else{$users = User::where('role',"!=",Role::ADMIN)->get();}
        return $this->returnData("users",$users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * todo Store a newly created resource in storage.
     * ?admin || owner
     */
    public function store(Request $request)
    {

       
    }

    /**
     * todo show info users
     * todo Display the specified resource.
     */
    public function show(Request $request )
    {
        // ! valditaion
        $rules = ["id"=> "required|exists:users,id",];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? show info for user 
        $user = User::find($request->id);
        return  $this->returnData("users" , $user);

    }

    /**
     * todo Edit Users 
     * todo Show the form for editing the specified resource.
     */
    public function edit(Request $request , User $user)
    {
        // ! valditaion
        $rules = ["id"=> "required|exists:users,id",];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? return data info for user
        // return $this->returnData("users",$user);
        $user = User::find($request->id);
        return  $this->returnData("users" , $user);
    }

    /**
     * todo Update the users password .
     */
    public function updatepass(Request $request)
    {
        // ? update user //
        $user = User::find($request->id);
        if($user->social_id){
            return $this->returnError("P403","Can Not do that Some thing Wrongs :( !.");
        }
        // ! valditaion
        $rules = ["password" => "required|min:8"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        $user->update([
                'password' => $request->password,
            ]);
             
            $msg = " Update successfully .";
            return $this->returnSuccessMessage($msg); 

    }


    /**
     * todo change Role Users to Admin or Owner
     * todo Update the specified resource in storage.
     */
    public function modifyrole(Request $request)
    {
        $user = User::find($request->id);
        // ! valditaion
        $rules = ['role' => 'required|integer|exists:users,role',"id"=> "required|exists:users,id"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}
        // todo change Email depend on role user
        $newEmail = $this->changemail($user , $request->role);
        
        $user->update([
                'role' => $request->role,
                'email' => $newEmail
            ]);
        if(isset($user->gmail)){
        // ! send mail to this users and know it the role and mail changed
        Mail::to($user->gmail)->send(new RoleUser (User::find($request->id)));}
        $msg = $this->typerole($request->role ,$user->username); 
        return $this->returnSuccessMessage($msg); 
    }
    
    /**
     * todo Delete Users
     * todo Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // ! valditaion
        $rules = ["id"=> "required|exists:users,id",];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? delete users //
        $user = User::find($request->id);
        $msg = " delete users : " .$user->name . "  " ."successfully .";
        if($user){
            $user ->delete();    
            return $this->returnSuccessMessage($msg);
        }
        else{return $this->returnError("U404" , "This users not fount");}
    }

    /**
     * todo Autocomplete Search the specified resource from storage.
     */
    public function autocolmpletesearch(Request $request)
    {
        // ! valditaion
        $rules = ["query" => "required"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? search by name || location machine // 
        $query = $request->get('query');
        $filterResult = User::whereAny('name','LIKE', '%'. $query. '%')
        ->orwhere('username', 'LIKE', '%'. $query. '%')
        ->orwhere('phone', 'LIKE', '%'. $query. '%')
        ->orwhere('Personal_card', 'LIKE', '%'. $query. '%')
        ->get();
        return $this->returnData("users",$filterResult);
    
    }

    /**
     * todo restore index the specified resource from storage.
     */
    public function restoreindex()
    {
       $user = User::onlyTrashed()->get();
       return $this->returnData("users",$user);
    }

     /**
     * todo  restore the specified resource from storage.
     */
    public function restore(Request $request)
    {
       // ! valditaion
       $rules = ['id' => 'required|exists:users,id',];
       $validator = $this->validate($request,$rules);
       if($validator !== true){return $validator;}

       $user = User::onlyTrashed()->find($request->id);
       if(!isset($user->id)){return $this->returnError('P404','Error Some Thing Wrong .');}
       User::onlyTrashed()->find($request->id)->restore();
       return $this->returnSuccessMessage("Restore User Successfully .");
    }


}
