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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group', 50)->default('general')->index()->comment('Grup Pengaturan');
            $table->string('key', 100)->unique()->comment('Kunci Variabel Settings');
            $table->text('value')->nullable()->comment('Nilai Konfigurasi');
            $table->string('type', 30)->default('string')->comment('Tipe Data (string/boolean/json/integer)');
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
