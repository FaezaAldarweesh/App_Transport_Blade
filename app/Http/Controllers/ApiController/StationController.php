<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\StationResources;
use App\Http\Resources\viewTripResources;
use App\Http\Resources\StationTripResources;
use App\Services\ApiServices\StationService;
use App\Http\Controllers\ApiController\Controller;
use App\Http\Requests\Station_Request\Store_Station_Request;
use App\Http\Requests\Station_Request\Update_Station_Request;

class StationController extends Controller
{
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait;
    protected $stationservices;
    /**
     * construct to inject Station Services 
     * @param StationService $stationservices
     */
    public function __construct(StationService $stationservices)
    {
        $this->stationservices = $stationservices;
    }
    //===========================================================================================================================
    /**
     * method to view all Stations 
     * @return /Illuminate\Http\JsonResponse
     * StationResources to customize the return responses.
     */
    public function all_station_trip($trip_id)
    {  
        $trip = $this->stationservices->all_station_trip($trip_id);
        return $this->success_Response(new StationTripResources($trip), "تمت عملية الوصول للمحطات بنجاح", 200);
    }
    //===========================================================================================================================
    /**
     * method to update on station status
     * @param   $station_id
     */
    public function update_station_status($station_id)
    {
        $station = $this->stationservices->update_station_status($station_id);
        // In case error messages are returned from the services section 
        if ($station instanceof \Illuminate\Http\JsonResponse) {
           return $station;
       }
        return $this->success_Response(new StationResources($station), "تمت عملية الوصول للمحطات بنجاح", 200);
    }
}
