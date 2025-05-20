@extends('layouts.partials.admin.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
<style>
    .dtr-details {
        width: 50%;
    }

    .container-xxl {
        max-width: 1250px !important;
    }

    .dtr-details li {
        display: flex;
        justify-content: space-between;
    }
</style>
@endpush
@section('content')
<div class="card mb-5 mb-xl-10">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 d-flex flex-row flex-wrap">
            <div class="d-flex flex-column flex-center h-200px w-200px m-3 bg-light rounded-circle">
                <i class="ki-duotone ki-book-square fs-5x text-primary">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>
                <div class="mb-0">
                    <div class="fs-lg-2hx fs-2x fw-bold d-flex flex-center">
                        <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="{{ $avgMateri }}"
                            data-kt-countup-suffix="%">0</div>
                    </div>
                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                        Pemahaman Materi
                    </span>
                </div>
            </div>
            <div class="d-flex flex-column flex-center h-200px w-200px m-3 bg-light rounded-circle">
                <i class="ki-duotone ki-book-open fs-5x text-success">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="mb-0">
                    <div class="fs-lg-2hx fs-2x fw-bold d-flex flex-center">
                        <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="{{ $avgKuis }}"
                            data-kt-countup-suffix="%">0</div>
                    </div>
                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                        Penilaian Kuis
                    </span>
                </div>
            </div>
            <div class="d-flex flex-column flex-center h-200px w-200px m-3 bg-light rounded-circle">
                <i class="ki-duotone ki-rocket fs-5x text-danger">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div class="mb-0">
                    <div class="fs-lg-2hx fs-2x fw-bold d-flex flex-center">
                        <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="{{ $avgOnTime }}"
                            data-kt-countup-suffix="%">0</div>
                    </div>
                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                        Ketepatan Waktu
                    </span>
                </div>
            </div>
            <div class="d-flex flex-column flex-center h-200px w-200px m-3 bg-light rounded-circle">
                <i class="ki-duotone ki-messages fs-5x text-warning">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                </i>
                <div class="mb-0">
                    <div class="fs-lg-2hx fs-2x fw-bold d-flex flex-center">
                        <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="{{ $forumParticipation }}"
                            data-kt-countup-suffix="%">0</div>
                    </div>
                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                        Keaktifan Forum
                    </span>
                </div>
            </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5"
                style="background-color: #F1416C;background-image:url('assets/media/patterns/vector-1.png')">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Amount-->
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $skalaLikert }} %</span>
                        <!--end::Amount-->
                        <!--begin::Subtitle-->
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-1hx">Hasil Pengujian Skala Likert</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex align-items-end pt-0">
                    <!--begin::Progress-->
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div
                            class="d-flex justify-content-end fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                            <span>{{ $skalaLikert }}%</span>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                            <div class="bg-white rounded h-8px" role="progressbar" style="width: {{ $skalaLikert }}%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Progress-->
                </div>
                <!--end::Card body-->
            </div>
                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5"
                style="background-color: #F1416C;background-image:url('assets/media/patterns/vector-1.png')">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Amount-->
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $avgCP }} %</span>
                        <!--end::Amount-->
                        <!--begin::Subtitle-->
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-1hx">Hasil Pengujian Completion Tracking</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex align-items-end pt-0">
                    <!--begin::Progress-->
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div
                            class="d-flex justify-content-end fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                            <span>{{ $avgCP }}%</span>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                            <div class="bg-white rounded h-8px" role="progressbar" style="width: {{ $avgCP }}%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Progress-->
                </div>
                <!--end::Card body-->
            </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title gap-3">
            <a href="{{ route('laporan-metode.index') }}" class="btn btn-light me-3">Kembali</a>
        </div>
    </div>
    <div class="card-body py-4">
        <div class="table-responsive">
            {!! $dataTable->table() !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush