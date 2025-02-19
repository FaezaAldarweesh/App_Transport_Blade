<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // تسجيل مسارات البث لـ Web بدون JWT
        Broadcast::routes();

        // تسجيل مسارات البث لـ API مع JWT
        Broadcast::routes([
            'middleware' => ['auth:api'],
            'prefix' => 'api' // تأكد من أن المسار يتم توجيهه إلى `/api/broadcasting/auth`
        ]);

        require base_path('routes/channels.php');
    }
}
