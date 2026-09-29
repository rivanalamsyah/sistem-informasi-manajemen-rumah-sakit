@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconRight' => null,
    'type' => 'button',
    'disabled' => false,
])

@php
    $variantClasses = match ($variant) {
        'primary' => 'bg-teal-600 hover:bg-teal-700 text-white border-transparent focus:ring-teal-500 shadow-xs',
        'secondary' => 'bg-slate-100 hover:bg-slate-200 text-slate-700 border-slate-200 focus:ring-slate-400',
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white border-transparent focus:ring-rose-500 shadow-xs',
        'warning' => 'bg-amber-500 hover:bg-amber-600 text-white border-transparent focus:ring-amber-400 shadow-xs',
        'outline' => 'bg-white hover:bg-slate-50 text-slate-700 border-slate-300 focus:ring-teal-500 shadow-xs',
        'ghost' => 'bg-transparent hover:bg-slate-100 text-slate-600 border-transparent focus:ring-slate-400',
        default => 'bg-teal-600 hover:bg-teal-700 text-white border-transparent focus:ring-teal-500 shadow-xs',
    };

    $sizeClasses = match ($size) {
        'sm' => 'px-3 py-1.5 text-xs font-semibold gap-1.5 min-h-[36px]',
        'lg' => 'px-6 py-3 text-base font-semibold gap-2.5 min-h-[48px]',
        default => 'px-4 py-2 text-sm font-semibold gap-2 min-h-[44px]',
    };

    $disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'cursor-pointer';
@endphp

<button
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-xl border font-sans transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-1 active:scale-[0.98] {$variantClasses} {$sizeClasses} {$disabledClasses}"]) }}
>
    @if ($icon)
        <i data-lucide="{{ $icon }}" class="{{ $size === 'sm' ? 'w-3.5 h-3.5' : ($size === 'lg' ? 'w-5 h-5' : 'w-4 h-4') }}"></i>
    @endif
    
    <span>{{ $slot }}</span>

    @if ($iconRight)
        <i data-lucide="{{ $iconRight }}" class="{{ $size === 'sm' ? 'w-3.5 h-3.5' : ($size === 'lg' ? 'w-5 h-5' : 'w-4 h-4') }}"></i>
    @endif
</button>
