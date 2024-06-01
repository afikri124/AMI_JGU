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
        Schema::create('audit_docs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audit_plan_id');
            $table->foreign('audit_plan_id')->references('id')->on('audit_plans');
            $table->string('doc_path');
            $table->string('date');
            $table->unsignedBigInteger('audit_doc_list_name_id');
            $table->foreign('audit_doc_list_name_id')->references('id')->on('audit_doc_list_names');
            $table->unsignedBigInteger('audit_doc_status_id');
            $table->foreign('audit_doc_status_id')->references('id')->on('audit_doc_statuses');
            $table->string('remark_by_lecture');
            $table->string('remark_by_auditor');
            $table->string('link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_docs');
    }
};
