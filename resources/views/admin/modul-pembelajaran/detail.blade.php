@extends('layouts.partials.admin.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
@endpush
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center border-0 pt-6">
        <a href="{{ route('modul-pembelajaran.index') }}" class="btn btn-light me-3">Kembali</a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rps_table_modal">
            <i class="ki-outline ki-calendar fs-2 pe-2"></i>RPS Matakuliah</button>
        </button>
        @include('admin.modul-pembelajaran.partials.rps-table')
    </div>
    <div class="card-body">
        @if ($rpsMatakuliah->rpsDetails->isEmpty())
        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6 mb-10">
            <!--begin::Wrapper-->
            <div class="d-flex justify-content-center flex-grow-1">
                <div class="fs-6 text-gray-700 fw-semibold">Rps Belum Dibuat di Matakuliah Ini !</div>
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
                            </h5>
                            <div class="text-muted fw-semibold fs-6">{{
                                \Carbon\Carbon::parse($rpsDetail->tanggal_pertemuan)->locale('id')->translatedFormat('l,
                                d F
                                Y')
                                }}
                            </div>
                        </div>
                        <div class="d-flex gap-5">
                            @if (canManageModul($rpsDetail->tanggal_pertemuan,$rpsDetail->force_upload))
                            @if(auth()->user()->roles->first()->name === 'dosen') <button type="button"
                                button-action="show" modal-id="#materi-modal"
                                button-url="{{ route('modul-pembelajaran.materi.create',['id' => $rpsDetail->id]) }}"
                                class="btn btn-light-primary">
                                <i class="ki-duotone ki-plus fs-2"></i>Tambah Materi</button>
                            <a href="{{ route('modul-pembelajaran.kuis.create',['id'=>$rpsDetail->id]) }}"
                                class="btn btn-light-warning">
                                <i class="ki-duotone ki-plus fs-2"></i>Tambah Tugas</a>
                            @endif
                            @if (auth()->user()->roles->first()->name == 'admin-matakuliah')
                            <div class="alert alert-success">
                                Upload sudah dibuka
                                <form action="{{ route('rps-detail.status-upload') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="rps_detail_id" value="{{ $rpsDetail->id }}">
                                    <button type="submit" class="btn btn-sm btn-light-primary ms-2">Tutup
                                        Upload</button>
                                </form>
                            </div>
                            @endif
                            @else
                            <div class="alert alert-warning">
                                @if ($rpsDetail->tanggal_pertemuan < now()) Upload sudah ditutup @if (auth()->
                                    user()->roles->first()->name == 'admin-matakuliah')
                                    <form action="{{ route('rps-detail.status-upload') }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <input type="hidden" name="rps_detail_id" value="{{ $rpsDetail->id }}">
                                        <button type="submit" class="btn btn-sm btn-light-primary ms-2">Buka
                                            Upload</button>
                                    </form>
                                    @elseif(auth()->user()->roles->first()->name === 'dosen'), silahkan hubungi admin
                                    untuk membuka upload modul.@endif @else Upload hanya dibuka mulai H-7 sampai hari
                                    pertemuan ({{ \Carbon\Carbon::parse($rpsDetail->
                                    tanggal_pertemuan)->translatedFormat('d F Y') }}).
                                    @if (auth()->
                                    user()->roles->first()->name == 'admin-matakuliah')
                                    <form action="{{ route('rps-detail.status-upload') }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <input type="hidden" name="rps_detail_id" value="{{ $rpsDetail->id }}">
                                        <button type="submit" class="btn btn-sm btn-light-primary ms-2">Buka
                                            Upload</button>
                                    </form>
                                    @endif
                                    @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @if(($rpsDetail->materi->isEmpty() || $rpsDetail->materi->first()?->status == 'draft' &&
                    auth()->user()->roles->first()->name !== 'dosen')
                    && ($rpsDetail->kuis->isEmpty() || $rpsDetail->kuis->first()?->status == 'draft' &&
                    auth()->user()->roles->first()->name !== 'dosen'))
                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6 mb-10">
                        <!--begin::Wrapper-->
                        <div class="d-flex justify-content-center flex-grow-1">
                            <div class="fs-6 text-gray-700 fw-semibold">Belum ada Modul yang ditambahkan di pertemuan
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
                    @if ($materi->status == 'draft' && auth()->user()->roles->first()->name !== 'dosen')
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
                        <!--begin::status-->
                        @php
                        $badgeColor = match($materi->status) {
                        'draft' => 'primary',
                        'uploaded' => 'warning',
                        'verified' => 'success',
                        default => 'danger',
                        };
                        @endphp
                        <span class="badge badge-light-{{ $badgeColor }} fs-7 py-3 px-4 text-capitalize">{{
                            $materi->status
                            }}</span>
                        <!--end::status-->
                        <!--begin::Action-->
                        <div class="ms-5">
                            <a href="{{ route('modul-pembelajaran.materi.edit',['id' => $materi->id]) }}"
                                class="btn btn-light-info">
                                <i class="bi bi-eye fs-5 p-0"></i></a>
                            @if ($materi->status == 'draft' && auth()->user()->roles->first()->name == 'dosen')
                            <button type="button" button-action="delete"
                                button-url="{{ route('modul-pembelajaran.materi.destroy',['id'=>$materi->id]) }}"
                                class="btn btn-light-danger">
                                <i class="bi bi-trash fs-5 p-0"></i></button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <!--end::Item-->
                    @if ($rpsDetail->kuis->isNotEmpty())
                    @foreach ($rpsDetail->kuis as $kuis)
                    @if ($kuis->status == 'draft' && auth()->user()->roles->first()->name !== 'dosen')
                    @continue
                    @endif
                    <!--begin::Item-->
                    <div
                        class="d-flex align-items-center bg-light-info hover-elevate-up rounded p-5 {{ $loop->last ? '' : 'mb-7' }}">
                        <i class="ki-duotone ki-note-2 text-info fs-1 me-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        <!--begin::Title-->
                        <div class="flex-grow-1 me-2">
                            <p class="fw-bold text-gray-800 m-0 fs-6">Kuis : {{ $kuis->title }}</p>
                            <span class="text-muted fw-semibold d-block">Deskripsi : {{ $kuis->description }}</span>
                        </div>
                        <!--end::Title-->
                        @php
                        $badgeColor = match($kuis->status) {
                        'draft' => 'primary',
                        'uploaded' => 'warning',
                        'verified' => 'success',
                        default => 'danger',
                        };
                        @endphp
                        <span class="badge badge-light-{{ $badgeColor }} fs-7 py-3 px-4 text-capitalize">{{
                            $kuis->status
                            }}</span>
                        <!--end::status-->
                        <!--begin::Action-->
                        <div class="ms-5">
                            <a href="{{ route('modul-pembelajaran.kuis.edit',['id' => $kuis->id]) }}"
                                class="btn btn-light-info">
                                <i class="bi bi-eye fs-5 p-0"></i></a>
                            @if ($kuis->status == 'draft' && auth()->user()->roles->first()->name == 'dosen')
                            <button type="button" button-action="delete"
                                button-url="{{ route('modul-pembelajaran.kuis.destroy',['id'=>$kuis->id]) }}"
                                class="btn btn-light-danger">
                                <i class="bi bi-trash fs-5 p-0"></i></button>
                            @endif
                        </div>
                    </div>
                    <!--end::Item-->
                    @endforeach
                    @endif
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endsection