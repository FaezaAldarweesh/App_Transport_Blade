<?php

namespace App\Services\ApiServices;

use App\Models\Trip;
use App\Models\User;
use App\Models\Student;
use App\Models\Transport;
use App\Models\StudentTrip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;

class StudentService {
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait;
    public function all_student_trips($student_id)
    {
        try
        {
            $tripIds = StudentTrip::where('student_id', $student_id)->pluck('trip_id');
            $trips = Trip::whereIn('id', $tripIds)->orderBy('start_date', 'asc')->get();
            return $trips;
        }
        catch(\Exception $e)
        {
            Log::error('Error show student information'.$e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
    //===========================================================================================================================
    public function update_student_status_transport($data)
    {
        try {
    
            $trip_id = $data['trip_id'];
            $station_id = $data['station_id'];
            $students = $data['students'];
    
            $trip = Trip::findOrFail($trip_id);
            $user = Auth::user();
    
            // التحقق من حالة الرحلة للمستخدم الأب
            if ($user->role === 'parent' && $trip->status === 1) {
                throw new \Exception( 'لا يمكنك نقل الطالب إذا كانت الرحلة جارية.', 403);
            }
    
            // التحقق من عدد المقاعد المتاحة في الحافلة
            if (count($trip->students) + count($students) > $trip->bus->number_of_seats) {
                throw new \Exception( 'لا يوجد مكان فارغ ضمن هذه الرحلة', 400);
            }
    
            foreach ($students as $student_id) {
                $transport = new Transport();
                $transport->trip_id = $trip_id;
                $transport->student_id = $student_id;
                $transport->station_id = $station_id;
                $transport->save();
            }

            $studen_id = Student::whereIn('id',$data['students'])->pluck('id');
            $AllTransports = Transport::whereIn('student_id',$studen_id)->get();
            $AllTransports->load('student');
            return $AllTransports;
        } catch (\Exception $e) { Log::error($e->getMessage()); return $this->failed_Response($e->getMessage(), 404);
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with make transport', 400);}
    }  
    
    //===========================================================================================================================
}
