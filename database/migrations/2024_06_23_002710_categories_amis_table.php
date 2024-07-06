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
        Schema::create('categories_amis', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('audit_plan_id');
            $table->foreign('audit_plan_id')->references('id')->on('audit_plans');
            $table->string('standard_categories_id')->nullable();
            $table->foreign('standard_categories_id')->references('id')->on('standard_categories')->nullable()->onDelete('cascade');
        });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_amis');
    }
};
