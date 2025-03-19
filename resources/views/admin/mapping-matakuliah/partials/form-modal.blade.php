<div class="modal fade" id="mapping-matakuliah-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_user_header">
                <h2 class="fw-bold">{{ $action === 'edit'? 'Edit' : "Tambah" }} Mapping Matakuliah</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            @php
            $tahunAktif = App\Models\Akademik\TahunAjaran::getActive();
            @endphp
            @if ($tahunAktif)
            <div class="modal-body px-5 my-7">
                <div
                    class="notice d-flex bg-light-primary rounded border-primary border border-dashed rounded-3 p-6 ms-10 me-14 mb-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-grow-1">
                        <!--begin::Content-->
                        <div class="fw-semibold">
                            <div class="fs-6 text-gray-700">Matakuliah akan ditambahkan pada Tahun Ajaran {{
                                $tahunAktif['tahun_ajaran'] }}
                            </div>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <form id="mapping-matakuliah-form" class="form" action="{{ $route }}" modal-action="{{ $action }}"
                    enctype="multipart/form-data">
                    @if($action == 'edit')
                    @method('PUT')
                    @endif
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10">
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Matakuliah</label>
                            <select name="matakuliah_id" data-control="select2" data-placeholder="Pilih Matakuliah"
                                class="form-select form-select-solid fw-bold">
                                <option value="">Pilih Matakuliah</option>
                                @foreach($matakuliah as $m)
                                <option value="{{ $m->id }}" {{ $mappingMatakuliah->matakuliah_id == $m->id ? 'selected'
                                    : '' }}>
                                    {{ $m->nama_matakuliah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Dosen</label>
                            <select name="dosen_id" data-control="select2" data-placeholder="Pilih Dosen"
                                class="form-select form-select-solid fw-bold">
                                <option value="">Pilih Dosen</option>
                                @foreach($dosen as $d)
                                <option value="{{ $d->id }}" {{ $mappingMatakuliah->dosen_id == $d->id ? 'selected' : ''
                                    }}>
                                    {{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Admin Verifier</label>
                            <select name="admin_verifier_id" data-control="select2"
                                data-placeholder="Pilih Admin Verifier" class="form-select form-select-solid fw-bold">
                                <option value="">Pilih Admin Verifier</option>
                                @foreach($adminVerifier as $av)
                                <option value="{{ $av->id }}" {{ $mappingMatakuliah->admin_verifier_id == $av->id ?
                                    'selected'
                                    : '' }}>
                                    {{ $av->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Semester</label>
                            <input type="number" name="semester" class="form-control form-control-solid fw-bold"
                                placeholder="Masukkan Semester" value="{{ $mappingMatakuliah->semester }}" />
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
            @else
            <div class="modal-body px-5">
                <div class="d-flex flex-column scroll-y px-5 px-lg-10">
                    <div
                        class="notice d-flex bg-light-danger rounded border-danger border border-dashed rounded-3 p-6">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1">
                            <!--begin::Content-->
                            <div class="fw-semibold">
                                <div class="fs-6 text-gray-700">Tidak ada Tahun Ajaran Aktif</div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/custom-modal.js') }}"></script>