@extends('layouts.admin')

@section('title', 'Konfigurasi Email SMTP')

@section('content')
    <x-page-header
        title="Pengaturan Email & Mailer SMTP"
        subtitle="Konfigurasi server SMTP email untuk pengiriman notifikasi, reset password, & invoice."
        :breadcrumb="[
            ['label' => 'Pengaturan', 'url' => route('settings.index')],
            ['label' => 'Email SMTP', 'url' => null]
        ]"
    />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <form method="POST" action="{{ route('settings.email') }}">
                @csrf
                <x-card title="Kredensial Mail Server SMTP" icon="mail" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="smtp_host" label="SMTP Host Server" required :value="old('smtp_host', $settings['email']['smtp_host'] ?? 'smtp.gmail.com')" />
                        <x-form-input name="smtp_port" label="SMTP Port" type="number" required :value="old('smtp_port', $settings['email']['smtp_port'] ?? '587')" />
                        <x-form-input name="smtp_username" label="SMTP Username" required :value="old('smtp_username', $settings['email']['smtp_username'] ?? 'noreply@kencanamedika.co.id')" />
                        <x-form-input name="smtp_password" label="SMTP Password" type="password" required :value="old('smtp_password', $settings['email']['smtp_password'] ?? 'secret')" />
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Enkripsi SMTP <span class="text-rose-500">*</span></label>
                            <select name="smtp_encryption" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="tls" {{ (old('smtp_encryption', $settings['email']['smtp_encryption'] ?? 'tls') === 'tls') ? 'selected' : '' }}>TLS (Port 587)</option>
                                <option value="ssl" {{ (old('smtp_encryption', $settings['email']['smtp_encryption'] ?? 'tls') === 'ssl') ? 'selected' : '' }}>SSL (Port 465)</option>
                                <option value="null" {{ (old('smtp_encryption', $settings['email']['smtp_encryption'] ?? 'tls') === 'null') ? 'selected' : '' }}>Tanpa Enkripsi (Port 25)</option>
                            </select>
                        </div>
                        <x-form-input name="from_name" label="Nama Pengirim (Sender Name)" required :value="old('from_name', $settings['email']['from_name'] ?? 'RSUD Kencana Medika')" />
                        <div class="sm:col-span-2">
                            <x-form-input name="from_address" label="Alamat Email Pengirim" type="email" required :value="old('from_address', $settings['email']['from_address'] ?? 'noreply@kencanamedika.co.id')" />
                        </div>
                    </div>
                </x-card>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan Konfigurasi SMTP
                    </button>
                </div>
            </form>
        </div>

        <div>
            <x-card title="Uji Coba Pengiriman Email (Test Mail)" icon="send" class="p-5">
                <form method="POST" action="{{ route('settings.email.test') }}" class="space-y-4">
                    @csrf
                    <p class="text-xs text-slate-500">Kirim email uji coba untuk memverifikasi apakah kredensial SMTP yang Anda masukkan sudah terhubung secara normal:</p>
                    <x-form-input name="test_email" label="Alamat Email Penerima Test" type="email" required placeholder="Contoh: admin@kencanamedika.co.id" />
                    <button type="submit" class="w-full py-2 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2">
                        <i data-lucide="send" class="w-3.5 h-3.5"></i> Kirim Email Test Now
                    </button>
                </form>
            </x-card>
        </div>
    </div>
@endsection
