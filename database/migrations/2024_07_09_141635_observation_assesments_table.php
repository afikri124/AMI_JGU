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
        Schema::create('observation_assesments', function (Blueprint $table) {
            $table->id('id');
            $table->string('observation_id')->nullable();
            $table->string('audit_plan_category_id')->nullable();
            $table->string('audit_plan_criteria_id')->nullable();
        });
    }    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observation_assesments');
    }
};
