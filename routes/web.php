<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Admin\User\AdministratorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\EstateController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ToolInventoryController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\GatewayController;
use App\Http\Controllers\Admin\User\SupplierController;
use App\Http\Controllers\QualityAssurance\PaymentController;
use App\Http\Controllers\Admin\User\FranchiseeController;
use App\Http\Controllers\Admin\User\TechnicianArtisanController;
use App\Http\Controllers\Admin\User\QualityAssuranceController;
use App\Http\Controllers\Admin\User\CustomerServiceExecutiveController;
use App\Http\Controllers\Admin\User\ClientController as AdministratorClientController;
use App\Http\Controllers\Technician\TechnicianProfileController;
use App\Http\Controllers\Admin\EWalletController;
use App\Http\Controllers\AdminLocationRequestController;


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

        Route::view('/ratings/category', 'admin.ratings.category')->name('category');
        Route::view('/ratings/job', 	 'admin.ratings.job')->name('job');
        Route::view('/ratings/category_reviews', 	 'admin.ratings.category_reviews')->name('category_reviews');

        Route::prefix('users')->name('users.')->group(function () {
            Route::resource('administrator', AdministratorController::class);
            Route::resource('clients', AdministratorClientController::class);
            Route::resource('supplier', SupplierController::class);
            Route::resource('cse', CustomerServiceExecutiveController::class);
            Route::resource('franchisee', FranchiseeController::class);
            Route::resource('technician-artisan', TechnicianArtisanController::class);
            Route::resource('quality-assurance', QualityAssuranceController::class);
        });

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
        Route::get('/services/deactivate/{service}',        [ServiceController::class, 'deactivate'])
        ->name('services.deactivate');
        Route::get('/services/reinstate/{service}',         [ServiceController::class, 'reinstate'])->name('services.reinstate');
        Route::get('/services/delete/{service}',            [ServiceController::class, 'destroy'])->name('services.delete');
        Route::resource('services',                         ServiceController::class);


        //  location request
        Route::get('/location-request',                     [AdminLocationRequestController::class, 'index'])->name('location_request');
        Route::post('/get-names',                           [AdminLocationRequestController::class, 'getNames'])->name('get_names');
        Route::post('/request-location',                    [AdminLocationRequestController::class, 'requestLocation'])->name('request_location');


        //Routes for Activity Log Management
        Route::post('/activity-log/sorting',                [ActivityLogController::class, 'sortActivityLog'])->name('activity-log.sorting_users');
        Route::get('/activity-log/details/{activity_log}',  [ActivityLogController::class, 'activityLogDetails'])->name('activity-log.details');
        Route::resource('activity-log',                     ActivityLogController::class);

        //Routes for Tools & Tools Request Management
        Route::get('/tools/delete/{tool}',                  [ToolInventoryController::class, 'destroy'])->name('tools.delete');
        Route::resource('tools',                            ToolInventoryController::class);


        //Routes for Tax Management
        Route::get('/taxes/delete/{tax}',                   [TaxController::class, 'destroy'])->name('taxes.delete');
        Route::resource('taxes',                            TaxController::class);


         //Routes for Discount Management
         Route::get('/discount/add',                     [App\Http\Controllers\DiscountController::class, 'create'])->name('add_discount');
         Route::get('/discount/list',                       [App\Http\Controllers\DiscountController::class, 'index'])->name('discount_list');
         Route::post('/discount/add',                    [App\Http\Controllers\DiscountController::class, 'store'])->name('store_discount');
        Route::post('/LGA',                             [App\Http\Controllers\DiscountController::class, 'getLGA'])->name('getLGA');
        Route::post('/estates',                             [App\Http\Controllers\DiscountController::class, 'estates'])->name('all_estates');
        Route::post('/categories-list',                             [App\Http\Controllers\DiscountController::class, 'category'])->name('categories');
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

        //Admin payment Routes
        Route::get('/payment-gateway/list',                 [GatewayController::class, 'index'])->name('list_payment_gateway');
        Route::post('/paystack/update',                     [GatewayController::class, 'paystackUpdate'])->name('paystack_update');
        Route::post('/flutter/update',                      [GatewayController::class, 'flutterUpdate'])->name('flutter_update');

        // messaging routes
         Route::view('/messaging/templates',           		'admin.messaging.template')->name('template');
         Route::view('/messaging/outbox',      'admin.messaging.email.outbox')->name('inbox');
         Route::view('/messaging/new',      'admin.messaging.email.new')->name('new_email');

        //Routes for E-Wallet Admin Management
        Route::get('/ewallet/clients',                      [EWalletController::class, 'clients'])->name('ewallet.clients'); 
        Route::get('/ewallet/client/history',               [EWalletController::class, 'clientHistory'])->name('ewallet.client_history'); 
        Route::get('/ewallet/transactions',                 [EWalletController::class, 'transactions'])->name('ewallet.transactions'); 

    });
});

// Route::resource('client', ClientController::class);
    //All routes regarding clients should be in here
    Route::prefix('/client')->group(function () {
        Route::name('client.')->group(function () {
            //All routes regarding clients should be in here
            Route::get('/',           		[ClientController::class, 'index'])->name('index'); //Take me to Supplier Dashboard

            // Route::get('password',          [ClientController::class, 'changePassword'])->name('client.password');
            // Route::post('password',         [ClientController::class, 'submitPassword'])->name('change.password');

            // Route::get('/profile/view',             [ClientController::class, 'view_profile'])->name('client.view_profile');
            // Route::get('/profile/edit',             [ClientController::class, 'edit_profile'])->name('client.edit_profile');
            // Route::post('/profile/update',          [ClientController::class, 'update_profile'])->name('client.updateProfile');
            // Route::post('/profile/updatePassword',  [ClientController::class, 'updatePassword'])->name('client.updatePassword');
            // Route::post('/password/upadte',         [ClientController::class, 'update_password'])->name('client.update_password');

            // Route::get('/requests',                    [ClientRequestController::class, 'index'])->name('client.requests');

            Route::get('/wallet',           		[ClientController::class, 'wallet'])->name('wallet'); //Take me to Supplier Dashboard

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
        Route::get('/',                                 [TechnicianProfileController::class, 'index'])->name('index');    //Take me to Technician Dashboard            
        Route::get('/location-request',                 [TechnicianProfileController::class, 'locationRequest'])->name('location_request'); 
        Route::get('/payments',                         [TechnicianProfileController::class, 'payments'])->name('payments');                
        Route::get('/requests',                         [TechnicianProfileController::class, 'serviceRequests'])->name('requests');                
        Route::get('/requests/details',                 [TechnicianProfileController::class, 'serviceRequestDetails'])->name('request_details');     

        Route::get('/profile/',                         [TechnicianProfileController::class, 'viewProfile'])->name('view_profile');
        Route::get('/profile/edit',                     [TechnicianProfileController::class, 'editProfile'])->name('edit_profile');
        Route::view('/messages/inbox',                  'technician.messages.inbox')->name('messages.inbox');
        Route::view('/messages/sent',                   'technician.messages.outbox')->name('messages.outbox');
    });
});

Route::prefix('/qa')->group(function () {
    Route::name('qa.')->group(function () {
        //All routes regarding quality_assurance should be in here
        Route::view('/', 'qa.index')->name('index'); //Take me to quality_assurance Dashboard

        Route::get('/profile',    [App\Http\Controllers\QualityAssurance\QualityAssuranceProfileController::class,'view_profile'])->name('view_profile');
        Route::get('/profile/edit_profile', [App\Http\Controllers\QualityAssurance\QualityAssuranceProfileController::class,'edit'])->name('edit_profile');
        Route::patch('/profile/update_profile', [App\Http\Controllers\QualityAssurance\QualityAssuranceProfileController::class,'update'])->name('update_profile');
        Route::patch('/update_password', [App\Http\Controllers\QualityAssurance\QualityAssuranceProfileController::class,'update_password'])->name('update_password');
        Route::view('/requests', 'qa.requests')->name('requests');
        Route::get('/payments', [PaymentController::class, 'get_qa_disbursed_payments'])->name('payments');
        Route::view('/messages/inbox', 'qa.messages.inbox')->name('messages.inbox');
        Route::view('/messages/sent', 'qa.messages.sent')->name('messages.sent');
    });
});
