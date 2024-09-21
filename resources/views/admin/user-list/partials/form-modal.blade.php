<div class="modal fade" id="user-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_user_header">
                <h2 class="fw-bold">Add User</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="user-form" class="form" action="{{ $route }}" modal-action="{{ $action }}" enctype="multipart/form-data">
                    @if($action == 'edit')
                    @method('PUT')
                    @endif
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_user_header"
                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <div class="fv-row mb-7">
                            <label class="d-block fw-semibold fs-6 mb-5">Profile Photo</label>
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
                            <label class="required fw-semibold fs-6 mb-2">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Full name" autofocus value="{{ $user->name ?? old('name') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Email</label>
                            <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="example@domain.com" value="{{ $user->email ?? old('email') }}" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="@if ($action == 'create') required @endif fs-6 mb-2">Password</label>
                            <input type="password" name="password" class="form-control form-control-solid mb-3 mb-lg-0"
                                value="{{ old('password') }}" />
                        </div>
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
                                        <div class="fw-bold text-gray-800 text-capitalize">{{ $role->name }}
                                        </div>
                                </div>
                            </div>
                            @if (!$loop->last)
                            <div class='separator separator-dashed my-5'></div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center pt-10">
                        <button type="reset" class="btn btn-light me-3" modal-action="close">Discard</button>
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
    $('[modal-action="close"]').on('click', function () {
    Swal.fire({
        text: "Apakah anda yakin ingin menutup modal ini?",
        icon: 'warning',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Ya',
        cancelButtonText:"Batal",
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-active-light',
        },

    }).then((result) => {
        if (result.isConfirmed) {
            $(this).closest('.modal').modal('hide');
            $(this).closest('.modal').remove();
        }
        if (result.isDismissed) {
            Swal.fire({
                text: 'Aksi Dibatalkan!',
                icon: 'error',
                buttonsStyling: false,
                confirmButtonText: 'Ok, mengerti!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                },
            });
        }
    });
});
$('[data-kt-image-input-action="change"]').on('change', function () {
    var files = $('input[type="file"]').prop('files');
    if (files.length > 0) {
        var file = files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.image-input-wrapper').css('background-image', 'url(' + e.target.result + ')');
        }
        reader.readAsDataURL(file);
        $('[data-kt-image-input-action="remove"]').removeClass('d-none');
        $('.image-feedback').html('');
    }
});

$('[data-kt-image-input-action="remove"]').on('click', function () {
    $(this).closest('.image-input').find('.image-input-wrapper').css('background-image', 'url(storage/image/profile-photo/blank.png)');
    $('input[name="profile_photo"]').val('image/profile-photo/blank.png');
    $(this).addClass('d-none');
    $('.image-feedback').html('');
});

$('#user-form').on('submit', function (e) {
    e.preventDefault();
    form = $(this);
    url = $(this).attr('action');
    isCreateAction = $(this).attr('modal-action') === 'create';
    formData = new FormData(this);
    Swal.fire({
        text: "Apakah anda yakin ingin "+(isCreateAction ? "menyimpan":"mengedit")+" data ini?",
        icon: 'warning',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Ya',
        cancelButtonText:"Batal",
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-active-light',
        },

    }).then((result) => {
        if (result.isConfirmed) {
            form.find('.indicator-label').html('Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>');
            form.find('[type="submit"]').attr('disabled', true);
            form.find('.is-invalid').removeClass('is-invalid').next('small').remove();
           $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method :"POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    window.LaravelDataTables[$("table").attr("id")].ajax.reload();
                    $('#user-modal').modal('hide');
                    Swal.fire({
                        text: response.message,
                        icon: 'success',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok, mengerti!',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        },
                    })
                },
                error: function (xhr) {
                    if (xhr.status == 422) {
                        $.each(xhr.responseJSON.errors, function (key, value) {
                            if (key == 'profile_photo') {
                                form.find('.image-feedback').html('<small class="text-danger">' + value + '</small>');
                            }else{
                                $('#user-form').find('[name="' + key + '"]').addClass('is-invalid').after('<small class="text-danger">' + value + '</small>');
                            }
                        })
                    } else {
                        Swal.fire({
                            text: xhr.responseJSON.message,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, mengerti!',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            },
                        });
                    }
                },
                complete: function () {
                    form.find('.indicator-label').html('Submit');
                    form.find('[type="submit"]').attr('disabled', false);
                }
           })
        }
        if (result.isDismissed) {
            Swal.fire({
                text: 'Aksi Dibatalkan!',
                icon: 'error',
                buttonsStyling: false,
                confirmButtonText: 'Ok, mengerti!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                },
            });
        }
    });
});
</script>