<?php

namespace App\Services\ApiServices;

use Carbon\Carbon;
use App\Models\Trip;
use App\Models\StudentTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\AllStudentsByTripTrait;

class TripService
{
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait, AllStudentsByTripTrait;

    /**
     * method to view all Trips
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function get_all_Trips()
    {
        try {
            $user = Auth::user();

            if ($user->role == 'supervisor') {
                $Trips = $user->trips()->orderBy('start_date', 'asc')->get();
            }

            return $Trips;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->failed_Response('Something went wrong with fetche Trips', 400);
        }
    }
    //========================================================================================================================

    /**
     * method to show Trip alraedy exist
     * @param  $Trip_id
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function view_Trip($Trip_id)
    {
        try {
            $Trip = Trip::find($Trip_id);
            if (!$Trip) {
                throw new \Exception('Trip not found');
            }

            $Trip->load('students', 'users', 'drivers', 'path.stations');

            return $Trip;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->failed_Response($e->getMessage(), 404);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->failed_Response('Something went wrong with show Trip', 400);
        }
    }
    //========================================================================================================================

    /**
     * method to show next Trip
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function next_trip()
    {
        try {
            $user = Auth::user();
            $currentTime = Carbon::now()->format('H:i:s');

            if ($user->role == 'supervisor') {
                $Trip = $user->trips()
                    ->where('status', 0)
                    ->where('end_date', '>', $currentTime)
                    ->orderBy('end_date', 'asc')
                    ->first();

                if (!$Trip) {
                    $Trip = $user->trips()
                        ->orderBy('start_date', 'asc')
                        ->first();
                }
            } else {
                $studentsTrips = $user->students->flatMap(function ($student) {
                    return $student->trips;
                });

                $Trip = $studentsTrips
                    ->where('status', 0)
                    ->where('end_date', '>', $currentTime)
                    ->sortBy('end_date')
                    ->first();

                if (!$Trip) {
                    $Trip = $studentsTrips
                        ->sortBy('start_date')
                        ->first();
                }
            }
            return $Trip;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->failed_Response($th->getMessage(), 400);
        }
    }
    //========================================================================================================================
    public function update_trip_status($trip_id)
    {
        try {
            $Trip = Trip::find($trip_id);
            $user = Auth::user();

            if (!$Trip) {
                throw new \Exception('الرحلة غير موجودة');
            }

            if ($user->role == 'supervisor') {
                $Trip = $user->trips()->find($trip_id);

                if(!$Trip){
                    throw new \Exception('لا يمكنك التعديل على حالة رحلة غير مخصصة لك');
                }
            }

            $Trip->status = $Trip->status == 1 ? 0 : 1;

            if ($Trip->status == 0) {
                // تحديث حالة الطلاب المرتبطين بالرحلة
                $students = $Trip->students()->wherePivotIn('status', ['absent', 'Moved_to'])->get();
                foreach ($students as $student) {
                    $Trip->students()->updateExistingPivot($student->id, ['status' => 'attendee']);
                }

                // حذف الطلاب المرتبطين بالرحلة مع حالة نقل
                $Trip->students()->wherePivot('status', 'Transferred_from')->detach();

                // تحديث حالة المحطات إلى 0
                $Trip->path->stations()->update(['status' => 0]);
                $Trip->save();
                (new NotificationService())->tripNotification($Trip);

                return ['trip' => $Trip, 'message' => 'تمت عملية إنهاء الرحلة بنجاح'];
            } else {
                // منع المشرفة من بدء أكثر من رحلة في نفس الوقت
                if ($user->trips()->exists()) {
                    $activeTrip = $user->trips()->where('status', 1)->where('trips.id', '!=', $trip_id)->first();
                    if ($activeTrip) {
                        throw new \Exception('لا يمكنك بدء هذه الرحلة لأن هناك رحلة أخرى لا تزال قيد التنفيذ.');
                    }
                }

                $Trip->save();
                (new NotificationService())->tripNotification($Trip);
                return ['trip' => $Trip, 'message' => 'تمت عملية بدأ الرحلة بنجاح'];
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->failed_Response($e->getMessage(), 404);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->failed_Response('Something went wrong with update status Trip', 400);
        }
    }

    //========================================================================================================================
    public function all_student_trip($trip_id)
    {
        try {
            $trip = Trip::findOrFail($trip_id);
            $trip->load(['students' => function ($query) {
                $query->orderBy('student_trip.time_arrive', 'asc');
            }]);

            return $trip;

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->failed_Response('Something went wrong with get all students', 400);
        }
    }

    //========================================================================================================================
    public function all_student_Back_trip($trip_id)
    {
        try {
            $trip = Trip::with(['students' => function ($query) {
                $query->wherePivotIn('status', ['attendee', 'Transferred_from']);
            }])->findOrFail($trip_id);
            return $trip;

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->failed_Response('Something went wrong with get all students', 400);
        }
    }
    //========================================================================================================================
    /**
     * method to show Trip alraedy exist
     * @param  $Trip_id
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function details_Trip($Trip_id) {
        try {
            $Trip = Trip::find($Trip_id);
            $Trip->load('students','users','drivers','path.stations');

            return $Trip;
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with show Trip', 400);}
    }
    //========================================================================================================================
    public function update_student_status($request,$student_id,$trip_id)
    {
        try {
            $student = StudentTrip::where('student_id',$student_id)->where('trip_id',$trip_id)->first();

            $user = Auth::user();
            $trip = Trip::where('id',$student->trip_id)->first();

            if($user->role == 'parent' && $trip->status == 1 ){
                throw new \Exception( 'لا يمكنك تعديل حالة الطالب في حال كانت الرحلة حاليا جارية');
            }

            $student->update(['status' => $request['status']]);

            return $trip;
        } catch (\Exception $e) { Log::error($e->getMessage()); return $this->failed_Response($e->getMessage(), 404);
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with update student status', 400);}
    }
    //========================================================================================================================
    public function trip_filter(Request $request){
        try {
            $Trips = Trip::filter($request)->orderBy('start_date', 'asc')->get();
            $Trips->load('users','drivers');
            return $Trips;
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with fetche Trips', 400);}
    }
    //========================================================================================================================
}
