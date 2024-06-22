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
        Schema::create('review_docs', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->uuid('standard_criterias_id')->nullable();
            $table->foreign('standard_criterias_id')->references('id')->on('standard_criterias')->nullable()->onDelete('cascade');
            $table->unsignedBigInteger('indicator_id')->nullable();
            $table->foreign('indicator_id')->references('id')->on('indicators')->onDelete('cascade');
            $table->unsignedBigInteger('sub_indicator_id')->nullable();
            $table->foreign('sub_indicator_id')->references('id')->on('sub_indicators')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_docs');
    }
};
