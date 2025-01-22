<?php

namespace App\Services\ApiServices;

use App\Models\Trip;
use Carbon\Carbon;

class TripTrackService
{

    /**
     * Fetch TripTrack records for a specific trip and date.
     * @param Trip $trip - The Trip model instance for which the tracks are to be fetched.
     * @param string|null $date - The specific date for filtering TripTrack records (defaults to the current date if null).
     * @return \Illuminate\Database\Eloquent\Collection - A collection of TripTrack records for the given trip and date.
     */
    public function showTracksForTrip(Trip $trip, $date)
    {
        $date = $date ?? Carbon::now()->format('Y-m-d');
        $tripTracks = $trip->tripTrack()->whereDate('created_at', $date)->get();
        return $tripTracks;
    }
}
