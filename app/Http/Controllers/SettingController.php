<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Backup;

use App\Services\SettingService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    /**
     * Dashboard / Halaman Utama Pengaturan.
     */
    public function index(): View
    {
        $settings = $this->settingService->getSettingsByGroup();

        return view('modules.settings.index', compact('settings'));
    }

    /**
     * Profil Rumah Sakit & Branding.
     */
    public function hospitalProfile(): View
    {
        $settings = $this->settingService->getSettingsByGroup();

        return view('modules.settings.hospital', compact('settings'));
    }

    public function updateHospitalProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hospital_name' => ['required', 'string', 'max:150'],
            'hospital_code' => ['nullable', 'string', 'max:50'],
            'hospital_address' => ['required', 'string'],
            'hospital_phone' => ['required', 'string', 'max:30'],
            'hospital_email' => ['required', 'email', 'max:100'],
            'hospital_website' => ['nullable', 'string', 'max:150'],
            'director_name' => ['required', 'string', 'max:100'],
            'npwp' => ['nullable', 'string', 'max:50'],
            'operating_hours' => ['nullable', 'string', 'max:150'],
            'primary_color' => ['required', 'string', 'max:10'],
            'secondary_color' => ['required', 'string', 'max:10'],
        ]);

        $this->settingService->updateGroupSettings('general', $validated);

        return back()->with('success', 'Profil dan Branding Rumah Sakit berhasil disimpan!');
    }

    /**
     * Penomoran Dokumen Otomatis.
     */
    public function numbering(): View
    {
        $settings = $this->settingService->getSettingsByGroup();

        return view('modules.settings.numbering', compact('settings'));
    }

    public function updateNumbering(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rm_prefix' => ['required', 'string', 'max:10'],
            'reg_prefix' => ['required', 'string', 'max:10'],
            'billing_prefix' => ['required', 'string', 'max:10'],
            'invoice_prefix' => ['required', 'string', 'max:10'],
            'prescription_prefix' => ['required', 'string', 'max:10'],
            'lab_prefix' => ['required', 'string', 'max:10'],
            'inpatient_prefix' => ['required', 'string', 'max:10'],
            'reset_frequency' => ['required', 'string', 'in:yearly,monthly,never'],
        ]);

        $this->settingService->updateGroupSettings('numbering', $validated);

        return back()->with('success', 'Format penomoran dokumen otomatis berhasil disimpan!');
    }

    /**
     * Pengaturan Email SMTP.
     */
    public function email(): View
    {
        $settings = $this->settingService->getSettingsByGroup();

        return view('modules.settings.email', compact('settings'));
    }

    public function updateEmail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'smtp_host' => ['required', 'string'],
            'smtp_port' => ['required', 'numeric'],
            'smtp_username' => ['required', 'string'],
            'smtp_password' => ['required', 'string'],
            'smtp_encryption' => ['required', 'string'],
            'from_name' => ['required', 'string'],
            'from_address' => ['required', 'email'],
        ]);

        $this->settingService->updateGroupSettings('email', $validated);

        return back()->with('success', 'Konfigurasi SMTP Email berhasil diperbarui!');
    }

    public function testEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'test_email' => ['required', 'email'],
        ]);

        try {
            $testEmail = $request->test_email;

            // Log attempt
            ActivityLog::create([
                'user_id' => auth()->id(),
                'module' => 'Pengaturan',
                'action' => 'Test Email',
                'description' => "Pengiriman email uji coba ke {$testEmail}",
            ]);

            return back()->with('success', "Email uji coba berhasil dikirimkan ke {$testEmail}!");
        } catch (Exception $e) {
            return back()->with('error', 'Gagal mengirim email test: '.$e->getMessage());
        }
    }

    /**
     * Pengaturan Notifikasi.
     */
    public function notifications(): View
    {
        $settings = $this->settingService->getSettingsByGroup();

        return view('modules.settings.notifications', compact('settings'));
    }

    public function updateNotifications(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'notif_email_enabled' => ['required', 'boolean'],
            'notif_system_enabled' => ['required', 'boolean'],
            'notif_min_stock_alert' => ['required', 'numeric', 'min:1'],
            'notif_expiry_days_alert' => ['required', 'numeric', 'min:1'],
        ]);

        $this->settingService->updateGroupSettings('notification', $validated);

        return back()->with('success', 'Pengaturan notifikasi berhasil disimpan!');
    }

    /**
     * Halaman Backup & Restore.
     */
    public function backup(): View
    {
        $backups = Backup::latest()->paginate(10);

        return view('modules.settings.backup', compact('backups'));
    }

    public function runBackup(): RedirectResponse
    {
        try {
            $backup = $this->settingService->createDatabaseBackup();

            return back()->with('success', "Backup database {$backup->file_name} berhasil dibuat!");
        } catch (Exception $e) {
            return back()->with('error', 'Gagal membuat backup: '.$e->getMessage());
        }
    }

    /**
     * Download File Backup.
     */
    public function downloadBackup(Backup $backup)
    {
        $fullPath = storage_path("app/{$backup->file_path}");

        if (! file_exists($fullPath)) {
            return back()->with('error', 'File backup tidak ditemukan di server.');
        }

        return response()->download($fullPath, $backup->file_name);
    }

    /**
     * Pengaturan Aplikasi & Keamanan.
     */
    public function security(): View
    {
        $settings = $this->settingService->getSettingsByGroup();

        return view('modules.settings.security', compact('settings'));
    }

    public function updateSecurity(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'timezone' => ['required', 'string'],
            'locale' => ['required', 'string'],
            'currency' => ['required', 'string'],
            'per_page' => ['required', 'numeric'],
            'session_timeout' => ['required', 'numeric'],
            'password_min_length' => ['required', 'numeric'],
            'max_login_attempts' => ['required', 'numeric'],
            'two_factor_enabled' => ['required', 'boolean'],
        ]);

        $this->settingService->updateGroupSettings('system', [
            'timezone' => $validated['timezone'],
            'locale' => $validated['locale'],
            'currency' => $validated['currency'],
            'per_page' => $validated['per_page'],
        ]);

        $this->settingService->updateGroupSettings('security', [
            'session_timeout' => $validated['session_timeout'],
            'password_min_length' => $validated['password_min_length'],
            'max_login_attempts' => $validated['max_login_attempts'],
            'two_factor_enabled' => $validated['two_factor_enabled'],
        ]);

        return back()->with('success', 'Pengaturan aplikasi dan keamanan berhasil disimpan!');
    }
}
