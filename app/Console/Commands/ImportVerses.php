<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Verse;
use App\Models\Riwaya;

class ImportVerses extends Command
{
    protected $signature = 'app:import-verses';
    protected $description = 'Import Verses from warsh_ayahs table linked to Warsh Riwaya';

    public function handle()
    {
        $this->info('Starting Verses Import...');

        $riwayaId = 1;
        $warshRiwayaName = 'رواية ورش عن نافع'; 
        
        if (!Riwaya::where('id', $riwayaId)->exists()) {
             $this->error("Error: Riwaya with ID $riwayaId not found in the 'riwayas' table! Please ensure the riwayas table is seeded.");
             return;
        }

        $this->info("Linking to Riwaya: {$warshRiwayaName} (ID: $riwayaId)");

        DB::table('warsh_ayahs')->orderBy('id')->chunk(500, function ($ayahs) use ($riwayaId) {
            
            $versesToImport = [];

            foreach ($ayahs as $ayah) {
                
                // ----------------------------------------------------
                // ✨ المعالجة الجديدة لحقل الصفحة (page)
                // ----------------------------------------------------
                $pageValue = $ayah->page;
                
                // إذا كان يحتوي على نطاق (مثل '317-318')، نأخذ القيمة الأولى فقط
                if (str_contains($pageValue, '-')) {
                    $pageParts = explode('-', $pageValue);
                    $pageValue = $pageParts[0];
                }
                
                // نحول القيمة المستخلصة إلى عدد صحيح
                $pageId = (int) $pageValue;
                // ----------------------------------------------------

                $versesToImport[] = [
                    'id'              => $ayah->id,
                    'number_in_surah' => $ayah->aya_no,
                    'text'            => $ayah->aya_text,
                    'line_start'      => $ayah->line_start,
                    'line_end'        => $ayah->line_end,
                    'page_id'         => $pageId, // استخدام القيمة المصححة
                    'surah_id'        => $ayah->sura_no,
                    'juz_id'          => $ayah->jozz,
                    'riwaya_id'       => $riwayaId,
                ];
            }
            
            Verse::upsert(
                $versesToImport, 
                ['id'], 
                [
                    'number_in_surah', 'text', 'line_start', 'line_end', 
                    'page_id', 'surah_id', 'juz_id', 'riwaya_id'
                ] 
            );

            $this->info('Imported/Updated chunk of ' . count($versesToImport) . ' verses...');
        });

        $this->newLine();
        $this->info('All Verses imported successfully! ✅');
    }
}