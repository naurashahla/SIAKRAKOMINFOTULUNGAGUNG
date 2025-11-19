<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TelegramTestCommand extends Command
{
    protected $signature = 'telegram:test {--quick} {--event=} {--type=reminder}';
    protected $description = 'Telegram support has been disabled';

    public function handle()
    {
        Log::warning('[Telegram] TelegramTestCommand invoked but Telegram support has been disabled.');
        $this->info('Telegram support has been disabled in this installation.');
        return Command::SUCCESS;
    }
    // All test logic removed. Telegram support has been disabled.
}