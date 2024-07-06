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
        Schema::create('user_standard', function (Blueprint $table) {
        $table->id('id');
        $table->unsignedBigInteger('audit_plan_id');
        $table->foreign('audit_plan_id')->references('id')->on('audit_plans');
        $table->unsignedBigInteger('auditor_id');
        $table->foreign('auditor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_standard');
    }
};
