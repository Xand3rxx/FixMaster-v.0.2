<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| This routes contain the following middleware
| 1. web -> Laravels web group middlewares
| 2. setlocale -> Middleware to set user language using $request->segment(1)
|                 if $request->segment(1) is not in config('app.available_locales')
|                  default of config('app.locale') is used.
|
*/

Auth::routes([
    'login'    => true,
    'logout'   => true,
    'reset'    => false,   // for resetting passwords
    'confirm'  => false,  // for additional password confirmations
    'verify'   => false,  // for email verification
]);

Route::view('/', 'frontend.index')->name('frontend.index');

Route::view('/about',                         'frontend.about')->name('frontend.about');
Route::view('/how-it-works',                 'frontend.how_it_works')->name('frontend.how_it_works');
Route::view('/why-home-fix',                 'frontend.why_home_fix')->name('frontend.why_home_fix');
Route::get('/join-us',                     [App\Http\Controllers\PageController::class, 'index'])->name('frontend.careers');
Route::post('/estate/add',      [\App\Http\Controllers\EstateController::class, 'store'])->name('frontend.store_estate');
Route::view('/faq',                         'frontend.faq')->name('frontend.faq');
Route::view('/register',                         'auth.register')->name('frontend.register');
Route::view('/messaging',           		'frontend.template')->name('template');



// Route::view('/service-details', 			'frontend.service_details')->name('frontend.services_details');
Route::get('/services',                     [App\Http\Controllers\PageController::class, 'services'])->name('frontend.services');
Route::get('/services/details/{url}',       [App\Http\Controllers\PageController::class, 'serviceDetails'])->name('frontend.services_details');
Route::post('/services/search',              [App\Http\Controllers\PageController::class, 'searchCategories'])->name('frontend.services_search');
Route::get('/contact-us',                   [App\Http\Controllers\PageController::class, 'contactUs'])->name('frontend.contact');
Route::post('/contact-us',                  [App\Http\Controllers\PageController::class, 'sendContactMail'])->name('frontend.send_contact_mail');

// //Essential Routes
// Route::post('/lga-list',                    [App\Http\Controllers\EssentialsController::class, 'lgasList'])->name('lga_list');
// Route::post('/avalaible-tool-quantity',     [App\Http\Controllers\EssentialsController::class, 'getAvailableToolQuantity'])->name('available_quantity');
// Route::get('/administrators-list',          [App\Http\Controllers\EssentialsController::class, 'getAdministratorsList'])->name('administrators_list');
// Route::get('/clients-list',                 [App\Http\Controllers\EssentialsController::class, 'getClientsList'])->name('clients_list');
// Route::get('/technicians-list',             [App\Http\Controllers\EssentialsController::class, 'getTechniciansList'])->name('technicians_list');
// Route::get('/cses-list',                    [App\Http\Controllers\EssentialsController::class, 'getCsesList'])->name('cses_list');
// Route::get('/ongoing-service-requests',     [App\Http\Controllers\EssentialsController::class, 'getOngoingServiceRequests'])->name('ongoing_service_request_list');
// Route::get('/ongoing-service-request/{id}', [App\Http\Controllers\EssentialsController::class, 'getOngoingServiceRequestDetail'])->name('ongoing_service_request_detail');

// Route::get('/tools-request/details/{id}',           [App\Http\Controllers\ToolsRequestController::class, 'toolRequestDetails'])->name('tool_request_details');
// Route::get('/rfq/details/{id}',                     [App\Http\Controllers\RFQController::class, 'rfqDetails'])->name('rfq_details');