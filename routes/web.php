<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes ONLY AUTHENTICATED USERS HAVE ACCESS TO THIS ROUTE
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| This routes contain the following middleware
| 1. web -> Laravels web group middlewares
| 2. setlocale -> Middleware to check user language using $request->segment(1)
|                 if $request->segment(1) is not in config('app.available_locales')
|                  default of config('app.locale') is used.
| 3. auth -> Laravels authentication middleware
|
| 4. permitted.user -> Middleware to check if user is permitted
|                      using $request->segment(2)
|                      and Authenticated User Type Url
*/


// Route::prefix('{type}')->group(function () {
//     Route::get('/',function () {
//         return dd('i am admin user');
//     });

//     Route::get('another',function () {
//         return dd('i am admin user insideer');
//     });
// });

Route::prefix('/admin')->group(function () {
    Route::name('admin.')->group(function () {
        Route::view('/',           		'admin.index')->name('index'); //Take me to Admin Dashboard
    });
});

Route::prefix('/client')->group(function () {
    Route::name('client.')->group(function () {
        //All routes regarding clients should be in here
    });
});

Route::prefix('/cse')->group(function () {
    Route::name('cse.')->group(function () {
        //All routes regarding CSE's should be in here
        Route::view('/',           		'cse.index')->name('index'); //Take me to CSE Dashboard
    });
});

Route::prefix('/supplier')->group(function () {
    Route::name('supplier.')->group(function () {
        //All routes regarding suppliers should be in here
        Route::view('/',           		'supplier.index')->name('index'); //Take me to Supplier Dashboard

    });
});

Route::prefix('/technician')->group(function () {
    Route::name('technician.')->group(function () {
        //All routes regarding technicians should be in here
        Route::view('/',           		'technician.index')->name('index'); //Take me to Technician Dashboard
    });
});

Route::prefix('/qa')->group(function () {
    Route::name('qa.')->group(function () {
        //All routes regarding quality_assurance should be in here
        Route::view('/', 'qa.index')->name('index'); //Take me to quality_assurance Dashboard
        //Route::view('/profile', 'qa.view_profile')->name('view_profile');
        Route::get('/profile', [App\Http\Controllers\QualityAssurance\QualityAssuranceProfileController::class,'view_profile'])->name('view_profile');
        Route::get('/profile/edit_profile', [App\Http\Controllers\QualityAssurance\QualityAssuranceProfileController::class,'edit'])->name('edit_profile');
        Route::patch('/profile/update_profile', [App\Http\Controllers\QualityAssurance\QualityAssuranceProfileController::class,'update'])->name('update_profile');
        Route::patch('/profile/update_password', [App\Http\Controllers\QualityAssurance\QualityAssuranceProfileController::class,'update_password'])->name('update_password');
        Route::view('/requests', 'qa.requests')->name('requests');
        Route::view('/payments', 'qa.payments')->name('payments');
        Route::view('/messages/inbox', 'qa.messages.inbox')->name('messages.inbox');
        Route::view('/messages/sent', 'qa.messages.sent')->name('messages.sent');
    });
});

