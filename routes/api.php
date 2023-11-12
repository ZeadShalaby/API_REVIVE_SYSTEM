<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ReviveController;
use App\Http\Controllers\Api\TourismController;
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
    Route::POST('/logout',[AuthController::class, 'logout'])->middleware('auth.guard:api');
    //// ? return profile information ////
    Route::get('/profile',[AuthController::class, 'profile'])->middleware('auth.guard:api');
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

    Route::get('/posts',[PostController::class, 'index']);
    Route::POST('/posts',[PostController::class, 'store']);
    Route::get('/posts/show/{id}',[PostController::class, 'show']);
    Route::get('/posts/edit/{id}',[PostController::class, 'show']);
    Route::PUT('/posts/update/{id}',[PostController::class, 'update']);
    Route::PUT('/posts/update/{id}',[PostController::class, 'update']);
    Route::Delete('/posts/destroy/{id}',[PostController::class, 'destroy']);

});
//?end//


//?start//
// ! all routes / api here must be role = owner or admin //
Route::group(['middleware' => ['checksecurity','auth.guard:api','check.owner.admin-role']], function () {

    Route::get('/revive/data',[ReviveController::class, 'index']);

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