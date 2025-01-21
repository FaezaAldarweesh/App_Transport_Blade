<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'checkout id' => $this->id,
            'trip name' => $this->name == 'delivery' ? 'توصيل' : 'مدرسية', 
            'trip type' => $this->type == 'go' ? 'ذهاب' : 'عودة', 
            'checkout student' => $this->student->name,
            'checkout checkout' => $this->checkout == 0 ? 'غياب' : 'حضور', 
            'checkout date' => Carbon::parse($this->created_at)->format('H:i:s d/m/Y'), 
        ];
    }
}
