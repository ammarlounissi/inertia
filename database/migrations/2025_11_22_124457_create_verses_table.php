<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verses', function (Blueprint $table) {
            // المعرف: رقم الآية التسلسلي في المصحف. صحيح.
            $table->unsignedMediumInteger('id')->primary(); 

            $table->unsignedSmallInteger('number_in_surah');
            $table->text('text');
            $table->unsignedTinyInteger('line_start');
            $table->unsignedTinyInteger('line_end');

            // --- المفاتيح الأجنبية ---
            
            // 1. ربط الصفحة (مفتاحها SmallInteger في جدول pages)
            $table->unsignedSmallInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

            // 2. ربط السورة (مفتاحها TinyInteger في جدول surahs)
            $table->unsignedTinyInteger('surah_id');
            $table->foreign('surah_id')->references('id')->on('surahs')->onDelete('cascade');

            // 3. ربط الجزء (مفتاحه TinyInteger في جدول juzs)
            $table->unsignedTinyInteger('juz_id');
            $table->foreign('juz_id')->references('id')->on('juzs')->onDelete('cascade');

            // 4. ربط الرواية (نفترض أن مفتاحها BigInteger الافتراضي)
            // نستخدم foreignId هنا لأننا نفترض أن riwayas.id هو UNSIGNED BIGINT
            $table->foreignId('riwaya_id')->constrained('riwayas')->onDelete('cascade');

            // لا توجد طوابع زمنية
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verses');
    }
};