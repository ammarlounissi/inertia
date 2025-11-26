<?php

namespace App\Http\Controllers;

use App\Models\Verse;
use Inertia\Inertia;
use Illuminate\Http\Request;

class VerseController extends Controller
{
    public function index()
    {
        // استخدام Eager Loading لتحميل جميع العلاقات، بالإضافة إلى علاقات متداخلة لاختبار أعمق
        $verses = Verse::with([
            'surah:id,name_ar,name_en', // علاقة الآية المباشرة بالسورة
            'juz:id,name',             // علاقة الآية المباشرة بالجزء
            'riwaya:id,name_ar',       // علاقة الآية المباشرة بالرواية
            'page',                    // علاقة الآية بالصفحة
            'page.surah:id,name_ar',   // علاقة متداخلة: السورة عبر الصفحة
            'page.juz:id,name',        // علاقة متداخلة: الجزء عبر الصفحة
        ])
        ->orderBy('id')
        ->limit(20) // عرض 20 آية للاختبار السريع
        ->get();

        // تحويل البيانات قبل إرسالها إلى Inertia للاحتفاظ بالمعلومات الضرورية فقط
        return Inertia::render('Quran/Index', [
            'verses' => $verses->map(function ($verse) {
                return [
                    'id' => $verse->id,
                    'text' => $verse->text,
                    'number_in_surah' => $verse->number_in_surah,
                    'surah' => $verse->surah,
                    'juz' => $verse->juz,
                    'riwaya' => $verse->riwaya,
                    'page' => [
                        'id' => $verse->page->id,
                        'surah' => $verse->page->surah, // التحقق من العلاقة المتداخلة 1
                        'juz' => $verse->page->juz,     // التحقق من العلاقة المتداخلة 2
                    ],
                ];
            }),
        ]);
    }
}