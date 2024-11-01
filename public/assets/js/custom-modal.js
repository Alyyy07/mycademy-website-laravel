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
                    if (
                        $("table").length > 0 &&
                        window.LaravelDataTables &&
                        window.LaravelDataTables[$("table").attr("id")]
                    ) {
                        window.LaravelDataTables[
                            $("table").attr("id")
                        ].ajax.reload();
                    }
                    $(".modal").modal("hide");
                    Swal.fire({
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, mengerti!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                    form[0].reset();
                    $(".image-input-wrapper").prop(
                        "style",
                        "background-image: url(storage/image/profile-photo/blank.png)"
                    );
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

const selectAllCheckbox = document.getElementById("kt_roles_select_all");
const permissionCheckboxes = document.querySelectorAll(".permission-checkbox");

selectAllCheckbox.addEventListener("change", function () {
    if (selectAllCheckbox.checked) {
        permissionCheckboxes.forEach((checkbox) => {
            $(checkbox).prop("checked", true);
        });
    } else {
        permissionCheckboxes.forEach((checkbox) => {
            $(checkbox).prop("checked", false);
            checkbox.disabled = false;
        });
    }
});

permissionCheckboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
        if (!checkbox.checked) {
            selectAllCheckbox.checked = false;
        }
        if (
            permissionCheckboxes.length ===
            Array.from(permissionCheckboxes).filter(
                (checkbox) => checkbox.checked
            ).length
        ) {
            selectAllCheckbox.checked = true;
        }
    });
});
