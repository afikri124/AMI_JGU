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
        Schema::create('observation_checklistes', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('observation_id')->nullable();
            $table->unsignedBigInteger('sub_indicator_id')->nullable();
            $table->foreign('sub_indicator_id')->references('id')->on('sub_indicators')->onDelete('cascade');
            $table->foreign('observation_id')->references('id')->on('observations')->nullable()->onUpdate('cascade')->onDelete('cascade');
            $table->string('obs_checklist_option')->nullable();
            $table->string('remark_success_failed')->nullable();
            $table->string('remark_recommend')->nullable();
            $table->string('remark_upgrade_repair')->nullable();
            $table->string('person_in_charge')->nullable();
            $table->string('plan_complated')->nullable();

        });
    }    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observation_checklistes');
    }
};
