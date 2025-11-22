<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verses', function (Blueprint $table) {
            // المعرف: رقم الآية التسلسلي في المصحف (1-6214)
            // نستخدم MediumInteger لأنه يستوعب حتى 16 مليون (مناسب جداً)
            $table->unsignedMediumInteger('id')->primary(); 

            $table->unsignedSmallInteger('number_in_surah'); // رقم الآية في السورة
            $table->text('text'); // نص الآية (ضروري)
            $table->unsignedTinyInteger('line_start'); // سطر البداية
            $table->unsignedTinyInteger('line_end');   // سطر النهاية

            // --- المفاتيح الأجنبية ---
            
            // 1. ربط الصفحة (مفتاحها smallInteger)
            $table->unsignedSmallInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

            // 2. ربط السورة (مفتاحها tinyInteger)
            $table->unsignedTinyInteger('surah_id');
            $table->foreign('surah_id')->references('id')->on('surahs')->onDelete('cascade');

            // 3. ربط الجزء (مفتاحه tinyInteger)
            $table->unsignedTinyInteger('juz_id');
            $table->foreign('juz_id')->references('id')->on('juzs')->onDelete('cascade');

            // 4. ربط الرواية (مفتاحها BigInteger افتراضي)
            // نستخدم foreignId العادية لأن جدول riwayas يستخدم الـ id الافتراضي
            $table->foreignId('riwaya_id')->constrained('riwayas')->onDelete('cascade');

            // لا توجد طوابع زمنية
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verses');
    }
};