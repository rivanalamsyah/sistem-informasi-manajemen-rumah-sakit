@props([
    'id' => 'modal',
    'title' => 'Konfirmasi',
    'size' => 'md', // sm, md, lg, xl, full
])

@php
    $maxWidth = match ($size) {
        'sm' => 'max-w-sm',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-full mx-4',
        default => 'max-w-lg',
    };
@endphp

<div
    id="{{ $id }}"
    tabindex="-1"
    aria-hidden="true"
    class="hidden fixed inset-0 z-50 overflow-y-auto overflow-x-hidden p-4 md:p-6 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs transition-opacity duration-200"
>
    <div {{ $attributes->merge(['class' => "relative w-full {$maxWidth} bg-white rounded-2xl shadow-xl border border-slate-200 transform transition-all"]) }}>
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-900 tracking-tight flex items-center gap-2">
                {{ $title }}
            </h3>
            <button
                type="button"
                data-modal-close="{{ $id }}"
                class="text-slate-400 bg-transparent hover:bg-slate-100 hover:text-slate-700 rounded-lg text-sm w-8 h-8 inline-flex items-center justify-center transition"
            >
                <i data-lucide="x" class="w-4 h-4"></i>
                <span class="sr-only">Tutup Modal</span>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="px-6 py-5">
            {{ $slot }}
        </div>

        <!-- Modal Footer -->
        @if (isset($footer))
            <div class="flex items-center justify-end gap-3 px-6 py-4 bg-slate-50/80 border-t border-slate-100 rounded-b-2xl">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
