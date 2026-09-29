@props([
    'title' => '',
    'value' => '0',
    'subtitle' => null,
    'icon' => 'activity',
    'color' => 'teal', // teal, blue, amber, emerald, rose, indigo
    'trend' => null,
    'trendUp' => true,
    'href' => null,
])

@php
    $colorMap = [
        'teal' => [
            'bg' => 'bg-teal-50',
            'icon' => 'text-teal-600',
            'border' => 'border-teal-200/60',
        ],
        'blue' => [
            'bg' => 'bg-sky-50',
            'icon' => 'text-sky-600',
            'border' => 'border-sky-200/60',
        ],
        'amber' => [
            'bg' => 'bg-amber-50',
            'icon' => 'text-amber-600',
            'border' => 'border-amber-200/60',
        ],
        'emerald' => [
            'bg' => 'bg-emerald-50',
            'icon' => 'text-emerald-600',
            'border' => 'border-emerald-200/60',
        ],
        'rose' => [
            'bg' => 'bg-rose-50',
            'icon' => 'text-rose-600',
            'border' => 'border-rose-200/60',
        ],
        'indigo' => [
            'bg' => 'bg-indigo-50',
            'icon' => 'text-indigo-600',
            'border' => 'border-indigo-200/60',
        ],
    ];

    $selectedColor = $colorMap[$color] ?? $colorMap['teal'];
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-slate-200/80 p-5 shadow-sm transition-all duration-200 hover:shadow-md relative overflow-hidden']) }}>
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ $title }}</p>
            <h4 class="text-2xl font-bold text-slate-900 mt-1 tracking-tight">{{ $value }}</h4>
            
            @if ($subtitle)
                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                    @if ($trend)
                        <span class="inline-flex items-center font-bold px-1.5 py-0.5 rounded text-[10px] {{ $trendUp ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                            <i data-lucide="{{ $trendUp ? 'trending-up' : 'trending-down' }}" class="w-3 h-3 mr-0.5"></i>
                            {{ $trend }}
                        </span>
                    @endif
                    <span>{{ $subtitle }}</span>
                </p>
            @endif
        </div>

        <div class="p-3 rounded-xl {{ $selectedColor['bg'] }} {{ $selectedColor['icon'] }} border {{ $selectedColor['border'] }} shadow-xs">
            <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
        </div>
    </div>

    @if ($href)
        <a href="{{ $href }}" class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-teal-600 hover:text-teal-700 transition">
            <span>Detail Selengkapnya</span>
            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
        </a>
    @endif
</div>
