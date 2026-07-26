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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->restrictOnDelete();
            $table->foreignId('patient_id')->constrained('patients')->restrictOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->restrictOnDelete();
            $table->dateTime('record_date')->index();
            $table->text('subjective')->nullable()->comment('Anamnesis / Keluhan Utama');
            $table->text('objective')->nullable()->comment('Pemeriksaan Fisik / TTV');
            $table->text('assessment')->nullable()->comment('Evaluasi Klinis / Diagnosis Kerja');
            $table->text('plan')->nullable()->comment('Rencana Terapi / Tindakan');
            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['patient_id', 'record_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
