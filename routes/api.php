<?php

use App\Http\Controllers\api\GameController;
use App\Http\Controllers\api\ScoreController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
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


Route::prefix("v1")->group(function(){
    Route::post("auth/signup ", [AuthController::class, "signup"]);
    Route::post("auth/signin ", [AuthController::class, "signin"]);

//    Routes that requires token
    Route::middleware("auth:sanctum" , "check.block.status")->group(function(){
        Route::post("auth/signout" , [AuthController::class, "signout"]);


        //game
        Route::apiResource("games" , GameController::class)->except("index", "show");

        //score
        Route::get("games/{game}/scores" , [ScoreController::class , "getHighscores"]);
        Route::post("games/{game}/scores" , [ScoreController::class , "postScore"]);
    });
    //user
    Route::get("users/{user}" , [UserController::class ,  "show"]);
    Route::apiResource("games" , GameController::class)->only("index", "show");
});
