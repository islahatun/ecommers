<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\api\testMailController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\expedisiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use function PHPSTORM_META\expectedArguments;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', RegisterController::class);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');
Route::post('/testMail',[testMailController::class,'index'])->middleware('auth:sanctum');

Route::group(['as' => 'categories', 'prefix' => 'categories'], function () {
    Route::resource('categories',CategoryController::class);
    Route::get('getDataCategories',[CategoryController::class,'getData']);
});

Route::group(['as' => 'expedisis', 'prefix' => 'expedisis'], function () {
    Route::resource('expedisis',expedisiController::class);
    Route::get('getDataExpedisi',[expedisiController::class,'getData']);
});

Route::group(['as' => 'banners', 'prefix' => 'banners'], function () {
    Route::resource('banners',BannerController::class);
    Route::get('getDataBanners',[BannerController::class,'getData']);
});
