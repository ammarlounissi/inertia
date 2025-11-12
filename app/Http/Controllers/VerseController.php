<?php

namespace App\Http\Controllers;

use App\Models\WarshAya;
use Inertia\Inertia;
use Illuminate\Http\Request;

class VerseController extends Controller
{
    /**
     * عرض صفحة آيات القرآن مع دعم التصفية.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        // استخدام التصفية (Pagination) لتجنب جلب كل 6211 آية دفعة واحدة
        // وافتراض أننا نريد 20 آية في كل صفحة.
        $verses = WarshAya::query()
            // يمكن إضافة عوامل تصفية (Filters) هنا بناءً على طلب المستخدم
            // مثال: ->where('sura_no', $request->input('sura'))
            ->orderBy('id')
            ->paginate(20) // 20 آية لكل صفحة
            ->withQueryString();

        // إرسال البيانات إلى صفحة Vue/Inertia
        return Inertia::render('Verses/Index', [
            'verses' => $verses,
        ]);
    }

    // يمكن إضافة دالة لعرض آية واحدة (show) لاحقاً إذا لزم الأمر
}