<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // bảng chi tiết đánh giá
        Schema::create('evaluation_details', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('score');
            $table->foreignId('evaluation_criteria_id')->constrained('evaluation_criteria')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_details');
    }
};
