<?php

namespace App\Mail;

class EventReminderNotification
{
    // Reminder emails have been disabled. This stub keeps class autoloadable
    // to avoid errors in places where the class name is referenced.
    public $event;

    public function __construct($event = null)
    {
        $this->event = $event;
    }
}
