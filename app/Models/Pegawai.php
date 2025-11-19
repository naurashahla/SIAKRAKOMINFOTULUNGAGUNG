<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'nama',
        'email',
        'bidang',
        'jabatan'
    ];

    /**
     * Get the events that this pegawai is a recipient of.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_recipients');
    }

    /**
     * Dynamically choose table: prefer `pegawai` if present, otherwise use `users`.
     */
    public function getTable()
    {
        if (Schema::hasTable('pegawai')) {
            return 'pegawai';
        }
        if (Schema::hasTable('users')) {
            return 'users';
        }
        return parent::getTable();
    }

    /**
     * Provide `nama` attribute fallback to `name` (users table).
     */
    public function getNamaAttribute($value)
    {
        if (!is_null($value) && $value !== '') {
            return $value;
        }
        return $this->attributes['name'] ?? null;
    }

    /**
     * Provide safe access for bidang/jabatan when columns may not exist on `users`.
     */
    public static function getBidangOptions()
    {
        try {
            $table = (new self)->getTable();
            if (!Schema::hasColumn($table, 'bidang')) {
                // No bidang column on current table; return options only from Option model
                if (class_exists(\App\Models\Option::class)) {
                    return \App\Models\Option::getOptionsByType('bidang');
                }
                return collect();
            }
            $fromModel = self::whereNotNull('bidang')->distinct()->pluck('bidang')->filter()->values();
            if (class_exists(\App\Models\Option::class)) {
                $fromOptions = \App\Models\Option::getOptionsByType('bidang');
                return $fromModel->merge($fromOptions)->unique()->sort()->values();
            }
            return $fromModel->sort()->values();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    public static function getJabatanOptions()
    {
        try {
            $table = (new self)->getTable();
            if (!Schema::hasColumn($table, 'jabatan')) {
                if (class_exists(\App\Models\Option::class)) {
                    return \App\Models\Option::getOptionsByType('jabatan');
                }
                return collect();
            }
            $fromModel = self::whereNotNull('jabatan')->distinct()->pluck('jabatan')->filter()->values();
            if (class_exists(\App\Models\Option::class)) {
                $fromOptions = \App\Models\Option::getOptionsByType('jabatan');
                return $fromModel->merge($fromOptions)->unique()->sort()->values();
            }
            return $fromModel->sort()->values();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    /**
     * Return the column name used for person name on the current table.
     * Prefer `nama` (legacy pegawai) and fallback to `name` (users).
     */
    public static function nameColumn()
    {
        try {
            $table = (new self)->getTable();
            if (Schema::hasColumn($table, 'nama')) {
                return 'nama';
            }
            if (Schema::hasColumn($table, 'name')) {
                return 'name';
            }
        } catch (\Throwable $e) {
            // ignore and fallback
        }
        return 'nama';
    }

    /**
     * Scope to get pegawai by bidang
     */
    public function scopeByBidang($query, $bidang)
    {
        return $query->where('bidang', $bidang);
    }

    /**
     * Get unique bidang options
     */
    
}
