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
        Schema::create('observations', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('audit_plan_id');
            $table->foreign('audit_plan_id')->references('id')->on('audit_plans');
            $table->unsignedBigInteger('auditor_id');
            $table->foreign('auditor_id')->references('id')->on('users');
            $table->string('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->nullable()->onDelete('cascade');
            $table->string('remark_plan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observations');
    }
};
