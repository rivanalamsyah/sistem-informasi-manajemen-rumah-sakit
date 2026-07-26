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
        Schema::create('medicine_stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_stock_id')->constrained('medicine_stocks')->cascadeOnDelete();
            $table->enum('type', ['Masuk', 'Keluar', 'Mutasi', 'Penyesuaian', 'Retur'])->index();
            $table->integer('quantity')->comment('Jumlah perubahan stok (+/-)');
            $table->string('reference_number', 50)->nullable()->index()->comment('No Faktur / No Resep / No Mutasi');
            $table->string('notes', 255)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_stock_movements');
    }
};
