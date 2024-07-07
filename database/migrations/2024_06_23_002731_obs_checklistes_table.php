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
        Schema::create('obs_checklistes', function (Blueprint $table) {
            $table->id('id');
            $table->string('ks')->nullable();
            $table->string('obs')->nullable();
            $table->string('kts_minor')->nullable();
            $table->string('kts_mayor')->nullable();
            $table->string('description_remark')->nullable();
            $table->string('success_remark')->nullable();
            $table->string('failed_remark')->nullable();
            $table->string('recommend_remark')->nullable();
            $table->string('upgrade_plan')->nullable();
            $table->string('plan_complated')->nullable();
            $table->string('responsible_person')->nullable();
        });
    }    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obs_checklistes');
    }
};
