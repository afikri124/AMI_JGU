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
            $table->string('doc_path');
            $table->string('link');
            $table->unsignedBigInteger('auditor_id');
            $table->foreign('auditor_id')->references('id')->on('users');
            $table->unsignedBigInteger('audit_status_id');
            $table->foreign('audit_status_id')->references('id')->on('audit_statuses');
            $table->unsignedBigInteger('lecture_id');
            $table->foreign('lecture_id')->references('id')->on('users');
            $table->string('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->nullable()->onDelete('cascade');
            $table->string('standard_categories_id')->nullable();
            $table->foreign('standard_categories_id')->references('id')->on('standard_categories')->nullable()->onDelete('cascade');
            $table->uuid('standard_criterias_id')->nullable();
            $table->foreign('standard_criterias_id')->references('id')->on('standard_criterias')->nullable()->onDelete('cascade');
            $table->unsignedBigInteger('indicator_id')->nullable();
            $table->foreign('indicator_id')->references('id')->on('indicators')->nullable()->onDelete('cascade');
            $table->unsignedBigInteger('sub_indicator_id')->nullable();
            $table->foreign('sub_indicator_id')->references('id')->on('sub_indicators')->nullable()->onDelete('cascade');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->string('total_student')->nullable();
            $table->string('remark')->nullable();
            $table->string('title_ass')->nullable();
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
