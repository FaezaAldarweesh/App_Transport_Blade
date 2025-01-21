<?php

namespace App\Services\ApiServices;

use Carbon\Carbon;
use App\Models\Trip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\AllStudentsByTripTrait;


class TripService {
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait,AllStudentsByTripTrait;
    /**
     * method to view all Trips 
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function get_all_Trips(){
        try {
            $user = Auth::user();

            if($user->role == 'supervisor'){
                $Trips = $user->trips()->get();
            }

            return $Trips;
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with fetche Trips', 400);}
    }
    //========================================================================================================================
    /**
     * method to show Trip alraedy exist
     * @param  $Trip_id
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function view_Trip($Trip_id) {
        try {    
            $Trip = Trip::find($Trip_id);
            if(!$Trip){
                throw new \Exception('Trip not found');
            }

            $Trip->load('students','users','drivers','path.stations');

            return $Trip;
        } catch (\Exception $e) { Log::error($e->getMessage()); return $this->failed_Response($e->getMessage(), 404);
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with show Trip', 400);}
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
                             ->where('status',0)
                             ->where('end_date', '>', $currentTime) 
                             ->orderBy('end_date', 'asc')
                             ->first();
                             
                if (!$Trip) {
                    $Trip = $user->trips()
                                 ->orderBy('start_date', 'asc')
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
            
            
            if ($user->role == 'supervisor') {
                $Trip = $user->trips()->find($trip_id);
                             
                if(!$Trip){
                    throw new \Exception('لا يمكنك التعديل على حالة رحلة غير مخصصة لك ');
                }

            }
  
            $Trip->status = !$Trip->status;

            if($Trip->status == 0){
                // جلب الطلاب المرتبطين بالرحلة مع حالة غياب أو منقول
                $Trip->students()
                     ->wherePivotIn('status', ['absent', 'Moved_to'])
                     ->each(function ($student) use ($Trip) {
                        $Trip->students()->updateExistingPivot($student->id, ['status' => 'attendee']);
                    });

                // حذف الطلاب المرتبطين بالرحلة مع حالة نقل
                $Trip->students()->wherePivot('status', 'Transferred_from')
                    ->detach();
                
                $Trip->path->stations()->update(['status' => 0]);
            }else{
                //منع المشرفة من بدأ أكثر من رحلة في نفس الوقت
                $activeTrip = $user->trips()->where('status', 1)->where('trips.id', '!=', $trip_id)->first();
                if ($activeTrip) {
                    throw new \Exception('لا يمكنك بدء هذه الرحلة لأن هناك رحلة أخرى لا تزال قيد التنفيذ.');
                }
            }

            $Trip->save(); 

            return $Trip;

        } catch (\Exception $e) { Log::error($e->getMessage()); return $this->failed_Response($e->getMessage(), 404);
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with update status Trip', 400);}
    }
    //========================================================================================================================
    public function all_student_trip($trip_id)
    {
        try {
            $trip = Trip::find($trip_id);
            $trip->load('students');

            return $trip;

        }catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with get all students', 400);}
    }
    //========================================================================================================================
    public function all_student_Back_trip($trip_id)
    {
        try {
            $trip = Trip::with(['students' => function ($query) {
                $query->wherePivotIn('status', ['attendee', 'Transferred_from']);
            }])->findOrFail($trip_id);
            return $trip;

        }catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with get all students', 400);}
    }
    //========================================================================================================================
}
