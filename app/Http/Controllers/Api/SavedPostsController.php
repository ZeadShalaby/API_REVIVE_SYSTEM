<?php

namespace App\Http\Controllers\Api;

use Exception;
use Validator;
use App\Models\SavedPosts;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;

class SavedPostsController extends Controller
{

    use ResponseTrait ;

     /**
     * todo Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //! rules
        $rules = [
            'posts_id' => 'required|exists:posts,id',
        ];

        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }
        
        $postfav = SavedPosts::create([
            'posts_id'  => $request->posts_id,
            'user_id' =>auth()->user()->id,
        ]);

        $msg = " Create successfully .";
        return $this->returnSuccessMessage($msg); 

    }


      /**
     * todo Display the specified resource.
     */
    public function showsaved(Request $request)
    {

        $saved = SavedPosts::where('user_id',auth()->user()->id)->get();
        foreach($saved as $belong){
          $user = $belong->user; 
          $post = $belong->post; 
        }
        return $this->returnData('PersonFav',$favourite);
    }

     /**
     * todo UnSaved Posts Remove From Favourite.
     */
    public function destroy(Request $request)
    {
        $postsav = SavedPosts::find($postid);
        $postsav->delete();
        $msg = " UnSaved posts successfully .";
        return $this->returnSuccessMessage($msg); 
    }


}
