<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\Api\BanksController;
use App\Http\Controllers\Api\BannersController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\expedisionController;
use App\Http\Controllers\Api\PackagesController;
use App\Http\Controllers\Api\ProdutsController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\api\testMailController;
use App\Http\Controllers\Api\transactiosController;
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
    Route::get('getDataImages',[BannersController::class,'getDataImages']);
});

Route::group(['as' => 'comments', 'prefix' => 'comments'], function () {
    Route::resource('comments',CommentsController::class);
    Route::get('getDataComments/{user_id}',[CommentsController::class,'getData']);
});

Route::group(['as' => 'packages', 'prefix' => 'packages'], function () {
    Route::resource('packages',PackagesController::class);
    Route::get('getDataPackages',[PackagesController::class,'getData']);
});

Route::group(['as' => 'products', 'prefix' => 'products'], function () {
    Route::resource('products',ProdutsController::class);
    Route::get('getDataProducts',[ProdutsController::class,'getData']);
    Route::get('getDataById',[ProdutsController::class,'getDataById']);
    Route::post('addStock',[ProdutsController::class,'createStock']);
    Route::post('updateStock/{id}',[ProdutsController::class,'updateStock']);
    Route::post('deleteStock/{id}/{id_product}',[ProdutsController::class,'deleteStock']);
});

Route::group(['as' => 'Banks', 'prefix' => 'Banks'], function () {
    Route::resource('Banks',BanksController::class);
    Route::get('getDataBanks',[BanksController::class,'getData']);
});

Route::group(['as' => 'transaction', 'prefix' => 'transaction'], function () {
    Route::post('transactionProduct',[transactiosController::class,'transactionProduct']);
    Route::get('getDataTransactionProduct}',[transactiosController::class,'getDataTransactionAdmin']);
    Route::get('getDataTransactionProduct/{user_id}',[transactiosController::class,'getDataTransactionUser']);
});
