<?php

namespace App\Http\Controllers\Api\users;


use Auth;
use Exception;
use Validator;
use App\Models\Role;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Input\Input;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    use ResponseTrait,ImageTrait;

   // todo Register to api natural user
   public function register(Request $request){

    $rules = [
        'name' => 'required',
        'email' => 'required|unique:users,email',
        "password" => "required"
    ];
    // ! valditaion
    $validator = Validator::make($request->all(),$rules);

    if($validator->fails()){
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
    
    // todo Register New Account //    
    $customer = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password'  => $request->password,
        'role' => Role::CUSTOMER,
     ]);

     if($customer){return $this->returnSuccessMessage("Create Account Successfully .");}
     else{return $this->returnError('R001','Some Thing Wrong .');}

   }

   ////! ////////////////////////////////////////

     // todo Login Users
     public function login(Request $request){
        try{
        $rules = [
            "email" => "required|exists:users,email",
            "password" => "required"
        ];
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }

        // todo login
        $credentials = $request->only(['email','password']);
        $token = Auth::guard('api')->attempt($credentials);
      
        if(!$token)
        return $this->returnError('E001','information not valid.');

        $users =  Auth::guard('api')->user();
        $users -> api_token = $token;
        // ! return tocken
        return $this->returnData('Users',$users);
        }
        catch(Exception $ex){
            return $this->returnError($ex->getcode(),$ex->getMessage());
        }

    }


 ////! ///////////////////////////////////////////////


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

   // todo POST image
   public function postsimage(Request $request){
    $folder = 'images/posts';
    $image_name = time().'.'.$request->file->extension();
    $images = $request->file->move(public_path($folder),$image_name) ;
    return $this->returnData('file name',$image_name);
   }

   // todo POST image
   public function machineimage(Request $request){
    $folder = 'images/machine';
    $image_name = time().'.'.$request->file->extension();
    $images = $request->file->move(public_path($folder),$image_name) ;
    return $this->returnData('file name',$image_name);
   }

//! ////////////////////////////////////////////////////////////

    // todo return users image
    public function imagesuser(Request $request,$user){
        if(isset($user)){
          return $this->returnimageusers($user,$user);}
        else {return 'null';}

    }

    // todo return users image
    public function imagesposts(Request $request,$post){
        if(isset($post)){
          return $this->returnimageposts($post,$post);}
        else {return 'null';}

    }

    // todo return users image
    public function imagesmachine(Request $request,$machine){
        if(isset($machine)){
          return $this->returnimagemachine($machine,$machine);}
        else {return 'null';}

    }

   ////! ////////////////////////////////////////

    // todo Logout Users
    public function logout(Request $request){
        
        //return $request->header('auth_token'); if i request tocken in header in postman
        // if i sen request in body 
        $token = $request->auth_token; 
        if(isset($token)){
            try{
            // todo logout
            JWTAuth::setToken($token)->invalidate();
            }catch(TokenInvalidException $e){
                return $this->returnError("T002","Some Thing Went Wrongs");
            }
            catch(TokenExpiredException $e){
                return $this->returnError("T002","Some Thing Went Wrongs");
            }
            return $this->returnSuccessMessage('Logged Out Successfully');
        }
        else{
            return $this->returnError("T001","Some Thing Went Wrongs .");
        }
    }


}
