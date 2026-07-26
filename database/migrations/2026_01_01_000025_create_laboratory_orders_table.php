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
        Schema::create('laboratory_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 30)->unique()->comment('No. Order Lab (LAB-YYYYMMDD-XXXX)');
            $table->foreignId('registration_id')->constrained('registrations')->restrictOnDelete();
            $table->foreignId('patient_id')->constrained('patients')->restrictOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->restrictOnDelete()->comment('Dokter Pengirim');
            $table->dateTime('order_date')->index();
            $table->enum('status', ['Menunggu Sampel', 'Diproses', 'Selesai', 'Batal'])->default('Menunggu Sampel')->index();
            $table->text('clinical_notes')->nullable();

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
        Schema::dropIfExists('laboratory_orders');
    }
};
