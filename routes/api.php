<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\AuthController;
use App\Http\Controllers\ApiController\TripController;
use App\Http\Controllers\ApiController\CheckoutController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
});

Route::group(['middleware' => ['auth:api']], function () {
    // protected routes go here
    Route::post('logout',[AuthController::class ,'logout']); 
    Route::post('refresh', [AuthController::class ,'refresh']);
    
    Route::apiResource('trip',TripController::class); 
    Route::get('next_trip', [TripController::class ,'next_trip']);
    Route::get('update_trip_status/{trip_id}/', [TripController::class, 'update_trip_status']);
    Route::get('all_student_trip/{trip_id}', [TripController::class, 'all_student_trip']);

    Route::post('checkout', [CheckoutController::class,'store']);

});
