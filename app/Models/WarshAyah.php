<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarshAyah extends Model
{
    protected $table = 'warsh_ayahs';

    protected $fillable = [
        'jozz',
        'page',
        'sura_no',
        'sura_name_en',
        'sura_name_ar',
        'line_start',
        'line_end',
        'aya_no',
        'aya_text'
    ];
}
