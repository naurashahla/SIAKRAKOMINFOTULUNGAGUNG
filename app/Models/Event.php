<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'startDate',
        'startTime',
        'endDate',
        'endTime',
        'location',
        'asal_surat',
        'keterangan',
        'document_path',
        'email',
        'notification_status',
        'reminder_sent',
        'day_reminder_sent',
        'hour_reminder_sent',
        'no_end_date'
    ];

    protected $casts = [
        'startDate' => 'date',
        'endDate' => 'date',
        'reminder_sent' => 'boolean',
        'day_reminder_sent' => 'boolean',
        'hour_reminder_sent' => 'boolean',
        'no_end_date' => 'boolean',
    ];

    /**
     * Mutators for time fields to ensure HH:MM format
     */
    public function setStartTimeAttribute($value)
    {
        // Ensure time is stored in HH:MM format only
        if ($value) {
            $this->attributes['startTime'] = substr($value, 0, 5);
        } else {
            $this->attributes['startTime'] = null;
        }
    }

    public function setEndTimeAttribute($value)
    {
        // Ensure time is stored in HH:MM format only
        if ($value) {
            $this->attributes['endTime'] = substr($value, 0, 5);
        } else {
            $this->attributes['endTime'] = null;
        }
    }

    /**
     * Get the pegawai recipients for this event.
     */
    public function recipients()
    {
        // Recipients are now users. Use dedicated pivot table 'event_user_recipients'.
        return $this->belongsToMany(\App\Models\User::class, 'event_user_recipients', 'event_id', 'user_id');
    }

    /**
     * Get all emails for this event from recipients
     */
    public function getAllEmails()
    {
        $emails = [];
        
        // Get emails from recipients
        foreach ($this->recipients as $recipient) {
            if (filter_var($recipient->email, FILTER_VALIDATE_EMAIL)) {
                $emails[] = $recipient->email;
            }
        }
        
        // Remove duplicates
        return array_unique($emails);
    }

    // Accessor untuk format tanggal yang user-friendly
    public function getFormattedStartDateAttribute()
    {
        return $this->startDate ? $this->startDate->format('d/m/Y') : null;
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->endDate ? $this->endDate->format('d/m/Y') : null;
    }

    // Scope untuk filter events
    public function scopeUpcoming($query)
    {
        return $query->where('startDate', '>=', now()->toDateString());
    }

    public function scopePast($query)
    {
        return $query->where('startDate', '<', now()->toDateString());
    }
}