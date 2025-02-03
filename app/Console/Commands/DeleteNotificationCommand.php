<?php

namespace App\Console\Commands;

use App\Jobs\DeleteNotificationJob;
use Illuminate\Console\Command;

class DeleteNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-notification-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DeleteNotificationJob::dispatch();
        $this->info('The command delete-trip-track-command is done');
    }
}
