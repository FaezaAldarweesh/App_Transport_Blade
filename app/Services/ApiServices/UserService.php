<?php

namespace App\Services\ApiServices;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;

class UserService {
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait;
    public function update_info($data){
        try {  
            $user = User::find(Auth::id());
            $user->first_phone = $data['first_phone'] ?? $user->first_phone;
            $user->secound_phone = $data['secound_phone'] ?? $user->secound_phone;
            $user->location = $data['location'] ?? $user->location;  

            $user->save();  
            return $user;
        }catch (\Exception $e) {
            Log::error('Error updating bus: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة التعديل على المستخدم');
        }
    }
}
