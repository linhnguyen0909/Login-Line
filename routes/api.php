<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\UploadImgController;
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

Route::get('/redirect', [LoginController::class,'redirect']);
Route::get('/callback', [LoginController::class,'callback']);

Route::get('/redirecting', [LoginGoogleController::class,'redirecting']);
Route::get('/callbackgoogle', [LoginGoogleController::class,'callback']);

Route::post('/upload',[UploadImgController::class,'uploadImage']);
