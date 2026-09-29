@extends('layouts.public')

@section('title', 'Dokter & Jadwal Praktik — RSU Rajawali Citra')
@section('meta_description', 'Temukan dokter spesialis RSU Rajawali Citra. Cari berdasarkan spesialisasi dan lihat jadwal praktik. Spesialis penyakit dalam, anak, kandungan, jantung, bedah, saraf, dan lainnya.')
@section('og_title', 'Dokter & Jadwal Praktik — RSU Rajawali Citra')

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "ItemList",
  "name": "Dokter Spesialis RSU Rajawali Citra",
  "itemListElement": [
    @foreach ($doctors as $i => $doctor)
    {
      "@@type": "ListItem",
      "position": {{ $i + 1 }},
      "item": {
        "@@type": "Physician",
        "name": "{{ $doctor['name'] }}",
        "medicalSpecialty": "{{ $doctor['specialization'] }}",
        "url": "{{ route('doctors.detail', $doctor['slug']) }}"
      }
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endpush

@section('content')

{{-- Page Hero --}}
<section class="page-hero" aria-label="Dokter dan Tenaga Medis">
    <div class="container-xl">
        <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Dokter &amp; Jadwal</span>
        </nav>
        <span class="section-label">Tim Medis</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 mt-2 mb-4 leading-tight">
            Dokter &amp; Tenaga Medis<br>Berpengalaman Kami
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl leading-relaxed">
            Ditangani oleh dokter spesialis dan subspesialis pilihan yang berdedikasi tinggi dan berkomitmen memberikan pelayanan medis terbaik untuk Anda.
        </p>
    </div>
</section>

{{-- ═══ SECTION 2: DOCTOR SEARCH & FILTER ═══ --}}
<section class="bg-white py-8 border-b border-slate-200" aria-label="Cari Dokter">
    <div class="container-xl">
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm">
            <h2 class="text-base font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                <i data-lucide="search" class="w-4 h-4 text-cyan-700" aria-hidden="true"></i>
                <span>Cari Dokter &amp; Jadwal Praktik</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="searchDoctor" class="block text-xs font-semibold text-slate-700 mb-1">Nama Dokter</label>
                    <input type="text" id="searchDoctor" placeholder="cth. dr. Andi Prasetyo…"
                        class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-600 transition"
                        oninput="filterDoctors()" aria-controls="doctorGrid">
                </div>
                <div>
                    <label for="filterSpec" class="block text-xs font-semibold text-slate-700 mb-1">Spesialisasi</label>
                    <select id="filterSpec"
                        class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-cyan-600 transition"
                        onchange="filterDoctors()">
                        <option value="">Semua Spesialisasi</option>
                        <option>Spesialis Penyakit Dalam</option>
                        <option>Spesialis Obstetri &amp; Ginekologi</option>
                        <option>Spesialis Bedah Umum</option>
                        <option>Spesialis Anak</option>
                        <option>Spesialis Jantung &amp; Pembuluh Darah</option>
                        <option>Spesialis Saraf</option>
                    </select>
                </div>
                <div>
                    <label for="filterDay" class="block text-xs font-semibold text-slate-700 mb-1">Hari Praktik</label>
                    <select id="filterDay"
                        class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-cyan-600 transition"
                        onchange="filterDoctors()">
                        <option value="">Semua Hari</option>
                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                        <option>Sabtu</option>
                    </select>
                </div>
            </div>
            <div id="searchResults" class="text-xs text-slate-500 font-medium mt-3 hidden"></div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 3: DOCTOR GRID ═══ --}}
<section class="section bg-white" aria-label="Dokter Spesialis">
    <div class="container-xl">
        <div class="mb-8">
            <span class="section-label">Dokter Spesialis</span>
            <h2 class="section-title">Tim Dokter Kami</h2>
        </div>

        <div id="doctorGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" role="list">
            @php
            $colorMap = ['blue'=>'#2563eb','pink'=>'#be185d','green'=>'#16a34a','orange'=>'#d97706','red'=>'#dc2626','purple'=>'#7c3aed'];
            @endphp
            @foreach ($doctors as $doctor)
            @php $clr = $colorMap[$doctor['color']] ?? '#2563eb'; @endphp
            <article class="card flex flex-col h-full"
                role="listitem"
                data-name="{{ strtolower($doctor['name']) }}"
                data-spec="{{ $doctor['specialization'] }}"
                data-days="{{ collect($doctor['schedule'])->pluck('day')->join(',') }}">
                <div class="p-6 text-center border-b border-slate-100 flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mb-4 border-4 shrink-0" style="background-color: {{ $clr }}15; border-color: {{ $clr }}25">
                        <span class="text-2xl font-black" style="color: {{ $clr }}">{{ $doctor['initials'] }}</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1 leading-snug">
                        <a href="{{ route('doctors.detail', $doctor['slug']) }}" class="hover:text-blue-900 transition no-underline">
                            {{ $doctor['name'] }}
                        </a>
                    </h3>
                    <p class="text-xs font-bold mb-1" style="color: {{ $clr }}">{{ $doctor['specialization'] }}</p>
                    <p class="text-xs text-slate-400 mb-3">{{ $doctor['polyclinic'] }}</p>

                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600" aria-hidden="true"></span>
                        <span>{{ $doctor['experience'] }} Pengalaman</span>
                    </span>
                </div>

                <div class="p-5 flex flex-col flex-1 mt-auto">
                    <div class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Jadwal Praktik</div>
                    <div class="space-y-1.5 mb-5 flex-1 text-xs">
                        @foreach ($doctor['schedule'] as $sched)
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-slate-800">{{ $sched['day'] }}</span>
                            <span class="font-bold px-2 py-0.5 rounded-full" style="background-color: {{ $clr }}10; color: {{ $clr }}">
                                {{ $sched['time'] }}
                            </span>
                        </div>
                        @endforeach
                    </div>

                    <a href="{{ route('doctors.detail', $doctor['slug']) }}" class="btn btn-primary btn-sm w-full justify-center">
                        Lihat Profil &amp; Janji
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        {{-- Empty state --}}
        <div id="noResults" class="hidden text-center py-16 px-4 bg-slate-50 border border-slate-200 rounded-2xl">
            <i data-lucide="search-x" class="w-12 h-12 text-slate-400 mx-auto mb-3" aria-hidden="true"></i>
            <h3 class="text-base font-bold text-slate-900 mb-1">Dokter Tidak Ditemukan</h3>
            <p class="text-xs sm:text-sm text-slate-500">Coba ubah kata kunci pencarian atau filter spesialisasi Anda.</p>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function filterDoctors() {
    const searchVal = document.getElementById('searchDoctor').value.toLowerCase().trim();
    const specVal   = document.getElementById('filterSpec').value;
    const dayVal    = document.getElementById('filterDay').value;
    const articles  = document.querySelectorAll('#doctorGrid article');
    const noResults = document.getElementById('noResults');
    const resultCount = document.getElementById('searchResults');
    let visibleCount = 0;

    articles.forEach(art => {
        const nameMatch = !searchVal || art.dataset.name.includes(searchVal);
        const specMatch = !specVal   || art.dataset.spec === specVal;
        const dayMatch  = !dayVal    || art.dataset.days.includes(dayVal);

        if (nameMatch && specMatch && dayMatch) {
            art.style.display = '';
            visibleCount++;
        } else {
            art.style.display = 'none';
        }
    });

    if (noResults) {
        noResults.classList.toggle('hidden', visibleCount > 0);
    }
    if (resultCount) {
        if (searchVal || specVal || dayVal) {
            resultCount.textContent = `Menampilkan ${visibleCount} dokter sesuai filter.`;
            resultCount.classList.remove('hidden');
        } else {
            resultCount.classList.add('hidden');
        }
    }
}
</script>
@endpush
