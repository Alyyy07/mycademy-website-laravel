@extends('layouts.partials.admin.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
@endpush
@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                    <a href="{{ route('rps-matakuliah.index') }}" class="btn btn-light me-3">Kembali</a>
                </div>
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