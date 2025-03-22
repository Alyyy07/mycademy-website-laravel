<div class="modal modal-fullscreen fade" id="rps-detail-modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_user_header">
                <h2 class="fw-bold">@if ($action == 'create') Tambah @else Ubah @endif RPS Matakuliah</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="rps-detail-form" class="form" action="{{ $route }}" modal-action="{{ $action }}"
                    enctype="multipart/form-data">
                    @if ($action == 'edit')
                    @method('PUT')
                    @endif
                    <div class="d-flex flex-column px-5 px-lg-10">
                        <div class="fv-row mb-7">
                            <input type="hidden" name="rps_matakuliah_id" value="{{ $rpsDetail->rps_matakuliah_id }}" />
                            <label class="required fw-semibold fs-6 mb-2">Sesi Pertemuan</label>
                            <input type="number" name="sesi_pertemuan"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                value="{{ $rpsDetail->sesi_pertemuan ?? old('sesi_pertemuan') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Tanggal Pertemuan</label>
                            <input type="date" name="tanggal_pertemuan"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                value="{{ $rpsDetail->tanggal_pertemuan ?? old('tanggal_pertemuan') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <div class="ckeditor">
                            <label class="required fw-semibold fs-6 mb-2">Capaian Pembelajaran</label>
                            <input type="hidden" name="capaian_pembelajaran"
                                value="{{ $rpsDetail->capaian_pembelajaran ?? old('capaian_pembelajaran') }}" />
                                <div class="document-toolbar"></div>
                                <div class="document-editor"></div>
                            </div>
                        </div>
                        <div class="fv-row mb-7">
                            <div class="ckeditor">
                            <label class="required fw-semibold fs-6 mb-2">Indikator</label>
                            <input type="hidden" name="indikator"
                                value="{{ $rpsDetail->indikator ?? old('indikator') }}" />
                                <div class="document-toolbar"></div>
                                <div class="document-editor"></div>
                            </div>
                        </div>
                        <div class="fv-row mb-7">
                            <div class="ckeditor">
                            <label class="required fw-semibold fs-6 mb-2">Metode Pembelajaran</label>
                            <input type="hidden" name="metode_pembelajaran"
                                value="{{ $rpsDetail->metode_pembelajaran ?? old('metode_pembelajaran') }}" />
                                <div class="document-toolbar"></div>
                                <div class="document-editor"></div>
                            </div>
                        </div>
                        <div class="fv-row mb-7">
                            <div class="ckeditor">
                            <label class="required fw-semibold fs-6 mb-2">Kriteria Penilaian</label>
                            <input type="hidden" name="kriteria_penilaian"
                                value="{{ $rpsDetail->kriteria_penilaian ?? old('kriteria_penilaian') }}" />
                                <div class="document-toolbar"></div>
                                <div class="document-editor"></div>
                            </div>
                        </div>
                        <div class="fv-row mb-7">
                            <div class="ckeditor">
                            <label class="required fw-semibold fs-6 mb-2">Materi Pembelajaran</label>
                            <input type="hidden" name="materi_pembelajaran"
                                value="{{ $rpsDetail->materi_pembelajaran ?? old('materi_pembelajaran') }}" />
                                <div class="document-toolbar"></div>
                                <div class="document-editor"></div>
                            </div>
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
<script src="{{ asset('assets/js/custom-modal.js') }}"></script>
<script src="assets/plugins/custom/ckeditor/ckeditor-document.bundle.js"></script>
<script>
   $('.ckeditor').each(function(index){
    let editorElement = $(this).find('.document-editor').get(0);
    let toolbarContainer = $(this).find('.document-toolbar').get(0);
    let hiddenInput = $(this).find('input[type="hidden"]').get(0); // Ambil input hidden

    DecoupledEditor
        .create(editorElement)
        .then(editor => {
            toolbarContainer.appendChild(editor.ui.view.toolbar.element);
            window['editor' + index] = editor;

            // Set nilai CKEditor berdasarkan input hidden
            editor.setData(hiddenInput.value);

            // Simpan perubahan CKEditor ke input hidden
            editor.model.document.on('change:data', () => {
                hiddenInput.value = editor.getData();
            });
        })
        .catch(error => {
            console.error('CKEditor Error:', error);
        });
});
</script>