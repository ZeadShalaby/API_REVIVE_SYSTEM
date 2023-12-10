<?php

namespace App\Http\Controllers\Api;

use validator;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\MethodconTrait;
use App\Http\Controllers\Controller;

////! only admin can do this method on this controller ////
class UserController extends Controller
{
    use ResponseTrait,ImageTrait,MethodconTrait;

    /** 
     * 
     * todo Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ? return  usres where role == "Admin" | "owner" | "Customer" //
        if($request->role){
            $role = $this->checkTypeUsers($request->type);
            $users = User::where('id','!=',Role::ADMIN)->where('role',$role)->get();
        }
         // ? return all usres //
        else{$users = User::where('role',(Role::OWNER||Role::CUSTOMER))->get();}
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
     * todo Display the specified resource.
     */
    public function show(Request $request)
    {
        // ? show info for user 
        $user = User::find($request->id);
        return  $this->returnData("users" , $user);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // ? 
        $user = User::find($request->id);
        return  $this->returnData("users" , $user);
    }

    /**
     * todo Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // ? update user //
        $user = User::find($request->id);
        if(asset($user->social_id)){
        $rules = [
            'name' => 'required|min:5|max:20',
            'username' => 'required|min:5|max:20|unique:users:username',
            "phone" => "required|unique:users,phone",
            'birthday' => "required",

        ];}
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }
        $old_post->update([
                'description' => $request->description,
            ]);
             
            $msg = " Update successfully .";
            return $this->returnSuccessMessage($msg); 

    }

    /**
     * todo Update the specified resource in storage.
     */
    public function modifyrole(Request $request)
    {
        $user = User::find($request->id);
        if(asset($user->social_id)){
        $rules = [
            'name' => 'required|integer',
        ];}
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }
        $old_post->update([
                'role' => $request->role,
            ]);
             
            $msg = " change role successfully .";
            return $this->returnSuccessMessage($msg); 

    }
    /**
     * todo Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // ? delete users //
        $user = User::find($request->id);
        $user ->delete();
        $msg = " delete users : " .$request->name . "  " ."successfully .";
        return $this->returnSuccessMessage($msg);
    }

    /**
     * todo Autocomplete Search the specified resource from storage.
     */
    public function autocolmpletesearch(Request $request)
    {
        // ? search by name || location machine // 
        $query = $request->get('query');
        $filterResult = User::where('name', 'LIKE', '%'. $query. '%')
        ->orwhere( 'username', 'LIKE', '%'. $query. '%')
        ->orwhere( 'phone', 'LIKE', '%'. $query. '%')
        ->get();
            return $this->returnData("users",$filterResult);
    
    }

//////////////////////////////////////////////////////////! ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////// ! users owners  only do this /////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////! ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


     // todo return users details
   public function profile(Request $request){
        $user = auth()->user();
        return $this->returnData("user",$user);
   }



    // todo POST image
    public function profileimage(Request $request){
        //  return $this->returnData("sss",$filename = $request->file('file')->getClientOriginalName());
        $folder = 'images/users';
        $image_name = time().'.'.$request->file->extension();
        $images = $request->file->move(public_path($folder),$image_name) ;
        return $this->returnData('file name',$image_name);
    }


}
