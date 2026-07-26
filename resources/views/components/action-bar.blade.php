@props([
    'saveLabel' => 'Simpan Perubahan',
    'cancelUrl' => null,
])

<div class="sticky bottom-0 z-20 -mx-4 -mb-4 sm:-mx-6 sm:-mb-6 mt-6 px-6 py-3.5 bg-white/90 backdrop-blur-md border-t border-slate-200/80 flex items-center justify-between shadow-lg rounded-b-2xl">
    <div class="text-xs text-slate-500 hidden sm:block flex items-center gap-1.5">
        <i data-lucide="shield-check" class="w-4 h-4 text-teal-600"></i> Pastikan data telah diisi dengan benar sebelum menyimpan.
    </div>
    <div class="flex items-center gap-2 ml-auto">
        @if ($cancelUrl)
            <a href="{{ $cancelUrl }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl border border-slate-200/80 transition flex items-center gap-1.5">
                <i data-lucide="x" class="w-3.5 h-3.5"></i> Batal
            </a>
        @endif
        <button type="submit" class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-xs rounded-xl shadow-sm transition flex items-center gap-2 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
            <i data-lucide="check-circle-2" class="w-4 h-4"></i> {{ $saveLabel }}
        </button>
    </div>
</div>
