<?php

namespace App\Http\Controllers\Api;

use Auth;
use Exception;
use Validator;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;

class FavouriteController extends Controller
{
    use ResponseTrait;
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
        
        $postfav = Favourite::create([
            'posts_id'  => $request->posts_id,
            'user_id' =>auth()->user()->id,
        ]);

        $msg = " Create successfully .";
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
     */
    public function showfavourite(Request $request)
    {
        //
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
        $postfav = Favourite::where('user_id',auth()->user()->id)
        ->where('posts_id',$request->post_id)->get();
        foreach ($postfav as $fav) {
          $fav->delete();
         }
        $msg = " Delete Favourite posts successfully .";
        return $this->returnSuccessMessage($msg);  
    }

    
}
