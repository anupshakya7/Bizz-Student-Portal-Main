<?php

use App\Http\Controllers\ApplyFormController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseSearchController;
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

Route::group(['middleware' => ['revalidate_back_history']], function () {
    //Home Route
    Route::get('/', [HomeController::class, 'home'])->name('home');

    Route::group(['prefix' => 'auth', 'middleware' => ['custom_guest']], function () {
        //Register Route
        Route::get('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register.submit');
        Route::post('/register/check_email_unique', [AuthController::class, 'checkEmail'])->name('register.checkEmail');

        //Verify Email
        Route::get('/verify-email/{verification_code}', [AuthController::class, 'verifyEmail'])->name('register.verifyEmail');

        //Login Route
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');

        //Forget Password
        Route::get('/forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');
        Route::post('/forget-password', [AuthController::class, 'forgetPasswordSubmit'])->name('forgetPassword.submit');

        //Reset Password
        Route::get('/reset-password/{resetcode}', [AuthController::class, 'resetPassword'])->name('resetPassword');
        Route::post('/reset-password/{resetcode}', [AuthController::class, 'resetPasswordSubmit'])->name('resetPassword.submit');

        //Google Login
        Route::get('google/login', [AuthController::class, 'handleRedirect'])->name('google.login');
        Route::get('google/callback', [AuthController::class, 'handleCallback'])->name('google.login.callback');
    });

    //Logout Route
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('custom_auth');

    Route::group(['middleware' => ['custom_auth']], function () {
        //Dashboard Route
        Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

        //Profile Route
        Route::prefix('profile')->group(function () {
            //Edit Profile
            Route::get('/edit-profile', [ProfileController::class, 'editProfile'])->name('profile.editProfile');
            Route::put('/edit-profile', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');

            //Change Password
            Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
            Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
        });

        //Courses Route
        Route::prefix('courses')->group(function () {
            Route::get('/search', [CourseSearchController::class,'index'])->name('course.index');
            Route::get('/universities-api-search', [CourseSearchController::class,'searchUniversity'])->name('university.searchapi');
            Route::get('/filter_university', [CourseSearchController::class,'filterUniversity'])->name('api.filterUniversity');
            Route::get('/filter_course', [CourseSearchController::class,'filterCourse'])->name('api.filterCourse');
            Route::get('/filter_intake', [CourseSearchController::class,'filterIntake'])->name('api.filterIntakemonth');
        });

        //Courses Apply Form Route
        Route::prefix('applynow')->group(function () {
            Route::get('/', [ApplyFormController::class,'index'])->name('applynow.index');
            Route::post('/', [ApplyFormController::class,'submit'])->name('applynow.submit');
        });
    });
});
