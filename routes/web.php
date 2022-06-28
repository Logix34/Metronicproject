<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers;
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

Route::get('/', function () {
    return view('login');
});
Route::get('login',[AdminController::class,'index'])->name('login') ;

Route::post('verify_login',[AdminController::class,'login'])->name('verify_login');

Route::post('logout',[AdminController::class,'logout'])->name('logout');

    Route::group(['middleware' => 'auth'], function () {

        Route::get('dashboard',[AdminController::class,'dashboard'])->name('dashboard');
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
