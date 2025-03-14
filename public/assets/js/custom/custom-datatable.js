let table = $("#user-table").DataTable();
table.on("order.dt", function () {
    $('[check-action="user"]').prop("checked", false);
    $('[user-toolbar="base"]').removeClass("d-none");
    $('[user-toolbar="selected-user"]').addClass("d-none");
    $("[selected-button]").text("0 Selected");
});

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

    var button = $(this); // Tombol yang diklik
    var menu = button.next(".menu"); // Dropdown terkait

    if (!menu.hasClass("show")) {
        // Tutup semua dropdown lain sebelum menampilkan yang baru
        $(".menu.show").removeClass("show").prop("style", "");

        button.addClass("show menu-dropdown");

        function updateDropdownPosition() {
            var buttonOffset = button.offset(); // Posisi tombol di layar
            var buttonHeight = button.outerHeight();

            menu.css({
                display: "flex",
                position: "fixed",
                top: (buttonOffset.top + buttonHeight) + "px", // Selalu di bawah tombol
                left: buttonOffset.left + "px",
                zIndex: 107,
            });
        }

        updateDropdownPosition(); // Set posisi awal dropdown
        $(window).on("scroll resize", updateDropdownPosition); // Update saat scroll/resize

        menu.addClass("show");

        // Tutup dropdown jika klik di luar
        $(document).on("click.menuDismiss", function (event) {
            if (!button.is(event.target) && !menu.is(event.target) && menu.has(event.target).length === 0) {
                menu.removeClass("show").prop("style", "");
                button.removeClass("show menu-dropdown");
                $(window).off("scroll resize", updateDropdownPosition);
                $(document).off("click.menuDismiss"); // Hapus event klik di luar setelah dropdown ditutup
            }
        });
    } else {
        menu.removeClass("show").prop("style", "");
        button.removeClass("show menu-dropdown");
        $(window).off("scroll resize", updateDropdownPosition);
        $(document).off("click.menuDismiss");
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

    if (
        !$(e.target).closest("[dropdown-option], .dropdown-menu").length &&
        !$(e.target).is("[dropdown-option]")
    ) {
        $(".dropdown-menu").removeClass("show").prop("style", "");
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
    if ($(modalId).length) {
        $(modalId).remove();
    }
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

$('[radio-action="set-status"]').on("change", function (e) {
    let checkbox = $(this).find('input[type="checkbox"]');
    let isChecked = checkbox.prop("checked");
    Swal.fire({
        text: "Apakah anda yakin ingin mengubah status User ini ?",
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
        if (result.isDismissed) {
            Swal.fire({
                text: "Aksi Dibatalkan!",
                icon: "error",
            });
            checkbox.prop("checked", !isChecked);
        }
    });
});

$('[check-target="user"] ').on("change", function () {
    let checked = $('[check-target="user"]:checked').length;
    let total = $('[check-target="user"]').length;
    let activeUser = $("[check-target='user']:checked").filter(function () {
        return $(this).closest("tr").find("[is-active-radio]").is(":checked");
    });
    let inactiveUser = $("[check-target='user']:checked").filter(function () {
        return !$(this).closest("tr").find("[is-active-radio]").is(":checked");
    });

    if (checked === total) {
        $('[check-action="user"]').prop("checked", true);
    } else {
        $('[check-action="user"]').prop("checked", false);
    }
    $('[user-toolbar="base"]').addClass("d-none");
    $('[user-toolbar="selected-user"]').removeClass("d-none");
    $("[selected-button]").text(checked + " Selected");

    $("[delete-option]").text("Delete " + checked + " User");
    inactiveUser.length
        ? $("[activate-option]")
              .removeClass("d-none")
              .text("Activate " + inactiveUser.length + " User")
        : $("[activate-option]").addClass("d-none");
    activeUser.length
        ? $("[deactivate-option]")
              .removeClass("d-none")
              .text("Deactivate " + activeUser.length + " User")
        : $("[deactivate-option]").addClass("d-none");

    $("[delete-option]").on("click", function () {
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
                let userIds = [];
                $("[check-target='user']:checked").each(function () {
                    userIds.push($(this).val());
                });
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    url: $(this).attr("button-url"),
                    type: "DELETE",
                    data: {
                        ids: userIds,
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
                        $('[user-toolbar="selected-user"]').addClass(
                            "d-none"
                        );
                        $("[data-user-selected").text(checked);
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            text: xhr.responseJSON.message,
                            icon: "error",
                        });
                    },
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

    $("[activate-option]").on("click", function () {
        Swal.fire({
            text:
                "Apakah Anda yakin ingin mengaktifkan " +
                inactiveUser.length +
                " data user?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, aktifkan!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                let userIds = [];
                inactiveUser.each(function () {
                    userIds.push($(this).val());
                });
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: $(this).attr("button-url"),
                        type: "POST",
                        data: {
                            ids: userIds,
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
                            $('[user-toolbar="selected-user"]').addClass(
                                "d-none"
                            );
                            $("[data-user-selected").text(checked);
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                text: xhr.responseJSON.message,
                                icon: "error",
                            });
                        },
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

    $("[deactivate-option]").on("click", function () {
        Swal.fire({
            text:
                "Apakah Anda yakin ingin menonaktifkan " +
                activeUser.length +
                " data user?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, nonaktifkan!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                let userIds = [];
                activeUser.each(function () {
                    userIds.push($(this).val());
                });
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: $(this).attr("button-url"),
                        type: "POST",
                        data: {
                            ids: userIds,
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
                            $('[user-toolbar="selected-user"]').addClass(
                                "d-none"
                            );
                            $("[data-user-selected").text(checked);
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                text: xhr.responseJSON.message,
                                icon: "error",
                            });
                        },
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
        $('[user-toolbar="selected-user"]').addClass("d-none");
        $("[data-user-selected").text(checked);
    }
});

$("[dropdown-option]").off('click').on("click", function () {
    console.log('test');
    let parentWidth = $(this).closest('[user-toolbar="selected-user"]').width();
    let dropdown = $(this).next(".dropdown-menu");
    if (!dropdown.hasClass("show")) {
        var buttonHeight = $(this).outerHeight();
        dropdown.css({
            display: "block",
            width: parentWidth + "px",
            position: "absolute",
            top: buttonHeight + "px",
            left: "0px",
            zIndex: 107,
        });

        dropdown.addClass("show");
    } else {
        dropdown.removeClass("show").prop("style", "");
    }
});
