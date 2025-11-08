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
        Schema::create('verses', function (Blueprint $table) {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verses');
    }
};