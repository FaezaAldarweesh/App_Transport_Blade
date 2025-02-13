<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Requests\TripTrack_Request\showRequest;
use App\Http\Requests\TripTrack_Request\StoreRequest;
use App\Http\Resources\TripTrackResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Student;
use App\Models\Trip;
use App\Models\TripTrack;
use App\Services\ApiServices\TripTrackService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TripTrackController extends Controller
{
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait;

    protected $tripTrackService;

    /**
     * Inject TripTrackService dependency and apply middleware for role-based access control.
     * @param TripTrackService $tripTrackService
     */
    public function __construct(TripTrackService $tripTrackService)
    {
        $this->tripTrackService = $tripTrackService;
        $this->middleware('role:supervisor')->only('store');
        $this->middleware('role:parent')->only('trackForParent');
    }


    /**
     * Store a newly created resource in storage.
     * This method is used to add a new TripTrack record.
     * @param StoreRequest $request - Validated request containing the necessary data to create a TripTrack.
     * @return JsonResponse - A success response indicating the record was added successfully.
     */

    public function store(StoreRequest $request)
    {
        TripTrack::create($request->validated());
        return $this->success_Response(null, 'تمت الإضافة بنجاح', 200);
    }


    /**
     * Display the specified resource.
     * This method retrieves TripTrack records for a given Trip on a specified date.
     * @param showRequest $request - Validated request containing the trip_date parameter.
     * @param Trip $trip - The Trip model instance for which the tracks are to be fetched.
     * @return JsonResponse - A success response containing the TripTrack records.
     */

    public function show(showRequest $request, Trip $trip)
    {
        $result = $this->tripTrackService->showTracksForTrip($trip, $request->trip_date);
        return $this->success_Response(TripTrackResource::collection($result), 'تمت العملية بنجاح', 200);
    }

    public function trackForParent($student_id){

        $tripTracks = $this->tripTrackService->trackForParent($student_id);
        return $this->success_Response(TripTrackResource::collection($tripTracks), 'تمت العملية بنجاح', 200);

    }
}
