<div class="modal fade" id="tahun-ajaran-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_user_header">
                <h2 class="fw-bold">{{ $action === 'edit'? 'Edit' : "Tambah" }} Tahun Ajaran</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="tahun-ajaran-form" class="form" action="{{ $route }}" modal-action="{{ $action }}"
                    enctype="multipart/form-data">
                    @if($action == 'edit')
                    @method('PUT')
                    @endif
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_user_header"
                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <div class="fv-row mb-7">
                            @php
                            [$tahunAjaranAwal,$tahunAjaranAkhir] = $tahunAjaran->tahun_ajaran ? explode('/',
                            $tahunAjaran->tahun_ajaran) : null;
                            @endphp
                            <label class="required fw-semibold fs-6 mb-2">Kode Tahun Ajaran</label>
                            <input type="text" name="kode_tahun_ajaran"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Kode Tahun Ajaran (contoh: TH241)" autofocus
                                value="{{ $tahunAjaran->kode_tahun_ajaran ?? old('kode_tahun_ajaran') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Tahun Ajaran</label>
                            <div class="d-flex align-items-center">
                                <input type="number" name="tahun_ajaran_awal"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Tahun Awal"
                                    min="2000" max="2999" maxlength="4"
                                    value="{{ $tahunAjaran->tahun_ajaran ? $tahunAjaranAwal : old('tahun_ajaran_awal') }}" />
                                <span class="fs-6 fw-bold text-muted mx-2">/</span>
                                <input type="number" name="tahun_ajaran_akhir"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Tahun Akhir"
                                    min="2000" max="2999" maxlength="4"
                                    value="{{ $tahunAjaran->tahun_ajaran ? $tahunAjaranAkhir : old('tahun_ajaran_akhir') }}" />
                            </div>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Tahun Ajaran"
                                value="{{ $tahunAjaran->tanggal_mulai ?? old('tanggal_mulai') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Tahun Ajaran"
                                value="{{ $tahunAjaran->tanggal_selesai ?? old('tanggal_selesai') }}" />
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