<?php

namespace App\Http\Controllers\ApiController;

use App\Services\ApiServices\TripService;
use App\Http\Controllers\ApiController\Controller;
use App\Http\Resources\TripResources;
use App\Http\Traits\ApiResponseTrait;

class TripController extends Controller
{
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait;
    protected $Tripservices;
    /**
     * construct to inject Trip Services 
     * @param TripService $Tripservices
     */
    public function __construct(TripService $Tripservices)
    {
        $this->Tripservices = $Tripservices;
    }
    //===========================================================================================================================
    /**
     * method to view all Trips
     * @return /Illuminate\Http\JsonResponse
     * UserResources to customize the return responses.
     */
    public function index()
    {  
        $Trips = $this->Tripservices->get_all_Trips();
        return $this->success_Response(TripResources::collection($Trips), "تمت عملية الوصول للرحلات بنجاح", 200);
    }
    //===========================================================================================================================
    /**
     * method to show Trip alraedy exist
     * @param  $Trip_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function show($Trip_id)
    {
        $Trip = $this->Tripservices->view_Trip($Trip_id);

        // In case error messages are returned from the services section 
        if ($Trip instanceof \Illuminate\Http\JsonResponse) {
            return $Trip;
        }
            return $this->success_Response(new TripResources($Trip), "تمت عملية عرض الرحلة بنجاح", 200);
    }
    //===========================================================================================================================
    /**
     * method to show next Trip
     * @return /Illuminate\Http\JsonResponse
     */
    public function next_trip()
    {
        $Trip = $this->Tripservices->next_trip();
        return $this->success_Response(new TripResources($Trip), "تمت عملية عرض الرحلة التالية بنجاح", 200);
    }
    //===========================================================================================================================
}
