<?php

namespace App\Services\BladeServices;

use App\Models\Student;
use Illuminate\Support\Facades\Log;

class StudentService
{
    public function get_all_Students()
    {
        try {
            return Student::all();
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
            $student->father_phone = $data['father_phone'];
            $student->mather_phone = $data['mather_phone'];
            $student->longitude = $data['longitude'];
            $student->latitude = $data['latitude'];
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
            $student->father_phone = $data['father_phone'] ?? $student->father_phone;
            $student->mather_phone = $data['mather_phone'] ?? $student->mather_phone;
            $student->longitude = $data['longitude'] ?? $student->longitude;
            $student->latitude = $data['latitude'] ?? $student->latitude;
            $student->user_id = $data['user_id'] ?? $student->user_id;
            $student->status = $data['status'] ?? $student->status;

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
}
