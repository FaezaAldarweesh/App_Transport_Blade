<?php

namespace App\Services\BladeServices;

use App\Models\Bus;
use App\Models\Trip;
use App\Models\Student;
use App\Models\TripUser;
use App\Models\DriverTrip;
use App\Models\StudentTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TripService {
    /**
     * method to view all Trips 
     * @return /view
     */
    public function get_all_Trips(){
        try {
            $user = Auth::user();

            if($user->role == 'supervisor'){
                $Trips = $user->trips()->get();
            }else{
                $Trips = Trip::all();
            }
            return $Trips;
        } catch (\Exception $e) {
            Log::error('Error fetching Trip: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
    //========================================================================================================================
    /**
     * method to store a new Trip
     * @param   $data
     * @return /view
     */
    public function create_Trip($data)
    {
        try {
            // التحقق من وجود رحلة توصيل بنفس المسار والباص
            if ($data['name'] === 'delivery') {
                $existingTripByPath = Trip::where('name', 'delivery')
                                          ->where('type', 'go')
                                          ->where('path_id', $data['path_id'])
                                          ->exists();
                if ($existingTripByPath) {
                    return redirect()->back()->withErrors(['error' => 'هذا المسار مرتبط برحلة توصيل أخرى مسبقاً']);
                }
    
                $existingTripByBus = Trip::where('name', 'delivery')
                                         ->where('type', 'go')
                                         ->where('bus_id', $data['bus_id'])
                                         ->exists();
                if ($existingTripByBus) {
                    return redirect()->back()->withErrors(['error' => 'هذا الباص مرتبط برحلة توصيل أخرى مسبقاً']);
                }
    
                $existingTrips = Trip::where('name', 'delivery')
                                     ->where('type', 'go')
                                     ->pluck('id');
    
                // التحقق من الطالب
                $existingStudent = StudentTrip::whereIn('trip_id', $existingTrips)
                                              ->where('student_id', $data['students'])
                                              ->exists();
                if ($existingStudent) {
                    return redirect()->back()->withErrors(['error' => 'تم إضافة هذا الطالب إلى رحلة توصيل أخرى مسبقاً']);
                }
    
                // التحقق من المشرف
                $existingSupervisor = TripUser::whereIn('trip_id', $existingTrips)
                                                    ->where('user_id', $data['supervisors'])
                                                    ->exists();
                if ($existingSupervisor) {
                    return redirect()->back()->withErrors(['error' => 'تم إضافة هذا المشرف إلى رحلة توصيل أخرى مسبقاً']);
                }
    
                // التحقق من السائق
                $existingDriver = DriverTrip::whereIn('trip_id', $existingTrips)
                                            ->where('driver_id', $data['drivers'])
                                            ->exists();
                if ($existingDriver) {
                    return redirect()->back()->withErrors(['error' => 'تم إضافة هذا السائق إلى رحلة توصيل أخرى مسبقاً']);
                }

            }elseif($data['name'] === 'school'){
                //جلب كل الرحل المدرسية بتاريخ اليوم    
                $existingTripsToday = Trip::where('name', 'school')
                                          ->whereDate('created_at', now()->toDateString())
                                          ->pluck('id');
            
                // التحقق من الطالب
                $existingStudent = StudentTrip::whereIn('trip_id', $existingTripsToday)
                                              ->where('student_id', $data['students'])
                                              ->exists();
                if ($existingStudent) {
                    return redirect()->back()->withErrors(['error' => 'تم إضافة هذا الطالب إلى رحلة  مدرسية أخرى بتاريخ اليوم']);
                }
            
                // التحقق من المشرف
                $existingSupervisor = TripUser::whereIn('trip_id', $existingTripsToday)
                                                    ->where('user_id', $data['supervisors'])
                                                    ->exists();
                if ($existingSupervisor) {
                    return redirect()->back()->withErrors(['error' => 'تم إضافة هذا المشرف إلى رحلة مدرسية أخرى بتاريخ اليوم']);
                }
            
                // التحقق من السائق
                $existingDriver = DriverTrip::whereIn('trip_id', $existingTripsToday)
                                            ->where('driver_id', $data['drivers'])
                                            ->exists();
                if ($existingDriver) {
                    return redirect()->back()->withErrors(['error' => 'تم إضافة هذا السائق إلى رحلة مدرسية أخرى بتاريخ اليوم']);
                }

                 // التحقق من الباص
                $existingBus = Trip::where('name', 'school')
                                    ->where('bus_id', $data['bus_id'])
                                    ->whereDate('created_at', now()->toDateString())
                                    ->exists();
                if ($existingBus) {
                    return redirect()->back()->withErrors(['error' => 'تم استخدام هذا الباص في رحلة مدرسية أخرى بتاريخ اليوم']);
                }
            }

            $bus = Bus::find($data['bus_id']);
            if (count($data['students']) > $bus->number_of_seats) {
                return redirect()->back()->withErrors(['error' => 'عدد الطلاب يجب أن يساوي عدد مقاعد الباص ']);
            }
    
            // إنشاء رحلتي ذهاب وإياب
            $tripTypes = ['go', 'back'];
            foreach ($tripTypes as $type) {
                $trip = new Trip();
                $trip->name = $data['name'];
                $trip->type = $type;
                $trip->path_id = $data['path_id'];
                $trip->bus_id = $data['bus_id'];
                $trip->save();
    
                $trip->students()->attach($data['students']);
                $trip->users()->attach($data['supervisors']);
                $trip->drivers()->attach($data['drivers']);
                $trip->save();
            }
    
            return redirect()->back()->with('success', 'تم إنشاء الرحلتين بنجاح');
        } catch (\Exception $e) {
            Log::error('Error creating trip: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'حدث خطأ أثناء إنشاء الرحلة: ' . $e->getMessage()]);
        }
    } 
    //========================================================================================================================
    /**
     * method to show Trip alraedy exist
     * @param  $Trip_id
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function view_Trip($Trip_id) {
        try {    
            $trip = Trip::findOrFail($Trip_id);
            $trip->with('students','users','drivers')->get();
            return $trip;
        }  catch (\Exception $e) {
            Log::error('Error view trip: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
    //========================================================================================================================
    /**
     * method to update Trip alraedy exist
     * @param  $data
     * @param  $Trip_id
     * @return /view
     */
    public function update_Trip($data,$id)
    {
        try {
            // جلب الرحلة الحالية
            $trip = Trip::findOrFail($id);
            
            // جلب رحلة الإياب المرتبطة (إذا كانت موجودة)
            $returnTrip = Trip::where('name', $trip->name)
                              ->where('type', $trip->type === 'go' ? 'back' : 'go')
                              ->where('path_id', $trip->path_id)
                              ->where('bus_id', $trip->bus_id)
                              ->first();
    
                        // التحقق من وجود رحلة بنفس المسار والباص
            if ($data['name'] === 'delivery') {
                $existingTripByPath = Trip::where('name', 'delivery')
                                          ->where('type', 'go')
                                          ->where('path_id', $data['path_id'])
                                          ->where('id', '!=', $id)
                                          ->exists();

                if ($existingTripByPath) {
                    return redirect()->back()->withErrors(['error' => 'هذا المسار مرتبط برحلة توصيل أخرى مسبقاً']);
                }
    
                $existingTripByBus = Trip::where('name', 'delivery')
                                         ->where('type', 'go')
                                         ->where('bus_id', $data['bus_id'])
                                         ->where('id', '!=', $id)
                                         ->exists();
                if ($existingTripByBus) {
                    return redirect()->back()->withErrors(['error' => 'هذا الباص مرتبط برحلة توصيل أخرى مسبقاً']);
                }
    
                $existingTrips = Trip::where('name', 'delivery')
                                     ->where('type', 'go')
                                     ->where('id', '!=', $id)
                                     ->pluck('id');
    
                // التحقق من الطالب
                $existingStudent = StudentTrip::whereIn('trip_id', $existingTrips)
                                              ->where('student_id', $data['students'])
                                              ->exists();
                if ($existingStudent) {
                    return redirect()->back()->withErrors(['error' => 'تم إضافة هذا الطالب إلى رحلة توصيل أخرى مسبقاً']);
                }
    
                // التحقق من المشرف
                $existingSupervisor = TripUser::whereIn('trip_id', $existingTrips)
                                                    ->where('user_id', $data['supervisors'])
                                                    ->exists();
                if ($existingSupervisor) {
                    return redirect()->back()->withErrors(['error' => 'تم إضافة هذا المشرف إلى رحلة توصيل أخرى مسبقاً']);
                }
    
                // التحقق من السائق
                $existingDriver = DriverTrip::whereIn('trip_id', $existingTrips)
                                            ->where('driver_id', $data['drivers'])
                                            ->exists();
                if ($existingDriver) {
                    return redirect()->back()->withErrors(['error' => 'تم إضافة هذا السائق إلى رحلة توصيل أخرى مسبقاً']);
                }
            }elseif($data['name'] === 'school'){
                //جلب كل الرحل المدرسية بتاريخ اليوم    
                $existingTripsToday = Trip::where('name', 'school')
                                          ->whereDate('created_at', now()->toDateString())
                                          ->pluck('id');
            
                // التحقق من الطالب
                $existingStudent = StudentTrip::whereIn('trip_id', $existingTripsToday)
                                              ->where('student_id', $data['students'])
                                              ->exists();
                if ($existingStudent) {
                    return redirect()->back()->withErrors(['error' => 'تم إضافة هذا الطالب إلى رحلة  مدرسية أخرى بتاريخ اليوم']);
                }
            
                // التحقق من المشرف
                $existingSupervisor = TripUser::whereIn('trip_id', $existingTripsToday)
                                                    ->where('user_id', $data['supervisors'])
                                                    ->exists();
                if ($existingSupervisor) {
                    return redirect()->back()->withErrors(['error' => 'تم إضافة هذا المشرف إلى رحلة مدرسية أخرى بتاريخ اليوم']);
                }
            
                // التحقق من السائق
                $existingDriver = DriverTrip::whereIn('trip_id', $existingTripsToday)
                                            ->where('driver_id', $data['drivers'])
                                            ->exists();
                if ($existingDriver) {
                    return redirect()->back()->withErrors(['error' => 'تم إضافة هذا السائق إلى رحلة مدرسية أخرى بتاريخ اليوم']);
                }

                 // التحقق من الباص
                $existingBus = Trip::where('name', 'school')
                                    ->where('bus_id', $data['bus_id'])
                                    ->whereDate('created_at', now()->toDateString())
                                    ->exists();
                if ($existingBus) {
                    return redirect()->back()->withErrors(['error' => 'تم استخدام هذا الباص في رحلة مدرسية أخرى بتاريخ اليوم']);
                }
            }
    
            $bus = Bus::find($data['bus_id']);

            if (count($data['students']) > $bus->number_of_seats) {
                return redirect()->back()->withErrors(['error' => 'عدد الطلاب يجب أن يساوي عدد مقاعد الباص ']);
            }
    
            // تحديث معلومات رحلة الذهاب
            $trip->update([
                'name' => $data['name'],
                'path_id' => $data['path_id'],
                'bus_id' => $data['bus_id']
            ]);
    
            // تحديث علاقات رحلة الذهاب
            $trip->students()->sync($data['students']);
            $trip->users()->sync($data['supervisors']);
            $trip->drivers()->sync($data['drivers']);
    
            // تحديث رحلة الإياب إذا كانت موجودة
            if ($returnTrip) {
                $returnTrip->update([
                    'name' => $data['name'],
                    'type' => $returnTrip->type,
                    'path_id' => $data['path_id'],
                    'bus_id' => $data['bus_id']
                ]);
    
                // تحديث علاقات رحلة الإياب
                $returnTrip->students()->sync($data['students']);
                $returnTrip->users()->sync($data['supervisors']);
                $returnTrip->drivers()->sync($data['drivers']);
            }
    
            return redirect()->back()->with('success', 'تم تعديل الرحلة بنجاح مع رحلة الإياب');
        } catch (\Exception $e) {
            Log::error('Error updating trip: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'حدث خطأ أثناء تعديل الرحلة: ' . $e->getMessage()]);
        }
    }    
    //========================================================================================================================
    /**
     * method to soft delete Trip alraedy exist
     * @param  $Trip_id
     * @return /view
     */
    public function delete_Trip($Trip_id)
    {
        try {  
            $Trip = Trip::findOrFail($Trip_id);

            $returnTrip = Trip::where('name', $Trip->name)
                              ->where('type', $Trip->type === 'go' ? 'back' : 'go')
                              ->where('path_id', $Trip->path_id)
                              ->where('bus_id', $Trip->bus_id)
                              ->whereDate('created_at', $Trip->created_at)
                              ->first();
            
            $Trip->students()->updateExistingPivot($Trip->students->pluck('id'), ['deleted_at' => now()]);     
            $Trip->users()->updateExistingPivot($Trip->users->pluck('id'), ['deleted_at' => now()]);     
            $Trip->drivers()->updateExistingPivot($Trip->drivers->pluck('id'), ['deleted_at' => now()]);  
            
            $returnTrip->students()->updateExistingPivot($returnTrip->students->pluck('id'), ['deleted_at' => now()]);     
            $returnTrip->users()->updateExistingPivot($returnTrip->users->pluck('id'), ['deleted_at' => now()]);     
            $returnTrip->drivers()->updateExistingPivot($returnTrip->drivers->pluck('id'), ['deleted_at' => now()]);  

            $Trip->delete();
            $returnTrip->delete();
            return true;
        } catch (\Exception $e) {
            Log::error('Error Deleting trip: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
    //========================================================================================================================
    /**
     * method to return all soft delete Trip
     * @return /view
     */
    public function all_trashed_Trip()
    {
        try {  
            return Trip::onlyTrashed()->get();
        } catch (\Exception $e) {
            Log::error('Error Deleting trip: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف الرحلة');
        }
    }
    //========================================================================================================================
    /**
     * method to restore soft delete Trip alraedy exist
     * @param   $Trip_id
     * @return /view
     */
    public function restore_Trip($Trip_id)
    {
        try {
            $Trip = Trip::onlyTrashed()->findOrFail($Trip_id);

            $returnTrip = Trip::withTrashed()
                              ->where('name', $Trip->name)
                              ->where('type', $Trip->type === 'go' ? 'back' : 'go')
                              ->where('path_id', $Trip->path_id)
                              ->where('bus_id', $Trip->bus_id)
                              ->whereDate('created_at', $Trip->created_at)
                              ->first();

            $Trip->restore();
            if($returnTrip){
                $returnTrip->restore();
    
                $returnTrip->students()->withTrashed()->updateExistingPivot($returnTrip->students->pluck('id'), ['deleted_at' => null]);
                $returnTrip->users()->withTrashed()->updateExistingPivot($returnTrip->users->pluck('id'), ['deleted_at' => null]);
                $returnTrip->drivers()->withTrashed()->updateExistingPivot($returnTrip->drivers->pluck('id'), ['deleted_at' => null]);
            }
            
            $Trip->students()->withTrashed()->updateExistingPivot($Trip->students->pluck('id'), ['deleted_at' => null]);
            $Trip->users()->withTrashed()->updateExistingPivot($Trip->users->pluck('id'), ['deleted_at' => null]);
            $Trip->drivers()->withTrashed()->updateExistingPivot($Trip->drivers->pluck('id'), ['deleted_at' => null]);
            

            return true;
        } catch (\Exception $e) {
            Log::error('Error Deleting trip: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
    //========================================================================================================================
    /**
     * method to force delete on Trip that soft deleted before
     * @param   $Trip_id
     * @return /view
     */
    public function forceDelete_Trip($Trip_id)
    {   
        try {
            $Trip = Trip::onlyTrashed()->findOrFail($Trip_id);

            $returnTrip = Trip::withTrashed()
                              ->where('name', $Trip->name)
                              ->where('type', $Trip->type === 'go' ? 'back' : 'go')
                              ->where('path_id', $Trip->path_id)
                              ->where('bus_id', $Trip->bus_id)
                              ->whereDate('created_at', $Trip->created_at)
                              ->first();

            $Trip->forceDelete();
            $returnTrip->forceDelete();
            return true;
        } catch (\Exception $e) {
            Log::error('Error Deleting trip: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف الرحلة');
        }
    }
    //========================================================================================================================




    //========================================================================================================================
    public function update_trip_status($trip_id)
    {
        try {
            $Trip = Trip::find($trip_id);
  
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
            }
            $Trip->save(); 

            return $Trip;

        }  catch (\Exception $e) {
            Log::error('Error update status trip: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
    //========================================================================================================================
    public function all_student_trip($trip_id)
    {
        try {
            $Trip = Trip::with('students')->find($trip_id);
            
            return $Trip;

        }  catch (\Exception $e) {
            Log::error('Error update status trip: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
    //========================================================================================================================
    public function update_student_status($student_id,$trip_id)
    {
        try {
            $student = StudentTrip::where('student_id',$student_id)->where('trip_id',$trip_id)->first();

            $user = Auth::user();
            $trip = Trip::where('id',$student->trip_id)->first();
            
            if($user->role == 'parent' && $trip->status == 1 ){
                return redirect()->back()->withErrors(['error' => 'لا يمكنك تعديل حالة الطالب في حال كانت الرحلة حاليا جارية']);
            }
            
            $status = $student->status == 'attendee' ? 'absent' : 'attendee';
            $student->update(['status' => $status]); 

            return $student;

        }  catch (\Exception $e) {
            Log::error('Error update status trip: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
    //========================================================================================================================
    public function update_student_status_transport(Request $request,$student_id)
    {
        try {
            $request->validate([
                'trip_id' => 'required|exists:trips,id',
            ]);
    
            $student = Student::findOrFail($student_id);
            $trip_id = $request->input('trip_id'); 
            $trip = Trip::findOrFail($trip_id);

            if (count($trip->students)+1 > $trip->bus->number_of_seats) {
                return redirect()->back()->withErrors(['error' => 'لا يوجد مكان فارغ ضمن هذه الرحلة']);
            }
                        
            $existingTrip = $student->trips()->wherePivot('status', 'attendee')->first();

            $student->trips()->updateExistingPivot(
                 $existingTrip->id, 
                [
                    'status' => 'Moved_to',
                ]
            );
            $student->trips()->attach($trip->id, ['status' => 'Transferred_from']);
    
            return true;
    
        } catch (\Exception $e) {
            Log::error('Error update status trip: ' . $e->getMessage());
            return redirect()->back()->withErrors('فشلت عملية النقل: ' . $e->getMessage());
        }
    }
    //========================================================================================================================
}
