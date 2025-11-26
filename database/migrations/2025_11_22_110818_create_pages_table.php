<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            
            // 1. المفتاح الأساسي (PK): رقم الصفحة الفعلي (1-604)
            // نستخدم SmallInteger لتقليل المساحة
            $table->unsignedSmallInteger('id')->primary()->comment('رقم الصفحة في المصحف 1-604');
            
            // 2. المفتاح الأجنبي لـ surahs
            // يجب أن يتطابق مع نوع surahs.id، وهو unsignedTinyInteger
            $table->unsignedTinyInteger('surah_id'); 
            
            // 3. المفتاح الأجنبي لـ juzs
            // يتطابق مع نوع juzs.id، وهو unsignedTinyInteger
            $table->unsignedTinyInteger('juz_id'); 

            // 4. تعريف القيود (Foreign Keys) يدوياً
            // نستخدم references و on بدلاً من constrained()
            
            $table->foreign('surah_id')
                  ->references('id')->on('surahs')
                  ->onDelete('restrict');

            $table->foreign('juz_id')
                  ->references('id')->on('juzs')
                  ->onDelete('restrict');
            
            // لا يوجد timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};