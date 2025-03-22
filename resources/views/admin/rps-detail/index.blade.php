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
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" user-toolbar="base">
                @can($globalModule['create'])
                <button type="button" button-action="show" modal-id="#rps-detail-modal"
                button-url="{{ route('rps-detail.create',['id'=>$rpsMatakuliah->id]) }}"
                class="btn btn-primary">
                <i class="ki-duotone ki-plus fs-2"></i>Tambah Detail RPS</button>
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