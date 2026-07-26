@extends('layouts.admin')

@section('title', 'Detail Poliklinik')

@section('content')
    <div class="mb-4">
        <x-breadcrumb :items="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Poliklinik', 'url' => route('master.departments.index')],
            ['label' => 'Detail Poli', 'url' => null]
        ]" />
        <div class="d-flex align-items-center justify-content-between">
            <h4 class="fw-bold text-dark mb-1">{{ $department->name }} ({{ $department->code }})</h4>
            <a href="{{ route('master.departments.edit', $department) }}" class="btn btn-warning btn-sm rounded-pill px-3 fw-semibold">
                <i class="bi bi-pencil-square me-1"></i> Edit Data
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <x-card title="Informasi Poliklinik" icon="hospital">
                <table class="table table-borderless fs-7 mb-0">
                    <tr>
                        <td class="text-muted w-35">Kode Poli:</td>
                        <td class="fw-bold text-teal">{{ $department->code }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nama Poli:</td>
                        <td class="fw-semibold text-dark">{{ $department->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status:</td>
                        <td><x-badge :type="$department->is_active ? 'Aktif' : 'Batal'">{{ $department->is_active ? 'Aktif' : 'Non-Aktif' }}</x-badge></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Deskripsi:</td>
                        <td>{{ $department->description ?? '-' }}</td>
                    </tr>
                </table>
            </x-card>
        </div>

        <div class="col-12 col-md-6">
            <x-card title="Dokter Praktik di Poli Ini" icon="person-badge-fill">
                <x-table :headers="['Nama Dokter', 'SIP', 'Spesialisasi']">
                    @forelse($department->doctors as $doc)
                        <tr>
                            <td class="fw-semibold text-dark fs-7">{{ $doc->full_name }}</td>
                            <td class="fs-7 text-muted">{{ $doc->sip }}</td>
                            <td class="fs-7">{{ $doc->specialization }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-3 text-muted fs-7">Belum ada dokter terdaftar di poli ini.</td>
                        </tr>
                    @endforelse
                </x-table>
            </x-card>
        </div>
    </div>
@endsection
