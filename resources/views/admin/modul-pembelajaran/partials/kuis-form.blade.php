@extends('layouts.partials.admin.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
@endpush
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-5">
            <a href="{{ route('modul-pembelajaran.detail',['id' => $rpsDetailId]) }}"
                class="btn btn-light me-3">Kembali</a>
            @if ($action == 'edit' && $kuis->status == 'draft' && auth()->user()->roles->first()->name == 'dosen')
            @if (canManageModul($rpsDetail->tanggal_pertemuan,$rpsDetail->force_upload))
                
            <button type="button" class="btn btn-light-primary me-3"
            data-route="{{ route('modul-pembelajaran.kuis.status') }}" data-action="publish"
            data-kuis-id="{{ $kuis->id }}" class="btn btn-light-success me-3">Upload</button>
            @else
            <small class="text-danger text-center d-flex gap-1 align-items-center">
                <strong>Perhatian!</strong> Anda tidak dapat mengupload kuis karena sudah melewati batas waktu upload.
                Silahkan hubungi admin matakuliah untuk mengupload kuis.
            </small>
            @endif
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
                    <label class="required fw-semibold fs-6 mb-2" for="title">Judul</label>
                    <input type="text" id="title" name="title" @if ($kuis->status !== 'draft') disabled @endif
                    class="form-control
                    form-control-solid mb-3 mb-lg-0"
                    placeholder="Masukkan Judul Kuis" autofocus value="{{ $kuis->title ?? old('title') }}" />
                </div>
                <div class="fv-row mb-7">
                    <label class="required fw-semibold fs-6 mb-2">Deskripsi</label>
                    <textarea name="description"
                        @if($kuis->status !== 'draft') disabled @endif class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Masukkan Deskripsi Kuis" data-kt-autosize="true">{{ $kuis->description ?? old('description') }}</textarea>
                </div>
                <div class="fv-row mb-7">
                    <div id="kuis_repeater">
                        <div data-repeater-list="questions">
                            @if($action === 'edit' && $kuis->questions)
                            @foreach($kuis->questions as $question)
                            <div data-repeater-item class="mb-4">
                                <div class="form-group row">
                                    <div class="mb-3">
                                        <label class="form-label">Soal:</label>
                                        <textarea name="question_text" class="form-control form-control-solid"
                                            placeholder="Masukkan Soal"
                                            @if($kuis->status !== 'draft') disabled @endif>{{ $question->question_text }}</textarea>
                                    </div>

                                    <div class="inner-repeater">
                                        <div data-repeater-list="options">
                                            @foreach($question->options as $index => $option)
                                            <div data-repeater-item class="row mb-2">
                                                <div class="col-md-9">
                                                    <input type="text" name="option_text"
                                                        class="form-control form-control-solid"
                                                        placeholder="Jawaban {{ chr(65 + $index) }}"
                                                        value="{{ $option->option_text }}" @if($kuis->status !==
                                                    'draft')
                                                    disabled @endif />
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
                                        <textarea name="question_text" class="form-control form-control-solid"
                                            placeholder="Masukkan Soal"
                                            @if($kuis->status !== 'draft') disabled @endif></textarea>
                                    </div>

                                    <div class="inner-repeater">
                                        <div data-repeater-list="options">
                                            @for ($i = 0; $i < 4; $i++) <div data-repeater-item class="row mb-2">
                                                <div class="col-md-9">
                                                    <input type="text" name="option_text"
                                                        class="form-control form-control-solid"
                                                        placeholder="Jawaban {{ chr(65 + $i) }}" @if($kuis->status
                                                    !==
                                                    'draft') disabled @endif />
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
        @if ($action === 'create' || $kuis->status == 'draft' && auth()->user()->roles->first()->name ==
        'dosen')
        <button type="reset" class="btn btn-light me-3">Reset</button>
        <button type="submit" class="btn btn-{{ $action == 'edit' ? 'light-warning' : 'light-primary' }}">
            <span class="indicator-label">{{ $action == 'edit' ? 'Update' : 'Submit' }}</span>
        </button>
        @elseif($kuis->status == 'uploaded' && auth()->user()->roles->first()->name == 'admin-matakuliah')
        <button type="button" class="btn btn-light-primary me-3"
            data-route="{{ route('modul-pembelajaran.kuis.status') }}" data-action="verify"
            data-kuis-id="{{ $kuis->id }}">Verifikasi</button>
        <button type="button" class="btn btn-light-danger me-3"
            data-route="{{ route('modul-pembelajaran.kuis.status') }}" data-action="reject"
            data-kuis-id="{{ $kuis->id }}">Tolak</button>
        @elseif(($kuis->status == 'verified' || $kuis->status == 'rejected') && auth()->user()->roles->first()->name == 'admin-matakuliah')
        <button type="button" class="btn btn-light-danger me-3"
            data-route="{{ route('modul-pembelajaran.kuis.status.reset') }}" data-action="reject"
            data-kuis-id="{{ $kuis->id }}">Batalkan Verifikasi</button>
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
    $(document).ready(function(){
        $(
        'button[data-action="publish"], button[data-action="verify"], button[data-action="reject"]'
    ).on("click", function () {
        const route = $(this).data("route");
        const action = $(this).data("action");
        const kuisId = $(this).data("kuis-id");

        const option = {
            publish: "upload",
            verify: "verifikasi",
            reject: "tolak",
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
                        kuis_id: kuisId,
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.message || "Status berhasil diubah",
                        }).then(() => {
                            window.location.href =
                                "{{ route('modul-pembelajaran.detail', ['id' => $rpsDetailId]) }}";
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