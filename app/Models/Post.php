<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'surah_id',
        'start_verse',
        'end_verse',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ayahs()
    {
        return $this->hasMany(WarshAyah::class, 'sura_no', 'surah_id')
                    ->whereBetween('aya_no', [$this->start_verse, $this->end_verse])
                    ->orderBy('aya_no');
    }
}
