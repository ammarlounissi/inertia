<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class ImportPages extends Command
{
    protected $signature = 'app:import-pages';
    protected $description = 'Import Pages data (1-604) from warsh_ayahs table';

    public function handle()
    {
        $this->info('Starting Pages Import...');

        // التحقق من وجود الجدول المصدر
        if (!DB::getSchemaBuilder()->hasTable('warsh_ayahs')) {
            $this->error('Table warsh_ayahs not found!');
            return;
        }

        // استعلام ذكي:
        // نقوم بتجميع البيانات حسب الصفحة
        // ونأخذ (MIN) لرقم السورة ورقم الجزء الظاهرين في تلك الصفحة
        // لتمثيل "بداية الصفحة"
        $pagesData = DB::table('warsh_ayahs')
            ->select('page', DB::raw('MIN(sura_no) as sura_id'), DB::raw('MIN(jozz) as juz_id'))
            ->groupBy('page')
            ->orderBy('page')
            ->get();

        $bar = $this->output->createProgressBar($pagesData->count());
        $bar->start();

        foreach ($pagesData as $data) {
            Page::updateOrCreate(
                ['id' => $data->page],
                [
                    'surah_id' => $data->sura_id,
                    'juz_id'   => $data->juz_id,
                ]
            );
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('All 604 Pages imported successfully!');
    }
}