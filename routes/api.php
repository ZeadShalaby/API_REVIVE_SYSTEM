<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\ReviveController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\TourismController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\users\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//?start//
// ! all routes / api here must be authentcated
Route::group(['middleware' => ['api']], function () {


    //?start//
    // todo group user to login & logout & register //
    Route::group(['prefix' =>'users','namespace' => 'users'], function () {
    Route::POST('/login', [AuthController::class, 'login']);
    Route::POST('/regist',[AuthController::class, 'register']);
    /*
     todo Invalidate Token Security Site
     todo  Brocken Access Controller Users enumeration
    */
    Route::POST('/logout',[AuthController::class, 'logout'])->middleware('auth.guard:api','checksecurity');
    //// ? return profile information ////
    Route::get('/profile',[AuthController::class, 'profile'])->middleware('auth.guard:api','checksecurity');
    });
    //?end//

    //?start//
    // ! login with social (github , google) //
    Route::group(['middleware' => ['checksecurity']], function () {
        // login with social
        Route::get('/redirect/{service}',[ServiceController::class,'redirect']);
        // callback google
        Route::get('/auth/google/callback',[ServiceController::class,'googlecallback']);
        // callback githup 
        Route::get('/auth/github/callback',[ServiceController::class,'githubcallback']); 
    
    });
    //?end//
   
    //?start//
    //! return image post or user or machine // 
    Route::group(['prefix' =>'images','namespace' => 'users'], function () {
    
    // todo return image post | users | machine //
    Route::POST('/revive/profilephoto',[AuthController::class, 'profileimage']);
    Route::POST('/revive/postimage',[AuthController::class, 'postsimage']);
    Route::POST('/revive/filesmachineimage',[AuthController::class, 'machineimage']);
        
//! ////////////////////////////////////////////////////////////////////////////////////////

    // todo return image post | users | machine //
    Route::get('/reviveimageusers/{service}',[AuthController::class, 'imagesuser']);
    Route::get('/reviveimageposts/{service}',[AuthController::class, 'imagesposts']);
    Route::get('/reviveimagemachine/{service}',[AuthController::class, 'imagesmachine']);

    });
    //?end//




//?start//
// ! all routes / api here must be role = Admin //
Route::group(['middleware' => ['checksecurity','auth.guard:api','check.admin-role']], function () {

    Route::POST('/tcr/new_machine',[ReviveController::class, 'newtcr']);
    Route::get('/tcr/edit/{machineid}',[ReviveController::class, 'edit']);
    Route::PUT('/tcr/update/{machineid}',[ReviveController::class, 'update']);
    Route::Delete('/tcr/{machineid}',[ReviveController::class, 'destroy']);


});
//?end//





//?start//
// ! all routes / api here must be role = Owner //
Route::group(['middleware' => ['checksecurity','auth.guard:api','check.owner-role']], function () {



});
//?end//



//?start//
// ! all routes / api here must be role = Customer //
Route::group(['middleware' => ['checksecurity','auth.guard:api','check.customer-role']], function () {



});
//?end//



//?start//
// ! all routes / api here must be role = owner or client //
Route::group(['middleware' => ['checksecurity','auth.guard:api','check.owner.customer-role']], function () {

    //? All posts Route //
    Route::get('/posts',[PostController::class, 'index']);
    Route::POST('/posts',[PostController::class, 'store']);
    Route::get('/posts/show/{id}',[PostController::class, 'show']);
    Route::get('/posts/edit/{id}',[PostController::class, 'edit']);
    Route::PUT('/posts/update/{id}',[PostController::class, 'update']);
    Route::PUT('/posts/update/{id}',[PostController::class, 'update']);
    Route::Delete('/posts/destroy/{id}',[PostController::class, 'destroy']);

    //? Favourite & Comment & Follow route //
    Route::POST('/posts/favourite',[FavouriteController::class, 'store']);
    Route::get('/posts/favourite',[FavouriteController::class, 'showfavourite']);
    Route::Delete('/posts/favourite',[FavouriteController::class, 'destroy']);
    // ? comment //
    Route::POST('/posts/comment',[CommentController::class, 'store']);
    Route::get('/posts/comment',[CommentController::class, 'showcomment']);
    Route::get('/posts/comment/edit/{comentid}',[CommentController::class, 'edit']);
    Route::PUT('/posts/comment',[CommentController::class, 'update']);
    Route::Delete('/posts/comment',[CommentController::class, 'destroy']);
    // ? follow //
    Route::POST('/users/follow',[FollowController::class, 'store']);
    Route::get('/users/following',[FollowController::class, 'showfollowing']);
    Route::get('/users/followers',[FollowController::class, 'showfollowers']);
    Route::Delete('/users/follow',[FollowController::class, 'destroy']);

});
//?end//


//?start//
// ! all routes / api here must be role = owner or admin //
Route::group(['middleware' => ['checksecurity','auth.guard:api','check.owner.admin-role']], function () {
    // ?revive //
    Route::get('/revive/data',[ReviveController::class, 'index']);
    Route::get('/revive/machine/data',[ReviveController::class, 'machineindex']);
    Route::get('/revive/data/date/{createat}',[ReviveController::class, 'show']);
    // ? tourism //
    Route::get('/tourism/data',[TourismController::class, 'index']);
    Route::get('/tourism/data/date/{createat}',[TourismController::class, 'show']);

});
//?end//


//?start//
// ! all routes / api here must be for machine (revive | tourism ) //
Route::group(['middleware' => ['securitymachine']], function () {
     
    //?start//
    // todo prefix in all routes *hard* //
    Route::group(['prefix' =>'hard'], function () {


    Route::POST('/revive/data',[ReviveController::class, 'store']);

    Route::POST('/tourism/data',[TourismController::class, 'store']);

    

});
//?end//

});
//?end//


});
//?end//