<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('semester_scores', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->enum('semester', ['Học Kỳ 1', 'Học Kỳ 2', 'Học Kỳ 3']);
            $table->date('evaluation_start');
            $table->date('evaluation_end');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semester_scores');
    }
};
