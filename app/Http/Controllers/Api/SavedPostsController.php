<?php

namespace App\Http\Controllers\Api;

use Exception;
use Validator;
use App\Models\SavedPosts;
use App\Traits\CountTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Traits\validator\ValidatorTrait;

class SavedPostsController extends Controller
{

    use ResponseTrait , CountTrait , ValidatorTrait ;

     /**
     * todo Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // ! valditaion
        $rules = ["posts_id" => "required|numeric|exists:posts,id"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? check if you added alredy 
        $checksaved = $this->checksaved($request->posts_id,auth()->user());
        if($checksaved == true){return $this->returnError("S001" , "It has already been added previously");}
        $postfav = SavedPosts::create([
            'posts_id'  => $request->posts_id,
            'user_id' =>auth()->user()->id,
        ]);

        $msg = " Aded To Favourite successfully .";
        return $this->returnSuccessMessage($msg); 

    }


      /**
     * todo Display the specified resource.
     */
    public function showsaved(Request $request)
    {

        $saved = SavedPosts::where('user_id',auth()->user()->id)
        ->with(['user' => function ($query) {$query->withTrashed(); }],['post' => function ($query) {$query->withTrashed(); }])
        ->get();
        return $this->returnData('PersonFav',$saved);
    }

     /**
     * todo UnSaved Posts Remove From Favourite.
     */
    public function destroy(Request $request)
    {
        // ! valditaion
        $rules = ["postid" => "required|numeric|exists:posts,id"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        $postsav = SavedPosts::find($request->postid);
        if(isset($postsav) && $postsav ->count() != 0 ){
        $postsav->delete();
        $msg = " UnSaved posts successfully .";
        return $this->returnSuccessMessage($msg); }
        return $this->returnError("P404","Something Wrong :( !...");
    }


}
