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
        Schema::create('standards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('weight');
            $table->boolean('status')->nullable()->default(true);
            $table->uuid('question_category_id')->nullable();
            $table->foreign('question_category_id')->references('id')->on('question_categories')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standards');
    }
};
