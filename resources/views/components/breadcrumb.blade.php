@props([
    'items' => [],
])

<nav class="flex text-xs text-slate-500 mb-2" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1.5 flex-wrap">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-slate-500 hover:text-teal-600 font-medium transition-colors">
                <i data-lucide="home" class="w-3.5 h-3.5 mr-1.5"></i> Beranda
            </a>
        </li>
        @foreach ($items as $item)
            <li>
                <div class="flex items-center">
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400 mx-1"></i>
                    @if ($loop->last || empty($item['url']))
                        <span class="font-semibold text-teal-600 truncate max-w-xs">{{ $item['label'] }}</span>
                    @else
                        <a href="{{ $item['url'] }}" class="text-slate-500 hover:text-teal-600 font-medium transition-colors truncate max-w-xs">{{ $item['label'] }}</a>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
