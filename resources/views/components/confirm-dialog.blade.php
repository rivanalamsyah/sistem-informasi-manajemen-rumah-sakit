@props([
    'id' => 'confirm-modal',
    'title' => 'Konfirmasi Hapus Data',
    'message' => 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
    'action' => '',
    'method' => 'DELETE',
    'confirmText' => 'Ya, Hapus Data',
    'cancelText' => 'Batal',
])

<div
    id="{{ $id }}"
    tabindex="-1"
    aria-hidden="true"
    class="hidden fixed inset-0 z-50 overflow-y-auto overflow-x-hidden p-4 md:p-6 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs transition-opacity duration-200"
>
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-6 text-center transform transition-all">
        <!-- Warning Icon Circle -->
        <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="alert-triangle" class="w-7 h-7"></i>
        </div>

        <h3 class="text-lg font-bold text-slate-900 mb-2">
            {{ $title }}
        </h3>
        
        <p class="text-xs text-slate-500 mb-6 leading-relaxed">
            {{ $message }}
        </p>

        <form id="{{ $id }}-form" action="{{ $action }}" method="POST" class="flex items-center justify-center gap-3">
            @csrf
            @if(strtoupper($method) !== 'POST')
                @method($method)
            @endif

            <button
                type="button"
                data-modal-close="{{ $id }}"
                class="px-4 py-2.5 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition border border-slate-200"
            >
                {{ $cancelText }}
            </button>

            <button
                type="submit"
                class="px-4 py-2.5 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-xs transition inline-flex items-center gap-2"
            >
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                <span>{{ $confirmText }}</span>
            </button>
        </form>
    </div>
</div>
