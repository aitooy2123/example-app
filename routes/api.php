<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DistrictController;

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

Route::get('/province',[DistrictController::class,'provinces']);
Route::get('/province/{province_code}/amphoe',[DistrictController::class,'amphoes']);
Route::get('/province/{province_code}/amphoe/{amphoe_code}/district',[DistrictController::class,'districts']);
Route::get('/province/{province_code}/amphoe/{amphoe_code}/district/{district_code}',[DistrictController::class,'detail']);

// Route::get('/province','API\DistrictController@provinces');
// Route::get('/province/{province_code}/amphoe','API\DistrictController@amphoes');
// Route::get('/province/{province_code}/amphoe/{amphoe_code}/district','API\DistrictController@districts');
// Route::get('/province/{province_code}/amphoe/{amphoe_code}/district/{district_code}','API\DistrictController@detail');