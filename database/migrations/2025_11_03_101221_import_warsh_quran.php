<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warsh_ayahs', function (Blueprint $table) {
            $table->id();
            $table->integer('jozz');
            $table->string('page');
            $table->integer('sura_no');
            $table->string('sura_name_en');
            $table->string('sura_name_ar');
            $table->integer('line_start');
            $table->integer('line_end');
            $table->integer('aya_no');
            $table->text('aya_text');
            $table->timestamps();
        });

        $sqlFilePath = database_path('data/warshData_v2-1.sql');

        if (!file_exists($sqlFilePath)) {
            throw new \Exception("SQL file not found: " . $sqlFilePath);
        }

        DB::unprepared(file_get_contents($sqlFilePath));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // حذف الجدول الرئيسي إذا وجد (تعدل حسب احتياجاتك)
        Schema::dropIfExists('warsh_ayahs');
        
        // إذا كان هناك جداول أخرى، أضفها هنا، مثل:
        // Schema::dropIfExists('another_table');
    }
};