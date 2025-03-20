<div class="modal fade" id="rps-matakuliah-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_user_header">
                <h2 class="fw-bold">{{ $action === 'edit'? 'Edit' : "Tambah" }} RPS Matakuliah</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="rps-matakuliah-form" class="form" action="{{ $route }}" modal-action="{{ $action }}"
                    enctype="multipart/form-data">
                    @if($action == 'edit')
                    @method('PUT')
                    @endif
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10">
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Matakuliah</label>
                            <select name="mapping_matakuliah_id" data-control="select2"
                                data-placeholder="Pilih Matakuliah" class="form-select form-select-solid fw-bold">
                                <option value="">Pilih Matakuliah</option>
                                @foreach($mappingMatakuliah as $m)
                                <option value="{{ $m->id }}" {{ $rps->mapping_matakuliah_id == $m->id ? 'selected'
                                    : '' }}>
                                    {{ $m->matakuliah->nama_matakuliah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Tanggal Mulai"
                                value="{{ $rps->tanggal_mulai ?? old('tanggal_mulai') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Tanggal Selesai"
                                value="{{ $rps->tanggal_selesai ?? old('tanggal_selesai') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Jumlah Pertemuan</label>
                            <input type="number" name="jumlah_pertemuan" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Jumlah Pertemuan" min="1" max="99"
                                value="{{ $rps->jumlah_pertemuan ?? old('jumlah_pertemuan') }}" />
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