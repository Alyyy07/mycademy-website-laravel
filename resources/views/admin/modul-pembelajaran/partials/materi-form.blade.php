@extends('layouts.partials.admin.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
@endpush
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-5">
            <a href="{{ route('modul-pembelajaran.detail',['id' => $rpsDetail->rps_matakuliah_id]) }}"
                class="btn btn-light me-3">Kembali</a>
            @if ($rpsDetail->tanggal_realisasi !== null)
            <small class="text-danger text-center d-flex gap-1 align-items-center">
                <strong>Perhatian!</strong> Sesi pertemuan sudah berakhir
            </small>
            @endif
        </div>
        <form id="materi-form" class="form" action="{{ $route }}" modal-action="{{ $action }}"
            enctype="multipart/form-data">
            @if ($action == 'edit')
            @method('PUT')
            @endif
            @csrf
            <div class="d-flex flex-column scroll-y px-5 px-lg-10">
                <div class="fv-row mb-7">
                    <input type="hidden" name="rps_detail_id" value="{{ $rpsDetailId }}">
                    <input type="hidden" name="tipe_materi" value="{{ $tipeMateri }}">
                    <label class="required fw-semibold fs-6 mb-2">Judul</label>
                    <input type="text" @if ($materi->status != 'draft') disabled @endif name="title" class="form-control
                    form-control-solid mb-3 mb-lg-0"
                    placeholder="Masukkan Judul Materi" autofocus value="{{ $materi->title ?? old('title') }}" />
                    <input type="hidden" name="status" id="status_input" value="draft">
                </div>
                @switch($tipeMateri)
                @case('video')
                <div class="fv-row mb-7">
                    <label class="required fw-semibold fs-6 mb-2">Link video</label>
                    <input type="text" name="video_path" id="video_path" @if ($materi->status != 'draft') disabled
                    @endif
                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan link Video" autofocus
                    value="{{ $materi->video_path ?? old('video_path') }}" />
                    <div id="video-preview" class="mt-3"></div>
                </div>
                @break
                @case('pdf')
                <div class="fv-row mb-7">
                    <label class="required fw-semibold fs-6 mb-2">File PDF</label>
                    <div class="dropzone" id="dropzone-materi">
                        <div class="dz-message needsclick">
                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span
                                    class="path2"></span></i>
                            <div class="ms-4">
                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Seret file ke sini atau klik untuk
                                    mengupload file</h3>
                                <span class="form-text">File harus bertipe <strong>.pdf</strong> (Maks. 2MB)</span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="file_path" id="file_path" @if ($materi->status != 'draft') disabled
                    @endif value="{{ $pdfPath ?? old('file_path') }}"
                    data-upload-route="{{ route('modul-pembelajaran.materi.file.upload') }}"
                    data-delete-route="{{ route('modul-pembelajaran.materi.file.delete') }}" />
                </div>
                <div class="mt-3">
                    <iframe id="pdf-preview" src="{{ $pdfPath ?? old('file_path') }}" type="application/pdf"
                        style="width: 100%; border: none;"></iframe>
                </div>
                @break

                @default
                <div class="fv-row mb-7">
                    <label class="required fw-semibold fs-6 mb-2">Teks</label>
                    <input type="hidden" name="text_content" @if ($materi->status != 'draft') disabled @endif
                    value="{{ $materi->text_content ?? old('text_content') }}" />
                    <div class="ckeditor">
                        <div class="document-toolbar"></div>
                        <div class="document-editor"></div>
                    </div>
                </div>
                @endswitch
            </div>
            <div class="text-center pt-10">
                @if ($rpsDetail->tanggal_realisasi === null)
                @if ($action === 'create' || $materi->status == 'draft' && auth()->user()->roles->first()->name ==
                'dosen')
                <div class="position-relative w-100">
                    <div class="d-flex justify-content-center gap-3">
                        <button type="reset" class="btn btn-light me-3">Reset</button>
                        <button type="submit"
                            class="btn btn-{{ $action == 'edit' ? 'light-warning' : 'light-primary' }}"
                            onclick="setStatus('draft')">
                            <span class="indicator-label">{{ $action == 'edit' ? 'Update' : 'Simpan sebagai Draft'
                                }}</span>
                        </button>
                        @elseif($materi->status == 'uploaded' && auth()->user()->roles->first()->name ==
                        'admin-matakuliah')
                        <button type="button" class="btn btn-light-primary me-3"
                            data-route="{{ route('modul-pembelajaran.materi.status') }}" data-action="verify"
                            data-materi-id="{{ $materi->id }}">Verifikasi</button>
                        <button type="button" class="btn btn-light-danger me-3"
                            data-route="{{ route('modul-pembelajaran.materi.status') }}" data-action="reject"
                            data-materi-id="{{ $materi->id }}">Tolak</button>
                        @elseif(($materi->status == 'verified' || $materi->status == 'rejected') &&
                        auth()->user()->roles->first()->name ==
                        'admin-matakuliah')
                        <button type="button" class="btn btn-light-danger me-3"
                            data-route="{{ route('modul-pembelajaran.materi.status.reset') }}" data-action="reset"
                            data-materi-id="{{ $materi->id }}">Batalkan Verifikasi</button>
                        @endif
                        @if ($materi->status == 'draft' && auth()->user()->roles->first()->name == 'dosen')
                        <button type="submit"
                            class="position-absolute end-0 top-50 translate-middle-y btn btn-light-primary"
                            onclick="setStatus('uploaded')">
                            Simpan & Upload
                        </button>
                    </div>
                </div>
                @elseif ($materi->status == 'uploaded' && auth()->user()->roles->first()->name ==
                'dosen')
                <button type="button" class="btn btn-light-danger me-3"
                    data-route="{{ route('modul-pembelajaran.materi.status') }}" data-action="unpublish"
                    data-materi-id="{{ $materi->id }}">Batalkan Upload</button>
                @endif
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-document.bundle.js') }}"></script>
<script src="{{ asset('assets/js/materi-form.js') }}"></script>
<script>
    function setStatus(status) {
    document.getElementById('status_input').value = status;
}
    $(document).ready(function () {
    $(
        'button[data-action="publish"], button[data-action="verify"], button[data-action="reject"], button[data-action="unpublish"], button[data-action="reset"]'
    ).on("click", function () {
        const route = $(this).data("route");
        const action = $(this).data("action");
        const materiId = $(this).data("materi-id");
        const option = {
            publish: "upload",
            verify: "verifikasi",
            reject: "tolak",
            unpublish: "batalkan upload",
            reset: "batalkan verifikasi",
        }

        Swal.fire({
            title: "Konfirmasi",
            text: `Apakah Anda yakin ingin ${option[action]} materi ini?`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, lanjutkan",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: route,
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        action: action,
                        materi_id: materiId,
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.message || "Status berhasil diubah",
                        }).then(() => {
                            window.location.href = "{{ route('modul-pembelajaran.detail', ['id' => $rpsDetail->rps_matakuliah_id]) }}";
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text:
                                xhr.responseJSON?.message ||
                                "Terjadi kesalahan saat mengubah status",
                        });
                    },
                });
            }
        });
    });
});
</script>
@endpush