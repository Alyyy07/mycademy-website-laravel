function debounce(func, delay) {
    let debounceTimer;
    return function () {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(context, args), delay);
    };
}
$('[button-action="show"]').on("click", function () {
    let modalId = $(this).attr("modal-id");
    //cek apakah modal sudah ada lalu hapus terlebih dahulu
    if ($(modalId).length) {
        $(modalId).remove();
    }
    $.ajax({
        url: $(this).attr("button-url"),
        type: "GET",
        success: function (response) {
            $(".app-main").append(response);
            $(modalId).modal("show");
        },
    });
});

$('[button-action="delete"]').on("click", function (e) {
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
                beforeSend: function () {
                    // Optional: tampilkan loading indicator
                    Swal.fire({
                        title: "Loading",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });
                },
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
                        }
                    });
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

$('[data-action="filter"]').on('change', function () {
    console.log('filter');
    let params = $(this).val();
    let url = $(this).attr('data-url');
    let table = $(this).attr('data-table');
    $(table).DataTable().ajax.url(`${url}?filter=${params}`).load();
});