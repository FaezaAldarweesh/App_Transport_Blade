<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $createdAt = Carbon::parse($this->created_at)->locale('ar');

        // إذا كان التاريخ هو الأمس، استخدم "البارحة"
        $create = $createdAt->isYesterday() ? 'البارحة' : $createdAt->diffForHumans();

        return [
            'id' => $this->id,
            'data' => $this->data,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
            'create' => $create,
        ];
    }
}
