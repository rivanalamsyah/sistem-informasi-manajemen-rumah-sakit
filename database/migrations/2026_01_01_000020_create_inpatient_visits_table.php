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
        Schema::create('inpatient_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->unique()->constrained('registrations')->cascadeOnDelete();
            $table->foreignId('bed_id')->constrained('beds')->restrictOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->restrictOnDelete()->comment('DPJP Dokter Penanggung Jawab');
            $table->dateTime('admission_date')->index()->comment('Waktu Masuk Kamar');
            $table->dateTime('discharge_date')->nullable()->index()->comment('Waktu Pulang / Keluar');
            $table->text('initial_diagnosis')->nullable();
            $table->enum('discharge_reason', ['Sembuh', 'Rujuk', 'APS', 'Meninggal'])->nullable();
            $table->enum('status', ['Aktif', 'Checkout Medis', 'Checkout Billing', 'Batal'])->default('Aktif')->index();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inpatient_visits');
    }
};
