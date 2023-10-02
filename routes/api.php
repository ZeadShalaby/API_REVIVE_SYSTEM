<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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


// ! all routes / api here must be authentcated
Route::group(['middleware' => ['api','checksecurity']], function () {

    // todo group user to login & logout & register //
    Route::group(['prefix' =>'users','namespace' => 'users'], function () {
    Route::POST('login', [AuthController::class, 'login']);
    Route::POST('regist',[AuthController::class, 'register']);
    /*
     todo Invalidate Tocken Security Site
     todo  Brocken Access Controller Users enumeration
    */
    Route::POST('logout',[AuthController::class, 'logout'])->middleware('auth.guard:api');
    //// ? return profile information ////
    Route::POST('profile',[AuthController::class, 'profile'])->middleware('auth.guard:api');
    });
    //

});



// ! all routes / api here must be role = Admin //
Route::group(['middleware' => ['api','checksecurity','auth.guard:api','check.admin-role']], function () {



});







// ! all routes / api here must be role = Owner //
Route::group(['middleware' => ['api','checksecurity','auth.guard:api','check.owner-role']], function () {



});





// ! all routes / api here must be role = Customer //
Route::group(['middleware' => ['api','checksecurity','auth.guard:api','check.customer-role']], function () {



});
