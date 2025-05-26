class MyUploadAdapter {
    constructor(loader) {
        this.loader = loader;
        this.imageUrl = null;
    }

    upload() {
        return this.loader.file.then(
            (file) =>
                new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append("upload", file);

                    fetch("/upload-image", {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                    })
                        .then((response) => response.json())
                        .then((result) => {
                            if (result.url) {
                                this.imageUrl = result.url; // Simpan URL untuk penghapusan nanti
                                resolve({ default: result.url });
                            } else {
                                reject(result.error.message);
                            }
                        })
                        .catch((error) => {
                            reject("Upload failed");
                            console.error("Upload error:", error);
                        });
                })
        );
    }

    deleteFile() {
        if (this.imageUrl) {
            fetch("/delete-image", {
                method: "POST",
                body: JSON.stringify({ imageUrl: this.imageUrl }),
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            })
                .then((response) => response.json())
                .then((result) => {
                    console.log("Image deleted:", result);
                })
                .catch((error) => {
                    console.error("Delete image failed:", error);
                });
        }
    }
}

function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
    };
}

function initAllCKEditors(context = document) {
    context
        .querySelectorAll(".document-editor")
        .forEach(function (editorElement) {
            // Skip jika sudah terinisialisasi
            if (editorElement.classList.contains("ck-editor__editable_inline"))
                return;

            const parent = editorElement.closest(".ckeditor");
            const hiddenInput = parent?.querySelector('input[type="hidden"]');
            const isReadOnly = hiddenInput?.hasAttribute("disabled");

            DecoupledEditor.create(editorElement, {
                removePlugins: ["MediaEmbed", "MediaEmbedToolbar"],
                toolbar: {
                    items: [
                        "heading",
                        "|",
                        "bold",
                        "italic",
                        "underline",
                        "link",
                        "bulletedList",
                        "numberedList",
                        "|",
                        "outdent",
                        "indent",
                        "|",
                        "blockQuote",
                        "insertTable",
                        "undo",
                        "redo",
                        "imageUpload",
                        "fontSize",
                        "fontFamily",
                        "fontColor",
                        "fontBackgroundColor",
                        "alignment",
                        
                    ],
                },
                extraPlugins: isReadOnly ? [] : [MyCustomUploadAdapterPlugin],
            })
                .then((editor) => {
                    parent
                        ?.querySelector(".document-toolbar")
                        ?.appendChild(editor.ui.view.toolbar.element);

                    if (hiddenInput) {
                        editor.setData(hiddenInput.value || "");
                    }

                    if (isReadOnly) {
                        editor.enableReadOnlyMode("readonly-mode");
                    }

                    if (!isReadOnly && hiddenInput) {
                        editor.model.document.on("change:data", () => {
                            hiddenInput.value = editor.getData();
                        });
                    }
                })
                .catch((error) => console.error("CKEditor error:", error));
        });
}

$(document).ready(function () {
    initAllCKEditors();

    // Saat tombol "Tambah Soal" diklik
    $("[data-repeater-create]").on("click", function () {
        // Tunggu sejenak sampai elemen baru selesai ditambahkan ke DOM
        setTimeout(() => {
            // Ambil elemen soal terakhir yang baru ditambahkan
            const lastItem = document.querySelector(
                '#kuis_repeater [data-repeater-list="questions"] > [data-repeater-item]:last-child'
            );
            initAllCKEditors(lastItem);
        }, 100); // delay untuk memastikan DOM terupdate
    });

    document
        .querySelectorAll(".document-editor")
        .forEach(function (editorElement, index) {
            const parent = editorElement.closest(".ckeditor");
            const hiddenInput = parent?.querySelector('input[type="hidden"]');
            const isReadOnly = hiddenInput?.hasAttribute("disabled");

            DecoupledEditor.create(editorElement, {
                extraPlugins: isReadOnly ? [] : [MyCustomUploadAdapterPlugin],
            })
                .then((editor) => {
                    parent
                        ?.querySelector(".document-toolbar")
                        ?.appendChild(editor.ui.view.toolbar.element);
                    window.editors = window.editors || [];
                    window.editors.push(editor);

                    // Simpan isi dari input ke editor
                    if (hiddenInput) {
                        editor.setData(hiddenInput.value || "");
                    }

                    // Jika readonly, set editor jadi tidak bisa diedit
                    if (isReadOnly) {
                        editor.enableReadOnlyMode("readonly-mode");
                    }

                    // Update hidden input saat konten berubah
                    if (!isReadOnly && hiddenInput) {
                        editor.model.document.on("change:data", () => {
                            hiddenInput.value = editor.getData();
                        });
                    }
                    setTimeout(() => {
                        const modelRoot = editor.model.document.getRoot();
                        previousImages = getAllImageSrcFromModel(modelRoot);
                    }, 200);
                    function getAllImageSrcFromModel(modelRoot) {
                        let result = [];

                        for (const value of modelRoot.getChildren()) {
                            if (
                                value.is("element", "imageBlock") ||
                                value.is("element", "imageInline")
                            ) {
                                const src = value.getAttribute("src");
                                if (src) result.push(src);
                            } else if (value.is("element")) {
                                result = result.concat(
                                    getAllImageSrcFromModel(value)
                                );
                            }
                        }

                        return result;
                    }

                    // Timeout handler untuk debounce
                    if (!isReadOnly) {
                        let changeTimeout = null;

                        editor.model.document.on("change:data", () => {
                            // Gunakan debounce agar model benar-benar stabil
                            if (changeTimeout) clearTimeout(changeTimeout);

                            changeTimeout = setTimeout(() => {
                                const modelRoot =
                                    editor.model.document.getRoot();
                                const currentImages =
                                    getAllImageSrcFromModel(modelRoot);

                                const deletedImages = previousImages.filter(
                                    (src) => !currentImages.includes(src)
                                );

                                deletedImages.forEach((imgUrl) => {
                                    if (imgUrl) {
                                        fetch("/delete-image", {
                                            method: "POST",
                                            body: JSON.stringify({
                                                imageUrl: imgUrl,
                                            }),
                                            headers: {
                                                "Content-Type":
                                                    "application/json",
                                                "X-CSRF-TOKEN": document
                                                    .querySelector(
                                                        'meta[name="csrf-token"]'
                                                    )
                                                    .getAttribute("content"),
                                            },
                                        })
                                            .then((response) => response.json())
                                            .then((result) =>
                                                console.log(
                                                    "Image deleted:",
                                                    result
                                                )
                                            )
                                            .catch((error) =>
                                                console.error(
                                                    "Delete image failed:",
                                                    error
                                                )
                                            );
                                    }
                                });

                                previousImages = currentImages;
                            }, 300); // tunggu 300ms sebelum cek perubahan
                        });
                    }
                })
                .catch((error) => console.error("CKEditor error:", error));
        });

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

    $("#kuis-form").on("submit", function (e) {
        e.preventDefault();

        let form = $(this)[0];
        let formData = new FormData(form);
        let route = $(this).attr("action");

        $.ajax({
            url: route,
            method: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    text: response.message,
                    icon: response.status,
                    buttonsStyling: false,
                    confirmButtonText: "Ok, mengerti!",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = response.redirect_url;
                    }
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
