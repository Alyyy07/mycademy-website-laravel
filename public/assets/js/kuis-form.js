$(document).ready(function () {

    $("#kuis_repeater").repeater({
        initEmpty: false,
        defaultValues: {
            question_text: "",
        },
        repeaters: [
            {
                selector: ".inner-repeater",
                initEmpty: false,
                defaultValues: {
                    option_text: "",
                    is_correct: false,
                },
            },
        ],
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            Swal.fire({
                title: "Hapus Soal?",
                text: "Soal akan dihapus dari form.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).slideUp(deleteElement);
                }
            });
        },
    });

    $("#materi-form").on("submit", function (e) {
        e.preventDefault();

        let form = $(this)[0];
        let formData = new FormData(form);
        let route = $(this).attr("action");

        $.ajax({
            url: route,
            method: "POST",
            data: formData,
            headers:{
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            processData: false,
            contentType: false,
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
                    icon: "success",
                    title: "Berhasil",
                    text: response.message || "Data berhasil disimpan!",
                }).then(() => {
                    window.location.href =
                        response.redirect || document.referrer;
                });
            },
            error: function (xhr) {
                Swal.close();

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorList = "";
                    $.each(errors, function (key, value) {
                        errorList += `<div>${value}</div>`;
                    });

                    Swal.fire({
                        icon: "error",
                        title: "Validasi Gagal",
                        html: errorList,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Terjadi Kesalahan",
                        text:
                            xhr.responseJSON?.message ||
                            "Silakan coba lagi nanti.",
                    });
                }
            },
        });
    });
});
