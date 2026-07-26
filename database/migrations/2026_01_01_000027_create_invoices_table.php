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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 30)->unique()->comment('No. Invoice (INV-YYYYMMDD-XXXX)');
            $table->foreignId('registration_id')->unique()->constrained('registrations')->restrictOnDelete();
            $table->foreignId('patient_id')->constrained('patients')->restrictOnDelete();
            $table->dateTime('invoice_date')->index();
            $table->decimal('services_total', 12, 2)->default(0.00);
            $table->decimal('medicines_total', 12, 2)->default(0.00);
            $table->decimal('laboratory_total', 12, 2)->default(0.00);
            $table->decimal('room_total', 12, 2)->default(0.00);
            $table->decimal('subtotal', 12, 2)->default(0.00);
            $table->decimal('discount', 12, 2)->default(0.00);
            $table->decimal('grand_total', 12, 2)->default(0.00);
            $table->enum('status', ['Belum Lunas', 'Lunas', 'Batal'])->default('Belum Lunas')->index();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['invoice_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
