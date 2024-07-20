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
            $table->text('name');
            $table->unsignedBigInteger('standard_criteria_id')->nullable();
            $table->foreign('standard_criteria_id')->references('id')->on('standard_criterias')->nullable()->onDelete('cascade');
            $table->unsignedBigInteger('standard_statement_id')->nullable();
            $table->foreign('standard_statement_id')->references('id')->on('standard_statements')->nullable()->onDelete('cascade');
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
