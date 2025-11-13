<div class="modal fade" id="prodi-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_user_header">
                <h2 class="fw-bold">{{ $action === 'edit'? 'Edit' : "Tambah" }} Prodi</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="prodi-form" class="form" action="{{ $route }}" modal-action="{{ $action }}"
                    enctype="multipart/form-data">
                    @if($action == 'edit')
                    @method('PUT')
                    @endif
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10">
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Kode Prodi</label>
                            <input type="text" name="kode_prodi" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Kode Prodi (contoh: FA001)" autofocus
                                value="{{ $prodi->kode_prodi ?? old('kode_prodi') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Nama Prodi</label>
                            <input type="text" name="nama_prodi" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Nama Prodi"
                                value="{{ $prodi->nama_prodi ?? old('nama_prodi') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Fakultas</label>
                            <select name="fakultas_id" data-control="select2" data-placeholder="Pilih Fakultas"
                                class="form-select form-select-solid fw-bold">
                                <option value="">Pilih Fakultas</option>
                                @foreach($fakultas as $f)
                                <option value="{{ $f->id }}" {{ $prodi->fakultas_id == $f->id ? 'selected'
                                    : '' }}>
                                    {{ $f->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Deskripsi Prodi">{{ $prodi->deskripsi ?? old('deskripsi') }}</textarea>
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