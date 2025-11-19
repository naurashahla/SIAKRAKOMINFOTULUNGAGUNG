<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestTelegramReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:test-reminder {--event-id= : ID event spesifik untuk ditest} {--type=reminder : Tipe notifikasi (created|updated|reminder|cancelled)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Telegram support has been disabled';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::warning('[Telegram] TestTelegramReminder invoked but Telegram support has been disabled.');
        $this->info('Telegram support has been disabled in this installation.');
        return Command::SUCCESS;
    }
    // All interactive logic removed. This command now only reports Telegram disabled.
}