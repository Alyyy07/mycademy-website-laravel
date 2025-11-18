<div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Export Users</h2>
                <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="kt_modal_export_users_form" class="form" action="#">
                    <div class="fv-row mb-10">
                        <label class="fs-6 fw-semibold form-label mb-2">Select
                            Roles:</label>
                        <select name="role" data-control="select2" data-placeholder="Select a role"
                            data-hide-search="true" class="form-select form-select-solid fw-bold">
                            <option></option>
                            <option value="Administrator">Administrator</option>
                            <option value="Analyst">Analyst</option>
                            <option value="Developer">Developer</option>
                            <option value="Support">Support</option>
                            <option value="Trial">Trial</option>
                        </select>
                    </div>
                    <div class="fv-row mb-10">
                        <label class="required fs-6 fw-semibold form-label mb-2">Select
                            Export Format:</label>
                        <select name="format" data-control="select2" data-placeholder="Select a format"
                            data-hide-search="true" class="form-select form-select-solid fw-bold">
                            <option></option>
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                            <option value="cvs">CVS</option>
                            <option value="zip">ZIP</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="reset" class="btn btn-light me-3">Reset</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
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