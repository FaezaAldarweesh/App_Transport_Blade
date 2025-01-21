<?php

namespace App\Services\ApiServices;

use Carbon\Carbon;
use App\Models\Trip;
use App\Models\Checkout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;

class CheckoutService {
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait;
    /**
     * method to view all checkouts 
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function get_all_Checkout(){
        try {
            $Checkouts = Checkout::all();
            return $Checkouts;
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with fetche Checkouts', 400);}
    }
    //========================================================================================================================
    /**
     * method to store a new checkout if it does not exist , or update on cheackout where find it
     * @param   $data
     * @return /Illuminate\Http\JsonResponse ig have an error
     */
    public function create_Checkout($data) {
        try {
            $user = Auth::user();
            $trip = Trip::where('id',$data['trip_id'])->first();

            //منع المشرفة من إضافة تفقد في حال كانت حالة الرحلة منتهية.....تستطيع فقط أضافة تفقد في حال الرحلة حارية    
            if($user->role == 'supervisor' && $trip->status == 0 ){
                throw new \Exception('لا يمكنك أخذ الحضور للطلاب في حال كانت الرحلة حاليا منتهية');
            }

            //التحقق من أن الطالب لم يتم تسجيل حضور له بتاريخ اليوم في الرحلة المحددة
            $checkout = Checkout::where('trip_id', $data['trip_id'])
                                ->where('student_id', $data['student_id'])
                                ->whereDate('created_at',Carbon::now())
                                ->first();

            if (!$checkout) {
               $checkout = new Checkout();
            }
    
            // تحديث أو إنشاء السجل
            $checkout->trip_id = $data['trip_id'] ?? $checkout->trip_id;
            $checkout->student_id = $data['student_id'] ?? $checkout->student_id;
            $checkout->checkout = $data['checkout'] ?? $checkout->checkout;

            $checkout->save();

            return $checkout;
        } catch (\Exception $e) { Log::error($e->getMessage()); return $this->failed_Response($e->getMessage(), 404);
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('Something went wrong with create checkout', 400);}
    }    
    //========================================================================================================================
}
