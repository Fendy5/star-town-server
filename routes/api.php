<?php

use App\Http\Controllers\Api\CircleController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WorkController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix'=>'/v1'], function () {
    Route::post('login', [AuthController::class,'login']);

    Route::post('/register', [UserController::class, 'register']);

    Route::get('/index', [IndexController::class, 'index']);
    Route::get('/get_recommend', [IndexController::class, 'getRecommendList']);

    Route::get('/user',[UserController::class, 'index']);
    Route::get('/user/my_like', [UserController::class, 'myLike']);
    Route::get('/user/my_comment', [UserController::class, 'myComment']);
    Route::get('/user/my_create', [UserController::class, 'myCreate']);
    Route::get('/user/my_follow', [UserController::class, 'myFollow']);
    Route::get('/user/my_fans', [UserController::class, 'myFans']);

    Route::apiResources([
            'comments' => CommentController::class,
            'follows'=> FollowController::class,
            'works' => WorkController::class,
            'circles' => CircleController::class,
            'likes' => LikeController::class
    ]);

    Route::get('/get_arts', [IndexController::class, 'getArtList']);

    Route::get('/test', function () {
        return 'test';
    });
});

Route::group(['prefix'=>'/v1','middleware'=>'auth:api'], function () {
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::get('user-info', [AuthController::class,'userInfo'])->name('user-info');

//    Route::post('/work/create', [WorkController::class,'create']);
});

//Route::group(['namespace' => 'Home','prefix'=>'/v1','middleware'=>'auth:api'], function () {
//    Route::post('/work/create', [WorkController::class,'create']);
//});

//Route::group(['prefix' => 'auth'], function () {
//    Route::post('login', [AuthController::class,'login']);
//    Route::post('logout', [AuthController::class,'logout']);
//    Route::post('refresh', [AuthController::class,'refresh']);
//    Route::post('me', [AuthController::class,'me']);
//});
