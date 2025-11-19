<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class QuickTelegramTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:quick-test {message? : Pesan yang ingin dikirim}';

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
        Log::warning('[Telegram] QuickTelegramTest invoked but Telegram support has been disabled.');
        $this->info('Telegram support has been disabled in this installation.');
        return Command::SUCCESS;
    }
}