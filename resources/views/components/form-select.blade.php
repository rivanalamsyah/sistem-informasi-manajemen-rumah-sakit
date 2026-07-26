@props([
    'name',
    'label',
    'required' => false,
    'helper' => null,
])

<div>
    <label for="{{ $name }}" class="block text-xs font-semibold text-slate-700 mb-1">
        {{ $label }}
        @if ($required)
            <span class="text-rose-500">*</span>
        @endif
    </label>
    <select 
        name="{{ $name }}" 
        id="{{ $name }}" 
        {{ $attributes->merge(['class' => 'w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition']) }}
        @if($required) required @endif
    >
        {{ $slot }}
    </select>
    @if ($helper)
        <p class="text-[11px] text-slate-400 mt-1">{{ $helper }}</p>
    @endif
    @error($name)
        <p class="text-xs text-rose-600 font-medium mt-1 flex items-center gap-1">
            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
        </p>
    @enderror
</div>
