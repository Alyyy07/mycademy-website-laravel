<div>
    <div class="position-relative">
        <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click"
            data-kt-menu-placement="bottom-end">Actions
            <i class="ki-duotone ki-down fs-5 ms-1"></i>
        </button>
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
            data-kt-menu="true">

            @can($globalModule['update'])
            <div class="menu-item px-3" data-action="edit" button-url="{{ $editRoute }}" modal-id="#fakultas-modal">
                <a class="menu-link px-3">Edit</a>
            </div>
            @else
            <div class="menu-item px-3">
                <a class="menu-link px-3 text-muted" style="pointer-events: none; opacity: 0.5;">Edit</a>
            </div>
            @endcan
            
            @can($globalModule['delete'])
            <div class="menu-item px-3" data-action="delete" button-url="{{ $deleteRoute }}" modal-id="#fakultas-modal">
                <a class="menu-link px-3">Delete</a>
            </div>
            @else
            <div class="menu-item px-3">
                <a class="menu-link px-3 text-muted" style="pointer-events: none; opacity: 0.5;">Delete</a>
            </div>
            @endcan
        </div>
    </div>
</div>