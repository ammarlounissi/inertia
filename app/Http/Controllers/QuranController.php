<?php

namespace App\Http\Controllers;

use App\Models\Juz;
use App\Models\Page;
use App\Models\Surah;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuranController extends Controller
{
    /**
     * عرض صفحة المصحف مع إمكانية التنقل بالصفحة، السورة، أو الجزء.
     */
    public function index(Request $request)
    {
        // تحديد رقم الصفحة الافتراضي (صفحة البداية) أو استلامه من الطلب
        $pageNumber = $request->query('page', 1);

        // إذا كان التنقل بواسطة السورة
        if ($surahId = $request->query('surah')) {
            $surah = Surah::find($surahId);
            if ($surah) {
                // افتراضياً، لديك حقل في جدول السور يحدد صفحة بداية السورة
                // لغرض هذا المثال، سأفترض وجود حقل `start_page` في موديل `Surah`.
                // (يجب أن يتم ملء هذه البيانات من قاعدة بيانات المصحف)
                $startPage = Page::whereHas('verses', function ($query) use ($surahId) {
                    $query->where('surah_id', $surahId);
                })->min('id');

                $pageNumber = $startPage ?? 1;
            }
        }

        // إذا كان التنقل بواسطة الجزء
        if ($juzId = $request->query('juz')) {
            $juz = Juz::find($juzId);
            if ($juz) {
                // افتراضياً، لديك حقل في جدول الأجزاء يحدد صفحة بداية الجزء
                // لغرض هذا المثال، سأفترض وجود حقل `start_page` في موديل `Juz`.
                $startPage = Page::whereHas('verses', function ($query) use ($juzId) {
                    $query->where('juz_id', $juzId);
                })->min('id');

                $pageNumber = $startPage ?? 1;
            }
        }

        // التأكد من أن رقم الصفحة ضمن النطاق (1-604)
        $pageNumber = max(1, min(604, (int) $pageNumber));
        
        // جلب بيانات الصفحة الحالية مع علاقاتها
        $currentPage = Page::with(['verses' => function ($query) {
            // جلب الآيات المرتبة داخل الصفحة
            $query->orderBy('id', 'asc');
        }, 'verses.surah', 'verses.juz', 'verses.riwaya'])->find($pageNumber);


        // إذا لم يتم العثور على الصفحة (رغم أننا قمنا بالتأكد من النطاق)، نعرض صفحة 1
        if (! $currentPage) {
            $currentPage = Page::with(['verses.surah', 'verses.juz', 'verses.riwaya'])->find(1);
        }

        // جلب قائمة السور والأجزاء لاستخدامها في شريط التنقل
        $surahs = Surah::orderBy('id')->get(['id', 'name_ar']);
        $juzs = Juz::orderBy('id')->get(['id', 'name']);

        return Inertia::render('Quran/Mushaf', [
            'currentPage' => $currentPage,
            'surahs' => $surahs,
            'juzs' => $juzs,
            'nextPage' => $pageNumber < 604 ? $pageNumber + 1 : null,
            'prevPage' => $pageNumber > 1 ? $pageNumber - 1 : null,
            'initialPageNumber' => (int) $pageNumber,
        ]);
    }
}