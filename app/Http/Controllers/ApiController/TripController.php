<?php

namespace App\Http\Controllers\ApiController;


use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;

use App\Http\Resources\AllTripResources;
use App\Http\Resources\detailsTripResources;
use App\Http\Resources\StudentTripResources;
use App\Http\Resources\viewTripResources;
use App\Services\ApiServices\TripService;


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
        return $this->success_Response(AllTripResources::collection($Trips), "تمت عملية الوصول للرحلات بنجاح", 200);
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
        return $this->success_Response(new viewTripResources($Trip), "تمت عملية عرض الرحلة بنجاح", 200);
    }
    //===========================================================================================================================

    /**
     * method to show next Trip
     * @return /Illuminate\Http\JsonResponse
     */
    public function next_trip()
    {
        $Trip = $this->Tripservices->next_trip();
        return $this->success_Response(new AllTripResources($Trip), "تمت عملية عرض الرحلة التالية بنجاح", 200);
    }
    //===========================================================================================================================

    /**
     * method to update on trip status
     * @param   $Trip_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function update_trip_status($trip_id)
    {
        $result = $this->Tripservices->update_trip_status($trip_id);
        // In case error messages are returned from the services section
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }
        return $this->success_Response(new AllTripResources($result['trip']), $result['message'], 200);
    }
    //========================================================================================================================

    /**
     * method to get all students that belong to Specify trip
     * @param   $Trip_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function all_student_trip($trip_id)
    {
        $trip = $this->Tripservices->all_student_trip($trip_id);
        return $this->success_Response(new StudentTripResources($trip), 'تمت عملية جلب طلاب الرحلة بنجاح', 200);
    }
    //========================================================================================================================

    /**
     * method to get all students that belong to Specify back trip
     * @param   $Trip_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function all_student_Back_trip($trip_id)
    {
        $trip = $this->Tripservices->all_student_Back_trip($trip_id);
        return $this->success_Response(new StudentTripResources($trip), 'تمت عملية جلب طلاب رحلة العودة بنجاح', 200);
    }
    //========================================================================================================================

    /**
     * method to show Trip alraedy exist
     * @param  $Trip_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function details_Trip($Trip_id)
    {
        //$Trip = $this->Tripservices->details_Trip($Trip_id);
        $Trip = Trip::find($Trip_id);
        $Trip->load('students', 'users', 'drivers', 'path.stations');

        return $this->success_Response(new detailsTripResources($Trip), "تمت عملية عرض الرحلة بنجاح", 200);
    }
    //===========================================================================================================================
    /**
     * method to update on trip status
     * @param   $Trip_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function update_student_status(Request $request,$student_id,$trip_id)
    {
        $trip = $this->Tripservices->update_student_status($request,$student_id,$trip_id);
        // In case error messages are returned from the services section
        if ($trip instanceof \Illuminate\Http\JsonResponse) {
            return $trip;
        }
        return $this->success_Response(new detailsTripResources($trip), 'تمت عملية تعديل حالة الطالب بنجاح', 200);
    }
    //===========================================================================================================================
    public function trip_filter(Request $request)
    {
        $Trips = $this->Tripservices->trip_filter($request);
        return $this->success_Response(viewTripResources::collection($Trips), "تمت عملية الوصول للرحلات بنجاح", 200);
    }
    //===========================================================================================================================
}
