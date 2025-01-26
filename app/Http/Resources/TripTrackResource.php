<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripTrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'trip_id'=>$this->trip_id,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
            'created_at'=>$this->created_at
        ];
    }
}
