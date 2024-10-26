@extends('layouts.partials.admin.app')
@section('content')
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                <div class="col-md-4">
                    <div class="card card-flush h-md-100">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Administrator</h2>
                            </div>
                        </div>
                        <div class="card-body pt-1">
                            <div class="fw-bold text-gray-600 mb-5">Total users with this role: 5</div>
                            <div class="d-flex flex-column text-gray-600">
                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>All Admin Controls
                                </div>
                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>View and Edit Financial Summaries
                                </div>
                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>Enabled Bulk Reports
                                </div>
                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>View and Edit Payouts
                                </div>
                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>View and Edit Disputes
                                </div>
                                <div class='d-flex align-items-center py-2'>
                                    <span class='bullet bg-primary me-3'></span>
                                    <em>and 7 more...</em>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer flex-wrap pt-0">
                            <a href="../../demo1/dist/apps/user-management/roles/view.html"
                                class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
                            <button type="button" class="btn btn-light btn-active-light-primary my-1"
                                data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Edit Role</button>
                        </div>
                    </div>
                </div>
                <div class="ol-md-4">
                    <div class="card h-md-100">
                        <div class="card-body d-flex flex-center">
                            <button type="button" class="btn btn-clear d-flex flex-column flex-center"
                                data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                                <img src="assets/media/illustrations/sketchy-1/4.png" alt=""
                                    class="mw-100 mh-150px mb-7" />
                                <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.role.partials.modal')
@endsection