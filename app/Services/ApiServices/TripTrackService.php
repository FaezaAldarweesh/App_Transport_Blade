<?php

namespace App\Services\ApiServices;

use App\Http\Traits\ApiResponseTrait;
use App\Models\Student;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TripTrackService
{
    use ApiResponseTrait;

    /**
     * Fetch TripTrack records for a specific trip and date.
     * @param Trip $trip - The Trip model instance for which the tracks are to be fetched.
     * @param string|null $date - The specific date for filtering TripTrack records (defaults to the current date if null).
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse - A collection of TripTrack records for the given trip and date.
     */
    public function showTracksForTrip(Trip $trip, $date)
    {
        try {
            $date = $date ?? Carbon::now()->format('Y-m-d');
            $tripTracks = $trip->tripTrack()->whereDate('created_at', $date)->get();
            return $tripTracks;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->failed_Response($th->getMessage(), 400);
        }

    }

    /**
     * Fetch TripTrack records for parents.
     * @param $student_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\Collection
     */

    public function trackForParent($student_id)
    {
        try {
            $student = Student::find($student_id);
            $trip = $student->trips->where('status', 1)->first();
            if (!$trip) {
                throw new \Exception('لا يوجد رحلة جارية للطالب حالياً');
            }
            $tripTrack = $trip->tripTrack()->whereDate('created_at', Carbon::now()->format('Y-m-d'))->latest()->first();
            return $tripTrack ?? null;

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->failed_Response($th->getMessage(), 400);
        }

    }
}
