<?php

namespace App\Services\ApiServices;

use App\Http\Traits\ApiResponseTrait;
use App\Models\Student;
use App\Models\Trip;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    use ApiResponseTrait;

    /**
     * Send notifications to the admin and to the students' families on the trip (start trip - end trip)
     *
     * @param Trip $trip
     * @return \Illuminate\Http\JsonResponse
     */
    public function tripNotification(Trip $trip)
    {
        try {
            $users = $trip->students()
                ->wherePivotIn('status', ['attendee', 'Transferred_from'])
                ->with('user')
                ->get()->pluck('user')->unique();
            $users = [...$users,...User::role('Admin', 'web')->get()];
            $status = $trip->status ? "بدأت رحلة " : "انتهت رحلة ";
            $name = $trip->name == 'delivery' ? "التوصيل " : "المدرسة ";
            $type = $trip->type == 'go' ? " ( ذهاب ) " : "( عودة ) ";
            $path = "خط " . $trip->path->name;
            $message = $status . $name . $type . $path;

            Notification::send($users, new UserNotification($message));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->failed_Response("لم يتم إرسال الإشعار للمستخدمين بسبب مشكلة ما", 400);
        }
    }

    /**
     * Send notifications to the parents of a specific student (check-in - get off the bus)
     *
     * @param Student $student
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function studentNotification(Student $student, $message)
    {
        try {
            $student->user->notify(new UserNotification($message));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->failed_Response("لم يتم إرسال الإشعار للمستخدمين بسبب مشكلة ما", 400);
        }
    }

    /**
     * send notification to admin
     *
     * @param $message
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function adminsNotification($message){
        try {
            $admins = User::role('Admin', 'web')->get();
            Notification::send($admins, new UserNotification($message));
        }catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->failed_Response("لم يتم إرسال الإشعار للمستخدمين بسبب مشكلة ما", 400);
        }
    }

}
