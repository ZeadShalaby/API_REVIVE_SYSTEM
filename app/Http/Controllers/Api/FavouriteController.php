<?php

namespace App\Http\Controllers\Api;

use Auth;
use Exception;
use Validator;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\MethodconTrait;
use App\Http\Controllers\Controller;

class FavouriteController extends Controller
{
    use ResponseTrait , MethodconTrait;
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
            'posts_id' => 'required|exists:posts,id',
        ];

        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
        }

        $checkfav = $this->checkfav($request->posts_id , auth()->user()->id);
        if($checkfav !=true){return $this->returnError('Fv001',"Alredy Liked this posts. :( !.."); }

        $postfav = Favourite::create([
            'posts_id'  => $request->posts_id,
            'user_id' =>auth()->user()->id,
        ]);

        $msg = " Add Like To This Post successfully .";
        return $this->returnSuccessMessage($msg); 



    }

    /**
     * todo Display the specified resource.
     */
    public function show(string $id)
    {
        //
        
    }

     /**
     * todo Display the specified resource.
     * ? show all favourite of post 
     */
    public function showfavourite(Request $request)
    {
        //
        $favourite = Favourite::select('user_id')->where('posts_id',$request->posts_id)->get();
        foreach($favourite as $belong){
          $user = $belong->user; 
        }
        return $this->returnData('PersonFav',$favourite);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
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
        //
        $msg = " Delete Favourite posts successfully .";
        $postfav = Favourite::where('user_id',auth()->user()->id)
        ->where('posts_id',$request->post_id)->get();
        
        foreach ($postfav as $fav) {
            
            if( isset($fav->id) )
            {
              $fav->delete();
              return $this->returnSuccessMessage($msg);  
            }
        }
        
        return $this->returnError("FV404" , "Something Wrong :( ! ...");

    }

    
}
