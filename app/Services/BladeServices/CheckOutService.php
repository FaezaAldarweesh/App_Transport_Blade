<?php

namespace App\Services\BladeServices;

use Carbon\Carbon;
use App\Models\Trip;
use App\Models\Checkout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckOutService
{
    public function get_all_checkouts()
    {
        try {
            $user = Auth::user();

            if($user->role == 'supervisor'){
                $trip = $user->trips()->pluck('trip_id');
                $checkout = Checkout::whereIn('trip_id', $trip)->get();
            }else{
                $checkout = Checkout::all();
            }
            return $checkout;
        } catch (\Exception $e) {
            Log::error('Error fetching Trip: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
//========================================================================================================================
public function create_Checkout($data) {
    try {
        $user = Auth::user();
        $trip = Trip::where('id',$data['trip_id'])->first();

        //منع المشرفة من إضافة تفقد في حال كانت حالة الرحلة منتهية.....تستطيع فقط أضافة تفقد في حال الرحلة حارية    
        if($user->role == 'supervisor' && $trip->status == 0 ){
            return redirect()->back()->withErrors(['error' => 'لا يمكنك إضافة حضور على رحلة حاليا غير جارية']);
        }
        //التحقق من أن الطالب لم يتم تسجيل حضور له بتاريخ اليوم في الرحلة المحددة
        $checkStudent = Checkout::where('trip_id',$data['trip_id'])
                                ->where('student_id',$data['student_id'])
                                ->whereDate('created_at',Carbon::now())
                                ->first();
        if($checkStudent){
            return redirect()->back()->withErrors(['error' => 'تم تسجيل تفقد لهذا الطالب على هذه الرحلة اليوم']);
        }else{
            $Checkout = new Checkout(); 
            
            $Checkout->trip_id = $data['trip_id'];
            $Checkout->student_id = $data['student_id'];
            $Checkout->checkout = $data['checkout'];
            $Checkout->note = $data['note'];
            
            $Checkout->save();
    
            return $Checkout;
        }
        } catch (\Exception $e) {
            Log::error('Error creating checkout: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
//========================================================================================================================
    public function update_checkout($data, $id)
    {
        try
        {
            $user = Auth::user();
            $trip = Trip::where('id',$data['trip_id'])->first();
            
            //منع المشرفة من إضافة تفقد في حال كانت حالة الرحلة منتهية.....تستطيع فقط أضافة تفقد في حال الرحلة حارية    
            if($user->role == 'supervisor' && $trip->status == 0 ){
                return redirect()->back()->withErrors(['error' => 'لا يمكنك التعديل على حضور في حال كانت الرحلة حاليا منتهية']);
            }
            $checkout = CheckOut::findOrFail($id);
            
            $checkout->trip_id = $data['trip_id'] ?? $checkout->trip_id;
            $checkout->student_id = $data['student_id'] ?? $checkout->student_id;
            $checkout->checkout = $data['checkout'] ?? $checkout->checkout;
            $checkout->note = $data['note'] ?? $checkout->note;
  
            $checkout->save();

            return $checkout;
        }
        catch(\Exception $e)
        {
            Log::error('Error update checkout'.$e->getMessage());
            throw new \Exception($e->getMessage());

        }
    }
//========================================================================================================================
    public function view_checkout($trip_id)
    {
        try
        { 
            $trip = Trip::findOrFail($trip_id);
            $trip->with('students')->get();
            return $trip;
        }
        catch(\Exception $e)
        {
            Log::erro('Error view check out'.$e->getMessage());
            throw new \Exception('حدث خطأ أثناء عرض التفقد');
        }
    }
//========================================================================================================================
public function show_checkout($trip_id)
{
    try
    { 
        $checkouts = Checkout::with('student','trip')->where('trip_id',$trip_id)->get();
        return $checkouts;
    }
    catch(\Exception $e)
    {
        Log::erro('Error view check out'.$e->getMessage());
        throw new \Exception('حدث خطأ أثناء عرض التفقد');
    }
}
//========================================================================================================================
    public function delete_checkout($id)
    {
        try
        {
            $checkout = CheckOut::find($id);

            $user = Auth::user();
            $trip = Trip::where('id',$checkout->trip_id)->first();
            
            //منع المشرفة من إضافة تفقد في حال كانت حالة الرحلة منتهية.....تستطيع فقط أضافة تفقد في حال الرحلة حارية    
            if($user->role == 'supervisor' && $trip->status == 0 ){
                return redirect()->back()->withErrors(['error' => 'لا يمكنك حذف حضور في حال كانت الرحلة حاليا منتهية']);
            }

            $checkout->delete();
            return true;
        }
        catch(\Exception $e)
        {
            Log::error('Error deleting checkout'.$e->getMessage());
            throw new \Exception('حدث خطأ أنثاء حذف التفقد');
        }
    }
}