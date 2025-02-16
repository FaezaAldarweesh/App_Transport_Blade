<?php

use App\Models\Trip;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\AuthController;
use App\Http\Controllers\ApiController\TripController;
use App\Http\Controllers\ApiController\UserController;
use App\Http\Controllers\ApiController\StationController;
use App\Http\Controllers\ApiController\StudentController;
use App\Http\Controllers\ApiController\CheckoutController;

use App\Http\Controllers\ApiController\TransportController;
use App\Http\Controllers\ApiController\TripTrackController;

use \App\Http\Controllers\ApiController\NotificationController;

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
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::apiResource('trip', TripController::class);
    Route::get('next_trip', [TripController::class, 'next_trip']);
    Route::get('update_trip_status/{trip_id}/', [TripController::class, 'update_trip_status']);
    Route::get('all_student_trip/{trip_id}', [TripController::class, 'all_student_trip']);
    Route::get('all_student_Back_trip/{trip_id}', [TripController::class, 'all_student_Back_trip']);

    Route::get('checkout/{trip_id}/{student_id}/{status}', [CheckoutController::class, 'store']);
    Route::get('view_checkout/{trip_id}', [CheckoutController::class, 'view']);

    Route::get('all_station_trip/{trip_id}', [StationController::class, 'all_station_trip']);
    Route::post('update_station_status/{station_id}', [StationController::class, 'update_station_status']);

    Route::get('view_info', [UserController::class, 'view_info']);
    Route::post('update_info', [UserController::class, 'update_info']);

    Route::post('trip-tracks', [TripTrackController::class, 'store']);
    Route::get('trip-tracks/{trip}', [TripTrackController::class, 'show']);
    Route::get('trip-tracks/for-parent/{student}',[TripTrackController::class,'trackForParent']);

    Route::get('all_children', [UserController::class, 'all_children']);
    Route::get('all_student_trips/{student_id}', [StudentController::class, 'all_student_trips']);
    Route::post('update_student_status_transport', [StudentController::class, 'update_student_status_transport']);

    Route::get('details_Trip/{trip_id}', [TripController::class, 'details_Trip']);
    Route::post('update_student_status/{student_id}/{trip_id}', [TripController::class, 'update_student_status']);
    Route::get('trip_filter', [TripController::class, 'trip_filter']);

    Route::get('all_transport', [TransportController::class, 'all_transport']);
    Route::delete('delete_transport/{transport_id}', [TransportController::class, 'delete_transport']);

    Route::get('student_station/{student_id}', [StationController::class, 'student_station']);

    Route::post('/student/{student}/got-off', [StudentController::class, 'studentGotOff'])->middleware('role:supervisor');
    Route::prefix('notifications')->group(function (){
        Route::get('/for-user',[NotificationController::class,'userNotification']);
        Route::get('/read/{notification_id}',[NotificationController::class,'readNotification']);
    });

});

Route::get('/test',function (){
//   $admin = \App\Models\User::find(1);
//   $admin->notify(new \App\Notifications\UserNotification('Hello Admin Rima'));
//
    $trip = Trip::find(3);
//    $users = $trip->students()
//        ->wherePivotIn('status', ['attendee', 'Transferred_from'])
//        ->with('user')
//        ->get()->pluck('user')->unique();
//    $users[] = User::role('Admin', 'web')->get();
//
    (new \App\Services\ApiServices\NotificationService())->tripNotification($trip);
   return "sndfhd";
});
