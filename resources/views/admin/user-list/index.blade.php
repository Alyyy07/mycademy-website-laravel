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
                    placeholder="Search user" />
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" user-toolbar="base">
                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_export_users">
                    <i class="ki-duotone ki-exit-up fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Export</button>
                @can($globalModule['create'])
                <button type="button" button-action="show" modal-id="#user-modal"
                    button-url="{{ route('user-management.users.create') }}" class="btn btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>Add User</button>
                @endcan
            </div>
            <div class="btn-group d-none" user-toolbar="selected-user">
                <button type="button" selected-button class="btn btn-danger"></button>
                <button type="button" @canany([$globalModule['update'],$globalModule['delete']]) @else disabled @endcanany
                    dropdown-option class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    @can($globalModule['delete'])
                    <a class="dropdown-item cursor-pointer" delete-option
                        button-url="{{ route('user-management.users.bulkDelete') }}">Delete 3 Users</a>
                    @endcan
                    @can($globalModule['update'])
                    <a class="dropdown-item cursor-pointer" deactivate-option
                        button-url="{{ route('user-management.users.bulkSetStatus') }}">Deactivate 5
                        Users</a>
                    <a class="dropdown-item cursor-pointer" activate-option
                        button-url="{{ route('user-management.users.bulkSetStatus') }}">Activate 4
                        Users</a>
                    @endcan
                </div>
            </div>
            @include('admin.user-list.partials.export-modal')
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