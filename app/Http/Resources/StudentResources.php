<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResources extends JsonResource
{
    private $tripId;

    public function __construct($resource, $tripId)
    {
        parent::__construct($resource);
        $this->tripId = $tripId;
    }

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $translations = [
            'attendee' => 'موجود',
            'absent' => 'غائب',
            'Moved_to' => 'نُقل',
            'Transferred_from' => 'مَنقول',
        ];

        $status = $translations[$this->pivot->status] ?? $this->pivot->status;
        $additionalInfo = $this->pivot->status === 'Transferred_from'
            ? $this->getLatestTransportStation()
            : $this->formatTimeToArabic($this->pivot->time_arrive);

        $trip_id = $this->tripId;
        $student_id = $this->id;
        $checkout = $this->checkout($trip_id,$student_id);

        return [
            'trip id' => $this->tripId, // الآن لديك trip id داخل الريسورس
            'student id' => $this->id,
            'student name' => $this->name,
            'student gender' => $this->gender,
            'student status' => $status,
            'time arrive' => $additionalInfo,
            'checkout' => $checkout ? ($checkout->checkout == 0 ? 'غياب' : 'حضور') : 'غير محدد',
        ];
    }

    private function formatTimeToArabic($time): string
    {
        return Carbon::parse($time)->format('h:i') . ' ' . 
               (Carbon::parse($time)->format('A') === 'AM' ? 'ص' : 'م');
    }

    private function getLatestTransportStation(): string
    {
        $latestTransport = $this->transports->last();
        return $latestTransport ? $latestTransport->station->name : 'لا يوجد نقل';
    }

    private function checkout($trip_id,$student_id)
    {
        return $checkout = Checkout::where('trip_id', $trip_id)
                            ->where('student_id', $student_id)
                            ->whereDate('created_at',Carbon::now())
                            ->first();
    }
}

 