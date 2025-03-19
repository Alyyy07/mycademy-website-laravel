$('[modal-action="close"]').on("click", function () {
    Swal.fire({
        text: "Apakah anda yakin ingin menutup modal ini?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Ya",
        cancelButtonText: "Batal",
        reverseButtons: true,
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-active-light",
        },
    }).then((result) => {
        if (result.isConfirmed) {
            $(this).closest(".modal").modal("hide");
            $(this).closest(".modal").remove();
        }
        if (result.isDismissed) {
            Swal.fire({
                text: "Aksi Dibatalkan!",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, mengerti!",
                customClass: {
                    confirmButton: "btn btn-primary",
                },
            });
        }
    });
});
$('[data-kt-image-input-action="change"]').on("change", function () {
    var files = $('input[type="file"]').prop("files");
    if (files.length > 0) {
        var file = files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".image-input-wrapper").css(
                "background-image",
                "url(" + e.target.result + ")"
            );
        };
        reader.readAsDataURL(file);
        $('[data-kt-image-input-action="remove"]').removeClass("d-none");
        $(".image-feedback").html("");
    }
});

$('[data-kt-image-input-action="remove"]').on("click", function () {
    $(this)
        .closest(".image-input")
        .find(".image-input-wrapper")
        .css("background-image", "url(storage/image/profile-photo/blank.png)");
    $('input[name="profile_photo"]').val("image/profile-photo/blank.png");
    $(this).addClass("d-none");
    $(".image-feedback").html("");
});

$("form").on("submit", function (e) {
    e.preventDefault();
    form = $(this);
    url = $(this).attr("action");
    isCreateAction = $(this).attr("modal-action") === "create";
    formData = new FormData(this);
    Swal.fire({
        text:
            "Apakah anda yakin ingin " +
            (isCreateAction ? "menyimpan" : "mengedit") +
            " data ini?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Ya",
        cancelButtonText: "Batal",
        reverseButtons: true,
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-active-light",
        },
    }).then((result) => {
        if (result.isConfirmed) {
            form.find(".indicator-label").html(
                'Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>'
            );
            form.find('[type="submit"]').attr("disabled", true);
            form.find(".is-invalid")
                .removeClass("is-invalid")
                .next("small")
                .remove();

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: url,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, mengerti!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (
                                $("table").length > 0 &&
                                window.LaravelDataTables &&
                                window.LaravelDataTables[$("table").attr("id")]
                            ) {
                                window.LaravelDataTables[
                                    $("table").attr("id")
                                ].ajax.reload();
                            } else {
                                window.location.reload();
                            }
                            form[0].reset();
                            $(".image-input-wrapper").prop(
                                "style",
                                "background-image: url(storage/image/profile-photo/blank.png)"
                            );
                            $(".modal").remove();
                            $(".modal-backdrop").remove();
                        }
                    });
                },
                error: function (xhr) {
                    if (xhr.status == 422) {
                        $.each(xhr.responseJSON.errors, function (key, value) {
                            if (key == "profile_photo") {
                                form.find(".image-feedback").html(
                                    '<small class="text-danger">' +
                                        value +
                                        "</small>"
                                );
                            } else {
                                $("form")
                                    .find('[name="' + key + '"]')
                                    .addClass("is-invalid")
                                    .after(
                                        '<small class="text-danger">' +
                                            value +
                                            "</small>"
                                    );
                            }
                        });
                        if (xhr.responseJSON.errors.permissions) {
                            Swal.fire({
                                text: xhr.responseJSON.errors.permissions[0],
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                },
                            });
                        }
                    } else {
                        Swal.fire({
                            text: xhr.responseJSON.message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, mengerti!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    }
                },
                complete: function () {
                    form.find(".indicator-label").html("Submit");
                    form.find('[type="submit"]').attr("disabled", false);
                },
            });
        }
        if (result.isDismissed) {
            Swal.fire({
                text: "Aksi Dibatalkan!",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, mengerti!",
                customClass: {
                    confirmButton: "btn btn-primary",
                },
            });
        }
    });
});

$("#kt_roles_select_all").on("change", function () {
    if ($(this).prop("checked")) {
        $(".permission-checkbox").each(function () {
            $(this).prop("checked", true);
        });
    } else {
        $(".permission-checkbox").each(function () {
            $(this).prop("checked", false);
            $(this).prop("disabled", false);
        });
    }
});

$(".permission-checkbox").on("change", function () {
    if (!$(this).prop("checked")) {
        $("#kt_roles_select_all").prop("checked", false);
    }
    if (
        $(".permission-checkbox").length ===
        $(".permission-checkbox:checked").length
    ) {
        $("#kt_roles_select_all").prop("checked", true);
    }
});

$('.modal').on('shown.bs.modal', function () {
    $('[data-control="select2"]').select2({
        dropdownParent: $(this),
        placeholder: $(this).attr('data-placeholder'),
        allowClear: true
    });
});
