<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Admin\User\AdministratorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EstateController;
use App\Http\Controllers\ServiceController;
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


Route::prefix('admin')->group(function () {
    Route::name('admin.')->group(function () {
        Route::view('/', 'admin.index')->name('index'); //Take me to Admin Dashboard

        Route::prefix('users')->name('users.')->group(function () {
            Route::resource('administrator', AdministratorController::class);
        });
        Route::view('/',                   'admin.index')->name('index'); //Take me to Admin Dashboard

        Route::get('/estate/list',      [EstateController::class, 'index'])->name('list_estate');
        Route::get('/estate/add',      [EstateController::class, 'create'])->name('add_estate');
        Route::post('/estate/add',      [EstateController::class, 'store'])->name('store_estate');
        Route::get('/estate/summary/{estate:uuid}',      [EstateController::class, 'estateSummary'])->name('estate_summary');
        Route::get('/estate/edit/{estate:uuid}',      [EstateController::class, 'edit'])->name('edit_estate');
        Route::patch('/estate/edit/{estate:uuid}',      [EstateController::class, 'update'])->name('update_estate');
        Route::get('/estate/reinstate/{estate:uuid}',      [EstateController::class, 'reinstate'])->name('reinstate_estate');
        Route::get('/estate/deactivate/{estate:uuid}',      [EstateController::class, 'deactivate'])->name('deactivate_estate');
        Route::get('/estate/approve/{estate:uuid}',      [EstateController::class, 'approve'])->name('approve_estate');
        Route::get('/estate/decline/{estate:uuid}',      [EstateController::class, 'decline'])->name('decline_estate');
        Route::get('/estate/delete/{estate:uuid}',      [EstateController::class, 'delete'])->name('delete_estate');


        //Routes for Category Management
        Route::get('/categories/reassign/{category}',       [CategoryController::class, 'reassign'])->name('categories.reassign');
        Route::post('/categories/reassign-service',         [CategoryController::class, 'reassignService'])->name('categories.reassign_service');
        Route::get('/categories/deactivate/{category}',     [CategoryController::class, 'deactivate'])->name('categories.deactivate');
        Route::get('/categories/reinstate/{category}',      [CategoryController::class, 'reinstate'])->name('categories.reinstate');
        Route::get('/categories/delete/{category}',         [CategoryController::class, 'destroy'])->name('categories.delete');
        Route::resource('categories',                       CategoryController::class);

        //Routes for Services Management
        Route::resource('services',                         ServiceController::class);


         //  location request
         Route::get('/location-request',                     [App\Http\Controllers\AdminLocationRequestController::class, 'index'])->name('location_request');
         Route::post('/get-names',                           [App\Http\Controllers\AdminLocationRequestController::class, 'getNames'])->name('get_names');
         Route::post('/request-location',                    [App\Http\Controllers\AdminLocationRequestController::class, 'requestLocation'])->name('request_location');

         //discount 
         Route::get('/discount/add',                     [App\Http\Controllers\DiscountController::class, 'create'])->name('add_discount');
         Route::get('/discount/list',                       [App\Http\Controllers\DiscountController::class, 'index'])->name('discount_list');
         Route::post('/discount/add',                    [App\Http\Controllers\DiscountController::class, 'store'])->name('store_discount');
        Route::post('/LGA',                             [App\Http\Controllers\DiscountController::class, 'getLGA'])->name('getLGA');
        Route::post('/estates',                             [App\Http\Controllers\DiscountController::class, 'estates'])->name('all_estates');
        Route::post('/categories',                             [App\Http\Controllers\DiscountController::class, 'category'])->name('categories');
        Route::post('/category-services',                             [App\Http\Controllers\DiscountController::class, 'categoryServices'])->name('category_services');
        Route::post('/discount-users',                    [App\Http\Controllers\DiscountController::class, 'discountUsers'])->name('discount_users');
        Route::post('/discount-users-edit',                    [App\Http\Controllers\DiscountEditController::class, 'discountUsersEdit'])->name('discount_users_edit');
        Route::get('/discount/edit/{discount:id}',                    [App\Http\Controllers\DiscountEditController::class, 'edit'])->name('edit_discount');
        Route::post('/categories-edit',                             [App\Http\Controllers\DiscountEditController::class, 'categoryEdit'])->name('categories_edit');
        Route::post('/category-services-edit',                             [App\Http\Controllers\DiscountEditController::class, 'categoryServicesEdit'])->name('category_services_edit');
        Route::post('/discount/edit',                    [App\Http\Controllers\DiscountEditController::class, 'editDiscount'])->name('store_discount_edit');
        Route::get('/discount/summary/{discount:id}',                    [App\Http\Controllers\DiscountController::class, 'show'])->name('summary');
        Route::get('/discount/delete/{discount:id}',                    [App\Http\Controllers\DiscountController::class, 'delete'])->name('delete_discount');
        Route::get('/discount/deactivate/{discount:id}',                    [App\Http\Controllers\DiscountController::class, 'deactivate'])->name('deactivate_discount');
        Route::get('/discount/activate/{discount:id}',                    [App\Http\Controllers\DiscountController::class, 'reinstate'])->name('activate_discount');

    });
});

    //All routes regarding clients should be in here
    // Route::view('/', 'client.index')->name('index'); //Take me to Admin Dashboard
    Route::resource('client', ClientController::class);

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
