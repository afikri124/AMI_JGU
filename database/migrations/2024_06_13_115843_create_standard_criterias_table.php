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
        Schema::create('standard_criterias', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->boolean('status')->nullable();
            $table->uuid('standard_categories_id')->nullable();
            $table->foreign('standard_categories_id')->references('id')->on('standard_categories')->nullable()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standard_criterias');
    }
};
