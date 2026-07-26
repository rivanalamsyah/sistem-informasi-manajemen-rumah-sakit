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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number', 30)->unique()->comment('Nomor Registrasi (REG-YYYYMMDD-XXXX)');
            $table->foreignId('patient_id')->constrained('patients')->restrictOnDelete();
            $table->enum('service_type', ['Rawat Jalan', 'Rawat Inap', 'IGD'])->default('Rawat Jalan')->index();
            $table->dateTime('registration_date')->index();
            $table->enum('guarantor', ['Umum', 'Asuransi Swasta'])->default('Umum')->index();
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai', 'Batal'])->default('Menunggu')->index();
            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['registration_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
