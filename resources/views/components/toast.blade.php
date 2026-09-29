@props([
    'type' => 'success', // success, danger, warning, info
    'message' => '',
])

@php
    $style = match ($type) {
        'success' => 'bg-emerald-600 text-white border-emerald-700 icon-check-circle',
        'danger' => 'bg-rose-600 text-white border-rose-700 icon-alert-octagon',
        'warning' => 'bg-amber-500 text-white border-amber-600 icon-alert-triangle',
        'info' => 'bg-sky-600 text-white border-sky-700 icon-info',
        default => 'bg-slate-800 text-white border-slate-900 icon-bell',
    };

    $iconName = match ($type) {
        'success' => 'check-circle-2',
        'danger' => 'alert-octagon',
        'warning' => 'alert-triangle',
        'info' => 'info',
        default => 'bell',
    };
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 4000)"
    class="fixed bottom-5 right-5 z-50 flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg border text-xs font-semibold {{ $style }} transition-all duration-300 transform"
    role="alert"
>
    <i data-lucide="{{ $iconName }}" class="w-5 h-5 shrink-0"></i>
    <div class="flex-1 pr-2">
        {{ $message ?: $slot }}
    </div>
    <button @click="show = false" type="button" class="opacity-80 hover:opacity-100 transition p-1 rounded-md">
        <i data-lucide="x" class="w-4 h-4"></i>
    </button>
</div>
