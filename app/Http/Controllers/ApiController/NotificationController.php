<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Http\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    use ApiResponseTrait;

    /**
     * Return notifications for the logged in userز
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userNotification()
    {
        $notifications = auth()->user()->notifications()
            ->where('created_at', '>=', Carbon::now()->subDays(4))
            ->latest()->get();
        return $this->success_Response(NotificationResource::collection($notifications), 'تمت العملية بنجاح', 200);
    }

    public function readNotification()
    {
        try {
            auth()->user()->unreadNotifications->markAsRead();
            return $this->success_Response(null, 'تمت العملية بنجاح', 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->failed_Response('الإشعار غير موجود عند هذا المستخدم', 400);
        }
    }
}
