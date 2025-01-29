<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransportResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'students' => $this->whenLoaded('student', function () {
                return [
                    'name' => $this->student->name,
                ];
            }) ?? [],
            'name' => $this->trip->name == 'delivery' ? 'توصيل' : 'مدرسية', 
            'type' => $this->trip->type == 'go' ? 'ذهاب' : 'عودة', 
            'bus' => $this->trip->bus->name,
            'supervisor' => $this->trip->users->map(function ($user) {
                return [
                    'name' => $user->name,
                ];
            }),
            'driver' => $this->trip->drivers->map(function ($driver) {
                return [
                    'name' => $driver->name,
                ];
            }),
            'path' => $this->trip->path->name, 
            'station name' => $this->station->name, 
            'station time' => $this->formatTimeToArabic($this->station->time_arrive), 
            'start_date' =>  $this->formatTimeToArabic($this->trip->start_date),
            'end_date' => $this->formatTimeToArabic($this->trip->end_date),
        ];
    }
    private function formatTimeToArabic($time): string
    {
        return Carbon::parse($time)->format('h:i') . ' ' . 
               (Carbon::parse($time)->format('A') === 'AM' ? 'ص' : 'م');
    }
}
