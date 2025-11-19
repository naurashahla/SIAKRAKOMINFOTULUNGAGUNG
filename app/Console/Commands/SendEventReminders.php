<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Event reminders have been disabled in this installation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('[Scheduler] events:send-reminders invoked but reminders are disabled.');
        $this->info('Event reminders are disabled in this environment.');
        return 0;
    }
}
