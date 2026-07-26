@props([
    'title' => 'Belum Ada Data',
    'description' => 'Tidak ada informasi atau catatan data yang dapat ditampilkan saat ini.',
    'icon' => 'inbox',
    'actionText' => null,
    'actionUrl' => null,
])

<div {{ $attributes->merge(['class' => 'text-center py-12 px-4']) }}>
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4 shadow-xs">
        <i data-lucide="{{ $icon }}" class="w-8 h-8"></i>
    </div>
    <h3 class="text-base font-semibold text-slate-800 tracking-tight mb-1">{{ $title }}</h3>
    <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4 leading-relaxed">{{ $description }}</p>
    @if ($actionText && $actionUrl)
        <a href="{{ $actionUrl }}" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
            <i data-lucide="plus" class="w-4 h-4"></i> {{ $actionText }}
        </a>
    @endif
</div>
