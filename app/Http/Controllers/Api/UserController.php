<?php

namespace App\Http\Controllers\Api;

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

        //! rules //
        $rules = [
            'name' => 'required|min:5|max:20',
            'email' => 'required|unique:users,email',
            "password" => "required|regex:/(^([a-zA-Z]+)(\d+)?$)/u"
        ];
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }
        $path = $this->checkpath($request->gender,$request->role);
        // todo Register New Account //    
        $customer = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password'  => $request->password,
            'role' => $request->role,
            'gmail'=> $request->email,
            'password' => $request->password , //! password
            'phone' => $request->password,
            'profile_photo' => $path,
            'Personal_card' => $request->Personal_card,
            'birthday' => $request->birthday,
        ]);

        if($customer){return $this->returnSuccessMessage("Create Account Successfully .");}
        else{return $this->returnError('R001','Some Thing Wrong .');}
    }

    /**
     * todo Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * todo Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * todo Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * todo Autocomplete Search the specified resource from storage.
     */
    public function autocolmpletesearch()
    {
       //
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
