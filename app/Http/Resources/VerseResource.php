<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VerseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    // app/Http/Resources/VerseResource.php

public function toArray($request)
{
    return [
        'id' => $this->id,
        'number_in_surah' => $this->number_in_surah,
        'text' => $this->text,
        'line_start' => $this->line_start,
        'line_end' => $this->line_end,
        'surah' => [
            'id' => $this->surah->id,
            'name_ar' => $this->surah->name_ar,
        ],
        // ... بيانات العلاقات الأخرى المطلوبة
    ];
}
}
