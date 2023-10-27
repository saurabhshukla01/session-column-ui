<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

Route::get('/blog', [BlogController::class,'index'])->name('blog');
Route::post('/update-blog-data', [BlogController::class,'updateBlogData'])->name('update-blog-data');
Route::get('/user-form', [UserController::class,'showForm'])->name('user.form');
Route::post('/user-form', [UserController::class,'storeData'])->name('user.store');
Route::get('/edit-user/{id}',[UserController::class,'editUser'])->name('editUser');
Route::get('/delete-user/{id}',[UserController::class,'deleteUser'])->name('deleteUser');
Route::patch('/update-user/{index}', [UserController::class,'updateUser'])->name('updateUser');
Route::post('/user-final-form', [UserController::class,'finalData'])->name('user.final');