<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surahs', function (Blueprint $table) {
            // المعرف هو رقم السورة (1-114)
            $table->unsignedTinyInteger('id')->primary(); 
            
            $table->string('name_ar'); // الفاتحة
            $table->string('name_en'); // Al-Fatiha
            $table->unsignedSmallInteger('verses_count'); // عدد الآيات
            $table->string('revelation_type'); // مكية / مدنية
            
            // لا يوجد timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surahs');
    }
};
