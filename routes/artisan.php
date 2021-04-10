<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Artisan && Configuration && Misc. Routes
|--------------------------------------------------------------------------
|
| Only Web Middleware is loaded here. These
| routes are loaded by the RouteServiceProvider with just web middleware attached
|
*/

Route::get('/', function () {
    return redirect(app()->getLocale());
});

// Route::get('another', function () {
//     return dd(request()->url(), request()->path(), request()->user(), auth()->user());
// })->middleware('auth');


Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    $request->session()->flash('success', 'Email Verified Successfully!!');
    return redirect(app()->getLocale() . '/' . auth()->user()->type->url ?: app()->getLocale() . '/home');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::get('email/verify', function () {
    return view('auth.verify', ['email' => request()->user()->email]);
})->middleware('auth')->name('verification.notice');


//Clear configurations:
Route::get('/config-clear', function () {
    Artisan::call('config:clear');
    return '<h1 style="color: #4CAF50">Configurations cleared</h1>';
});

//Clear cache:
Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');
    return '<h1 style="color: #4CAF50">Cache cleared</h1>';
});

//Clear view:
Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return '<h1 style="color: #4CAF50">Views cleared</h1>';
});

//Clear route:
Route::get('/route-clear', function () {
    Artisan::call('route:clear');
    return '<h1 style="color: #4CAF50">Routes cleared</h1>';
});
