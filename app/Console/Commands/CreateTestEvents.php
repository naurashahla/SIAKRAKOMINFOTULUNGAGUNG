<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Pegawai;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CreateTestEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:create-test-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test events for reminder system testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Creating test events for reminder system...");
        
        // Get some sample pegawai
        $pegawai = Pegawai::whereNotNull('email')->where('email', '!=', '')->take(3)->get();
        
        if ($pegawai->count() == 0) {
            $this->error("No pegawai with email found. Cannot create test events.");
            return 1;
        }
        
        // Create event for tomorrow (day reminder)
        $tomorrow = Carbon::tomorrow();
        $tomorrowEvent = Event::create([
            'title' => 'Test Event - Day Reminder (Tomorrow)',
            'description' => 'Test event created for testing day reminder functionality',
            'startDate' => $tomorrow,
            'startTime' => '10:00',
            'endTime' => '11:00',
            'location' => 'Meeting Room A',
            'notification_status' => 1,
            'reminder_sent' => false,
            'day_reminder_sent' => false,
            'hour_reminder_sent' => false
        ]);
        
        // Attach recipients to tomorrow's event
        $tomorrowEvent->recipients()->attach($pegawai->pluck('id'));
        $this->info("Created event for tomorrow: " . $tomorrowEvent->title);
        $this->info("Attached " . $pegawai->count() . " recipients");
        
        // Create event for 1 hour from now (hour reminder)
        $oneHourFromNow = Carbon::now()->addMinutes(60); // Exactly 1 hour
        $hourEvent = Event::create([
            'title' => 'Test Event - Hour Reminder (1 hour)',
            'description' => 'Test event created for testing hour reminder functionality',
            'startDate' => $oneHourFromNow->toDateString(),
            'startTime' => $oneHourFromNow->format('H:i'),
            'endTime' => $oneHourFromNow->addHour()->format('H:i'),
            'location' => 'Meeting Room B',
            'notification_status' => 1,
            'reminder_sent' => false,
            'day_reminder_sent' => false,
            'hour_reminder_sent' => false
        ]);
        
        // Attach recipients to hour event
        $hourEvent->recipients()->attach($pegawai->pluck('id'));
        $this->info("Created event for 1 hour from now: " . $hourEvent->title);
        $this->info("Event time: " . $oneHourFromNow->format('Y-m-d H:i:s'));
        $this->info("Attached " . $pegawai->count() . " recipients");
        
        $this->info("\nTest events created successfully!");
        $this->info("Recipients attached:");
        foreach ($pegawai as $p) {
            $this->info("  - {$p->nama} ({$p->email})");
        }
        
        $this->info("\nReminder functionality has been disabled in this installation. There is no scheduled reminder command to run.");
        
        return 0;
    }
}
