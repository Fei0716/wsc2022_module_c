<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//routes that does not require authentication

Route::middleware("guest")->group(function(){
    Route::get('admin' , [AuthController::class, 'loginPage'])->name('loginPage');
    Route::post('admin' , [AuthController::class, 'login'])->name('login');
});


//routes that does not require authentication
Route::middleware("auth")->group(function(){
    Route::post('admin/logout' , [AuthController::class, 'logout'])->name('logout');

    Route::get('' , [AuthController::class, 'getAdminUsers'])->name("getAdminUsers");

//    users
    Route::resource("users" , UserController::class);
    Route::post("users/{user}/unblock" , [UserController::class , 'unblock'])->name('users.unblock');
    Route::delete("users/{user}/block" , [UserController::class , 'block'])->name('users.block');
    Route::resource("users" , UserController::class);

//    games
    Route::resource("games" , GamesController::class);
//    scores
    Route::resource("scores" , ScoreController::class);
    Route::delete("scores/{game}/reset", [ScoreController::class, "resetScore"])->name("scores.reset");
    Route::delete("scores/{user}/remove-scores", [ScoreController::class, "deletePlayerScores"])->name("scores.deletePlayerScores");
});

