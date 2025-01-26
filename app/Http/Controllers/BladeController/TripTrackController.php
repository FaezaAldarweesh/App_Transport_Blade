<?php

namespace App\Http\Controllers\BladeController;

use App\Http\Controllers\Controller;
use App\Http\Requests\TripTrack_Request\showRequest;
use App\Http\Resources\TripTrackResource;
use App\Models\Trip;
use App\Models\TripTrack;
use App\Services\ApiServices\TripTrackService;
use Illuminate\Http\Request;

class TripTrackController extends Controller
{

    protected $tripTrackService;

    /**
     * Inject TripTrackService dependency and apply middleware for role-based access control.
     * @param TripTrackService $tripTrackService
     */
    public function __construct(TripTrackService $tripTrackService)
    {
        $this->tripTrackService = $tripTrackService;
    }

    public function showMap($trip){
        return view('map',['trip'=>$trip]);
    }

    public function show(showRequest $request, Trip $trip)
    {
        $result = $this->tripTrackService->showTracksForTrip($trip, $request->trip_date);
        return view('trips.track',['trip'=>$result]);        
    }
}
