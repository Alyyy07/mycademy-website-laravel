@extends('layouts.partials.admin.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
@endpush
@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title gap-3">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <input type="text" data-action="search" class="form-control form-control-solid w-250px ps-13"
                    placeholder="Cari" />
            </div>
            <div class="d-flex align-items-center position-relative my-1">
                <select name="matakuliah_id" data-table="#matakuliah-table" data-action="filter"
                    data-url="{{ route('akademik.matakuliah.index') }}" data-control="select2" data-allow-clear="true"
                    data-placeholder="Pilih Prodi" class="form-select form-select-solid w-250px fw-bold">
                    <option value="">Pilih Prodi</option>
                    @foreach($prodi as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" user-toolbar="base">
                @can($globalModule['create'])
                <button type="button" button-action="show" modal-id="#matakuliah-modal"
                    button-url="{{ route('akademik.matakuliah.create') }}" class="btn btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>Tambah Matakuliah</button>
                @endcan
            </div>
        </div>
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