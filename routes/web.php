<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

////////////////////////////Begin: public Routes............//////////////////////////////////////
Route::get('/', function () {
    return view('login');
});
Route::get('login',[AdminController::class, 'index'])->name('login') ;

Route::post('verify_login',[AdminController::class,'login'])->name('verify_login');

Route::post('logout',[AdminController::class,'logout'])->name('logout');

////////Begin: socialite facebook Route............///////
Route::get('/login/facebook',[AdminController::class,'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback',[AdminController::class,'handleFacebookCallback']);
Route::get('privacy',[AdminController::class,'privacy'])->name('privacy');

////end: socialite facebook Route............///////////////////

///////Begin: socialite Google Route............///////////////
    Route::get('/login/google',[AdminController::class,'redirectToGoogle'])->name('login.facebook');
    Route::get('/login/Google/callback',[AdminController::class,'handleGoogleCallback']);
    Route::get('google_privacy',[AdminController::class,'privacy'])->name('privacy');
///////END: socialite Google Route............/////////////////

/////////end: Public Routes............///////

////////Begin: protected Routes............///
Route::group(['middleware' => 'auth'], function () {
        Route::get('dashboard',[AdminController::class,'dashboard'])->name('dashboard');
        Route::get('users_list',[AdminController::class,'usersList'])->name('usersList');
    Route::get('change_status/{id}', [AdminController::class,'changeStatus'])->name('changeStatus');

    //////////////////////////.......Category Section .........../////////
        Route::get('categories',[CategoryController::class,'index'])->name('categories');
        Route::get('edit/category/{id}', [CategoryController::class,'editCategory'])->name('edit/category');
        Route::post('add_Categories',[CategoryController::class,'store'])->name('add_Categories');
        Route::post('update_Categories',[CategoryController::class,'update'])->name('update_Categories');
        Route::get('delete_Category/{id}',[CategoryController::class,'destroy'])->name('delete');

        //////////////////////////.......Subcategory Section .........../////////

        Route::get('sub_categories',[SubcategoriesController::class,'index'])->name('sub_categories');
        Route::get('edit/subcategory/{id}', [SubcategoriesController::class,'edit'])->name('edit/subcategory');
        Route::post('add_subCategories',[SubcategoriesController::class,'store'])->name('add_subCategories');
        Route::post('update_subcategories',[SubcategoriesController::class,'update'])->name('update_subcategories');
        Route::get('delete_subCategory/{id}',[SubcategoriesController::class,'destroy'])->name('delete');
    });
//////////////////////////end: Protected Routes............//////////////////////////////////////
