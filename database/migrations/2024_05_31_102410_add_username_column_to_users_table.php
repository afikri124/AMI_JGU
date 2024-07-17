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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name')->nullable();
            $table->string('nidn')->unique()->nullable();
            $table->string('no_phone',15)->nullable();
            $table->string('google_id')->unique()->nullable();
            $table->char('gender')->nullable();
            $table->string('image')->nullable();
            $table->string('front_title')->nullable();
            $table->string('back_title')->nullable();
            $table->char('job')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->nullable()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('nidn');
            $table->dropColumn('no_phone');
            $table->dropColumn('google_id');
            $table->dropColumn('gender');
            $table->dropColumn('image');
            $table->dropColumn('front_title');
            $table->dropColumn('back_title');
            $table->dropColumn('job');
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
        });
    }
};
