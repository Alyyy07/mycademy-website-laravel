$("form").on("submit", function (e) {
    e.preventDefault();
    let form = $(this);
    let url = form.attr("action");
    let isCreateAction = form.attr("modal-action") === "create";

    //menyimpan data dari ckeditor ke dalam input hidden
    if (form.find(".document-editor").length > 0) {
        let ckeditorData = window["editor"].getData();
        form.find("input[name='text_content']").val(ckeditorData);
    }

    let formData = new FormData(this);

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
                beforeSend: function () {
                    // Optional: tampilkan loading indicator
                    Swal.fire({
                        title: isCreateAction ? "Menyimpan..." : "Mengedit...",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });
                },
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

document.addEventListener("DOMContentLoaded", function () {
    //init Dropzone
    let fileInput = document.getElementById("file_path");
    isDisabled = fileInput?.hasAttribute("disabled");

    if (fileInput) {
        Dropzone.autoDiscover = false;
        uploadRoute = fileInput.getAttribute("data-upload-route");
        deleteRoute = fileInput.getAttribute("data-delete-route");

        let uploadedFilePath = fileInput.value;
        var myDropzone = new Dropzone("#dropzone-materi", {
            url: uploadRoute,
            maxFiles: 1, // Hanya 1 file yang diizinkan
            maxFilesize: 2, // Maksimum 2MB
            acceptedFiles: ".pdf",
            autoProcessQueue: !isDisabled,
            addRemoveLinks: !isDisabled,
            dictRemoveFile: "Hapus",
            dictDefaultMessage: isDisabled
                ? "File sudah diunggah"
                : "Klik atau seret file ke sini untuk mengunggah",
            clickable: !isDisabled,
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            init: function () {
                let dropzoneInstance = this;

                // Jika ada file yang sudah di-upload sebelumnya
                if (uploadedFilePath) {
                    let mockFile = {
                        name: uploadedFilePath.split("/").pop(),
                        size: 12345, // optional
                        type: "application/pdf",
                        status: Dropzone.SUCCESS,
                        accepted: true,
                    };

                    dropzoneInstance.emit("addedfile", mockFile);
                    dropzoneInstance.emit("complete", mockFile);
                    dropzoneInstance.files.push(mockFile); // Masukkan ke daftar file Dropzone
                    dropzoneInstance.existingFile = mockFile; // Simpan untuk nanti dihapus

                    // Tampilkan thumbnail custom
                    mockFile.previewElement.classList.add(
                        "dz-success",
                        "dz-complete"
                    );
                    mockFile.previewElement.querySelector(".dz-image img").src =
                        "/assets/media/svg/files/pdf.svg";
                    mockFile.previewElement.querySelector(
                        ".dz-image img"
                    ).style.width = "100%";
                    mockFile.previewElement.querySelector(
                        ".dz-filename span"
                    ).innerHTML = mockFile.name;

                    if (isDisabled) {
                        let removeBtn =
                            mockFile.previewElement.querySelector(".dz-remove");
                        if (removeBtn) {
                            removeBtn.style.display = "none";
                        }
                    }

                    // Tampilkan preview PDF
                    let pdfPreview = document.getElementById("pdf-preview");
                    pdfPreview.src = uploadedFilePath + "?display=inline";
                    pdfPreview.style.display = "block";
                    pdfPreview.style.height = "500px";
                }
                if (isDisabled) {
                    dropzoneInstance.disable();
                }

                // Saat file baru ditambahkan
                this.on("addedfile", function (file) {
                    // Hapus file sebelumnya (mock atau file upload)
                    if (dropzoneInstance.existingFile) {
                        dropzoneInstance.removeFile(
                            dropzoneInstance.existingFile
                        );
                    } else if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                    dropzoneInstance.existingFile = file;
                });

                // Saat unggahan berhasil
                this.on("success", function (file, response) {
                    uploadedFilePath = response.file_path;
                    document.getElementById("file_path").value =
                        uploadedFilePath;

                    file.previewElement.querySelector(
                        ".dz-filename span"
                    ).innerHTML = file.name;
                    file.previewElement.querySelector(".dz-image img").src =
                        "/assets/media/svg/files/pdf.svg";
                    file.previewElement.querySelector(
                        ".dz-image img"
                    ).style.width = "100%";
                    file.previewElement.querySelector(
                        ".dz-success-mark"
                    ).style.display = "block";
                    file.previewElement.querySelector(
                        ".dz-error-mark"
                    ).style.display = "none";
                    if (!isDisabled) {
                        file.previewElement.querySelector(
                            ".dz-remove"
                        ).onclick = function () {
                            dropzoneInstance.removeFile(file);
                        };
                    }

                    let fileURL = URL.createObjectURL(file);
                    let pdfPreview = document.getElementById("pdf-preview");
                    pdfPreview.src = fileURL;
                    pdfPreview.style.height = "500px";
                    pdfPreview.style.display = "block";

                    dropzoneInstance.existingFile = file;
                });

                // Saat file dihapus
                this.on("removedfile", function (file) {
                    if (uploadedFilePath && !isDisabled) {
                        $.ajax({
                            url: deleteRoute,
                            type: "POST",
                            data: {
                                _token: document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content"),
                                file_path: uploadedFilePath,
                            },
                            success: function () {
                                uploadedFilePath = null;
                                document.getElementById("file_path").value = "";

                                let pdfPreview =
                                    document.getElementById("pdf-preview");
                                pdfPreview.src = "";
                                pdfPreview.style.display = "none";
                            },
                        });
                    }
                });
            },
        });
    }

    // Preview PDF
    fileInput?.addEventListener("change", function (event) {
        let file = event.target.files[0];
        if (file && file.type === "application/pdf") {
            let fileURL = URL.createObjectURL(file);
            let pdfPreview = document.getElementById("pdf-preview");
            pdfPreview.src = fileURL;
            pdfPreview.style.display = "block";
        }
    });

    const videoInput = document.getElementById("video_path");
    const videoPreview = document.getElementById("video-preview");
    if (videoInput && videoInput.value !== "") {
        const videoUrlCheckMessage = document.createElement("div");
        videoUrlCheckMessage.id = "video-url-check-message";
        videoPreview.appendChild(videoUrlCheckMessage);
        videoUrlCheckMessage.innerHTML = "Memeriksa link video...";
        let url = videoInput.value;
        let embedUrl = "";

        // Cek URL Video YouTube atau Vimeo
        if (url.includes("youtube.com") || url.includes("youtu.be")) {
            let videoId =
                url.split("v=")[1]?.split("&")[0] || url.split("/").pop();
            embedUrl = `https://www.youtube.com/embed/${videoId}`;
        } else if (url.includes("vimeo.com")) {
            let videoId = url.split("/").pop();
            embedUrl = `https://player.vimeo.com/video/${videoId}`;
        }

        // Jika URL ditemukan
        if (embedUrl) {
            videoPreview.innerHTML = `<iframe width="100%" height="415" src="${embedUrl}" frameborder="0" allowfullscreen></iframe>`;
            videoUrlCheckMessage.innerHTML = ""; // Hapus pesan pengecekan
        } else {
            videoPreview.innerHTML = "";
            videoUrlCheckMessage.innerHTML =
                "URL tidak valid untuk video. Harap masukkan URL YouTube atau Vimeo.";
        }
    }

    // Debounce dan Preview Video
    videoInput?.addEventListener("input", function () {
        let debounceTimer;
        const videoPreview = document.getElementById("video-preview");
        const videoUrlCheckMessage = document.createElement("div");
        videoUrlCheckMessage.id = "video-url-check-message";
        videoPreview.appendChild(videoUrlCheckMessage);
        clearTimeout(debounceTimer);
        const url = videoInput.value;

        debounceTimer = setTimeout(function () {
            let embedUrl = "";
            videoUrlCheckMessage.innerHTML = "Memeriksa link video...";

            // Cek URL Video YouTube atau Vimeo
            if (url.includes("youtube.com") || url.includes("youtu.be")) {
                let videoId =
                    url.split("v=")[1]?.split("&")[0] || url.split("/").pop();
                embedUrl = `https://www.youtube.com/embed/${videoId}`;
            } else if (url.includes("vimeo.com")) {
                let videoId = url.split("/").pop();
                embedUrl = `https://player.vimeo.com/video/${videoId}`;
            }

            // Jika URL ditemukan
            if (embedUrl) {
                videoPreview.innerHTML = `<iframe width="100%" height="415" src="${embedUrl}" frameborder="0" allowfullscreen></iframe>`;
                videoUrlCheckMessage.innerHTML = ""; // Hapus pesan pengecekan
            } else {
                videoPreview.innerHTML = "";
                videoUrlCheckMessage.innerHTML =
                    "URL tidak valid untuk video. Harap masukkan URL YouTube atau Vimeo.";
            }
        }, 500); // Debounce 500ms
    });

    // Inisialisasi CKEditor jika tipe materi adalah teks
    if (document.querySelector(".document-editor")) {
        const hiddenInput = document.querySelector(
            'input[name="text_content"]'
        );
        const isReadOnly = hiddenInput.hasAttribute("disabled");
        DecoupledEditor.create(document.querySelector(".document-editor"), {
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
                document
                    .querySelector(".document-toolbar")
                    .appendChild(editor.ui.view.toolbar.element);

                window["editor"] = editor;
                const hiddenInput = document.querySelector(
                    'input[name="text_content"]'
                );
                editor.setData(hiddenInput.value);
                if (isReadOnly) {
                    editor.enableReadOnlyMode("materi-readonly");
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
                            const modelRoot = editor.model.document.getRoot();
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
                                            "Content-Type": "application/json",
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
    }
});
