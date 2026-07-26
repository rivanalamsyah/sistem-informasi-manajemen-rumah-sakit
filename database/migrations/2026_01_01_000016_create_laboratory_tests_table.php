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
        Schema::create('laboratory_tests', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique()->comment('Kode Pemeriksaan Lab');
            $table->string('name', 150)->index()->comment('Nama Parameter Lab');
            $table->string('category', 50)->default('Umum')->index()->comment('Kategori Lab (Hematologi/Kimia/dll)');
            $table->string('unit', 30)->nullable()->comment('Satuan Ukur (mg/dL, /uL)');
            $table->string('reference_range_male', 100)->nullable()->comment('Nilai normal pria');
            $table->string('reference_range_female', 100)->nullable()->comment('Nilai normal wanita');
            $table->decimal('price', 12, 2)->default(0.00)->comment('Biaya Pemeriksaan');
            $table->boolean('is_active')->default(true)->index();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratory_tests');
    }
};
