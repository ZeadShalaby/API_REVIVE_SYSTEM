<?php

namespace App\Http\Controllers\Api;

use Auth;
use Exception;
use Validator;
use App\Models\Post;
use App\Models\Follow;
use App\Traits\ImageTrait;
use App\Events\PostsVieweer;
use App\Traits\MachineTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\MethodconTrait;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    use ResponseTrait,MachineTrait,ImageTrait,MethodconTrait,TestAuth;

    //
     /**
     * todo Display a listing of the resource.
     */
    public function index()
    {
        // ? show all post of follwing //
        $posts = Post::get();
        $folowers = Follow::where('followers_id',auth()->user()->id)->get();
        $postfollow =  $this->postfollowers($posts , $folowers);
        return $this->returnData("posts",$postfollow);
    }

    //
     /**
     * todo Display a listing of the My posts.
     */
    public function showmyposts()
    {
        // ? show all post of follwing //
        $posts = Post::where("user_id",auth()->user()->id)->get();
        return $this->returnData("posts",$posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * todo  Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //! rules
        $rules = $this->rulesPosts();
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }

        // todo move image to folder images/posts //
        $folder = 'images/posts';$path = 'reviveimageposts';
        $path = $this->saveimage($request->file,$folder ,$path);
        //! Add into database //
        $posts = Post::create([
            'description' => $request->description,
            'user_id' =>auth()->user()->id,
            'path'  => $path,
        ]);
        $msg = " Create successfully .";
        return $this->returnSuccessMessage($msg); 
    }

    /**
     * todo Display the specified resource.
     */
    public function show(Request $request , Post $post)
    {
        // ? show only psot by id and +view //
        $post = Post::find($request->post) ;
        if($post){event(new PostsVieweer($post));}
        return $this->returnData("post",$post);
    }

    /**
     * todo Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // ? return info post
        $posts = Post::find($request->id) ;
        if($posts->user_id != auth()->user()->id){return $this->returnError('U303','Error Some Thing Wrong .');}
        return $this->returnData("post",$posts);

    }

    /** 
     * 
     * todo Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
        $old_post = Post::find($request->post);
        if($old_post->user_id != auth()->user()->id){return $this->returnError('U303','Error Some Thing Wrong .');} 
        $rules = [
            'description' => 'required|max:200',
        ];
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
      * todo return posts image
      */
    public function imagesposts(Request $request,$post){
        if(isset($post)){
        return $this->returnimageposts($post,$post);}
        else {return 'null';}

    }
    /**
     * todo Remove the specified resource from storage.
     */
    public function destroy(Request $request , $post)
    {
        // ? delete posts //
        $posts = Post::find($request->id) ;
        if($posts->user_id != auth()->user()->id){return $this->returnError('U303','Error Some Thing Wrong .');} 
        $posts->delete();
        return $this->returnSuccessMessage("Delete Posts Successfully .");
    }

    /**
     * todo Autocomplete Search the specified resource from storage.
     */
     public function autocolmpletesearch()
     {
        // search by 
          $query = $request->get('query');
          $filterResult = Departments::where('name', 'LIKE', '%'. $query. '%')->get();
          return $this->returnData("posts",$filterResult);
     }

    /**
     * todo restore index the specified resource from storage.
     */
    public function restoreindex()
    {
       // return all post i deleted it //
       $post = Post::where('user_id',auth()->user()->id)->onlyTrashed()->get();
       return $this->returnData("posts",$post);
    }

     /**
     * todo  restore the specified resource from storage.
     */
    public function restore(Request $request)
    {
       //
       $post = Post::withTrashed()->find($request->id);
       if(!$post->id){return $this->returnError('P404','Error Some Thing Wrong .');}
       if($posts->user_id != auth()->user()->id){return $this->returnError('U303','Error Some Thing Wrong .');} 
       Post::withTrashed()->find($request->id)->restore();
       return $this->returnSuccessMessage("Restore Posts Successfully .");
    }

}
