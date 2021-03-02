<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Messaging\Template;
use App\Http\Controllers\Messaging\Message;
use App\Models\MessageTemplate;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('template/features', function() {
   $template = new Template();
   return $template->getMessageModules();

});

Route::get('template/list', function() {
  $template = new Template();
   return $template->getAllTemplates();

});

Route::get('template/{id}', function($id) {
  $template = new Template();
   return $template->getTemplate($id);

});

Route::post('template/save', function(Request $request) {
   $template = new Template();
   return $template->saveMessageTemplate($request);

});

Route::post('template/update', function(Request $request) {
   $template = new Template();
   return $template->updateMessageTemplate($request);

});

Route::delete('template/delete/{id}', function($id) {
   $template = new Template();
   return $template->deleteMessageTemplate($id);

});

Route::post('message/send', function(Request $request) {
   $message = new Message();
   return $message->sendEmail($request);

});




//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::get('/',      [\App\Http\Controllers\EstateController::class, 'showEstates'])->name('list_estate');


