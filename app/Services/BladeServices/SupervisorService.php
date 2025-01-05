<?php

namespace App\Services\BladeServices;

use App\Models\Trip;
use App\Models\User;
use App\Models\TripUser;
use App\Models\Supervisor;
use Illuminate\Support\Facades\Log;

class SupervisorService {

    /**
     * method to view all Supervisors 
     * @return /view
     */
    public function get_all_Supervisors(){
        try {
            $Supervisor = Supervisor::all();
            return $Supervisor;
        } catch (\Exception $e) {
            Log::error('Error fetching supervisors: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة الوصول إلى المشرف');
        }
    }
    //========================================================================================================================
    /**
     * method to store a new Supervisor
     * @param   $data
     * @return /view
     */
    public function create_Supervisor($data) {
        try {
            $Supervisor = new Supervisor();
            $Supervisor->name = $data['name'];
            $Supervisor->phone = $data['phone'];
            $Supervisor->location = $data['location'];
            
            $Supervisor->save(); 

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->assignRole('supervisor');
            
            $user->save(); 
    
            return $Supervisor; 
        } catch (\Exception $e) {
            Log::error('Error creating supervisor: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة إضافة مشرف جديد');
        }
    }    
    //========================================================================================================================
    /**
     * method to update Supervisor alraedy exist
     * @param  $data
     * @param  $Supervisor_id
     * @return /view
     */
    public function update_Supervisor($data,$Supervisor_id){
        try {  
            $Supervisor = Supervisor::findOrFail($Supervisor_id);
            $user = User::where('name','=',$Supervisor->name)->first();

            $Supervisor->name = $data['name'] ?? $Supervisor->name; 
            $Supervisor->phone = $data['phone'] ?? $Supervisor->phone;  
            $Supervisor->location = $data['location'] ?? $Supervisor->location;  
            $Supervisor->save();  

            $user->name = $data['name'] ?? $user->name;
            $user->save();  

            return $Supervisor;
            
        } catch (\Exception $e) {
            Log::error('Error updating supervisor: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
    //========================================================================================================================
    /**
     * method to soft delete Supervisor alraedy exist
     * @param  Supervisor $Supervisor
     * @return /view
     */
    public function delete_Supervisor($Supervisor_id)
    {
        try {  
            $Supervisor = Supervisor::findOrFail($Supervisor_id);
            $user = User::where('name','=',$Supervisor->name)->first();
            $Supervisor->delete();
            $user->delete();
            return true;
        } catch (\Exception $e) {
            Log::error('Error Deleting supervisor: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف المشرف');
        }
    }
    //========================================================================================================================
    /**
     * method to return all soft delete Supervisors
     * @return /view
     */
    public function all_trashed_Supervisor()
    {
        try {  
            return Supervisor::onlyTrashed()->get();
        } catch (\Exception $e) {
            Log::error('Error fetching trashed supervisor: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة الوصول إلى أرشيف المشرفين');
        }
    }
    //========================================================================================================================
    /**
     * method to restore soft delete Supervisor alraedy exist
     * @param   $Supervisor_id
     * @return /view
     */
    public function restore_Supervisor($Supervisor_id)
    {
        try {
            $Supervisor = Supervisor::onlyTrashed()->findOrFail($Supervisor_id);
            $user = User::onlyTrashed()->where('name','=',$Supervisor->name)->first();
            $Supervisor->restore();
            $user->restore();
            return $Supervisor;
        } catch (\Exception $e) {
            Log::error('Error restoring supervisor: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة إستعادة المشرف');
        }
    }
    //========================================================================================================================
    /**
     * method to force delete on Supervisor that soft deleted before
     * @param   $Supervisor_id
     * @return /view
     */
    public function forceDelete_Supervisor($Supervisor_id)
    {   
        try {
            $Supervisor = Supervisor::onlyTrashed()->findOrFail($Supervisor_id);
            $user = User::onlyTrashed()->where('name','=',$Supervisor->name)->first();
            $Supervisor->forceDelete();
            $user->forceDelete();
            return true;
        } catch (\Exception $e) {
            Log::error('Error force deleting supervisor: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف أرشيف المشرف');
        }
    }
    //========================================================================================================================
    public function view_Supervisor($Supervisor_id)
    {
        try
        {
            $Supervisor = Supervisor::where('id',$Supervisor_id)->first();
            $user = User::where('name',$Supervisor->name)->first();
            $tripIds = TripUser::where('user_id', $user->id)->pluck('trip_id');
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
