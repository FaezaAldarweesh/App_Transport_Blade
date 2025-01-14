<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResources extends JsonResource
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
            'trip path' => $this->path->name,
            'trip bus' => $this->bus->name,
            'trip status' => $this->status == 0 ? 'منتهية' : 'جارية',
            'trip start_date' => $this->start_date,
            'trip end_date' => $this->end_date,
            'students' =>StudentResources::collection($this->whenLoaded('students')),
            'supervisors' => UserResources::collection($this->whenLoaded('users')),
            'drivers' => DriverResources::collection($this->whenLoaded('drivers')),
        ];
    }
}
