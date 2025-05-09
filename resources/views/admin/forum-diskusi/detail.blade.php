@extends('layouts.partials.admin.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
@endpush
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center border-0 pt-6">
        <a href="{{ route('forum-diskusi.index') }}" class="btn btn-light me-3">Kembali</a>
    </div>
    <div class="card-body">
        @if ($rpsMatakuliah->rpsDetails->isEmpty())
        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6 mb-10">
            <!--begin::Wrapper-->
            <div class="d-flex justify-content-center flex-grow-1">
                <div class="fs-6 text-gray-700 fw-semibold">Materi Belum ada di Matakuliah Ini !</div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
            @endif
            @foreach ($rpsMatakuliah->rpsDetails as $rpsDetail)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-6 ">
                        <div>
                            <h5 class="card-title fw-bold text-dark">Pertemuan Ke - {{ $rpsDetail->sesi_pertemuan }}
                                @if($rpsDetail->tanggal_realisasi)
                                <span class="badge badge-light-success">
                                    <i class="bi bi-check-circle me-1"></i>Sesi sudah berakhir
                                </span>
                                @elseif ($rpsDetail->tanggal_pertemuan > now())
                                <span class="badge badge-light">
                                    <i class="bi bi-clock me-1"></i>Sesi belum dimulai
                                </span>
                                @else
                                <span class="badge badge-light-primary">
                                    <i class="bi bi-alarm me-1"></i>Sesi sedang berlangsung
                                </span>
                                @endif
                            </h5>
                            <div class="text-muted fw-semibold fs-6">{{
                                \Carbon\Carbon::parse($rpsDetail->tanggal_pertemuan)->locale('id')->translatedFormat('l,
                                d F
                                Y')
                                }}
                            </div>
                        </div>
                        @if(!$rpsDetail->close_forum && $rpsDetail->tanggal_realisasi && Auth::user()->roles->first()->name === 'dosen')
                        <button type="button" class="btn btn-light-danger tutup-forum-btn"
                            data-id="{{ $rpsDetail->id }}">
                            <i class="ki-outline ki-check fs-2"></i> Tutup Forum Diskusi
                        </button>
                        @elseif($rpsDetail->close_forum)
                        <span class="badge badge-light-danger fs-6 px-3 fw-semibold"><i
                                class="ki-outline ki-information text-danger fs-3 me-2"></i>Forum sudah ditutup</span>                        
                        @endif
                    </div>
                    @if (
                    $rpsDetail->materi->filter(fn($m) => $m->status === 'verified')->isEmpty())
                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6 mb-10">
                        <!--begin::Wrapper-->
                        <div class="d-flex justify-content-center flex-grow-1">
                            <div class="fs-6 text-gray-700 fw-semibold">Belum ada Materi di pertemuan
                                ini!
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    @else
                    <!--begin::Item-->
                    @if ($rpsDetail->materi->isNotEmpty())
                    @foreach ($rpsDetail->materi as $materi)
                    @if ($materi->status !== 'verified' && auth()->user()->roles->first()->name !== 'dosen')
                    @continue
                    @endif
                    <div class="d-flex align-items-center bg-light-success hover-elevate-up rounded p-5 mb-7">
                        <i class="ki-duotone ki-book-open text-success fs-1 me-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        <!--begin::Title-->
                        <div class="flex-grow-1 me-2">
                            <p class="fw-bold text-gray-800 m-0 fs-6">Materi : {{ $materi->title }}</p>
                            <span class="text-muted fw-semibold d-block capitalize">Tipe : {{ $materi->tipe_materi
                                }}</span>
                        </div>
                        <!--end::Title-->

                        <!--begin::Action-->
                        <div class="ms-5">
                            @if (!$rpsDetail->tanggal_realisasi)
                            <span class="badge badge-light-warning fs-5 fw-semibold"><i
                                    class="ki-outline ki-information text-warning fs-3 me-2"></i>Sesi belum berakhir</span>
                            @else
                            <a href="{{ route('forum-diskusi.forum',['id'=>$materi->id,'rps_id'=> $rpsMatakuliah->id]) }}"
                                class="btn btn-light-info">
                                <i class="bi bi-eye fs-5 p-0 me-3"></i> Lihat Forum</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endsection
    @push('scripts')
    <script>
        document.querySelector('.tutup-forum-btn')?.addEventListener('click', function () {
		const rpsDetailId = this.dataset.id;
        Swal.fire({
            title: 'Tutup Forum Diskusi?',
            text: "Setelah dikonfirmasi, forum ini akan diakhiri dan tidak dapat diubah!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Akhiri!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('modul-pembelajaran.end-forum') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ rps_detail_id: rpsDetailId })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: true
                    }).then((result) => {
                        if (result.isConfirmed) {
							window.location.href = data.redirect_url
                        }
                    });
                });
            }
        });
	});
    </script>
    @endpush