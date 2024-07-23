<?php

//use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

//Authentication API:

Route::post('register',[UserAuthController::class,'register']);
Route::post('login',[UserAuthController::class,'login']);
Route::middleware('auth:sanctum')->group(function (){
    Route::post('logout',[UserAuthController::class,'logout']);

});


Route::middleware('auth:sanctum')->group(function () {

    Route::post('upload',[PictureController::class,'store']);
    Route::post('update',[UserController::class,'update']);
    Route::get('user',[UserController::class,'current']);
    Route::get('conversations',[ConversationController::class,'index']);
    Route::post('conversations',[ConversationController::class,'store']);
    Route::post('conversations/read',[ConversationController::class,'makConversationAsReaded']);
    Route::post('messages',[MessageController::class,'store']);
    Route::post('fcm',[UserController::class,'fcmToken']);

});
