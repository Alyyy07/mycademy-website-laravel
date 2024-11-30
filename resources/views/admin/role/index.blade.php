@extends('layouts.partials.admin.app')
@section('content')
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
    @foreach ($roles as $role)
    <div class="col-md-4">
        <div class="card card-flush h-md-100">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    <h2>{{ $role['role'] }}</h2>
                </div>
            </div>
            <div class="card-body pt-1">
                <div class="fw-bold text-gray-600 mb-5">Total users with this role: {{ $role['users'] }}</div>
                <div class="d-flex flex-column text-gray-600">
                    @foreach ($role['permissions'] as $permission)
                    <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>{{ $permission }}
                    </div>
                    @if($loop->iteration >= 5)
                    <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3 italic"></span> and {{ $loop->remaining }} more...
                    </div>
                    @break
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="card-footer flex-wrap pt-0 justify-content-center d-flex">
                <button type="button" class="btn btn-light btn-active-light-primary my-1" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_update_role">Edit Role</button>
            </div>
        </div>
    </div>
    @endforeach
    <div class="ol-md-4">
        <div class="card h-md-100">
            <div class="card-body d-flex flex-center">
                <button type="button" class="btn btn-clear d-flex flex-column flex-center" button-action="show"
                    modal-id="#role-modal" button-url="{{ route('user-management.roles.create') }}">
                    <img src="assets/media/illustrations/sketchy-1/4.png" alt="" class="mw-100 mh-150px mb-7" />
                    <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
@endpush