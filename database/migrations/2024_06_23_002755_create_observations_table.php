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
            $table->unsignedBigInteger('audit_plan_auditor_id');
            $table->foreign('audit_plan_auditor_id')->references('id')->on('audit_plan_auditors');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->nullable()->onDelete('cascade');
            $table->string('remark_plan')->nullable();
            $table->text('remark_standard_lpm')->nullable();
            $table->string('person_in_charge')->nullable();
            $table->string('plan_complated')->nullable();
            $table->string('date_prepared')->nullable();
            $table->string('date_checked')->nullable();
            $table->string('date_validated')->nullable();
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
