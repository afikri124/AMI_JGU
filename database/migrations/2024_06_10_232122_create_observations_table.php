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
            $table->id();
            $table->unsignedBigInteger('audit_plan_id')->nullable();
            $table->foreign('audit_plan_id')->references('id')->on('audit_plans')->onDelete('cascade');
            $table->unsignedBigInteger('audit_status_id')->nullable();
            $table->foreign('audit_status_id')->references('id')->on('audit_statuses')->onDelete('cascade');
            $table->unsignedBigInteger('auditor_id')->nullable();
            $table->foreign('auditor_id')->references('id')->on('users')->onDelete('set null');
            $table->string('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->unsignedBigInteger('standard_criterias_id')->nullable();
            $table->foreign('standard_criterias_id')->references('id')->on('standard_criterias')->onDelete('set null');
            $table->boolean('attendance')->default(false);
            $table->string('remark')->nullable();
            $table->string('doc_path')->nullable();
            $table->string('subject_course')->nullable();
            $table->string('topic')->nullable();
            $table->string('class_type')->nullable();
            $table->string('total_students')->nullable();
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
