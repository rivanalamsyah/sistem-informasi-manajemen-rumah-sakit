@props([
    'title',
    'value',
    'icon' => 'activity',
    'subtext' => null,
    'color' => 'teal', // teal, indigo, sky, amber, emerald, rose, purple, slate
    'trend' => null, // e.g. '+12%'
    'trendUp' => true,
])

@php
    $theme = match ($color) {
        'teal' => [
            'bgIcon' => 'bg-teal-50 text-teal-600 border-teal-100',
            'valColor' => 'text-teal-600',
            'border' => 'border-slate-200/80 hover:border-teal-300',
        ],
        'indigo' => [
            'bgIcon' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
            'valColor' => 'text-indigo-900',
            'border' => 'border-slate-200/80 hover:border-indigo-300',
        ],
        'sky' => [
            'bgIcon' => 'bg-sky-50 text-sky-600 border-sky-100',
            'valColor' => 'text-sky-600',
            'border' => 'border-slate-200/80 hover:border-sky-300',
        ],
        'amber' => [
            'bgIcon' => 'bg-amber-50 text-amber-600 border-amber-100',
            'valColor' => 'text-amber-600',
            'border' => 'border-slate-200/80 hover:border-amber-300',
        ],
        'emerald' => [
            'bgIcon' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
            'valColor' => 'text-emerald-600',
            'border' => 'border-slate-200/80 hover:border-emerald-300',
        ],
        'rose' => [
            'bgIcon' => 'bg-rose-50 text-rose-600 border-rose-100',
            'valColor' => 'text-rose-600',
            'border' => 'border-slate-200/80 hover:border-rose-300',
        ],
        'purple' => [
            'bgIcon' => 'bg-purple-50 text-purple-600 border-purple-100',
            'valColor' => 'text-purple-600',
            'border' => 'border-slate-200/80 hover:border-purple-300',
        ],
        default => [
            'bgIcon' => 'bg-slate-100 text-slate-700 border-slate-200',
            'valColor' => 'text-slate-900',
            'border' => 'border-slate-200/80 hover:border-slate-300',
        ],
    };
@endphp

<div class="bg-white rounded-2xl border {{ $theme['border'] }} p-5 shadow-xs hover:shadow-md transition-all duration-200">
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">{{ $title }}</span>
            <div class="flex items-baseline gap-2">
                <h2 class="text-2xl font-bold {{ $theme['valColor'] }} tracking-tight">{{ $value }}</h2>
                @if ($trend)
                    <span class="inline-flex items-center gap-0.5 text-[10px] font-bold px-1.5 py-0.5 rounded-full {{ $trendUp ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                        <i data-lucide="{{ $trendUp ? 'trending-up' : 'trending-down' }}" class="w-3 h-3"></i>
                        {{ $trend }}
                    </span>
                @endif
            </div>
            @if ($subtext)
                <p class="text-[11px] text-slate-400 flex items-center gap-1 font-medium">
                    {{ $subtext }}
                </p>
            @endif
        </div>
        <div class="w-12 h-12 rounded-xl border {{ $theme['bgIcon'] }} flex items-center justify-center shadow-xs shrink-0">
            <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
        </div>
    </div>
</div>
