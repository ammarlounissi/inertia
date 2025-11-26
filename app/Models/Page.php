<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'surah_id',
        'juz_id',
    ];

    // علاقات اختيارية (Best Practice)
    public function surah(): BelongsTo
    {
        return $this->belongsTo(Surah::class);
    }

    public function juz(): BelongsTo
    {
        return $this->belongsTo(Juz::class);
    }
}