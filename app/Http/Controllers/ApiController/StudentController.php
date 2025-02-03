<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\AllTripResources;
use App\Http\Resources\TransportResources;
use App\Models\Student;
use App\Services\ApiServices\NotificationService;
use App\Services\ApiServices\StudentService;
use App\Http\Controllers\ApiController\Controller;
use App\Http\Requests\Transport_Request;


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
        return $this->success_Response(AllTripResources::collection($student_trip), "تمت عملية جلب كل رحل الطالب
         بنجاح", 200);
    }

    //===========================================================================================================================

    public function update_student_status_transport(Transport_Request $request)
    {
        $AllTransports = $this->studentservices->update_student_status_transport($request->validated());
        // In case error messages are returned from the services section
        if ($AllTransports instanceof \Illuminate\Http\JsonResponse) {
        return $AllTransports;
        }
        return $this->success_Response( null, ".تمت عملية تسجيل طلب نقل الطالب بنجاح يرجى ,الانتظار حتى يتم الموافقة عليه من قبل المدير", 200);
    }




    /**
     * Send notification when student gets off the bus
     *
     * @param Student $student
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function studentGotOff(Student $student)
    {
        $message = "نزل " . $student->name . " من الحافلة ";
        (new NotificationService())->studentNotification($student, $message);
        return $this->success_Response(null, 'تمت العملية بنجاح', 200);
    }

}
