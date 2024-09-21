<div style="height: 60px">
    <div class="position-relative">
        <button class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click"
            data-kt-menu-placement="bottom-end">Actions
            <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
            data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3" data-action="edit" button-action="edit" button-url="{{ $editRoute }}"
                modal-id="#user-modal">
                <a class="menu-link px-3">Edit</a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3" data-action="delete" button-action="delete" button-url="{{ $deleteRoute }}">
                <a class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
            </div>
            <!--end::Menu item-->
        </div>
    </div>
</div>