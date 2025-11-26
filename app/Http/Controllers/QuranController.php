<?php

namespace App\Http\Controllers;

use App\Models\Verse;
use App\Models\Surah;
use App\Http\Resources\VerseResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuranController extends Controller
{
    /**
     * عرض صفحة تصفح القرآن مع دعم البحث والتصفية.
     */
    public function index(Request $request)
    {
        // 1. تحديد الرواية الافتراضية (يمكن جلبها من إعدادات المستخدم)
        $riwayaId = $request->input('riwaya_id', 1);

        // 2. بناء الاستعلام الأساسي (Base Query)
        $query = Verse::query()
            ->where('riwaya_id', $riwayaId)
            ->with(['surah', 'page', 'juz']); // تجنب N+1

        // 3. تطبيق شروط البحث والتصفية (Conditional Filtering)
        $query->when($request->filled('search_term'), function ($q) use ($request) {
            $searchTerm = '%' . $request->input('search_term') . '%';
            // البحث عن النص في حقل 'text'
            return $q->where('text', 'LIKE', $searchTerm);
        });

        $query->when($request->filled('surah_id'), function ($q) use ($request) {
            // التصفية حسب السورة
            return $q->where('surah_id', $request->input('surah_id'));
        });

        $query->when($request->filled('juz_id'), function ($q) use ($request) {
            // التصفية حسب الجزء
            return $q->where('juz_id', $request->input('juz_id'));
        });
        
        // 4. جلب النتائج مع التصفح وحفظ متغيرات الـ Query String
        $verses = $query
            ->orderBy('id', 'asc')
            ->paginate(20)
            ->withQueryString();

        // 5. جلب قائمة السور للاستخدام في قوائم التصفية المنسدلة (Dropdowns)
        $surahs = Surah::select('id', 'name_ar')->orderBy('id')->get();


        // 6. إرجاع استجابة Inertia
        return Inertia::render('Quran/MushafViewer', [
            // استخدام الـ Resource لتهيئة البيانات
            'verses' => VerseResource::collection($verses), 
            
            // تمرير الفلاتر الحالية للواجهة للحفاظ على حالة الـ Form
            'filters' => $request->only(['riwaya_id', 'search_term', 'surah_id', 'juz_id']),
            
            // تمرير قائمة السور لإنشاء Dropdown
            'surahs' => $surahs,
        ]);
    }
}