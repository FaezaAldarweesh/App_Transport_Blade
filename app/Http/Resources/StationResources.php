<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StationResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'station id' => $this->id,
            'station name' => $this->name, 
            'station time arrive' => $this->formatTimeToArabic($this->time_arrive), 
        ];
    }
    private function formatTimeToArabic($time)
    {
        $formattedTime = Carbon::parse($time)->format('h:i'); // تنسيق 12 ساعة مع الدقائق
        $period = Carbon::parse($time)->format('A') == 'AM' ? 'ص' : 'م'; // تحديد الفترة

        return $formattedTime . ' ' . $period; // دمج الوقت مع الفترة
    }
}
