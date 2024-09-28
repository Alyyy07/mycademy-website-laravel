$('[check-action="user"]').on("change", function () {
    var isChecked = $(this).prop("checked");
    $(this)
        .closest("table")
        .find("[check-target='user']")
        .each(function () {
            $(this).prop("checked", isChecked);
        });
    $(this).closest("table").find("[check-target='user']").trigger("change");
});

$('table [data-kt-menu-trigger="click"]').on("click", function (e) {
    e.preventDefault();
    var $menu = $(this).next(".menu");
    if (!$menu.hasClass("show")) {
        $(this).addClass("show menu-dropdown");

        var buttonHeight = $(this).outerHeight();
        $menu.css({
            display: "block",
            position: "absolute",
            top: buttonHeight + "px",
            left: "0px",
            zIndex: 107,
        });

        $menu.addClass("show");
    } else {
        $(this).removeClass("show menu-dropdown");
        $menu.removeClass("show").prop("style", "");
    }
});

$(document).on("click", function (e) {
    if (
        !$(e.target).closest('table [data-kt-menu-trigger="click"], .menu')
            .length
    ) {
        $(".menu").removeClass("show").prop("style", "");
        $('table [data-kt-menu-trigger="click"]').removeClass(
            "show menu-dropdown"
        );
    }
});

$('[data-action="search"]').on(
    "input",
    debounce(function () {
        const tableId = $("table").attr("id");
        if (window.LaravelDataTables[tableId]) {
            window.LaravelDataTables[tableId].search($(this).val()).draw();
        } else {
            console.error(`DataTable dengan ID ${tableId} tidak ditemukan.`);
        }
    }, 1000)
);

$('[data-action="edit"]').on("click", function (e) {
    let modalId = $(this).attr("modal-id");
    $.ajax({
        url: $(this).attr("button-url"),
        type: "GET",
        timeout: 2000,
        success: function (response) {
            $(".app-main").append(response);
            $(modalId).modal("show");
        },
    });
});

$('[data-action="delete"]').on("click", function (e) {
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: $(this).attr("button-url"),
                type: "DELETE",
                timeout: 2000,
                success: function (response) {
                    Swal.fire({
                        text: response.message,
                        icon: "success",
                    });
                    window.LaravelDataTables[
                        $("table").attr("id")
                    ].ajax.reload();
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        text: xhr.responseJSON.message,
                        icon: "error",
                    });
                },
            });
        }
    });
});

$('[data-action="set-status"]').on("click", function (e) {
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Anda akan mengubah status data ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, Ubah!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: $(this).attr("button-url"),
                type: "PATCH",
                timeout: 2000,
                success: function (response) {
                    Swal.fire({
                        text: response.message,
                        icon: "success",
                    });
                    window.LaravelDataTables[
                        $("table").attr("id")
                    ].ajax.reload();
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        text: xhr.responseJSON.message,
                        icon: "error",
                    });
                },
            });
        }
    });
});

$('[check-target="user"] ').on("change", function () {
    let checked = $('[check-target="user"]:checked').length;
    let total = $('[check-target="user"]').length;
    if (checked === total) {
        $('[check-action="user"]').prop("checked", true);
    } else {
        $('[check-action="user"]').prop("checked", false);
    }
    $('[user-toolbar="base"]').addClass("d-none");
    $('[user-toolbar="bulk-delete"]').removeClass("d-none");
    $("[data-user-selected]").text(checked);

    $('[button-action="bulk-delete"]').on("click", function () {
        Swal.fire({
            text:
                "Apakah Anda yakin ingin menghapus " + checked + " data user?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                $('[check-target="user"]:checked').each(function () {
                    let userIds = $(this).val();
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: $(this).attr("button-url"),
                        type: "DELETE",
                        data: {
                            ids: [userIds],
                        },
                        success: function (response) {
                            Swal.fire({
                                text: response.message,
                                icon: "success",
                            });
                            window.LaravelDataTables[
                                $("table").attr("id")
                            ].ajax.reload();
                            $('[user-toolbar="base"]').removeClass("d-none");
                            $('[user-toolbar="bulk-delete"]').addClass("d-none");
                            $("[data-user-selected").text(checked);
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                text: xhr.responseJSON.message,
                                icon: "error",
                            });
                        },
                    });
                });
            }
            if (result.isDismissed) {
                Swal.fire({
                    text: "Aksi Dibatalkan!",
                    icon: "error",
                });
            }
        });
    });

    if (checked === 0) {
        $('[user-toolbar="base"]').removeClass("d-none");
        $('[user-toolbar="bulk-delete"]').addClass("d-none");
        $("[data-user-selected").text(checked);
    }
});
