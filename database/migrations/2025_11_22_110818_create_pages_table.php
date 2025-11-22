<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            // رقم الصفحة 1-604
            $table->unsignedSmallInteger('id')->primary(); 
            
            // مفاتيح أجنبية
            // نستخدم restrict لمنع حذف السورة/الجزء إذا كانت مرتبطة بصفحة
            $table->foreignId('surah_id')->constrained('surahs')->onDelete('restrict');
            $table->foreignId('juz_id')->constrained('juzs')->onDelete('restrict');

            // لا يوجد timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};