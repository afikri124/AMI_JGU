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
        Schema::create('audit_plans', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('lecture_id');
            $table->foreign('lecture_id')->references('id')->on('users');
            $table->dateTime('date');
            $table->unsignedBigInteger('audit_status_id');
            $table->foreign('audit_status_id')->references('id')->on('audit_statuses');
            $table->string('location');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->unsignedBigInteger('auditor_id');
            $table->foreign('auditor_id')->references('id')->on('users');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_plans');
    }
};
