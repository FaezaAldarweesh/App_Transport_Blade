<?php
namespace App\Http\Traits;

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

trait UserManagementTrait
{
    public function getAllUsers()
    {
        try {
            return User::all();
        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception('Unable to fetch users at this time. Please try again later.');
        }
    }

    public function getRoles()
    {
        try {
            return Role::pluck('name', 'name')->all();
        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception('Unable to fetch roles at this time. Please try again later.');
        }
    }

    public function createUser(array $data)
    {
        try {
            $user = User::create($data);
            $user->assignRole($data['role']);
            $user->role = $data['role'];
            $user->save();

            return $user;
        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception('Unable to create user at this time. Please try again later.');
        }
    }

    public function getUserWithRoles(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = Role::pluck('name', 'name')->all();
            $userRole = $user->roles->pluck('name', 'name')->all();

            return [
                'user' => $user,
                'roles' => $roles,
                'userRole' => $userRole
            ];
        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception('Unable to retrieve user or roles at this time. Please try again later.');
        }
    }

    public function updateUser(array $data, string $id)
    {
      //  dd($data);
        try {
            $user = User::findOrFail($id);
    
            if (!empty($data['password'])) {
                $data['password'] = $data['password'];
            } else {
                $data = Arr::except($data, ['password']);
            }
    
            $user->update($data);
    
            // إعادة تعيين الأدوار باستخدام syncRoles
            $user->syncRoles($data['role']);

            $user->role = $data['role'];
            $user->save();
    
            return $user;
        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception('Unable to update user at this time. Please try again later.');
        }
    }
    

    public function deleteUser(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $students = Student::where('user_id',$id)->delete();
            $user->delete();

            return true;
        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception('Unable to delete user at this time. Please try again later.');
        }
    }

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


//===========================================================================================================================
    public function restore_user($user_id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($user_id);
            $user->restore();
            $students = Student::onlyTrashed()->where('user_id',$user_id)->restore();
            return $user;
        } catch (\Exception $e) {
            Log::error('Error restoring student: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة استعادة المستخدم');
        }
    }
//===========================================================================================================================
    public function forceDelete_user($user_id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($user_id);
            $user->forceDelete();
            $students = Student::onlyTrashed()->where('user_id',$user_id)->forceDelete();
            return true;
        } catch (\Exception $e) {
            Log::error('Error force deleting student: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف أرشيف المستخدم');
        }
    }
//===========================================================================================================================
}