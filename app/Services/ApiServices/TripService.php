<?php

namespace App\Services\ApiServices;

use Carbon\Carbon;
use App\Models\Trip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\AllStudentsByTripTrait;


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

            $Trip->load('students','users','drivers','path.stations');

            return $Trip;
        } catch (\Exception $e) { Log::error($e->getMessage()); return $this->failed_Response($e->getMessage(), 404);
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with show Trip', 400);}
    }
    //========================================================================================================================
        /**
     * method to show next Trip 
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function next_trip()
    {
        try {
            $user = Auth::user();
            $currentTime = Carbon::now()->format('H:i:s');

            if ($user->role == 'supervisor') {
                $Trip = $user->trips()
                             ->where('start_date', '>', $currentTime) 
                             ->orderBy('start_date', 'asc')
                             ->first();
                             
                if (!$Trip) {
                    $Trip = $user->trips()
                                 ->orderBy('start_date', 'asc')
                                 ->first(); 
                }
            }

            return $Trip;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->failed_Response($th->getMessage(), 400);
        }
    }    
    //========================================================================================================================
}
