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
        // ── 1. MANAJEMEN GUDANG (WAREHOUSE MANAGEMENT) ──────────────────────

        // Master Gudang
        if (! Schema::hasTable('warehouses')) {
            Schema::create('warehouses', function (Blueprint $table) {
                $table->id();
                $table->string('code', 20)->unique();
                $table->string('name', 100);
                $table->string('type', 50)->default('Gudang Utama')->comment('Gudang Utama / Depo Farmasi / Gudang Alkes / Depo Logistik');
                $table->text('location_description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Lokasi / Rak Gudang
        if (! Schema::hasTable('warehouse_locations')) {
            Schema::create('warehouse_locations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
                $table->string('code', 20);
                $table->string('name', 100);
                $table->string('rack_number', 30)->nullable();
                $table->string('description', 255)->nullable();
                $table->timestamps();
            });
        }

        // Master Barang Gudang
        if (! Schema::hasTable('warehouse_items')) {
            Schema::create('warehouse_items', function (Blueprint $table) {
                $table->id();
                $table->string('code', 30)->unique();
                $table->string('barcode', 50)->nullable()->index();
                $table->string('name', 150);
                $table->string('category', 50)->default('Umum');
                $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
                $table->foreignId('medicine_id')->nullable()->constrained('medicines')->nullOnDelete();
                $table->string('unit', 30)->default('Pcs');
                $table->integer('min_stock')->default(10);
                $table->integer('max_stock')->default(500);
                $table->decimal('purchase_price', 15, 2)->default(0);
                $table->decimal('sell_price', 15, 2)->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Stok Barang per Gudang
        if (! Schema::hasTable('warehouse_stocks')) {
            Schema::create('warehouse_stocks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
                $table->foreignId('warehouse_item_id')->constrained('warehouse_items')->cascadeOnDelete();
                $table->string('batch_number', 50)->default('DEFAULT');
                $table->date('expired_date')->nullable();
                $table->integer('stock')->default(0);
                $table->timestamps();

                $table->unique(['warehouse_id', 'warehouse_item_id', 'batch_number'], 'idx_wh_stock_unique');
            });
        }

        // Penerimaan Barang (Goods Receipt Note / Inbound)
        if (! Schema::hasTable('warehouse_receipts')) {
            Schema::create('warehouse_receipts', function (Blueprint $table) {
                $table->id();
                $table->string('receipt_number', 30)->unique();
                $table->date('receipt_date');
                $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
                $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
                $table->string('invoice_number', 50)->nullable();
                $table->decimal('total_amount', 15, 2)->default(0);
                $table->text('notes')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('warehouse_receipt_items')) {
            Schema::create('warehouse_receipt_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('warehouse_receipt_id')->constrained('warehouse_receipts')->cascadeOnDelete();
                $table->foreignId('warehouse_item_id')->constrained('warehouse_items')->cascadeOnDelete();
                $table->integer('quantity');
                $table->decimal('purchase_price', 15, 2);
                $table->string('batch_number', 50)->default('DEFAULT');
                $table->date('expired_date')->nullable();
                $table->decimal('subtotal', 15, 2);
                $table->timestamps();
            });
        }

        // Pengeluaran Barang / Distribusi
        if (! Schema::hasTable('warehouse_dispatches')) {
            Schema::create('warehouse_dispatches', function (Blueprint $table) {
                $table->id();
                $table->string('dispatch_number', 30)->unique();
                $table->date('dispatch_date');
                $table->foreignId('source_warehouse_id')->constrained('warehouses')->cascadeOnDelete();
                $table->string('destination_type', 50)->default('Farmasi')->comment('Farmasi / Poliklinik / Rawat Inap / Unit Logistik');
                $table->string('destination_name', 100);
                $table->string('status', 30)->default('Selesai')->comment('Pending / Selesai / Dibatalkan');
                $table->text('notes')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('warehouse_dispatch_items')) {
            Schema::create('warehouse_dispatch_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('warehouse_dispatch_id')->constrained('warehouse_dispatches')->cascadeOnDelete();
                $table->foreignId('warehouse_item_id')->constrained('warehouse_items')->cascadeOnDelete();
                $table->integer('quantity');
                $table->string('batch_number', 50)->default('DEFAULT');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Mutasi Barang Antar Gudang/Depo
        if (! Schema::hasTable('warehouse_mutations')) {
            Schema::create('warehouse_mutations', function (Blueprint $table) {
                $table->id();
                $table->string('mutation_number', 30)->unique();
                $table->date('mutation_date');
                $table->foreignId('source_warehouse_id')->constrained('warehouses')->cascadeOnDelete();
                $table->foreignId('target_warehouse_id')->constrained('warehouses')->cascadeOnDelete();
                $table->string('status', 30)->default('Selesai');
                $table->text('notes')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('warehouse_mutation_items')) {
            Schema::create('warehouse_mutation_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('warehouse_mutation_id')->constrained('warehouse_mutations')->cascadeOnDelete();
                $table->foreignId('warehouse_item_id')->constrained('warehouse_items')->cascadeOnDelete();
                $table->integer('quantity');
                $table->string('batch_number', 50)->default('DEFAULT');
                $table->timestamps();
            });
        }

        // Stock Opname & Penyesuaian
        if (! Schema::hasTable('stock_opnames')) {
            Schema::create('stock_opnames', function (Blueprint $table) {
                $table->id();
                $table->string('opname_number', 30)->unique();
                $table->date('opname_date');
                $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
                $table->string('status', 30)->default('Draft')->comment('Draft / Selesai');
                $table->text('notes')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('stock_opname_items')) {
            Schema::create('stock_opname_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('stock_opname_id')->constrained('stock_opnames')->cascadeOnDelete();
                $table->foreignId('warehouse_item_id')->constrained('warehouse_items')->cascadeOnDelete();
                $table->integer('system_stock');
                $table->integer('physical_stock');
                $table->integer('difference');
                $table->string('notes', 255)->nullable();
                $table->timestamps();
            });
        }

        // Kartu Stok (Stock Movements Ledger)
        if (! Schema::hasTable('warehouse_stock_movements')) {
            Schema::create('warehouse_stock_movements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
                $table->foreignId('warehouse_item_id')->constrained('warehouse_items')->cascadeOnDelete();
                $table->dateTime('movement_date');
                $table->string('movement_type', 40)->comment('Masuk / Keluar / Mutasi Masuk / Mutasi Keluar / Penyesuaian');
                $table->string('reference_number', 50);
                $table->integer('quantity');
                $table->integer('stock_before');
                $table->integer('stock_after');
                $table->string('notes', 255)->nullable();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }

        // ── 2. MANAJEMEN USER & AUDIT TRAIL ─────────────────────────────────

        // Add Avatar and 2FA columns to users table if missing
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('is_active');
            }
            if (! Schema::hasColumn('users', 'two_factor_enabled')) {
                $table->boolean('two_factor_enabled')->default(false)->after('last_login_at');
            }
        });

        // Log Login History
        if (! Schema::hasTable('user_logins')) {
            Schema::create('user_logins', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->timestamp('login_at');
                $table->timestamp('logout_at')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->string('browser', 50)->nullable();
                $table->string('device', 50)->nullable();
                $table->string('status', 20)->default('Sukses');
                $table->timestamps();
            });
        }

        // Activity Log / Audit Trail
        if (! Schema::hasTable('activity_logs')) {
            Schema::create('activity_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('module', 50)->index();
                $table->string('action', 50)->index();
                $table->text('description');
                $table->string('subject_type', 100)->nullable();
                $table->unsignedBigInteger('subject_id')->nullable();
                $table->json('old_values')->nullable();
                $table->json('new_values')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->timestamps();
            });
        }

        // Backup History
        if (! Schema::hasTable('backups')) {
            Schema::create('backups', function (Blueprint $table) {
                $table->id();
                $table->string('file_name');
                $table->string('file_path');
                $table->bigInteger('file_size')->default(0);
                $table->string('backup_type', 30)->default('database');
                $table->string('status', 30)->default('Sukses');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backups');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('user_logins');
        Schema::dropIfExists('warehouse_stock_movements');
        Schema::dropIfExists('stock_opname_items');
        Schema::dropIfExists('stock_opnames');
        Schema::dropIfExists('warehouse_mutation_items');
        Schema::dropIfExists('warehouse_mutations');
        Schema::dropIfExists('warehouse_dispatch_items');
        Schema::dropIfExists('warehouse_dispatches');
        Schema::dropIfExists('warehouse_receipt_items');
        Schema::dropIfExists('warehouse_receipts');
        Schema::dropIfExists('warehouse_stocks');
        Schema::dropIfExists('warehouse_items');
        Schema::dropIfExists('warehouse_locations');
        Schema::dropIfExists('warehouses');
    }
};
