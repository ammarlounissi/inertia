<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('juzs', function (Blueprint $table) {
            // نستخدم unsignedTinyInteger لأن الأرقام من 1 إلى 30 فقط
            // نجعلها primary يدوياً
            $table->unsignedTinyInteger('id')->primary(); 
            $table->string('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('juzs');
    }
};