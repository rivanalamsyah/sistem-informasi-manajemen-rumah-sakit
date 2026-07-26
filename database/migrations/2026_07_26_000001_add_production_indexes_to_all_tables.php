<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tambahkan Composite Index untuk Performa Query Production
 *
 * Index ini ditargetkan untuk query yang paling sering dieksekusi oleh:
 * - Dashboard (filter tanggal, status)
 * - Rawat Jalan & Rawat Inap (filter tanggal & status)
 * - Billing (filter status invoice)
 * - Laporan (agregasi tanggal)
 * - Farmasi (filter stok & expiry)
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── REGISTRATIONS ────────────────────────────────────────────────
        Schema::table('registrations', function (Blueprint $table) {
            // Filter utama dashboard: tanggal + service_type
            if (! $this->hasIndex('registrations', 'idx_reg_date_service')) {
                $table->index(['registration_date', 'service_type'], 'idx_reg_date_service');
            }
            // Filter status
            if (! $this->hasIndex('registrations', 'idx_reg_status')) {
                $table->index(['status'], 'idx_reg_status');
            }
        });

        // ── QUEUES ───────────────────────────────────────────────────────
        Schema::table('queues', function (Blueprint $table) {
            // Dashboard rawat jalan: queue_date + status (paling sering)
            if (! $this->hasIndex('queues', 'idx_queue_date_status')) {
                $table->index(['queue_date', 'status'], 'idx_queue_date_status');
            }
            // Filter per dokter & departemen
            if (! $this->hasIndex('queues', 'idx_queue_doctor_dept')) {
                $table->index(['doctor_id', 'department_id'], 'idx_queue_doctor_dept');
            }
        });

        // ── OUTPATIENT_VISITS ────────────────────────────────────────────
        Schema::table('outpatient_visits', function (Blueprint $table) {
            // Filter per tanggal kunjungan
            if (! $this->hasIndex('outpatient_visits', 'idx_outpatient_date_status')) {
                $table->index(['visit_date', 'status'], 'idx_outpatient_date_status');
            }
            if (! $this->hasIndex('outpatient_visits', 'idx_outpatient_dept')) {
                $table->index(['department_id'], 'idx_outpatient_dept');
            }
        });

        // ── INPATIENT_VISITS ─────────────────────────────────────────────
        Schema::table('inpatient_visits', function (Blueprint $table) {
            if (! $this->hasIndex('inpatient_visits', 'idx_inpatient_status')) {
                $table->index(['status'], 'idx_inpatient_status');
            }
            if (! $this->hasIndex('inpatient_visits', 'idx_inpatient_admission_date')) {
                $table->index(['admission_date'], 'idx_inpatient_admission_date');
            }
        });

        // ── INVOICES ─────────────────────────────────────────────────────
        Schema::table('invoices', function (Blueprint $table) {
            // Billing index: status + tanggal
            if (! $this->hasIndex('invoices', 'idx_invoice_status')) {
                $table->index(['status'], 'idx_invoice_status');
            }
        });

        // ── PAYMENTS ─────────────────────────────────────────────────────
        Schema::table('payments', function (Blueprint $table) {
            // Report finansial: agregasi per tanggal
            if (! $this->hasIndex('payments', 'idx_payment_date')) {
                $table->index(['payment_date'], 'idx_payment_date');
            }
        });

        // ── PRESCRIPTIONS ────────────────────────────────────────────────
        Schema::table('prescriptions', function (Blueprint $table) {
            if (! $this->hasIndex('prescriptions', 'idx_prescription_status')) {
                $table->index(['status'], 'idx_prescription_status');
            }
        });

        // ── LABORATORY_ORDERS ────────────────────────────────────────────
        Schema::table('laboratory_orders', function (Blueprint $table) {
            if (! $this->hasIndex('laboratory_orders', 'idx_lab_status')) {
                $table->index(['status'], 'idx_lab_status');
            }
        });

        // ── MEDICINE_STOCKS ──────────────────────────────────────────────
        Schema::table('medicine_stocks', function (Blueprint $table) {
            // Monitoring stok rendah
            if (! $this->hasIndex('medicine_stocks', 'idx_stock_level')) {
                $table->index(['stock'], 'idx_stock_level');
            }
            // Monitoring expiry date
            if (! $this->hasIndex('medicine_stocks', 'idx_stock_expiry')) {
                $table->index(['expired_date'], 'idx_stock_expiry');
            }
        });

        // ── PATIENTS ─────────────────────────────────────────────────────
        Schema::table('patients', function (Blueprint $table) {
            // Pencarian pasien by nomor RM (sudah ada unique, tapi pastikan index ada)
            if (! $this->hasIndex('patients', 'idx_patient_name')) {
                $table->index(['name'], 'idx_patient_name');
            }
        });
    }

    public function down(): void
    {
        $indexes = [
            'registrations'      => ['idx_reg_date_service', 'idx_reg_status'],
            'queues'             => ['idx_queue_date_status', 'idx_queue_doctor_dept'],
            'outpatient_visits'  => ['idx_outpatient_date_status', 'idx_outpatient_dept'],
            'inpatient_visits'   => ['idx_inpatient_status', 'idx_inpatient_admission_date'],
            'invoices'           => ['idx_invoice_status'],
            'payments'           => ['idx_payment_date'],
            'prescriptions'      => ['idx_prescription_status'],
            'laboratory_orders'  => ['idx_lab_status'],
            'medicine_stocks'    => ['idx_stock_level', 'idx_stock_expiry'],
            'patients'           => ['idx_patient_name'],
        ];

        foreach ($indexes as $table => $tableIndexes) {
            Schema::table($table, function (Blueprint $blueprint) use ($tableIndexes) {
                foreach ($tableIndexes as $index) {
                    try {
                        $blueprint->dropIndex($index);
                    } catch (\Exception $e) {
                        // Index mungkin tidak ada, abaikan
                    }
                }
            });
        }
    }

    /**
     * Cek apakah index sudah ada untuk menghindari duplikasi error.
     */
    private function hasIndex(string $table, string $indexName): bool
    {
        $indexes = \Illuminate\Support\Facades\DB::select(
            "SHOW INDEX FROM `{$table}` WHERE Key_name = ?",
            [$indexName]
        );

        return count($indexes) > 0;
    }
};
