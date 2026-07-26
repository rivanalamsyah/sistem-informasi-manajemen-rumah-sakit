@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'headerClass' => 'px-6 py-4 border-b border-slate-100 bg-white rounded-t-xl',
    'bodyClass' => 'p-6',
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-slate-200/80 shadow-sm transition-all duration-200 hover:shadow-md']) }}>
    @if ($title || isset($header))
        <div class="{{ $headerClass }} flex items-center justify-between">
            @if ($title)
                <div class="flex items-center gap-3">
                    @if ($icon)
                        <div class="p-2 rounded-lg bg-teal-50 text-teal-600">
                            <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-sm font-semibold text-slate-800 tracking-tight">{{ $title }}</h3>
                        @if ($subtitle)
                            <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
                        @endif
                    </div>
                </div>
            @endif
            @if (isset($header))
                <div>{{ $header }}</div>
            @endif
        </div>
    @endif
    <div class="{{ $bodyClass }}">
        {{ $slot }}
    </div>
    @if (isset($footer))
        <div class="px-6 py-3 bg-slate-50/80 border-t border-slate-100 rounded-b-xl text-xs text-slate-500">
            {{ $footer }}
        </div>
    @endif
</div>
