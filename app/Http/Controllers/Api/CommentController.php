<?php

namespace App\Http\Controllers\Api;

use Auth;
use Exception;
use Validator;
use App\Models\Role;
use App\Models\Follow;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\MethodconTrait;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    use ResponseTrait , MethodconTrait;

    //
     /**
     * Display a listing of the resource.
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
        $rules = $this->rulesComment();
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }

        $checkfollowing = $this->checkfollowing($request->posts_id );
        if($checkfollowing != true){return $this->returnError('F001',"Cant do that Sir  !!..:("); }

        $postfav = Comment::create([
            'posts_id'  => $request->posts_id,
            'user_id' =>auth()->user()->id,
            'comment' =>$request->comment,
        ]);

        $msg = " Create successfully .";
        return $this->returnSuccessMessage($msg); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        
    }

     /**
     * todo Display the specified resource.
     */
    public function showcomment(Request $request)
    {
        // ? show all coment for posts //
        $comment = Comment::Where('posts_id',$request->posts_id)->select('id','posts_id','user_id','comment')->get();
        foreach ($comment as $belong) {
            $users = $belong->user;
            }
        return $this->returnData("comments" , $comment);
    }

    /**
     * todo Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        $comment = Comment::find($request->comentid);
        if(($comment->user_id != auth()->user()->id )||(isset($comment) && $comment ->count() == 0 )){return $this->returnError('C4000',"Something Wrong Sir :( !...");}
        return $this->returnData("Comments",$comment);

    }

    /**
     * todo Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //

        $comment = Comment::find($request->commentid);
        if($comment->user_id != auth()->user()->id){return $this->returnError('C403',"UnAuthorization to do that !!...:(");}
        
        $rules = ['comment' => 'required|max:200',];
        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }
        $comment->update([
                'comment' => $request->comment,
            ]);
             
            $msg = " Update Comment successfully ," ."new comment : " .$request->comment;
            return $this->returnSuccessMessage($msg); 
    }

    /**
     * todo Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $msg = " Delete Comment successfully .";
        $comment = Comment::find($request->commentid);
        if(auth()->user()->role != Role::ADMIN){
        if(($comment->user_id != auth()->user()->id )|| (isset($comment) && $comment ->count() == 0)){return $this->returnError('C400',"Something Wrong Sir :( !...");}$comment->delete();return $this->returnSuccessMessage($msg);}
        $comment->delete();
        return $this->returnSuccessMessage($msg); 
    }
}
