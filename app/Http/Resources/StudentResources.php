<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $translations = [
            'attendee' => 'موجود',
            'absent' => 'غائب',
            'Moved_to' => 'مَنقول',
            'Transferred_from' => 'نُقل',
        ];

        // تحديد البيانات بناءً على الحالة
        $status = $translations[$this->pivot->status] ?? $this->pivot->status;
        $additionalInfo = $this->pivot->status === 'Transferred_from'
            ? $this->getLatestTransportStation()
            : $this->formatTimeToArabic($this->pivot->time_arrive);

        return [
            'student id' => $this->id,
            'student name' => $this->name,
            'student gender' => $this->gender,
            'student status' => $status,
            'time arrive' => $additionalInfo,
        ];
    }

    /**
     * Format time to Arabic style (AM/PM).
     *
     * @param string $time
     * @return string
     */
    private function formatTimeToArabic($time): string
    {
        return Carbon::parse($time)->format('h:i') . ' ' . 
               (Carbon::parse($time)->format('A') === 'AM' ? 'ص' : 'م');
    }

    /**
     * Get the latest transport station name.
     *
     * @return string
     */
    private function getLatestTransportStation(): string
    {
        $latestTransport = $this->transports->last();

        return $latestTransport 
            ? $latestTransport->station->name 
            : 'لا يوجد نقل';
    }
}
 