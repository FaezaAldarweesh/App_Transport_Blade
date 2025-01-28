<?php

namespace App\Http\Controllers\ApiController;

use App\Services\ApiServices\StudentService;
use App\Http\Controllers\ApiController\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\AllTripResources;
use Illuminate\Http\Request;

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
     public function store(Request $request,$student_id)
    {
        try {
            $user = User::filter($role)->get();

            $request->validate([
                'trip_id' => 'required|exists:trips,id',
            ]);
    
            $student = Student::findOrFail($student_id);
            $trip_id = $request->input('trip_id'); 
            $station_id = $request->input('station_id'); 
            $trip = Trip::findOrFail($trip_id);

            $user = Auth::user();

            if ($user->role === 'parent' && $trip->status === 1) {
                return redirect()->back()->withErrors(['error' => 'لا يمكنك نقل الطالب إذا كانت الرحلة جارية.']);
            }

            if (count($trip->students)+1 > $trip->bus->number_of_seats) {
                return redirect()->back()->withErrors(['error' => 'لا يوجد مكان فارغ ضمن هذه الرحلة']);
            }

            $transport = new Transport();
            $transport->trip_id = $trip_id;
            $transport->student_id = $student_id;
            $transport->station_id = $station_id;
            $transport->save(); 

            session()->flash('success', 'تمت عملية نقل الطالب بنجاح');
            return redirect()->back();
    
        } catch (\Exception $e) {
            Log::error('Error update status student: ' . $e->getMessage());
            return redirect()->back()->withErrors('فشلت عملية النقل: ' . $e->getMessage());
        }
    }
}
