<?php

namespace App\Http\Controllers\Api;

use Exception;
use Validator;
use App\Models\Post;
use App\Events\PostsReport;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;

class ReportsPostsController extends Controller
{

     use ResponseTrait ;

     /** // ! only Admin can do that // 
     * todo  show all report posts .
     */
    public function reportposts(Request $request)
    {
       // ? return all posts have a report
       $posts = Post::where("report" , '>' , 0 )->get();
       return $this->returnData("reportposts",$posts);
    }
    
    /**
     * todo  Add Report in Posts.
     */
    public function store(Request $request)
    {
        //! rules
        $rules = ["postid" => "required|numeric|exists:posts,id"];
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }

        $posts = Post::find($request->postid);
        $posts ->skip = false;
        event(new PostsReport($posts));

        return $this->returnSuccessMessage("Add Report Post Successfully .");

    }
     /**
     * todo Remove the posts .
     */
     public function skipreport(Request $request)
     {
        //! rules
        $rules = ["postid" => "required|numeric|exists:posts,id"];
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }

        $posts = Post::find($request->postid);
        $posts ->skip = true;
        event(new PostsReport($posts));

        return $this->returnSuccessMessage("Skip Report Post Successfully .");
     }

     /**
     * todo Remove the posts .
     */
    public function destroy(Request $request , $post)
    {
        // ? delete posts //
        $posts = Post::find($request->id) ;
        $posts->delete();
        return $this->returnSuccessMessage("Delete Posts Successfully .");
    }
}
