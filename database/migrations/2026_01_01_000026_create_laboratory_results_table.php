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
        Schema::create('laboratory_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratory_order_id')->constrained('laboratory_orders')->cascadeOnDelete();
            $table->foreignId('laboratory_test_id')->constrained('laboratory_tests')->restrictOnDelete();
            $table->string('result_value', 255)->nullable()->comment('Nilai Hasil Pemeriksaan');
            $table->string('reference_range', 100)->nullable()->comment('Nilai Rujukan');
            $table->string('unit', 30)->nullable();
            $table->boolean('is_abnormal')->default(false)->index()->comment('Flag Hasil Abnormal');
            $table->text('notes')->nullable();

            $table->foreignId('analyst_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('doctor_in_charge_id')->nullable()->constrained('doctors')->nullOnDelete();
            $table->dateTime('result_date')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratory_results');
    }
};
