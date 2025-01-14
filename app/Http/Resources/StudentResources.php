<?php

namespace App\Http\Resources;

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
        return [
            'student id' => $this->id,
            'student name' => $this->name, 
            'student status' => $this->pivot->status,
            'student time arrive' => $this->pivot->time_arrive,
        ];
    }
}
