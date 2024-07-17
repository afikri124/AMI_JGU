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
        Schema::create('observation_categories', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('observation_id')->nullable();
            $table->foreign('observation_id')->references('id')->on('observations')->nullable()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('audit_plan_category_id')->nullable();
            $table->foreign('audit_plan_category_id')->references('id')->on('audit_plan_categories')->onUpdate('cascade')->nullable();
            $table->unsignedBigInteger('audit_plan_criteria_id')->nullable();
            $table->foreign('audit_plan_criteria_id')->references('id')->on('audit_plan_criterias')->onUpdate('cascade')->nullable();
            $table->timestamps();
        });
    }    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observation_categories');
    }
};
