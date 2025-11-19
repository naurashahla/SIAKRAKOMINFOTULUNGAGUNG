<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $table = 'options';

    protected $fillable = [
        'type',
        'value',
    ];

    public static function getOptionsByType(string $type)
    {
        return self::where('type', $type)->orderBy('value')->pluck('value')->values();
    }
}
