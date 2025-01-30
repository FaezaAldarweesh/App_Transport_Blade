<?php

namespace App\Services\ApiServices;

use App\Models\Trip;
use App\Models\Station;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Request;

class StationService {
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait;
    /**
     * method to view all stations 
     * @param   Request $request
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function all_station_trip($trip_id){
        try {
            $trip = Trip::find($trip_id);
            $trip->load('path.stations');
            return $trip;
        } catch (\Throwable $th) { Log::error($th->getMessage()); return $this->failed_Response('حدث خطأ أثناء محاولة الوصول إلى المحطة', 400);}
    }
    //========================================================================================================================
    public function update_station_status($station_id)
{
    try {
        $station = Station::findOrFail($station_id);
        $trip = Trip::where('path_id', $station->path_id)
                    ->where('status', 1)
                    ->first();

        if (auth()->user()->role == 'supervisor' && !$trip) {
            throw new \Exception('لا يمكن تعديل حالة المحطة إلا إذا كانت الرحلة جارية');
        }

        if (!$trip) {
            throw new \Exception('لم يتم العثور على رحلة نشطة لهذا الطريق');
        }

        // تحديد نوع الرحلة (ذهاب أو إياب)
        $orderColumn = $trip->type == 'go' ? 'time_go' : 'time_back';

        // جلب جميع المحطات المرتبطة بالطريق وترتيبها حسب وقت الوصول المناسب
        $stations = Station::where('path_id', $station->path_id)
                           ->orderBy($orderColumn, 'asc')
                           ->get();

        // التحقق من ترتيب المحطات
        foreach ($stations as $key => $currentStation) {
            if ($currentStation->id == $station_id) {
                // التحقق من أن المحطة السابقة تم الوصول لها قبل تعديل الحالية
                if ($key > 0) {
                    $previousStation = $stations[$key - 1];
                    if ($previousStation->status == 0) {
                        throw new \Exception('لا يمكن تعديل حالة هذه المحطة قبل تعديل المحطة السابقة لها');
                    }
                }
                break;
            }
        }

        // تحديث حالة المحطة
        $station->status = !$station->status;
        $station->save();

        return $station;
    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return $this->failed_Response($e->getMessage(), 404);
    } catch (\Throwable $th) {
        Log::error($th->getMessage());
        return $this->failed_Response('Error updating station status', 400);
    }
}
}