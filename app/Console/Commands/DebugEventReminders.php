<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Pegawai;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DebugEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:debug-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug event reminder system to check data and relationships';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("=== DEBUGGING EVENT REMINDER SYSTEM ===\n");
        
        // Check tomorrow's events
        $tomorrow = Carbon::tomorrow();
        $this->info("Tomorrow's date: " . $tomorrow->format('Y-m-d'));
        
        $tomorrowEvents = Event::whereDate('startDate', $tomorrow->toDateString())->get();
        $this->info("Events for tomorrow: " . $tomorrowEvents->count());
        
        foreach ($tomorrowEvents as $event) {
            $this->info("\n--- Event: {$event->title} ---");
            $this->info("Start Date: {$event->startDate}");
            $this->info("Start Time: {$event->startTime}");
            $this->info("Day Reminder Sent: " . ($event->day_reminder_sent ? 'Yes' : 'No'));
            
            // Check recipients
            $recipients = $event->recipients;
            $this->info("Recipients count: " . $recipients->count());
            
            if ($recipients->count() > 0) {
                foreach ($recipients as $recipient) {
                    $this->info("  - {$recipient->nama} ({$recipient->email})");
                }
            }
            
            // Check getAllEmails method
            $allEmails = $event->getAllEmails();
            $this->info("All emails: " . json_encode($allEmails));
        }
        
        // Check today's events for hour reminders
        $this->info("\n=== HOUR REMINDERS DEBUG ===");
        $now = Carbon::now();
        $oneHourFromNow = $now->copy()->addHour();
        
        $this->info("Current time: " . $now->format('Y-m-d H:i:s'));
        $this->info("One hour from now: " . $oneHourFromNow->format('Y-m-d H:i:s'));
        
        $todayEvents = Event::whereDate('startDate', $now->toDateString())->get();
        $this->info("Events for today: " . $todayEvents->count());
        
        foreach ($todayEvents as $event) {
            if ($event->startTime) {
                $eventDateTime = Carbon::parse($event->startDate->format('Y-m-d') . ' ' . $event->startTime);
                $timeDifference = $now->diffInMinutes($eventDateTime, false);
                
                $this->info("\n--- Event: {$event->title} ---");
                $this->info("Event DateTime: " . $eventDateTime->format('Y-m-d H:i:s'));
                $this->info("Time difference: {$timeDifference} minutes");
                $this->info("Hour Reminder Sent: " . ($event->hour_reminder_sent ? 'Yes' : 'No'));
                $this->info("Recipients count: " . $event->recipients->count());
                $this->info("All emails: " . json_encode($event->getAllEmails()));
                
                if ($timeDifference >= 55 && $timeDifference <= 65) {
                    $this->info("*** ELIGIBLE FOR HOUR REMINDER ***");
                }
            }
        }
        
        // Check Pegawai table
        $this->info("\n=== PEGAWAI TABLE DEBUG ===");
        $pegawaiCount = Pegawai::count();
        $this->info("Total Pegawai records: " . $pegawaiCount);
        
        $pegawaiWithEmail = Pegawai::whereNotNull('email')->where('email', '!=', '')->count();
        $this->info("Pegawai with email: " . $pegawaiWithEmail);
        
        if ($pegawaiWithEmail > 0) {
            $samplePegawai = Pegawai::whereNotNull('email')->where('email', '!=', '')->take(3)->get();
            foreach ($samplePegawai as $pegawai) {
                $this->info("  - {$pegawai->nama} ({$pegawai->email})");
            }
        }
        
        return 0;
    }
}
