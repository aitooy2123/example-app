<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DistrictController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RegisterController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/province', [DistrictController::class, 'provinces']);
Route::get('/province/{province_code}/amphoe', [DistrictController::class, 'amphoes']);
Route::get('/province/{province_code}/amphoe/{amphoe_code}/district', [DistrictController::class, 'districts']);
Route::get('/province/{province_code}/amphoe/{amphoe_code}/district/{district_code}', [DistrictController::class, 'detail']);

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::resource('products', ProductController::class);
});
