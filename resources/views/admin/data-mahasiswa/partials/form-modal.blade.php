<div class="modal fade" id="data-mahasiswa-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_user_header">
                <h2 class="fw-bold">{{ $action === 'edit'? 'Edit' : "Tambah" }} Data Mahasiswa</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="data-mahasiswa-form" class="form" action="{{ $route }}" modal-action="{{ $action }}"
                    enctype="multipart/form-data">
                    @if($action == 'edit')
                    @method('PUT')
                    @endif
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-3">Mahasiswa</label>
                            <div class="d-flex align-items-center">
                                <div class='symbol symbol-circle symbol-75px overflow-hidden me-3'>
                                    <div class='symbol-label'>
                                        @php
                                        $photoPath = $mahasiswa->user->profile_photo ?? 'image/profile-photo/blank.png';
                                        @endphp
                                        <img src='{{ asset("storage/$photoPath") }}' alt='{{$mahasiswa->user->name }}'
                                            class='w-100' />
                                    </div>
                                </div>
                                <div class='d-flex flex-column'>
                                    <p class='text-gray-800 mb-1 fw-bold text-capitalize'>{{$mahasiswa->user->name }}
                                    </p>
                                    <span>{{ $mahasiswa->user->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">NPM</label>
                            <input type="text" name="npm" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan NPM" value="{{ $mahasiswa->npm ?? old('npm') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Prodi</label>
                            <select name="prodi_id" data-control="select2" data-placeholder="Pilih Prodi"
                                class="form-select form-select-solid fw-bold">
                                <option value="">Pilih Prodi</option>
                                @foreach($prodi as $p)
                                <option value="{{ $p->id }}" {{ $mahasiswa->prodi_id == $p->id ? 'selected'
                                    : '' }}>
                                    {{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">NIK</label>
                            <input type="text" name="nik" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan NIK" value="{{ $mahasiswa->nik ?? old('nik') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Tempat Lahir"
                                value="{{ $mahasiswa->tempat_lahir ?? old('tempat_lahir') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control form-control-solid mb-3 mb-lg-0"
                                value="{{ $mahasiswa->tanggal_lahir ?? old('tanggal_lahir') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Jenis Kelamin</label>
                            <select name="jenis_kelamin" data-control="select2" data-placeholder="Pilih Jenis Kelamin"
                                class="form-select form-select-solid fw-bold">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Pria" {{ $mahasiswa->jenis_kelamin == 'Pria' ? 'selected' : '' }}>Pria
                                </option>
                                <option value="Wanita" {{ $mahasiswa->jenis_kelamin == 'Wanita' ? 'selected' : ''
                                    }}>Wanita</option>
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Agama</label>
                            <input type="text" name="agama" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Agama" value="{{ $mahasiswa->agama ?? old('agama') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Alamat</label>
                            <textarea name="alamat" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Alamat">{{ $mahasiswa->alamat ?? old('alamat') }}</textarea>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">NO HP</label>
                            <input type="text" name="no_hp" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan NO HP" value="{{ $mahasiswa->no_hp ?? old('no_hp') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Masukkan Nama Ibu" value="{{ $mahasiswa->nama_ibu ?? old('nama_ibu') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Semester</label>
                            <input type="number" name="semester" class="form-control form-control-solid fw-bold"
                                placeholder="Masukkan Semester" value="{{ $mahasiswa->semester }}" />
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