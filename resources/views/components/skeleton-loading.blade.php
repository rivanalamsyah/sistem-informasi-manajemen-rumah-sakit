@props([
    'rows' => 5,
])

<div class="animate-pulse space-y-4 p-4 bg-white rounded-2xl border border-slate-200/80">
    <div class="h-4 bg-slate-200 rounded w-1/4"></div>
    <div class="space-y-2">
        @for($i = 0; $i < $rows; $i++)
            <div class="h-10 bg-slate-100 rounded-xl w-full"></div>
        @endfor
    </div>
</div>
