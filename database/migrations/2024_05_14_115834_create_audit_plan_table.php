<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_plan', function (Blueprint $table) {
            $table->id(); // Primary key, auto-increment
            $table->date('date'); // Tanggal audit plan
            $table->unsignedBigInteger('audit_plan_status_id')->references('id')->on('audit_plan_statuses')->onDelete('cascade');
            $table->unsignedBigInteger('auditee_id'); // ID auditee
            $table->unsignedBigInteger('location_id'); // ID lokasi
            $table->unsignedBigInteger('auditor_id'); // ID auditor
            $table->unsignedBigInteger('departement_id'); // ID departemen
            $table->timestamps(); // Kolom created_at dan updated_at

            // Opsional: Menambahkan foreign key constraints jika diperlukan
            // $table->foreign('audit_plan_status_id')->references('id')->on('audit_plan_statuses')->onDelete('cascade');
            // $table->foreign('auditee_id')->references('id')->on('auditees')->onDelete('cascade');
            // $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            // $table->foreign('departement_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_plan'); // Menghapus tabel jika rollback
    }
}
