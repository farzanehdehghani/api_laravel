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

Route::middleware('ipcheck','auth:api')->match(['post','get'],'/get-running-processes', [App\Http\Controllers\ApiController::class, 'getRunningProcessesList'])->name('getRunningProcessesList');
Route::middleware('ipcheck','auth:api')->match(['post','get'],'/make-directory', [App\Http\Controllers\ApiController::class, 'createDirectory'])->name('createDirectory');
Route::middleware('ipcheck','auth:api')->match(['post','get'],'/create-file', [App\Http\Controllers\ApiController::class, 'createFile'])->name('createFile');
Route::middleware('ipcheck','auth:api')->match(['post','get'],'/get-directory-list', [App\Http\Controllers\ApiController::class, 'getDirectoryList'])->name('getDirectoryList');

