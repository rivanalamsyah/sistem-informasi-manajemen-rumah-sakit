@props([
    'name' => '',
    'label' => '',
    'required' => false,
    'hint' => null,
])

<div {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    @if ($label)
        <label for="{{ $name }}" class="block text-xs font-semibold text-slate-700">
            {{ $label }}
            @if ($required)
                <span class="text-rose-500 font-bold">*</span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if ($hint)
        <p class="text-[11px] text-slate-400 font-medium">{{ $hint }}</p>
    @endif

    @if ($name)
        @error($name)
            <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
                <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i> {{ $message }}
            </p>
        @enderror
    @endif
</div>
