<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juz extends Model
{
    // تعطيل الطابع الزمني
    public $timestamps = false;

    // تعطيل الترقيم التلقائي لأننا سنحدد الـ ID يدوياً ليكون رقم الجزء
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
    ];
}
