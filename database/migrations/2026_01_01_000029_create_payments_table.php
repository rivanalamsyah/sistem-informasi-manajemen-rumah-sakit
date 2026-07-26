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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number', 30)->unique()->comment('No. Kuitansi (KWT-YYYYMMDD-XXXX)');
            $table->foreignId('invoice_id')->constrained('invoices')->restrictOnDelete();
            $table->dateTime('payment_date')->index();
            $table->enum('payment_method', ['Tunai', 'Transfer Bank', 'Kartu Debit', 'Kartu Kredit'])->default('Tunai')->index();
            $table->decimal('amount_paid', 12, 2)->default(0.00);
            $table->decimal('change_amount', 12, 2)->default(0.00);
            $table->foreignId('cashier_user_id')->constrained('users')->restrictOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
