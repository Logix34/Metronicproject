<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\SubCategoriesController;
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

Route::post('login',[UserController::class,'login']);
Route::post('signUp',[UserController::class,'signUp']);
Route::post('forget',[UserController::class,'forget']);
Route::post('reset',[UserController::class,'reset']);


Route::get('dashboard',[UserController::class,'index'])->middleware('auth:sanctum');
Route::get('categories',[CategoriesController::class,'index'])->middleware('auth:sanctum');
Route::get('sub_categories',[SubCategoriesController::class,'index'])->middleware('auth:sanctum');
Route::post('update',[UserController::class,'update'])->middleware('auth:sanctum');
