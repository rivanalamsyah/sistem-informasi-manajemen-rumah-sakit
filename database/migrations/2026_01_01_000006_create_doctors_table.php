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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->foreignId('department_id')->constrained('departments')->restrictOnDelete();
            $table->string('sip', 50)->unique()->comment('Surat Izin Praktik');
            $table->string('name', 150)->index()->comment('Nama Lengkap Dokter');
            $table->string('title_prefix', 30)->nullable()->comment('Gelar Depan (dr. / Dr.)');
            $table->string('title_suffix', 50)->nullable()->comment('Gelar Belakang (Sp.PD)');
            $table->string('specialization', 100)->comment('Spesialisasi Medis');
            $table->string('phone', 20);
            $table->string('email', 100)->nullable();
            $table->boolean('is_active')->default(true)->index();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
