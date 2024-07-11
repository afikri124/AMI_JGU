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
        Schema::create('audit_plan_criterias', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('audit_plan_auditor_id');
            $table->foreign('audit_plan_auditor_id')->references('id')->on('audit_plan_auditors')->onDelete('cascade');
            $table->unsignedBigInteger('standard_criteria_id')->nullable();
            $table->foreign('standard_criteria_id')->references('id')->on('standard_criterias')->nullable()->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_plan_criterias');
    }
};
