<?php

namespace App\Console\Commands;

use App\Jobs\DeleteTripTrackJob;
use Illuminate\Console\Command;

class DeleteTripTrackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-trip-track-command';

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
        DeleteTripTrackJob::dispatch();
        $this->info('The command delete-trip-track-command is done');
    }
}
