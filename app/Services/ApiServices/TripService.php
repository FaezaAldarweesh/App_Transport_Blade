<?php

namespace App\Services\ApiServices;

use App\Models\Bus;
use App\Models\Trip;
use App\Models\Driver;
use App\Models\BusTrip;
use App\Models\Student;
use App\Models\DriverTrip;
use App\Models\Supervisor;
use App\Models\StudentTrip;
use App\Models\SupervisorTrip;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\AllStudentsByTripTrait;
use Illuminate\Support\Facades\Auth;


class TripService {
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait,AllStudentsByTripTrait;
    /**
     * method to view all Trips 
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function get_all_Trips(){
        try {
            $user = Auth::user();

            if($user->role == 'supervisor'){
                $Trips = $user->trips()->get();
            }else{
                $Trips = Trip::all();
            }
            return $Trips;
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with fetche Trips', 400);}
    }
    //========================================================================================================================
    /**
     * method to show Trip alraedy exist
     * @param  $Trip_id
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function view_Trip($Trip_id) {
        try {    
            $Trip = Trip::find($Trip_id);
            if(!$Trip){
                throw new \Exception('Trip not found');
            }

            $Trip->load('students','users','drivers');

            return $Trip;
        } catch (\Exception $e) { Log::error($e->getMessage()); return $this->failed_Response($e->getMessage(), 404);
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with update Trip', 400);}
    }
    //========================================================================================================================
}
