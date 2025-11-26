<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    public $timestamps = false;
    public $incrementing = false; // لأننا سندخل الـ ID يدوياً

    protected $fillable = [
        'id',
        'name_ar',
        'name_en',
        'verses_count',
        'revelation_type',
    ];
}
