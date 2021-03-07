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
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentServices\Paystack;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
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


        Route::get('/estate/list',      [\App\Http\Controllers\EstateController::class, 'index'])->name('list_estate');
        Route::get('/estate/add',      [\App\Http\Controllers\EstateController::class, 'create'])->name('add_estate');
        Route::post('/estate/add',      [\App\Http\Controllers\EstateController::class, 'store'])->name('store_estate');
        Route::get('/estate/summary/{estate:uuid}',      [\App\Http\Controllers\EstateController::class, 'estateSummary'])->name('estate_summary');
        Route::get('/estate/edit/{estate:uuid}',      [\App\Http\Controllers\EstateController::class, 'edit'])->name('edit_estate');
        Route::patch('/estate/edit/{estate:uuid}',      [\App\Http\Controllers\EstateController::class, 'update'])->name('update_estate');
        Route::get('/estate/reinstate/{estate:uuid}',      [\App\Http\Controllers\EstateController::class, 'reinstate'])->name('reinstate_estate');
        Route::get('/estate/deactivate/{estate:uuid}',      [\App\Http\Controllers\EstateController::class, 'deactivate'])->name('deactivate_estate');
        Route::get('/estate/delete/{estate:uuid}',      [\App\Http\Controllers\EstateController::class, 'delete'])->name('delete_estate');
       
        //Routes for E-Wallet Related Services
        Route::get('/client/transaction', 	[\App\Http\Controllers\TransactionController::class, 'adminUserTransaction'])->name('wallet_transaction');
        
        Route::get('/client/approval/{transaction:id}', 	[\App\Http\Controllers\TransactionController::class, 'transactionApproval'])->name('approve_transaction');
        Route::get('/client/pending/{transaction:id}', 	[\App\Http\Controllers\TransactionController::class, 'transactionPending'])->name('pending_transaction');
        Route::get('/client/delete/{transaction:id}',      [\App\Http\Controllers\TransactionController::class, 'deleteTransaction'])->name('delete_transaction');
        Route::get('/client/wallet_transaction', 	[\App\Http\Controllers\TransactionController::class, 'userTransaction'])->name('user_wallet_transaction');
        Route::get('/client/all_wallet_payments', 	[\App\Http\Controllers\TransactionController::class, 'allUserEwalletPayment'])->name('all_user_wallet_payment');
        Route::get('/client/transaction_summary/{transaction:id}',      [\App\Http\Controllers\TransactionController::class, 'adminTransactionSummary'])->name('summary');
        Route::get('/client/ewallet_refund', 	[\App\Http\Controllers\WalletController::class, 'walletServiceRequestRefund'])->name('wallet_refund');
        Route::post('/client/ewallet_refund_summary/{transaction:id}', 	[\App\Http\Controllers\WalletController::class, 'walletServiceRequestRefundSummary'])->name('wallet_refund_summary');
        Route::get('/client/refund_approval/{transaction:id}', 	[\App\Http\Controllers\WalletController::class, 'approveRefund'])->name('approve_refund');

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
         

    });
});

Route::prefix('/client')->group(function () {
    Route::name('client.')->group(function () {
        Route::view('/',           		'client.index')->name('index'); //Take me to Admin Dashboard(To be replaced by the client index view)
        Route::get('/client/wallet', 	[\App\Http\Controllers\TransactionController::class, 'eWallet'])->name('fund_wallet');
        Route::get('/client/wallet_transactions', 	[\App\Http\Controllers\TransactionController::class, 'userTransaction'])->name('user_wallet_transaction');
        Route::post('/client/initiate_transactions', 	[\App\Http\Controllers\TransactionController::class, 'initiateTransaction'])->name('initiate_wallet_transaction');
        Route::get('/client/reQuery', 	[\App\Http\Controllers\PaymentService\Paystack::class, 'reQuery'])->name('verify_transaction');
        Route::get('/client/wallet_payments', 	[\App\Http\Controllers\TransactionController::class, 'userEwalletPayment'])->name('user_wallet_payment');
        Route::get('/client/service_summary/{transaction:id}',      [\App\Http\Controllers\TransactionController::class, 'eWalletServiceRequestSummary'])->name('summary');
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

