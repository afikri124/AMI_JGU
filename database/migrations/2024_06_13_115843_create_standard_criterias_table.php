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
        Schema::create('standard_criterias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('standard_id')->nullable();
            $table->foreign('standard_id')->references('id')->on('standards')->nullable();
            $table->unsignedBigInteger('indicator_id')->nullable();
            $table->foreign('indicator_id')->references('id')->on('indicators')->nullable();
            $table->unsignedBigInteger('sub_indicator_id')->nullable();
            $table->foreign('sub_indicator_id')->references('id')->on('sub_indicators')->nullable()->onDelete('cascade');
            $table->uuid('standard_category_id')->nullable();
            $table->foreign('standard_category_id')->references('id')->on('standard_categories')->nullable()->onDelete('cascade');
            $table->unsignedBigInteger('audit_status_id')->nullable();
            $table->foreign('audit_status_id')->references('id')->on('audit_statuses')->nullable()->onDelete('cascade');
            $table->string('remark')->nullable();
            $table->string('required')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standard_criterias');
    }
};
