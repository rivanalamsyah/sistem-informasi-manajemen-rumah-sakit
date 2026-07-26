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
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained('prescriptions')->cascadeOnDelete();
            $table->foreignId('medicine_id')->constrained('medicines')->restrictOnDelete();
            $table->integer('quantity')->comment('Jumlah Obat');
            $table->string('dosage', 100)->comment('Aturan Pakai (misal: 3x1 tablet sesudah makan)');
            $table->decimal('unit_price', 12, 2)->default(0.00)->comment('Harga Satuan');
            $table->decimal('subtotal', 12, 2)->default(0.00)->comment('Subtotal');
            $table->string('notes', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
    }
};
