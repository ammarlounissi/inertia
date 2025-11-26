<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verse extends Model
{
    public $timestamps = false;
    public $incrementing = false; // لأننا سندخل الـ ID يدوياً من المصدر

    protected $fillable = [
        'id',
        'number_in_surah',
        'text',
        'line_start',
        'line_end',
        'page_id',
        'surah_id',
        'juz_id',
        'riwaya_id',
    ];

    // العلاقات
    public function surah(): BelongsTo
    {
        return $this->belongsTo(Surah::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function juz(): BelongsTo
    {
        return $this->belongsTo(Juz::class);
    }

    public function riwaya(): BelongsTo
    {
        return $this->belongsTo(Riwaya::class);
    }
}