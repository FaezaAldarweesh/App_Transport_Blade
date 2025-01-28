<?php

namespace App\Http\Controllers\ApiController;

use App\Services\ApiServices\StudentService;
use App\Http\Controllers\ApiController\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\AllTripResources;

class StudentController extends Controller
{
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait;
    protected $studentservices;
    /**
     * construct to inject Student Services 
     * @param StudentService $studentservices
     */
    public function __construct(StudentService $studentservices)
    {
        $this->studentservices = $studentservices;
    }
    //===========================================================================================================================
    public function all_student_trips($student_id)
    {
        $student_trip = $this->studentservices->all_student_trips($student_id);
        return $this->success_Response( AllTripResources::collection($student_trip), "تمت عملية جلب كل رحل الطالب
         بنجاح", 200);
    }
    //===========================================================================================================================
}
