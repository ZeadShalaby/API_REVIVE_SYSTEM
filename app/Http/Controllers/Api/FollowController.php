<?php

namespace App\Http\Controllers\Api;

use Auth;
use Exception;
use Validator;
use App\Models\Follow;
use App\Traits\CountTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\MethodconTrait;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{
    use ResponseTrait , MethodconTrait , CountTrait , TestAuth;
    //
     /**
     * todo Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
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
     */
    public function store(Request $request)
    {
        //! rules
        $rules = [
            'following_id' => 'required|exists:users,id',
        ];
        
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }
        
        $checkfollow = $this->checkfollow($request->following_id , auth()->user()->id);
        if($checkfollow !=true){return $this->returnError('F001',"Cant do that Sir  !!..:("); }

        $postfav = Follow::create([
            'following_id'  => $request->following_id,
            'followers_id' =>auth()->user()->id,
            
        ]);
        $msg = " Following successfully .";
        return $this->returnSuccessMessage($msg); 
    }

    /**
     *  Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

      /**
     * todo Display the specified resource.
     */
    public function showfollowing(Request $request)
    {

        $following = Follow::Where('followers_id',auth()->user()->id)->get('following_id');
        foreach ($following as $belong) {
        $followinfo = $belong->userfollowing;
        }
        return $this->returnData("following" , $following);
    }

      /**
     * todo Display the specified resource.
     */
    public function showfollowers(Request $request)
    {
        //
        $followers = Follow::Where('following_id',auth()->user()->id)->get('followers_id');
        foreach ($followers as $belong) {
        $followinfo = $belong->userfollowers;
        }
        return $this->returnData("followers" , $followers);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
       
    }

    /**
     *  Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * todo Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // ? un follow users //
        $user = Follow::where('followers_id',auth()->user()->id)
        ->where('following_id',$request->userfollowing)->get();
        if(isset($user) && $user ->count() != 0){
        foreach ($user as $user) {
          $user->delete();
         }
        $msg = " UnFollow User successfully .";
        return $this->returnSuccessMessage($msg);}
        return $this-> returnError("F404" , "Something Wrong Sir :( ! ..."); 
    }

    /**
     * todo Autocomplete Search the specified resource from storage.
     */
    public function autocolmpletesearch(Request $request)
    {
       //
    }

    /**
     * todo go to profile followers the specified resource from storage.
     */
    public function profileinfo(Request $request)
    {
       //
    }

}
