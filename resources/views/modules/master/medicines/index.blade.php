@extends('layouts.admin')

@section('title', 'Master Katalog Obat & Alkes')

@section('content')
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <x-breadcrumb :items="[
                ['label' => 'Master Data', 'url' => route('master.index')],
                ['label' => 'Obat & Alkes', 'url' => null]
            ]" />
            <h4 class="fw-bold text-dark mb-1">Master Katalog Obat & Alkes</h4>
            <p class="text-muted fs-7 mb-0">Pengaturan data obat, golongan, HPP beli, harga jual, dan stok minimal.</p>
        </div>
        <a href="{{ route('master.medicines.create') }}" class="btn btn-teal rounded-pill px-4 shadow-sm fw-semibold">
            <i class="bi bi-plus-lg me-1"></i> Tambah Obat Baru
        </a>
    </div>

    <!-- Filter Bar -->
    <x-card class="bg-white border-0 mb-4">
        <form method="GET" action="{{ route('master.medicines.index') }}" class="row g-3">
            <div class="col-12 col-md-5 col-lg-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0 fs-7" placeholder="Cari kode, nama obat/generik..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-3">
                <select name="category_id" class="form-select bg-light fs-7">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-teal btn-sm px-3 rounded-3 fw-semibold"><i class="bi bi-filter"></i> Filter</button>
                <a href="{{ route('master.medicines.index') }}" class="btn btn-light btn-sm px-3 rounded-3 border">Reset</a>
            </div>
        </form>
    </x-card>

    <!-- Table Data -->
    <x-card class="bg-white border-0">
        <x-table :headers="['Kode / Nama Obat', 'Kategori', 'Satuan / Golongan', 'Harga Beli (HPP)', 'Harga Jual', 'Stok Min', 'Aksi']">
            @forelse($medicines as $med)
                <tr>
                    <td>
                        <div class="fw-bold text-dark fs-7">{{ $med->name }}</div>
                        <small class="text-teal font-monospace fs-8">{{ $med->code }}</small>
                        @if($med->generic_name)
                            <div class="text-muted fs-8">Generik: {{ $med->generic_name }}</div>
                        @endif
                    </td>
                    <td class="fs-7 fw-medium text-dark">{{ $med->category->name ?? '-' }}</td>
                    <td class="fs-7">
                        <div>{{ $med->unit }}</div>
                        <small class="badge bg-secondary-subtle text-secondary">{{ $med->type }}</small>
                    </td>
                    <td class="fs-7 text-muted">Rp {{ number_format($med->purchase_price, 0, ',', '.') }}</td>
                    <td class="fs-7 fw-bold text-success">Rp {{ number_format($med->selling_price, 0, ',', '.') }}</td>
                    <td class="fs-7 fw-semibold">{{ $med->min_stock }} {{ $med->unit }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <a href="{{ route('master.medicines.edit', $med) }}" class="btn btn-light btn-sm rounded-circle" title="Ubah">
                                <i class="bi bi-pencil-square text-warning"></i>
                            </a>
                            <form action="{{ route('master.medicines.destroy', $med) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Obat ini?');" class="d-inline">
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
                    <td colspan="7">
                        <x-empty-state title="Belum Ada Data Obat" description="Tidak ditemukan data katalog obat sesuai kriteria pencarian." />
                    </td>
                </tr>
            @endforelse
        </x-table>

        <div class="mt-3">
            {{ $medicines->links() }}
        </div>
    </x-card>
@endsection
