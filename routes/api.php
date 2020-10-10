<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// ,'ipcheck'//,'auth:api'
Route::middleware('ipcheck','auth:api')->match(['post','get'],'/send-sms', 'MessageController@sendMessageViaSMS')->name('send-sms');
Route::middleware('ipcheck','auth:api')->match(['post','get'],'/get-status', 'MessageController@getMessageStatus')->name('get-status');
Route::middleware('ip_check_for_update_status')->match(['get'],'/update-status', 'MessageController@updateMessageStatuses');
