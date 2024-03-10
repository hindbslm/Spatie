<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[RegisteredUserController::class,'store']);
Route::post('login',[AuthenticatedSessionController::class,'store']);
Route::post('logout',[AuthenticatedSessionController::class,'destroy'])
  ->middleware('auth:api');
  Route::get('users',[UserController::class,'index'])
  ->middleware('auth:api', 'role:Admin');
  Route::get('users/{id}',[UserController::class,'show'])
  ->middleware('auth:api', 'role:Admin');
  Route::post('users',[UserController::class,'store'])
  ->middleware('auth:api', 'role:Admin');
  Route::put('users/{id}',[UserController::class,'update'])
  ->middleware('auth:api', 'role:Admin');
  Route::delete('users/{id}',[UserController::class,'destroy'])
  ->middleware('auth:api', 'role:Admin');

    // Route::resource('users', UserController::class)->middleware('role:Admin');
