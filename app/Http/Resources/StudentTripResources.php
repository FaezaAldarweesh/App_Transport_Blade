<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentTripResources extends JsonResource
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
            'students' => StudentResources::collection(
                $this->whenLoaded('students'))->map(function ($student) {
                    return new StudentResources($student, $this->id);
                }),
        ];
    }
}
