<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warsh_ayahs', function (Blueprint $table) {
            // المعرف: رقم الآية التسلسلي في المصحف (1-6214)
            $table->unsignedMediumInteger('id')->primary();

            $table->unsignedTinyInteger('jozz')->comment('رقم الجزء');
            $table->unsignedSmallInteger('page')->comment('رقم الصفحة');
            $table->unsignedTinyInteger('sura_no')->comment('رقم السورة');
            $table->string('sura_name_en')->nullable(); // قد يكون مفيداً للربط
            $table->string('sura_name_ar')->nullable();
            $table->unsignedTinyInteger('line_start');
            $table->unsignedTinyInteger('line_end');
            $table->unsignedSmallInteger('aya_no')->comment('رقم الآية في السورة');
            $table->text('aya_text');
            
            // لا حاجة لـ timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warsh_ayahs');
    }
};