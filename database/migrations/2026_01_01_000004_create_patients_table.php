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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('mr_number', 20)->unique()->comment('Nomor Rekam Medis (RM-XXXXXX)');
            $table->string('nik', 16)->unique()->comment('Nomor Induk Kependudukan (16 digit)');
            $table->string('name', 150)->index()->comment('Nama Lengkap Pasien');
            $table->string('birth_place', 100);
            $table->date('birth_date')->index();
            $table->enum('gender', ['L', 'P'])->comment('L = Laki-laki, P = Perempuan');
            $table->enum('blood_type', ['A', 'B', 'AB', 'O', '-'])->default('-');
            $table->string('religion', 30)->nullable();
            $table->string('marital_status', 30)->nullable();
            $table->string('occupation', 100)->nullable();
            $table->string('phone', 20)->index();
            $table->string('email', 100)->nullable();
            $table->text('address')->comment('Alamat Domisili Pasien');
            $table->string('guardian_name', 150)->nullable()->comment('Nama Penanggung Jawab');
            $table->string('guardian_phone', 20)->nullable();
            $table->string('guardian_relation', 50)->nullable()->comment('Hubungan Keluarga');

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['name', 'birth_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
