<div class="modal fade" id="fakultas-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_user_header">
                <h2 class="fw-bold">{{ $action === 'edit'? 'Edit' : "Tambah" }} Fakultas</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="fakultas-form" class="form" action="{{ $route }}" modal-action="{{ $action }}"
                    enctype="multipart/form-data">
                    @if($action == 'edit')
                    @method('PUT')
                    @endif
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10">
                        <div class="fv-row text-center mb-7">
                            <label class="d-block fw-semibold fs-6 mb-5">Logo Fakultas</label>
                            <div class="image-input image-input-circle image-input-placeholder">
                                <div class="image-input-wrapper w-125px h-125px"
                                    style="background-image: url('storage/{{ $fakultas->logo ?? 'image/profile-photo/blank.png' }}');">
                                </div>
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change">
                                    <i class="ki-duotone ki-pencil fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="file" name="logo" />
                                </label>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary d-none w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div class="image-feedback"></div>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Kode Fakultas</label>
                            <input type="text" name="kode_fakultas" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Kode Fakultas (contoh: FA001)" autofocus
                                value="{{ $fakultas->kode_fakultas ?? old('kode_fakultas') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Nama Fakultas</label>
                            <input type="text" name="nama_fakultas" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Nama Fakultas"
                                value="{{ $fakultas->nama_fakultas ?? old('nama_fakultas') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Deskripsi Fakultas">{{ $fakultas->deskripsi ?? old('deskripsi') }}</textarea>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Email</label>
                            <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="example@domain.com" value="{{ $fakultas->email ?? old('email') }}" />
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