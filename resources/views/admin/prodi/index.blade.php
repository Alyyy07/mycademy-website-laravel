@extends('layouts.partials.admin.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
@endpush
@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <input type="text" data-action="search" class="form-control form-control-solid w-250px ps-13"
                    placeholder="Search Prodi" />
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" user-toolbar="base">
                @can($globalModule['create'])
                <button type="button" button-action="show" modal-id="#prodi-modal"
                    button-url="{{ route('akademik.prodi.create') }}" class="btn btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>Tambah Prodi</button>
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