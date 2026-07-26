@props([
    'type' => 'info',
    'dismissible' => true,
])

@php
    $styles = match ($type) {
        'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200 icon-check-circle',
        'danger' => 'bg-rose-50 text-rose-800 border-rose-200 icon-alert-circle',
        'warning' => 'bg-amber-50 text-amber-800 border-amber-200 icon-alert-triangle',
        default => 'bg-sky-50 text-sky-800 border-sky-200 icon-info',
    };
    $lucideIcon = match ($type) {
        'success' => 'check-circle',
        'danger' => 'alert-circle',
        'warning' => 'alert-triangle',
        default => 'info',
    };
@endphp

<div {{ $attributes->merge(['class' => "p-4 rounded-xl border flex items-start gap-3 text-sm mb-4 shadow-xs {$styles}"]) }} role="alert">
    <i data-lucide="{{ $lucideIcon }}" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
    <div class="flex-1 font-medium">
        {{ $slot }}
    </div>
</div>
