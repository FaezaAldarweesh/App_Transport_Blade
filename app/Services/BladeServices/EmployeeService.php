<?php

namespace App\Services\BladeServices;

use App\Models\Employee;
use Illuminate\Support\Facades\Log;

class EmployeeService {
    /**
     * method to view all buses 
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function get_all_employee(){
        try {
            $employee = Employee::all();
            return $employee;
        } catch (\Exception $e) {
            Log::error('Error fetching employee: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة الوصول إلى الموظفين');
        } 
    }
    //========================================================================================================================
    /**
     * method to store a new bus
     * @param   $data
     * @return /Illuminate\Http\JsonResponse ig have an error
     */
    public function create_employee($data) {
        try {
            $employee = new Employee(); 
            $employee->name = $data['name'];
            $employee->em_job = $data['em_job'];
            $employee->phone = $data['phone'];
            $employee->save();
    
            return $employee; 
        } catch (\Exception $e) {
            Log::error('Error creating employee: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة إضافة موظف جديد');
        }
    }    
    //========================================================================================================================
    /**
     * method to update bus alraedy exist
     * @param  $data
     * @param  $bus_id
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function update_employee($data, $employee_id){
        try {  
            $employee = Employee::findOrFail($employee_id);
            $employee->name = $data['name'] ?? $employee->name;
            $employee->em_job = $data['em_job'] ?? $employee->em_job;
            $employee->phone = $data['phone'] ?? $employee->phone;

            $employee->save(); 
            return $employee;

        } catch (\Exception $e) {
            Log::error('Error updating employee: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة التعديل على الموظف');
        }
    }
    //========================================================================================================================
    /**
     * method to soft delete bus alraedy exist
     * @param  $bus_id
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function delete_employee($employee_id)
    {
        try
        {
            $employee = Employee::find($employee_id);
            // $employee->trips()->delete();
            $employee->delete();
            return true;
        }    
         catch (\Exception $e) {
            Log::error('Error Deleting employee: '.$e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف الموظف');
        }
    }
    //========================================================================================================================
    /**
     * method to return all soft delete bus
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function all_trashed_employee()
    {
        try {  
            return Employee::onlyTrashed()->get();
        } catch (\Exception $e) {
            Log::error('Error fetching trashed employee: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة الوصول إلى أرشيف الموظفين');
        }
    }
    //========================================================================================================================
    /**
     * method to restore soft delete bus alraedy exist
     * @param   $bus_id
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function restore_employee($employee_id)
    {
        try {
            $employee = Employee::onlyTrashed()->findOrFail($employee_id);
            // $employee->trips()->restore();
            $employee->restore();
            return true;
        } catch (\Exception $e) {
            Log::error('Error restoring employee: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة إستعادة الموظف');
        }
    }
    //========================================================================================================================
    /**
     * method to force delete on bus that soft deleted before
     * @param   $bus_id
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function forceDelete_employee($employee_id)
    {   
        try {
            $employee = Employee::onlyTrashed()->findOrFail($employee_id);
            // $employee->trips()->forceDelete();
            return $employee->forceDelete();
        } catch (\Exception $e) {
            Log::error('Error force deleting employee: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف أرشيف الموظف');
        }
    }
    //========================================================================================================================

}
