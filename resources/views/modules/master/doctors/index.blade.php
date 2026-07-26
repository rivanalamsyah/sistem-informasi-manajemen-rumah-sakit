@extends('layouts.admin')

@section('title', 'Master Dokter')

@section('content')
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <x-breadcrumb :items="[
                ['label' => 'Master Data', 'url' => route('master.index')],
                ['label' => 'Dokter', 'url' => null]
            ]" />
            <h4 class="fw-bold text-dark mb-1">Master Dokter Spesialis & Umum</h4>
            <p class="text-muted fs-7 mb-0">Daftar dokter terdaftar di RSUD Kencana Medika.</p>
        </div>
        <a href="{{ route('master.doctors.create') }}" class="btn btn-teal rounded-pill px-4 shadow-sm fw-semibold">
            <i class="bi bi-plus-lg me-1"></i> Tambah Dokter Baru
        </a>
    </div>

    <!-- Filter Bar -->
    <x-card class="bg-white border-0 mb-4">
        <form method="GET" action="{{ route('master.doctors.index') }}" class="row g-3">
            <div class="col-12 col-md-5 col-lg-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0 fs-7" placeholder="Cari nama, SIP, spesialisasi..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-3">
                <select name="department_id" class="form-select bg-light fs-7">
                    <option value="">-- Semua Poliklinik --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-teal btn-sm px-3 rounded-3 fw-semibold"><i class="bi bi-filter"></i> Filter</button>
                <a href="{{ route('master.doctors.index') }}" class="btn btn-light btn-sm px-3 rounded-3 border">Reset</a>
            </div>
        </form>
    </x-card>

    <!-- Table Data -->
    <x-card class="bg-white border-0">
        <x-table :headers="['SIP / Nama Dokter', 'Spesialisasi', 'Poliklinik', 'Kontak', 'Status', 'Aksi']">
            @forelse($doctors as $doc)
                <tr>
                    <td>
                        <div class="fw-bold text-dark fs-7">{{ $doc->full_name }}</div>
                        <small class="text-teal font-monospace fs-8">{{ $doc->sip }}</small>
                    </td>
                    <td class="fs-7">{{ $doc->specialization }}</td>
                    <td class="fs-7 fw-medium text-dark">{{ $doc->department->name ?? '-' }}</td>
                    <td class="fs-7">
                        <div><i class="bi bi-telephone text-muted me-1"></i>{{ $doc->phone }}</div>
                        <small class="text-muted"><i class="bi bi-envelope me-1"></i>{{ $doc->email ?? '-' }}</small>
                    </td>
                    <td>
                        <x-badge :type="$doc->is_active ? 'Aktif' : 'Batal'">
                            {{ $doc->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </x-badge>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <a href="{{ route('master.doctors.edit', $doc) }}" class="btn btn-light btn-sm rounded-circle" title="Ubah">
                                <i class="bi bi-pencil-square text-warning"></i>
                            </a>
                            <form action="{{ route('master.doctors.destroy', $doc) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Dokter ini?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light btn-sm rounded-circle text-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <x-empty-state title="Belum Ada Data Dokter" description="Tidak ditemukan data dokter sesuai filter pencarian." />
                    </td>
                </tr>
            @endforelse
        </x-table>

        <div class="mt-3">
            {{ $doctors->links() }}
        </div>
    </x-card>
@endsection
