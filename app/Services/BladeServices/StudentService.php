<?php

namespace App\Services\BladeServices;

use App\Models\Trip;
use App\Models\Student;
use App\Models\StudentTrip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class StudentService
{
    public function get_all_Students()
    {
        $user = Auth::user();
        try {
            if($user->role == 'parent')
            {
                $students = Student::where('user_id', $user->id)->get();            }
            else
            {
                $students = Student::all();
            }
            return $students;
        } catch (\Exception $e) {
            Log::error('Error fetching students: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة الوصول إلى الطلاب');
        }
    }
//===========================================================================================================================
    public function create_Student($data)
    {
        try {
            $student = new Student();
            $student->name = $data['name'];
            $student->user_id = $data['user_id'];
            $student->save();

        } catch (\Exception $e) {
            Log::error('Error creating student: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
//===========================================================================================================================
    public function update_student($data, $student_id)
    {
        try {
            $student = Student::findOrFail($student_id);
            $student->name = $data['name'] ?? $student->name;
            $student->user_id = $data['user_id'] ?? $student->user_id;

            $student->save();

            return $student;
        } catch (\Exception $e) {
            Log::error('Error updating student: ' . $e->getMessage());
            throw new \Exception( 'حدث خطأ أثناء محاولة التعديل على طالب ');
        }
    }
//===========================================================================================================================
    public function delete_student($student_id)
    {
        try {
            $student = Student::findOrFail($student_id);
            $student->delete();
            return true;
        } catch (\Exception $e) {
            Log::error('Error deleting student: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف الطالب');
        }
    }
//===========================================================================================================================
    public function all_trashed_student()
    {
        try {
            return Student::onlyTrashed()->get();
        } catch (\Exception $e) {
            Log::error('Error fetching trashed students: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة الوصول إلى أرشيف الطلاب');
        }
    }
//===========================================================================================================================
    public function restore_student($student_id)
    {
        try {
            $student = Student::onlyTrashed()->findOrFail($student_id);
            $student->restore();
            return $student;
        } catch (\Exception $e) {
            Log::error('Error restoring student: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة استعادة الطالب');
        }
    }
//===========================================================================================================================
    public function forceDelete_student($student_id)
    {
        try {
            $student = Student::onlyTrashed()->findOrFail($student_id);
            $student->forceDelete();
            return true;
        } catch (\Exception $e) {
            Log::error('Error force deleting student: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف أرشيف الطالب');
        }
    }
//===========================================================================================================================
    public function view_student($student_id)
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

}
