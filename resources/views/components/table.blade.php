@props([
    'headers' => [],
])

<div class="overflow-x-auto rounded-xl border border-slate-200/80 bg-white shadow-xs">
    <table {{ $attributes->merge(['class' => 'w-full text-left text-sm text-slate-700 divide-y divide-slate-200/70']) }}>
        @if (count($headers) > 0)
            <thead class="bg-slate-50/80 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                <tr>
                    @foreach ($headers as $header)
                        <th scope="col" class="px-6 py-3.5">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-slate-100 bg-white">
            {{ $slot }}
        </tbody>
    </table>
</div>
