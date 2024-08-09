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
        Schema::create('observation_checklists', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('observation_id')->nullable();
            $table->unsignedBigInteger('indicator_id')->nullable();
            $table->foreign('indicator_id')->references('id')->on('indicators')->onDelete('cascade');
            $table->foreign('observation_id')->references('id')->on('observations')->nullable()->onUpdate('cascade')->onDelete('cascade');
            $table->string('doc_path')->nullable();
            $table->string('remark_docs')->nullable();
            $table->string('obs_checklist_option')->nullable();
            $table->string('remark_success_failed')->nullable();
            $table->string('remark_description')->nullable();
            $table->string('remark_recommend')->nullable();
            $table->string('remark_upgrade_repair')->nullable();
            $table->string('remark_by_lpm')->nullable();
            $table->timestamps();

        });
    }    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observation_checklists');
    }
};
