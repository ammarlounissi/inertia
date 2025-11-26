<?php

namespace Database\Seeders;

use App\Models\Riwaya;
use Illuminate\Database\Seeder;

class RiwayaSeeder extends Seeder
{
    public function run(): void
    {
        $riwayas = [
            [
                'name_ar' => 'رواية ورش عن نافع',
                'name_en' => "Warsh 'an Nafi'",
            ],
            [
                'name_ar' => 'رواية حفص عن عاصم',
                'name_en' => "Hafs 'an Asim",
            ],
            [
                'name_ar' => 'رواية قالون عن نافع',
                'name_en' => "Qalun 'an Nafi'",
            ],
        ];

        foreach ($riwayas as $riwaya) {
            // نستخدم firstOrCreate لتجنب تكرار البيانات إذا تم تشغيل الـ Seeder عدة مرات
            Riwaya::firstOrCreate(
                ['name_en' => $riwaya['name_en']], // البحث بواسطة الاسم الانجليزي
                ['name_ar' => $riwaya['name_ar']]
            );
        }
    }
}