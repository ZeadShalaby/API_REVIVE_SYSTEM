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
use App\Traits\MethodconTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Input\Input;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    use ResponseTrait,ImageTrait,MethodconTrait;

   // todo Register to api natural user
   public function register(Request $request){

       
    // ! valditaion
    $validator = Validator::make($request->all(),$rules);

    if($validator->fails()){
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
    $path = $this->checkuserpath($request->gender);
    // todo Register New Account //    
    $customer = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'password'  => $request->password,
        'role' => Role::CUSTOMER,
        'gmail'=> $request->email,
        'password' => $request->password , //! password
        'phone'=> $request->password,
        'profile_photo'=>$path,
        'Personal_card' => $request->Personal_card,
        'birthday' => $request->birthday,
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
 // todo change image of users 
    public function changeimg(Request $request)
   {
       //
       $users = user::find(auth()->user()->id);
       $rules = [
           "profile_photo" => "required|image|mimes:jpg,png,gif|max:2048"
       ];
       // ! valditaion
       $validator = Validator::make($request->all(),$rules);

       if($validator->fails()){
               $code = $this->returnCodeAccordingToInput($validator);
               return $this->returnValidationError($code,$validator);
           }
       else{
           $folder = 'images/users';
           $image_name = time().'.'.$request->file->extension();
           $images = $request->file->move(public_path($folder),$image_name) ;
           $path = env("APP_URL").env("Path_imgUsers").$image_name;
           $users->update([
               'path'  => $path ,
           ]);
       }    
       $msg = "users : ".$users->name." , Change Photo successfully .";
       return $this->returnSuccessMessage($msg);    
   
   }




////! ////////////////////////////////////////////////
   // todo return users details
   public function profile(Request $request){
    $user = auth()->user();
    return $this->returnData("user",$user);
   }

    // todo profileimage image
    public function profileimage(Request $request){
    //  return $this->returnData("sss",$filename = $request->file('file')->getClientOriginalName());          
    //   required|image|mimes:jpeg,png,jpg|max:2048
    $folder = 'images/users';
    $image_name = time().'.'.$request->file->extension();
    $images = $request->file->move(public_path($folder),$image_name) ;
    return $this->returnData('file name',$image_name);
   }

   // todo postsimage image
   public function postsimage(Request $request){
    $folder = 'images/posts';
    $image_name = time().'.'.$request->file->extension();
    $images = $request->file->move(public_path($folder),$image_name) ;
    return $this->returnData('file name',$image_name);
   }

   // todo machineimage image
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

    // todo return posts image
    public function imagesposts(Request $request,$post){
        if(isset($post)){
          return $this->returnimageposts($post,$post);}
        else {return 'null';}

    }

    // todo return machine image
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
