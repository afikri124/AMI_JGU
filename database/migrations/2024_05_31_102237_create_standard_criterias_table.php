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
            $table->id();
            $table->string('title');
            $table->decimal('weight');
            $table->boolean('status')->nullable()->default(true);
            $table->uuid('standard_category_id')->nullable();
            $table->foreign('standard_category_id')->references('id')->on('standard_categories')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standards_criterias');
    }
};
