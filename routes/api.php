<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\BusController;
use App\Http\Controllers\ApiController\AuthController;
use App\Http\Controllers\ApiController\PathController;
use App\Http\Controllers\ApiController\TripController;
use App\Http\Controllers\ApiController\UserController;
use App\Http\Controllers\ApiController\DriverController;
use App\Http\Controllers\ApiController\StationController;
use App\Http\Controllers\ApiController\StudentController;
use App\Http\Controllers\ApiController\SupervisorController;

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

});
