<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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

//Login Route
Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/login', [AuthController::class,'loginSubmit'])->name('login.submit');
