<?php

use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BladeController\BusController;
use App\Http\Controllers\BladeController\PathController;
use App\Http\Controllers\BladeController\RoleController;
use App\Http\Controllers\BladeController\TripController;
use App\Http\Controllers\BladeController\UserController;
use App\Http\Controllers\BladeController\DriverController;
use App\Http\Controllers\BladeController\StationController;
use App\Http\Controllers\BladeController\StudentController;
use App\Http\Controllers\BladeController\CheckOutController;
use App\Http\Controllers\BladeController\EmployeeController;
use App\Http\Controllers\BladeController\TransportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/user', function () {
    return view('users.view');
});

Auth::routes(['register' => false]);


Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::resource('student',  StudentController::class);
    Route::get('all_trashed_student', [StudentController::class, 'all_trashed_student'])->name('all_trashed_student');
    Route::get('restore_student/{student_id}', [StudentController::class, 'restore'])->name('restore_student');
    Route::delete('forceDelete_student/{student_id}', [StudentController::class, 'forceDelete'])->name('forceDelete_student');
    
    Route::Resource('driver',DriverController::class); 
    Route::get('all_trashed_driver', [DriverController::class, 'all_trashed_driver'])->name('all_trashed_driver');
    Route::get('restore_driver/{driver_id}', [DriverController::class, 'restore'])->name('restore_driver');
    Route::delete('forceDelete_driver/{driver_id}', [DriverController::class, 'forceDelete'])->name('forceDelete_driver');
    
    Route::Resource('bus',BusController::class); 
    Route::get('all_trashed_bus', [BusController::class, 'all_trashed_bus'])->name('all_trashed_bus');
    Route::get('restore_bus/{bus_id}', [BusController::class, 'restore'])->name('restore_bus');
    Route::delete('forceDelete_bus/{bus_id}', [BusController::class, 'forceDelete'])->name('forceDelete_bus');
    
    Route::Resource('path',PathController::class); 
    Route::get('all_trashed_path', [PathController::class, 'all_trashed_path'])->name('all_trashed_path');
    Route::get('restore_path/{path_id}', [PathController::class, 'restore'])->name('restore_path');
    Route::delete('forceDelete_path/{path_id}', [PathController::class, 'forceDelete'])->name('forceDelete_path');
    
    Route::Resource('station',StationController::class); 
    Route::get('all_trashed_station', [StationController::class, 'all_trashed_station'])->name('all_trashed_station');
    Route::get('restore_station/{station_id}', [StationController::class, 'restore'])->name('restore_station');
    Route::delete('forceDelete_station/{station_id}', [StationController::class, 'forceDelete'])->name('forceDelete_station');
    Route::post('update_station_status/{station_id}',[StationController::class,'update_station_status'])->name('update_station_status');
    
    Route::Resource('trip',TripController::class); 
    Route::get('all_trashed_trip', [TripController::class, 'all_trashed_trip'])->name('all_trashed_trip');
    Route::get('restore_trip/{trip_id}', [TripController::class, 'restore'])->name('restore_trip');
    Route::delete('forceDelete_trip/{trip_id}', [TripController::class, 'forceDelete'])->name('forceDelete_trip');
    Route::post('update_trip_status/{trip_id}/', [TripController::class, 'update_trip_status'])->name('update_trip_status');
    Route::get('all_student_trip/{trip_id}', [TripController::class, 'all_student_trip'])->name('all_student_trip');
    Route::post('update_student_status/{student_id}/{trip_id}', [TripController::class, 'update_student_status'])->name('update_student_status');  
    Route::post('accept_student_transport/{transport_id}', [TripController::class, 'update_student_status_transport'])->name('accept_student_transport');  
    Route::put('update_student_time_arrive/{student_id}/{trip_id}', [TripController::class, 'update_student_time_arrive'])->name('update_student_time_arrive');    

    
    Route::resource('employee', EmployeeController::class); 
    Route::get('all_trashed_employee',[EmployeeController::class,'all_trashed_employee']) -> name("all_trashed_employee");
    Route::get('restor_employee/{employee_id}',[EmployeeController::class,'restore']) -> name("restore_employee");
    Route::delete('forceDelete/{employee_id}',[EmployeeController::class,'forceDelete']) -> name("forceDelete_employee");
    
    Route::resource('users', UserController::class);
    Route::get('all_trushed_user',[UserController::class,'all_trushed_user'])->name("all_trashed_user");
    Route::get('restore_user/{user_id}',[UserController::class,'restore'])->name('restore_user');
    Route::delete('forceDelete_user/{user_id}',[UserController::class,'forceDelete'])->name("forceDelete_user");

    Route::resource('checkout', CheckOutController::class);
    Route::get('show_checkout/{student_id}', [CheckOutController::class, 'show_checkout'])->name('show_checkout');

    Route::resource('roles', RoleController::class);



    Route::get('/get-trip-stations/{trip}', function ($tripId) {
        $trip = Trip::with('path.stations')->findOrFail($tripId); // تعديل العلاقة لتشمل stations
        $stations = $trip->path->stations; 
        return response()->json(['stations' => $stations]);
    });

   Route::post('update_student_status_transport/{student_id}', [TransportController::class, 'store'])->name('update_student_status_transport');  
   Route::get('transport', [TransportController::class, 'index'])->name('transport');  
   Route::delete('destroy_transport/{transport_id}', [TransportController::class, 'destroy'])->name('destroy_transport');  

});


