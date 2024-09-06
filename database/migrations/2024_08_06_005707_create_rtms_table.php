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
        Schema::create('rtms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('observation_id')->nullable();
            $table->foreign('observation_id')->references('id')->on('observations')->nullable()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('indicator_id')->nullable();
            $table->foreign('indicator_id')->references('id')->on('indicators')->onDelete('cascade');
            $table->string('doc_path_rtm')->nullable();
            $table->string('link')->nullable();
            $table->string('status')->nullable();
            $table->string('remark_rtm_auditee')->nullable();
            $table->string('remark_rtm_auditor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rtms');
    }
};
