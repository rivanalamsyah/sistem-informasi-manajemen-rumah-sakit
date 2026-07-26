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
        Schema::create('beds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->string('bed_number', 20)->comment('Nomor Tempat Tidur');
            $table->enum('class', ['VVIP', 'VIP', 'Kelas 1', 'Kelas 2', 'Kelas 3'])->default('Kelas 1');
            $table->enum('status', ['Kosong', 'Terisi', 'Dibersihkan', 'Pemeliharaan'])->default('Kosong')->index();
            $table->decimal('price_per_night', 12, 2)->default(0.00)->comment('Tarif sewa per malam');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['room_id', 'bed_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beds');
    }
};
