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
        Schema::create('medicine_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->cascadeOnDelete();
            $table->enum('location', ['Gudang', 'Depo Farmasi'])->default('Gudang')->index();
            $table->string('batch_number', 50)->index()->comment('Nomor Batch Pabrik');
            $table->date('expired_date')->index()->comment('Tanggal Kadaluarsa');
            $table->integer('stock')->default(0)->comment('Jumlah Stok Fisik');

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['medicine_id', 'location', 'expired_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_stocks');
    }
};
