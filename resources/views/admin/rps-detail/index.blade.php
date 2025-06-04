@extends('layouts.partials.admin.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
@endpush

@section('content')
<div class="card mb-5">
    <div class="card-header border-0 pt-6">
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                <a href="{{ route('rps-matakuliah.index') }}" class="btn btn-light me-3">Kembali</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <h3 class="mb-4">Detail RPS Matakuliah</h3>
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start">
                <table class="table table-borderless table-lg fs-5">
                    <tr>
                        <th class="ps-0">Tahun Ajaran</th>
                        <td>: {{ $rpsMatakuliah->mappingMatakuliah->tahunAjaran->tahun_ajaran }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0">Kode Matakuliah</th>
                        <td>: {{ $rpsMatakuliah->mappingMatakuliah->matakuliah->kode_matakuliah }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0" style="width: 45%;">Nama Mata Kuliah</th>
                        <td>: {{ $rpsMatakuliah->mappingMatakuliah->matakuliah->nama_matakuliah }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0">Semester</th>
                        <td>: {{ $rpsMatakuliah->mappingMatakuliah->semester }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0">Dosen Pengampu</th>
                        <td>: {{ optional($rpsMatakuliah->mappingMatakuliah->dosen)->name ?? '-' }}</td>
                    </tr>

                </table>
            </div>

            <div class="col-md-6 d-flex justify-content-end">
                <table class="table table-borderless table-lg fs-5">
                    <tr>
                        <th class="ps-0" style="width: 45%;">Tanggal Mulai</th>
                        <td>: {{ \Carbon\Carbon::parse($rpsMatakuliah->tanggal_mulai)->locale('id')->translatedFormat('d
                            F Y') }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0">Tanggal Selesai</th>
                        <td>: {{
                            \Carbon\Carbon::parse($rpsMatakuliah->tanggal_selesai)->locale('id')->translatedFormat('d F
                            Y') }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0">Jumlah Pertemuan</th>
                        <td>: {{ $rpsMatakuliah->rpsDetails->count() }} pertemuan</td>
                    </tr>
                    <tr>
                        <th class="ps-0">Admin Verifier</th>
                        <td>: {{ optional($rpsMatakuliah->mappingMatakuliah->adminVerifier)->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0">Terakhir Diubah</th>
                        <td>:
                            @php
                            $lastUpdatedRpsDetail = $rpsMatakuliah->rpsDetails->sortByDesc('updated_at')->first();
                            @endphp
                            {{ $lastUpdatedRpsDetail ? $lastUpdatedRpsDetail->updated_at->diffForHumans() : '-' }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-end border-0 pt-6">
        @can($globalModule['create'])
        <button type="button" button-action="show" modal-id="#rps-detail-modal"
            button-url="{{ route('rps-detail.create', ['id' => $rpsMatakuliah->id]) }}" class="btn btn-primary">
            <i class="ki-duotone ki-plus fs-2"></i> Tambah Detail RPS
        </button>
        @endcan
    </div>
    <div class="card-body py-4">
        {{ $dataTable->table() }}
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush