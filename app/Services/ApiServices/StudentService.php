<?php

namespace App\Services\ApiServices;

use App\Models\Trip;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentTrip;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;

class StudentService {
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait;
    public function all_student_trips($student_id)
    {
        try
        {
            $tripIds = StudentTrip::where('student_id', $student_id)->pluck('trip_id');
            $trips = Trip::whereIn('id', $tripIds)->get();
            return $trips;
        }
        catch(\Exception $e)
        {
            Log::error('Error show student information'.$e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
    //===========================================================================================================================
}
