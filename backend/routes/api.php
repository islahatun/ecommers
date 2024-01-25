<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\Api\BannersController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\expedisionController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\api\testMailController;
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
    Route::resource('categories',CategoriesController::class);
    Route::get('getDataCategories',[CategoriesController::class,'getData']);
});

Route::group(['as' => 'expedisis', 'prefix' => 'expedisis'], function () {
    Route::resource('expedisis',expedisionController::class);
    Route::get('getDataExpedisi',[expedisionController::class,'getData']);
});

Route::group(['as' => 'banners', 'prefix' => 'banners'], function () {
    Route::resource('banners',BannersController::class);
    Route::get('getDataBanners',[BannersController::class,'getData']);
});
