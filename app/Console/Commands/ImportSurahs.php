<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Surah;

class ImportSurahs extends Command
{
    /**
     * اسم الأمر الذي ستكتبه في التيرمينال
     */
    protected $signature = 'app:import-surahs';

    /**
     * وصف الأمر
     */
    protected $description = 'Import Surahs from warsh_ayahs table and populate surahs table';

    public function handle()
    {
        $this->info('Starting Import...');

        // 1. التأكد من وجود الجدول المصدر
        if (!DB::getSchemaBuilder()->hasTable('warsh_ayahs')) {
            $this->error('Table warsh_ayahs not found! Please import the SQL file first.');
            return;
        }

        // 2. جلب البيانات مجمعة حسب السورة لحساب عدد الآيات
        // هذا الاستعلام السريع يجلب الاسم ورقم السورة ويحسب عدد الآيات في آن واحد
        $surahsData = DB::table('warsh_ayahs')
            ->select(
                'sura_no', 
                'sura_name_ar', 
                'sura_name_en', 
                DB::raw('count(*) as verses_count')
            )
            ->groupBy('sura_no', 'sura_name_ar', 'sura_name_en')
            ->orderBy('sura_no')
            ->get();

        $bar = $this->output->createProgressBar(count($surahsData));
        $bar->start();

        foreach ($surahsData as $data) {
            // تحديد نوع النزول (لأن الجدول المصدر لا يحتوي على هذه المعلومة)
            $revelationType = $this->getRevelationType($data->sura_no);

            // تنظيف الأسماء من المسافات الزائدة إن وجدت
            $nameAr = trim($data->sura_name_ar); 
            $nameEn = trim($data->sura_name_en);

            Surah::updateOrCreate(
                ['id' => $data->sura_no], // البحث بالرقم
                [
                    'name_ar' => $nameAr,
                    'name_en' => $nameEn,
                    'verses_count' => $data->verses_count,
                    'revelation_type' => $revelationType,
                ]
            );

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Surahs imported successfully!');
    }

    /**
     * دالة مساعدة لتحديد مكان النزول بناء على رقم السورة
     */
    private function getRevelationType($suraNo)
    {
        // أرقام السور المدنية (المشهور منها)
        $madaniSurahs = [
            2, 3, 4, 5, 8, 9, 13, 22, 24, 33, 47, 48, 49, 
            57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 76, 98, 110
        ];

        return in_array($suraNo, $madaniSurahs) ? 'مدنية' : 'مكية';
    }
}