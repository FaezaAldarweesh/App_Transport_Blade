<?php

namespace App\Services\BladeServices;

use App\Models\Trip;
use App\Models\Checkout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckOutService
{
    public function get_all_checkouts()
    {
        // try
        // {
        //     // $checkouts = Checkout::with('trips.students')->get();
        //     // return $checkouts;
        //     $trip = Trip::with('students')->get();
        //     return $trip;
        // }
        // catch(\Exception $e){
        //     Log::error('Error view CheckOuts'.$e->getMessage());
        //     throw new \Exception('حدث خطأ أثناء عرض  التفقد');
        // }
        try {
            $user = Auth::user();

            if($user->role == 'supervisor'){
                $trip = $user->trips()->pluck('trip_id');
                $checkout = Checkout::whereIn('trip_id', $trip);
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

    public function create_checkout($data){
        try
        {
            $checkout = new CheckOut();
            $checkout->trip_id = $data['trip_id'];
            $checkout->student_id = $data['student_id'];
            $checkout->checkout = $data['checkout'];
            $checkout->note = $data['note'];
            $checkout->save();
        }
        catch(\Exception $e)
        {
            Log::error('Error creating CheckOut'.$e->getMessage());
            throw new \Exception('حدث خطأ أثناء إنشاء التفقد');
        }
    }
//========================================================================================================================
    public function update_checkout($data, $id)
    {
        try
        {
            $checkout = CheckOut::find($id);
            if(!$checkout)
            {
                throw new \Exception('التفقد المطلوب غير موجود');
            } 
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
            throw new \Exception('حدث خطأ أثناء تعديل التفقد');

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

    public function create_checkout2()
    {
        // try
        // { 
            $trip = Trip::all();
            $trip->with('students')->get();
            return $trip;
        // }
        // catch(\Exception $e)
        // {
        //     Log::error('Error view check out'.$e->getMessage());
        //     throw new \Exception('حدث خطأ أثناء عرض التفقد');
        // }
    }
//========================================================================================================================

    public function delete_checkout($id)
    {
        try
        {
            $checkout = CheckOut::find($id);
            if(!$checkout)
            {
                throw new \Exception('حدث خطأ أثناء حذف التفقد');
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