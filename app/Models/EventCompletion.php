<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCompletion extends Model
{
    protected $table = 'event_completions';

    protected $fillable = [
        'event_id',
        'user_id',
        'notulen',
        'files'
    ];

    protected $casts = [
        'files' => 'array'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
