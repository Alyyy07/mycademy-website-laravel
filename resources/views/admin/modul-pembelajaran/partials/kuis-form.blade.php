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
        <form id="kuis-form" class="form" action="{{ $route }}" modal-action="{{ $action }}"
            enctype="multipart/form-data">
            @if ($action == 'edit')
            @method('PUT')
            @endif
            @csrf
            <div class="d-flex flex-column scroll-y px-5 px-lg-10">
                <div class="fv-row mb-7">
                    <input type="hidden" name="rps_detail_id" value="{{ $rpsDetailId }}">
                    <label class="required fw-semibold fs-6 mb-2" for="title">Judul</label>
                    <input type="text" id="title" name="title" @if ($kuis->status !== 'draft') disabled @endif
                    class="form-control
                    form-control-solid mb-3 mb-lg-0"
                    placeholder="Masukkan Judul Kuis" autofocus value="{{ $kuis->title ?? old('title') }}" />
                </div>
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">Deskripsi</label>
                    <textarea name="description"
                        @if($kuis->status !== 'draft') disabled @endif class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Deskripsi Kuis" data-kt-autosize="true">{{ $kuis->description ?? old('description') }}</textarea>
                    <input type="hidden" name="status" id="status_input" value="draft">
                </div>
                <div class="fv-row mb-7">
                    <div id="kuis_repeater">
                        <div data-repeater-list="questions">
                            @if($action === 'edit' && $kuis->questions)
                            @foreach($kuis->questions as $question)
                            <div data-repeater-item class="mb-4">
                                <div class="form-group row">
                                    <div class="mb-3">
                                        <label class="form-label fs-5">Soal ke - {{ $loop->index +1 }}</label>
                                        <div class="ckeditor">
                                            <div class="document-toolbar"></div>
                                            <div class="document-editor"></div>
                                            <input type="hidden" name="question_text"
                                                value="{{ $question->question_text }}" @if ($kuis->status !== 'draft')
                                            disabled @endif />
                                        </div>
                                    </div>

                                    <div class="inner-repeater">
                                        <label class="form-label">Jawaban:</label>
                                        <div data-repeater-list="options">
                                            @foreach($question->options as $index => $option)
                                            <div data-repeater-item class="row mb-2">
                                                <div class="col-md-9">
                                                    <div class="ckeditor">
                                                        <div class="document-toolbar"></div>
                                                        <div class="document-editor"></div>
                                                        <input type="hidden" name="option_text"
                                                            value="{{ $option->option_text }}" @if ($kuis->status
                                                        !==
                                                        'draft')
                                                        disabled @endif />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check form-check-custom form-check-solid mt-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="is_correct" value="1" @if($option->is_correct) checked
                                                        @endif
                                                        @if($kuis->status !== 'draft') disabled @endif />
                                                        <label class="form-check-label">Jawaban Benar</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    @if ($kuis->status == 'draft')

                                    <div class="mt-3">
                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger">
                                            <i class="bi bi-trash fs-5"></i> Hapus Soal
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div data-repeater-item class="mb-4">
                                <div class="form-group row">
                                    <div class="mb-3">
                                        <label class="form-label">Soal:</label>
                                        <div class="ckeditor">
                                            <div class="document-toolbar"></div>
                                            <div class="document-editor"></div>
                                            <input type="hidden" name="question_text" @if ($kuis->status !== 'draft')
                                            disabled @endif />
                                        </div>
                                    </div>

                                    <div class="inner-repeater">
                                        <div class="mb-3">
                                            <label class="form-label">Jawaban:</label>
                                            <div data-repeater-list="options">
                                                @for ($i = 0; $i < 4; $i++) <div data-repeater-item class="row mb-2">
                                                    <div class="col-md-9">
                                                        <div class="ckeditor">
                                                            <div class="document-toolbar"></div>
                                                            <div class="document-editor"></div>
                                                            <input type="hidden" name="option_text" @if ($kuis->status
                                                            !==
                                                            'draft')
                                                            disabled @endif />
                                                        </div>

                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-check form-check-custom form-check-solid mt-2">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="is_correct" value="1" @if($kuis->status !==
                                                            'draft')
                                                            disabled @endif />
                                                            <label class="form-check-label">Jawaban Benar</label>
                                                        </div>
                                                    </div>
                                            </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($kuis->status == 'draft')

                            <!-- Tombol hapus soal -->
                            <div class="mt-3">
                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger">
                                    <i class="bi bi-trash fs-5"></i> Hapus Soal
                                </a>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>

                    @if ($kuis->status == 'draft')

                    <div class="form-group mt-5">
                        <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                            <i class="ki-duotone ki-plus fs-3"></i> Tambah Soal
                        </a>
                    </div>
                    @endif
                </div>


                <!--end::Repeater-->
            </div>
    </div>
    <div class="text-center pt-10">
        @if ($rpsDetail->tanggal_realisasi === null)
        @if ($action === 'create' || $kuis->status == 'draft' && auth()->user()->roles->first()->name ==
        'dosen')
        <div class="position-relative w-100">
            <div class="d-flex justify-content-center gap-3">
                <button type="reset" class="btn btn-light me-3">Reset</button>
                <button type="submit" class="btn btn-{{ $action == 'edit' ? 'light-warning' : 'light-primary' }}"
                    onclick="setStatus('draft')">
                    <span class="indicator-label">{{ $action == 'edit' ? 'Update' : 'Simpan sebagai Draft' }}</span>
                </button>
                @elseif($kuis->status == 'uploaded' && auth()->user()->roles->first()->name == 'admin-matakuliah')
                <button type="button" class="btn btn-light-primary me-3"
                    data-route="{{ route('modul-pembelajaran.kuis.status') }}" data-action="verify"
                    data-kuis-id="{{ $kuis->id }}">Verifikasi</button>
                <button type="button" class="btn btn-light-danger me-3"
                    data-route="{{ route('modul-pembelajaran.kuis.status') }}" data-action="reject"
                    data-kuis-id="{{ $kuis->id }}">Tolak</button>
                @elseif(($kuis->status == 'verified' || $kuis->status == 'rejected') &&
                auth()->user()->roles->first()->name ==
                'admin-matakuliah')
                <button type="button" class="btn btn-light-danger me-3"
                    data-route="{{ route('modul-pembelajaran.kuis.status.reset') }}" data-action="reset"
                    data-kuis-id="{{ $kuis->id }}">Batalkan Verifikasi</button>
                @endif
                @if ($kuis->status == 'draft' && auth()->user()->roles->first()->name == 'dosen')
                <button type="submit" class="position-absolute end-0 top-50 translate-middle-y btn btn-light-primary"
                    onclick="setStatus('uploaded')">
                    Simpan & Upload
                </button>
            </div>
        </div>
        @elseif ($kuis->status == 'uploaded' && auth()->user()->roles->first()->name ==
        'dosen')
        <button type="button" class="btn btn-light-danger me-3"
            data-route="{{ route('modul-pembelajaran.kuis.status') }}" data-action="unpublish"
            data-kuis-id="{{ $kuis->id }}">Batalkan Upload</button>
        @endif
        @endif
    </div>
    </form>
</div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-document.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script src="{{ asset('assets/js/kuis-form.js') }}"></script>
<script>
    function setStatus(status) {
    document.getElementById('status_input').value = status;
}
    $(document).ready(function(){
        $(
        'button[data-action="publish"], button[data-action="verify"], button[data-action="reject"], button[data-action="unpublish"], button[data-action="reset"]'
    ).on("click", function () {
        const route = $(this).data("route");
        const action = $(this).data("action");
        const kuisId = $(this).data("kuis-id");

        const option = {
            publish: "upload",
            verify: "verifikasi",
            reject: "tolak",
            unpublish: "batalkan upload",
            reset: "batalkan verifikasi",
        }

        Swal.fire({
            title: "Konfirmasi",
            text: `Apakah Anda yakin ingin ${option[action]} kuis ini?`,
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
                        kuis_id: kuisId,
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.message || "Status berhasil diubah",
                        }).then(() => {
                            window.location.href =
                                "{{ route('modul-pembelajaran.detail', ['id' => $rpsDetail->rps_matakuliah_id]) }}";
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