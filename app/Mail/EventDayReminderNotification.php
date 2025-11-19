<?php

namespace App\Mail;

class EventDayReminderNotification
{
    // Day-before reminder emails disabled. Class kept as a harmless stub.
    public $event;

    public function __construct($event = null)
    {
        $this->event = $event;
    }
}
