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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique()->comment('Kode Ruangan (R-001)');
            $table->string('name', 100)->comment('Nama Ruangan / Bangsal');
            $table->string('building', 50)->comment('Nama Gedung');
            $table->string('floor', 20)->comment('Lantai');
            $table->enum('room_type', ['Rawat Inap', 'ICU', 'Isolasi', 'VIP', 'Operasi'])->default('Rawat Inap');
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
