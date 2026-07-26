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
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->foreignId('department_id')->constrained('departments')->restrictOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->restrictOnDelete();
            $table->integer('queue_number')->comment('Nomor Urut (1, 2, 3)');
            $table->string('queue_code', 20)->index()->comment('Kode Antrean (POL-A01)');
            $table->date('queue_date')->index();
            $table->enum('status', ['Menunggu', 'Dipanggil', 'Sedang Diperiksa', 'Selesai', 'Batal'])->default('Menunggu')->index();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['department_id', 'doctor_id', 'queue_date', 'status'], 'queues_dept_doc_date_status_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
