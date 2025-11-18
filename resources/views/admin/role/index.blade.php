@extends('layouts.partials.admin.app')
@section('content')
<div class="role-card-container row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
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
                    @if($loop->iteration >= 3 && $loop->remaining > 1)
                    <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3 italic"></span> and {{ $loop->remaining }} more...
                    </div>
                    @break
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="card-footer flex-wrap pt-0 gap-3 justify-content-center d-flex">
                @can($globalModule['delete'])
                <button type="button" class="btn btn-active-danger btn-light-danger my-1" button-action="delete"
                    button-url="{{ route('user-management.roles.destroy',$role['id']) }}"> Delete
                    Role</button>
                @endcan
                @can($globalModule['update'])
                <button type="button" class="btn btn-warning btn-active-light-warning my-1" button-action="show"
                    modal-id="#role-modal" button-url="{{ route('user-management.roles.edit',$role['id']) }}"> Edit
                    Role</button>
                @endcan
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