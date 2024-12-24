<?php

namespace App\Services\BladeServices;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class UserService {
    /**
     * method to view all users with filter on role
     * @param   Request $request
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function get_all_Users($role){
        try {
            $user = User::filter($role)->get();
            return $user;
        } catch (\Exception $e) {
            Log::error('Error fetching bus: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة الوصول إلى المستخدمين');
        }
    }
    //========================================================================================================================
    /**
     * method to store a new user
     * @param   $data
     * @return /Illuminate\Http\JsonResponse ig have an error
     */
    public function create_User($data) {
        try {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            
            $user->save(); 
    
            return $user; 
        }  catch (\Exception $e) {
            Log::error('Error creating bus: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة إضافة مستحدم جديد');
        }
    }    

    //========================================================================================================================

    public function view_user($user_id){
        try{
            $user = User::findOrFail($user_id);
            $user->with('students')->get();
            return $user;
        }       
        catch(\Exception $e){
            Log::error('Error view user'.$e->getMessage());
            throw new \Exception($e->getMessage());
        } 
    }
    
    //========================================================================================================================
    /**
     * method to update user alraedy exist
     * @param  $data
     * @param  $user_id
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function update_user($data,User $user){
        try {  
            $user->name = $data['name'] ?? $user->name;
            $user->email = $data['email'] ?? $user->email;
            $user->password = $data['password'] ?? $user->password;  
            $user->role = $data['role'] ?? $user->role;

            $user->save();  
            return $user;
        }catch (\Exception $e) {
            Log::error('Error updating bus: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة التعديل على المستخدم');
        }
    }
    //========================================================================================================================
    /**
     * method to soft delete user alraedy exist
     * @param  User $user
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function delete_user(User $user)
    {
        try {  
             //منع الأدمن من إزالة حسابه
             if ($user->role == 'admin') {
                throw new \Exception('لا يمكنك إجراء حذف على حساب الأدمن');
            }
            $user->students()->delete();
            $user->delete();
            return true;
        } catch (\Exception $e) {
            Log::error('Error Deleting bus: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف المستحدم');
        }
    }
    //========================================================================================================================
    /**
     * method to return all soft delete users
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function all_trashed_user()
    {
        try {  
            $users = User::onlyTrashed()->get();
            return $users;
        } catch (\Exception $e) {
            Log::error('Error fetching trashed bus: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة الوصول إلى أرشيف المستحدمين');
        }
    }
    //========================================================================================================================
    /**
     * method to restore soft delete user alraedy exist
     * @param   $user_id
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function restore_user($user_id)
    {
        try {
            $user = User::onlyTrashed()->find($user_id);
            if(!$user){
                throw new \Exception('المستخدم المطلوب غير موجود');
            }
            $user->students()->restore();
            return $user->restore();
        } catch (\Exception $e) {
            Log::error('Error restoring bus: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة إستعادة المستحدم');
        }
    }
    //========================================================================================================================
    /**
     * method to force delete on user that soft deleted before
     * @param   $user_id
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function forceDelete_user($user_id)
    {   
        try {
            $user = User::onlyTrashed()->find($user_id);
            if(!$user){
                throw new \Exception('المستخدم المطلوب غير موجود');
            }
            return $user->forceDelete();
        } catch (\Exception $e) {
            Log::error('Error force deleting bus: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف أرشيف المستحدم');
        }
    }
    //========================================================================================================================

}
