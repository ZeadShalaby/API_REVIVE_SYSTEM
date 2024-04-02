<?php

namespace App\Http\Controllers\Api\users;


use Auth;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Traits\ImageTrait;
use App\Traits\LoginTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\MethodconTrait;
use App\Traits\Requests\TestAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Traits\validator\ValidatorTrait;
use Symfony\Component\Console\Input\Input;
use App\Http\Controllers\Api\EmailController;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    use ResponseTrait , ImageTrait , MethodconTrait , TestAuth , ValidatorTrait , LoginTrait;

   // todo Register to api natural user
   public function register(Request $request){
    // ! valditaion
    $rules = $this->rulesRegist();    
    $validator = $this->validate($request,$rules);
    if($validator !== true){return $validator;}

    $email = $this->makeEmail($request->username);
    $path = $this->checkuserpaths($request->gender);
    // todo Register New Account //    
    $customer = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $email,
        'password'  => $request->password,
        'role' => Role::CUSTOMER,
        'profile_photo'=>$path,
        'birthday' => $request->birthday,
        'gender' =>$request->gender,
        'email_verified_at' => Carbon::now() ,
     ]);
     if($customer){return $this->returnSuccessAccount("Create Account Successfully .",$email);}
     else{return $this->returnError('R001','Some Thing Wrong .');}

   }

   ////! ////////////////////////////////////////


    // todo Login Users
    public function login(Request $request){
        try{
        $infofield = $this->CheckField($request);
        // ! valditaion
        $rules = $this->rulesLogin($infofield['fields']);    
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // todo login  $credentials = $request->only(['email','password']);
        $token = Auth::guard('api')->attempt($infofield['credentials']);
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
    public function changeimg(Request $request){
       
       $users = user::find(auth()->user()->id);
       // ! valditaion
       $rules = [ "profile_photo" => "required|image|mimes:jpg,png,gif|max:2048"];
       $validator = $this->validate($request,$rules);
       if($validator !== true){return $validator;}
       
       else{
           $folder = 'images/users';
           $path = 'reviveimageusers';
           $path = $this->saveimage($request->profile_photo , $folder , $path);
           $users->update([
               'profile_photo'  => $path ,
           ]);
       }    
       $msg = "users : ".$users->username." , Change Photo successfully .";
       return $this->returnSuccessMessage($msg);    
   
    }

    /**
     * todo return info users .
     */
    public function edit(Request $request)
    {
        // ? 
       // $user = User::find($request->id);
       $user = auth()->user();
       return  $this->returnData("users" , $user);
    }

   /**
     * todo Update the information users.
     */
    public function update(Request $request)
    {
        // ? update user //
        $user = auth()->user();
        if(isset($user->social_id) && $user->social_id->count() != 0 ){
        $rules = $this->rulessocialusers();
        }
        // ? if users login with googel or github //
        else{ $rules = $this->rulesUpdateUsers();}
        // ! valditaion
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}
        
        if(isset($user->social_id ) && $user->social_id->count() != 0){
        $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'birthday' => $request->birthday
            ]);}
        else{               
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'gmail' => $request->gmail,
                'Personal_card' => $request->Personal_card,
                'birthday' => $request->birthday
            ]);
        }

            $msg = " Update successfully .";
            return $this->returnSuccessMessage($msg); 

    }

     /**
     * todo edit my account pass (return my pass).
     */
    public function checkvalidatepass(Request $request)
    {
        // ! valditaion
        $rules = [ "password" => "required"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}
        
        if(Hash::check($request->password, auth()->user()->password)){
            return  $this->returnSuccessMessage(true);
        }
       else{return $this->returnError("406" , "Something Wrong" );}
    
    }

    /**
     * todo edit my account pass (return my pass).
     */
    public function editpass(Request $request)
    {
        // ? 
       // $user = User::find($request->id);
       $user = auth()->user()->password;
       return  $this->returnData("password" , $user);
    }

   /**
     * todo Update the My accont password .
     */
    public function updatepass(Request $request)
    {
        // ? update user //
        $user = User::find(auth()->user()->id);
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



////! //////////////////////////////////////
   // todo return users details
   public function profile(Request $request){
    $user = auth()->user();
    return $this->returnData("user",$user);
   } 

//! ////////////////////////////////////////

    // todo return users image
    public function imagesuser(Request $request,$user){
        if(isset($user)){
          return $this->returnimageusers($user,$user);}
        else {return 'null';}

    }


    //! forget pass // 
    // todo check code 
    public function checkcode(Request $request){
    
        // ! valditaion
        $rules = ["code" =>"required|integer|min:6"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}
        
        else{
        $code = User::where("code",$request->code)->value('code');
        if($code)
        return $this->returnSuccessMessage(True);
        else {
            $msg = "OOPS :( , your code not correct sorry :( ..!";
            return $this->returnError("C404",$msg);
        }}
    }

    // todo forget pass  
    public function forget(Request $request){

        // ! valditaion
        $rules = ["password" =>"required|min:8",'gmail'=>"required|exists:users,gmail"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}
        

        $id = User::where("gmail",$request->gmail)->orwhere('email',$request->gmail)->value('id');
        $user = User::find($id);
        $user->update([
            'password' => $request->password,
        ]);
         
        $msg = " Update successfully .";
        return $this->returnSuccessMessage($msg);      
    //   return $this->returnData("users",$user);
    
    }


     /**
      * ! only users can do that
     * todo Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // ? delete users //
        $user = auth()->user();
        $msg = " delete Your Account Sir : " .$user->username . "  " ."successfully .";
        $user ->delete();
        return $this->returnSuccessMessage($msg);
    }

//! ////////////////////////////////////////

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
                return $this->returnError("T003","Some Thing Went Wrongs");
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
