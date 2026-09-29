@props([
    'actionUrl' => null,
    'createRoute' => null,
    'createLabel' => 'Tambah Data',
    'searchPlaceholder' => 'Cari data...',
    'searchValue' => request('search'),
    'filterOptions' => [], // ['param_name' => ['label' => '', 'options' => ['val' => 'Label']]]
    'perPage' => request('per_page', 15),
])

<form method="GET" action="{{ $actionUrl ?? request()->url() }}" class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 p-4 bg-slate-50/80 border-b border-slate-200/80 rounded-t-2xl">
    <div class="flex flex-1 flex-wrap items-center gap-3">
        <!-- Search Input -->
        <div class="relative flex-1 min-w-[200px] max-w-md">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input
                type="text"
                name="search"
                value="{{ $searchValue }}"
                placeholder="{{ $searchPlaceholder }}"
                class="w-full pl-9 pr-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition shadow-xs"
            >
        </div>

        <!-- Filter Dropdowns -->
        @foreach ($filterOptions as $name => $filter)
            <select
                name="{{ $name }}"
                onchange="this.form.submit()"
                class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500 transition shadow-xs cursor-pointer"
            >
                <option value="">-- {{ $filter['label'] }} --</option>
                @foreach ($filter['options'] as $val => $lbl)
                    <option value="{{ $val }}" {{ request($name) == (string)$val ? 'selected' : '' }}>
                        {{ $lbl }}
                    </option>
                @endforeach
            </select>
        @endforeach

        <button type="submit" class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold transition flex items-center gap-1.5">
            <i data-lucide="filter" class="w-3.5 h-3.5"></i>
            <span>Filter</span>
        </button>

        @if(request()->hasAny(array_merge(['search'], array_keys($filterOptions))))
            <a href="{{ $actionUrl ?? request()->url() }}" class="px-3 py-2 text-rose-600 hover:text-rose-700 text-xs font-semibold transition flex items-center gap-1">
                <i data-lucide="x" class="w-3.5 h-3.5"></i> Reset
            </a>
        @endif
    </div>

    <div class="flex items-center gap-3">
        <!-- Items per page selector -->
        <select
            name="per_page"
            onchange="this.form.submit()"
            class="px-2.5 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-600 focus:outline-none focus:ring-2 focus:ring-teal-500 transition shadow-xs cursor-pointer"
        >
            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 / hal</option>
            <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 / hal</option>
            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 / hal</option>
            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 / hal</option>
        </select>

        <!-- Create Button -->
        @if ($createRoute)
            <a href="{{ $createRoute }}" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-semibold shadow-xs transition inline-flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>{{ $createLabel }}</span>
            </a>
        @endif
    </div>
</form>
