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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique()->comment('Kode Obat / Barang / Alkes');
            $table->string('name', 150)->index()->comment('Nama Komersial Obat');
            $table->string('generic_name', 150)->nullable()->comment('Nama Generik / Zat Aktif');
            $table->foreignId('category_id')->constrained('medicine_categories')->restrictOnDelete();
            $table->string('unit', 30)->comment('Satuan (Tablet, Botol, Ampul, Pcs)');
            $table->enum('type', ['Bebas', 'Bebas Terbatas', 'Keras', 'Narkotika', 'Psikotropika', 'Alkes'])->default('Bebas')->index();
            $table->integer('min_stock')->default(10)->comment('Batas minimal stok alert');
            $table->decimal('purchase_price', 12, 2)->default(0.00)->comment('Harga Beli / HPP');
            $table->decimal('selling_price', 12, 2)->default(0.00)->comment('Harga Jual ke Pasien');
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
        Schema::dropIfExists('medicines');
    }
};
