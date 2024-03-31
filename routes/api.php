<?php

use App\Mail\Emailmailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SmsController;
use App\Http\Controllers\Api\TCRController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EmailController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\ReviveController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TourismController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\SavedPostsController;
use App\Http\Controllers\Api\users\AuthController;
use App\Http\Controllers\Api\ReportsPostsController;
use App\Http\Controllers\Api\Barter\BartherController;
use App\Http\Controllers\Api\MachineLearningController;

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
/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


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
    Route::group(['middleware' => ['web']], function () {
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
    
    // todo edit image post | users  //
    Route::POST('/revive/postimage',[AuthController::class, 'postsimage']);
        
//! ////////////////////////////////////////////////////////////////////////////////////////

    // todo return image post | users | machine //
    Route::get('/reviveimageusers/{service}',[AuthController::class, 'imagesuser']);
    Route::get('/reviveimageposts/{service}',[PostController::class, 'imagesposts']);
    Route::get('/reviveimagemachine/{service}',[MachineLearningController::class, 'imagesmachine']);
    // todo change photo for users  //
    Route::PUT('/revive/imgusers',[AuthController::class, 'changeimg']);

    });
    //?end//



//?start//
// ! all routes / api here must be role = Admin //
Route::group(['middleware' => ['checksecurity','auth.guard:api','check.admin-role']], function () {

    // todo for all things of new & old machine //
    Route::POST('/tcr/new_machine',[TCRController::class, 'newtcr']);
    Route::get('/tcr/edit/{machineid}',[TCRController::class, 'edit']);
    Route::PUT('/tcr/update/{machineid}',[TCRController::class, 'update']);
    Route::Delete('/tcr/{machineid}',[TCRController::class, 'destroy']);
    // todo autocomplete search & restore machine //
    Route::get('/tcr/autocolmpletesearch',[TCRController::class, 'autocolmpletesearch']);
    Route::get('/tcr/restoreindex',[TCRController::class, 'restoreindex']);
    Route::post('/tcr/restore',[TCRController::class, 'restore']);
    // todo for all users //
    Route::POST('/users',[UserController::class, 'index']);
    Route::get('/users/shows',[UserController::class, 'show']);
    Route::get('/users/edit/{user}',[UserController::class, 'edit']);
    Route::PUT('/users/updatepass/{user}',[UserController::class, 'updatepass']);
    Route::PUT('/users/modifyrole/{user}',[UserController::class, 'modifyrole']);
    Route::Delete('/users/destroy/{user}',[UserController::class, 'destroy']);
    // todo autocomplete search  //
    Route::get('/users/autocolmpletesearch',[UserController::class, 'autocolmpletesearch']);
    // todo report posts //
    Route::get('/reports/posts',[ReportsPostsController::class, 'reportposts']);
    Route::PUT('/skip/report/posts',[ReportsPostsController::class, 'skipreport']);
    Route::Delete('/posts/destroy',[ReportsPostsController::class, 'destroy']);
//?start//
    // todo Barter process CarbonFootprint //
    // todo prefix in all routes *BarterProcess* //
    Route::group(['prefix' =>'BarterProcess'], function () {

    Route::POST('/CarbonFootprint',[BartherController::class, 'index']);
    Route::get('/edit',[BartherController::class, 'edit']);
    Route::PUT('/update',[BartherController::class, 'update']);
});
//?end//

});
//?end//





//?start//
// ! all routes / api here must be role = Owner //
Route::group(['middleware' => ['checksecurity','auth.guard:api','check.owner-role']], function () {

    // ? training Data carbon footprint for factory //
    Route::POST('/python/carbon/footprint/factory',[MachineLearningController::class, 'carbon_footprint']);
//?start//
    // todo Barter process CarbonFootprint //
    // todo prefix in all routes *BarterProcess* //
    Route::group(['prefix' =>'BarterProcess'], function () {

      Route::get('/mine',[BartherController::class, 'ShowBarter']);
      Route::POST('/Store',[BartherController::class, 'Store']);
      Route::Delete('/delete',[BartherController::class, 'destroy']);

      
    });
//?end//

});
//?end//



//?start//
// ! all routes / api here must be role = Customer //
Route::group(['middleware' => ['checksecurity','auth.guard:api','check.customer-role']], function () {
    //? delete my account
    Route::Delete('/users/delete/myaccounts',[AuthController::class, 'destroy']);

});
//?end//



//?start//
// ! all routes / api here must be role = owner or client //
Route::group(['middleware' => ['checksecurity','auth.guard:api','check.owner.customer-role']], function () {

    //? All posts Route //
    Route::get('/posts',[PostController::class, 'index']);
    Route::POST('/posts',[PostController::class, 'store']);
    Route::get('/posts/show/{id}',[PostController::class, 'show']);
    Route::get('/posts/showmyposts',[PostController::class, 'showmyposts']);
    Route::get('/posts/edit/{id}',[PostController::class, 'edit']);
    Route::PUT('/posts/update/{id}',[PostController::class, 'update']);
    Route::Delete('/posts/destroy/{id}',[PostController::class, 'destroy']);

    //? Favourite & Comment & Follow & saved & report routes //
    Route::POST('/posts/favourite',[FavouriteController::class, 'store']);
    Route::get('/posts/favourite',[FavouriteController::class, 'showfavourite']);
    Route::Delete('/posts/favourite',[FavouriteController::class, 'destroy']);
    // ? comment //
    Route::POST('/posts/comment',[CommentController::class, 'store']);
    Route::get('/posts/comment',[CommentController::class, 'showcomment']);
    Route::get('/posts/comment/edit',[CommentController::class, 'edit']);
    Route::PUT('/posts/comment/update',[CommentController::class, 'update']);
    Route::Delete('/posts/comment/destroy',[CommentController::class, 'destroy']);
    // ? follow //
    Route::POST('/users/follow',[FollowController::class, 'store']);
    Route::get('/users/following',[FollowController::class, 'showfollowing']);
    Route::get('/users/followers',[FollowController::class, 'showfollowers']);
    Route::get('/follow/autocolmpletesearch',[FollowController::class, 'autocolmpletesearch']);
    Route::Delete('/users/follow',[FollowController::class, 'destroy']);
    // ? saved posts (favourite posts) //
    Route::POST('/saved/post',[SavedPostsController::class, 'store']);
    Route::get('/show/posts/saved',[SavedPostsController::class, 'showsaved']);
    Route::Delete('/unsaved/posts',[SavedPostsController::class, 'destroy']);
    // ? report posts //
    Route::POST('/add/report/posts',[ReportsPostsController::class, 'store']);
    // ? user info 
    Route::get('/users/edits/myaccount',[AuthController::class, 'edit']);
    Route::PUT('/users/updates/myaccount',[AuthController::class, 'update']);
    Route::get('/users/checkvalidate/password',[AuthController::class, 'checkvalidatepass']);
    Route::get('/users/edits/pasword',[AuthController::class, 'editpass']);
    Route::PUT('/users/updates/password',[AuthController::class, 'updatepass']);

    
});
//?end//

//?start//
// ! all routes / api here must be users info//
Route::group(['middleware' => ['checksecurity']], function () {

    // ? users 
    Route::POST('/forget/pass',[AuthController::class, 'forget']);
    Route::POST('/check/code',[AuthController::class, 'checkcode']);

});
//?end//

//?start//
// ! all routes / api here must be role = owner or admin //
Route::group(['middleware' => ['checksecurity','auth.guard:api','check.owner.admin-role']], function () {
    // ?revive //
    Route::get('/revive/data',[ReviveController::class, 'index']);
    Route::get('/revive/machine/data',[ReviveController::class, 'machineindex']);
    Route::get('/revive/data/date/revive',[ReviveController::class, 'show']);
    // ? tourism //
    Route::get('/tourism/data',[TourismController::class, 'index']);
    Route::get('/tourism/data/date/machines',[TourismController::class, 'show']);
    // ? training Data //
    Route::POST('/python/tranining',[MachineLearningController::class, 'tranining']);
    // ? training Data weather //
    Route::POST('/python/weather',[MachineLearningController::class, 'weather']);
    // ? training Data footprint product //
    Route::POST('/python/trainng/footprint/product',[MachineLearningController::class, 'tcfpfactory_years']);
//?start//
    // todo Barter process CarbonFootprint //
    // todo prefix in all routes *BarterProcess* //
    Route::group(['prefix' =>'BarterProcess'], function () {

        Route::get('/mine/show',[BartherController::class, 'Show']);
        Route::get('/restoreindex/barter',[BartherController::class, 'restoreindex']);
        Route::POST('/restore/barter',[BartherController::class, 'restore']);
        Route::get('/autocolmpletesearch',[BartherController::class, 'autocolmpletesearch']);

    });
    //?end//

});
//?end//

//?start//
// ! all routes / api here must be for machine (revive | tourism | other ) //
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


//?start//
// ! for all users Owner | Client | Admin //
Route::group(['middleware' => ['checksecurity','auth.guard:api']], function () {
    
Route::POST('/python/dioxide/ratio',[MachineLearningController::class, 'dioxide_ratio']);
Route::POST('/python/trainng/footprint/person',[MachineLearningController::class, 'tcfpperson_years']);
Route::POST('/python/chat',[MachineLearningController::class, 'chat']);

//? test code python //
Route::POST('/python/test',[MachineLearningController::class, 'sayhellow']);
// ? all tourist area fci tourism coastal 
Route::get('/tourist/areas',[TourismController::class,'touristareas']);
// ? edit user image //
Route::POST('/revive/usersimage',[AuthController::class, 'changeimg']);

});
//?end//

});
//?end//

Route::get('/send/sms',[SmsController::class ,'sendsms'] );
Route::get('/send/mail',[EmailController::class ,'sendmail'] );
Route::get('/send/mail/error/machine',[EmailController::class ,'errormachine'] );
Route::POST('/send/mail/users',[EmailController::class ,'SendAll'] );
