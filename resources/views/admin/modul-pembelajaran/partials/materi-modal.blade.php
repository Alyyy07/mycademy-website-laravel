<div class="modal fade" id="materi-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_user_header">
                <h2 class="fw-bold">Tipe Materi</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="materi-form" class="form" action="{{ $route }}" method="POST">
                    @csrf
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10">
                        <div class="fv-row mb-7">
                            <input type="hidden" name="rps_detail_id" id="rps_detail_id" value="{{ $rpsDetailId }}">
                            <label class="required fw-semibold fs-6 mb-2">Tipe Materi</label>
                            <select name="tipe_materi" data-control="select2" required data-placeholder="Pilih Tipe Materi"
                                class="form-select form-select-solid fw-bold">
                                <option value="">Pilih Tipe Materi</option>
                                <option value="pdf">PDF</option>
                                <option value="video">Video</option>
                                <option value="teks">Teks</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center pt-10">
                        <button type="reset" class="btn btn-light me-3">Reset</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('[data-control="select2"]').select2({
        dropdownParent: $('#materi-modal'),
        placeholder: "Pilih Tipe Materi",
        allowClear: true,
    });
</script>