<div>
    <div class="position-relative">
        <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click"
            data-kt-menu-placement="bottom-end">Actions
            <i class="ki-duotone ki-down fs-5 ms-1"></i>
        </button>
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
            data-kt-menu="true">

            @can($globalModule['update'])
            <div class="menu-item px-3" data-action="edit" button-url="{{ $editRoute }}" modal-id="#fakultas-modal">
                <a class="menu-link px-3 btn btn-light btn-active-light-warning"><i class="bi bi-pen me-2"></i> Edit</a>
            </div>
            @else
            <div class="menu-item px-3">
                <a class="menu-link px-3 btn btn-light btn-active-light-warning text-muted"
                    style="pointer-events: none; opacity: 0.5;"><i class="bi bi-pen me-2"></i> Edit</a>
            </div>
            @endcan

            @can($globalModule['delete'])
            <div class="menu-item px-3" data-action="delete" button-url="{{ $deleteRoute }}" modal-id="#fakultas-modal">
                <a class="menu-link px-3 btn btn-light btn-active-light-danger"><i class="bi bi-trash me-2"></i>
                    Delete</a>
            </div>
            @else
            <div class="menu-item px-3">
                <a class="menu-link px-3 text-muted btn btn-light btn-active-light-danger"
                    style="pointer-events: none; opacity: 0.5;"><i class="bi bi-trash me-2"></i> Delete</a>
            </div>
            @endcan
        </div>
    </div>
</div>