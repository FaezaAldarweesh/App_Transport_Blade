<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class detailsTripResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'trip id' => $this->id,
            'trip name' => $this->name == 'delivery' ? 'توصيل' : 'مدرسية', 
            'trip type' => $this->type == 'go' ? 'ذهاب' : 'عودة', 
            'trip bus' => $this->bus->name,
            'trip status' => $this->status == 0 ? 'منتهية' : 'جارية',
            'trip start_date' =>  $this->formatTimeToArabic($this->start_date),
            'trip end_date' => $this->formatTimeToArabic($this->end_date),
            'the number of students' => $this->students->count(),
            'supervisors' => UserResources::collection($this->whenLoaded('users')),
            'drivers' => DriverResources::collection($this->whenLoaded('drivers')),
            'trip stations' => $this->formatStations(),
            'students' => StudentResources::collection(
                $this->whenLoaded('students')->filter(function ($student) {
                    return $student->user_id === Auth::id();
                })
            ),
        ];
    }
    /**
     * تنسيق المحطات حسب نوع الرحلة وترتيبها تصاعديًا
     */
    private function formatStations()
    {
        return $this->path->stations
            ->map(function ($station) {
                return [
                    'station id' => $station->id,
                    'station name' => $station->name,
                    'station status' => $station->status == 0 ? 'لم يتم الوصول لها بعد' : 'تم الوصول إليها',
                    'time' => $this->type == 'go' ? $this->formatTimeToArabic($station->time_go) : $this->formatTimeToArabic($station->time_back),
                    'latitude' => $station->latitude,
                    'longitude' => $station->longitude,
                    'raw_time' => $this->type == 'go' ? $station->time_go : $station->time_back, // لاستخدامه في الترتيب
                ];
            })
            ->filter(fn($station) => $station['raw_time'] !== null) // تجاهل المحطات بدون وقت
            ->sortBy('raw_time') // ترتيب تصاعدي حسب الوقت
            ->values() // إعادة تعيين الفهارس
            ->map(fn($station) => collect($station)->except('raw_time')); // إزالة الحقل المؤقت بعد الترتيب
    }

    private function formatTimeToArabic($time): ?string
    {
        if (!$time) {
            return null;
        }
        
        $carbonTime = Carbon::parse($time);
        $period = $carbonTime->format('A') === 'AM' ? 'ص' : 'م';

        return $carbonTime->format('h:i') . ' ' . $period;
    }
}
