<div class="modal fade" id="user-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_user_header">
                <h2 class="fw-bold">{{ $action === 'edit'? 'Edit' : "Tambah" }} Pengguna</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="user-form" class="form" action="{{ $route }}" modal-action="{{ $action }}"
                    enctype="multipart/form-data">
                    @if($action == 'edit')
                    @method('PUT')
                    @endif
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_user_header"
                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <div class="fv-row mb-7">
                            <label class="d-block fw-semibold fs-6 mb-5">Foto Profil</label>
                            <div class="image-input image-input-circle image-input-placeholder">
                                <div class="image-input-wrapper w-125px h-125px"
                                    style="background-image: url('storage/{{ $user->profile_photo ?? 'image/profile-photo/blank.png' }}');">
                                </div>
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change">
                                    <i class="ki-duotone ki-pencil fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="file" name="profile_photo" />
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
                            <label class="required fw-semibold fs-6 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Full name" autofocus value="{{ $user->name ?? old('name') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Email</label>
                            <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="example@domain.com" value="{{ $user->email ?? old('email') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="@if ($action == 'create') required @endif fs-6 mb-2"> @if ($action ==
                                'create') Password @else Password Baru (Kosongkan jika tidak ingin Diubah) @endif</label>
                            <input type="password" name="password" class="form-control form-control-solid mb-3 mb-lg-0"
                                value="{{ old('password') }}" />
                        </div>
                        @if ($action == 'edit')
                        <div class="fv-row mb-7">
                            <label class="fs-6 mb-2"> Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                value="{{ old('password_confirmation') }}" />
                        </div>
                        @endif
                        <div class="mb-5">
                            <label class="required fw-semibold fs-6 mb-5">Role</label>
                            @foreach ($roles as $role )
                            <div class="d-flex fv-row">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input me-3" name="role" type="radio"
                                        @if(isset($user->roles) && $user->roles->contains($role->id)) checked
                                    @elseif (isset($user->roles) && $loop->first) checked
                                    @endif value="{{ $role->name }}" id="kt_modal_update_role_option_{{ $role->id }}" />
                                    <label class="form-check-label" for="kt_modal_update_role_option_{{ $role->id }}">
                                        <div class="fw-bold text-gray-800 text-capitalize">{{ str_replace("-"," ",$role->name) }}
                                        </div>
                                        <div class="text-gray-600">{{ $role->description }}</div>
                                </div>
                            </div>
                            @if (!$loop->last)
                            <div class='separator separator-dashed my-5'></div>
                            @endif
                            @endforeach
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