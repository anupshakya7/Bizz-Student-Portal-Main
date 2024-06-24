<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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
//Home Route
Route::get('/', [HomeController::class,'home'])->name('home');

//Register Route
Route::get('/register', [AuthController::class,'register'])->name('register');
Route::post('/register', [AuthController::class,'registerSubmit'])->name('register.submit');
Route::post('/register/check_email_unique', [AuthController::class,'checkEmail'])->name('register.checkEmail');
Route::get('/register/verify-email/{verification_code}',[AuthController::class,'verifyEmail'])->name('register.verifyEmail');

//Login Route
Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/login', [AuthController::class,'loginSubmit'])->name('login.submit');

//Logout Route
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

//Dashboard Route
Route::get('/dashboard',[ProfileController::class,'dashboard'])->name('dashboard');

//Profile Route
Route::get('/profile/edit-profile',[ProfileController::class,'editProfile'])->name('profile.editProfile');
Route::put('/profile/edit-profile',[ProfileController::class,'updateProfile'])->name('profile.updateProfile');


