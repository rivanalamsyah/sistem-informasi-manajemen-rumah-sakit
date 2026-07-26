@props([
    'title',
    'subtitle' => null,
    'breadcrumb' => [],
    'actions' => null,
])

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        @if (!empty($breadcrumb))
            <x-breadcrumb :items="$breadcrumb" />
        @endif
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">{{ $title }}</h1>
        @if ($subtitle)
            <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>
    @if ($actions || isset($slot))
        <div class="flex items-center gap-2">
            {{ $actions ?? $slot }}
        </div>
    @endif
</div>
