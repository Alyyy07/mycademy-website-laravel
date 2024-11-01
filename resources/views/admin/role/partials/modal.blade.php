<div class="modal fade" id="role-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Add a Role</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body scroll-y mx-lg-5 my-7">
                <form id="role_form" class="form" action="{{ $route }}" modal-action="{{ $action }}">
                    @if ($action == 'edit')
                        @method('PUT')
                    @endif
                    <div class="d-flex flex-column scroll-y me-n7 pe-7 ps-1">
                        <div class="fv-row mb-10">
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">Role name</span>
                            </label>
                            <input class="form-control form-control-solid" placeholder="Enter a role name"
                                name="role_name" />
                        </div>
                        <div class="fv-row">
                            <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                    <tbody class="text-gray-600 fw-semibold">
                                        <tr>
                                            <td class="text-gray-800">Administrator Access
                                                <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover"
                                                    data-bs-html="true"
                                                    data-bs-content="Allows a full access to the system">
                                                    <i class="ki-duotone ki-information fs-7">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </td>
                                            <td>
                                                <label class="form-check form-check-custom form-check-solid me-9">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="kt_roles_select_all" />
                                                    <span class="form-check-label" for="kt_roles_select_all">Select
                                                        all</span>
                                                </label>
                                            </td>
                                        </tr>
                                        @php
                                        $permissions = ['create', 'read', 'update', 'delete'];
                                        @endphp
                                        @foreach ($menus as $menu)
                                        <tr>
                                            <td class="text-gray-800">{{ $menu->name }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @foreach ($permissions as $permission)
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                        <input class="form-check-input permission-checkbox"
                                                            type="checkbox" value="{{ $menu->module . '-' . $permission }}"
                                                            name="permissions[]" />
                                                        <span class="form-check-label">{{ ucfirst($permission) }}</span>
                                                    </label>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        @foreach ($menu->childrens as $submenu)
                                        <tr>
                                            <td class="text-gray-800">{{ $menu->name . " - " . $submenu->name }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @foreach ($permissions as $permission)
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                        <input class="form-check-input permission-checkbox"
                                                            type="checkbox" value="{{ $submenu->module . '-' . $permission }}"
                                                            name="permissions[]" />
                                                        <span class="form-check-label">{{ ucfirst($permission) }}</span>
                                                    </label>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3"
                            data-kt-roles-modal-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/custom-modal.js') }}"></script>