<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Transport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransportResources;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;


class TransportController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function all_transport()
    {
        try {
            $user = Auth::user();
            if($user->role == 'parent'){
                $students = $user->students;
                // جلب سجلات النقل الخاصة بهؤلاء الطلاب

                $transports = collect(); // إنشاء مجموعة فارغة لتخزين سجلات النقل

                foreach ($students as $student) {
                    $transports = $transports->merge($student->transports);
                }
            }
            return $this->success_Response( TransportResources::collection($transports), "تمت عملية جلب كل طلبات النقل بنجاح", 200);

        } catch (\Exception $e) {
            Log::error('Error fetching transports: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function delete_transport($transport_id)
    {
        try {  
            $transport = Transport::findOrFail($transport_id);
            $transport->delete();
            
            return $this->success_Response( null, "تمت عملية حذف طلب النقل بنجاح", 200);

        }catch (\Exception $e) {
            Log::error('Error Deleting Transport: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف النقل');
        }
    }
}
