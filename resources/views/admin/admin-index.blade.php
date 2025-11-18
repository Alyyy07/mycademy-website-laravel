@extends('layouts.partials.admin.app')
@section('content')
<div class="card mb-5 mb-xl-10">
    <div class="card-body">
        <div class="d-flex flex-row justify-content-between flex-wrap">
            <div class="d-flex flex-column flex-center h-200px w-200px m-3 bg-light rounded-circle">
                <i class="ki-duotone ki-bank fs-5x text-primary">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div class="mb-0">
                    <div class="fs-lg-2hx fs-2x fw-bold d-flex flex-center">
                        <div class="min-w-70px text-center" data-kt-countup="true"
                            data-kt-countup-value="{{ $fakultas }}">0</div>
                    </div>
                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                        Fakultas Terdaftar
                    </span>
                </div>
            </div>
            <div class="d-flex flex-column flex-center h-200px w-200px m-3 bg-light rounded-circle">
                <i class="ki-duotone ki-medal-star fs-5x text-danger">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i> 
                <div class="mb-0">
                    <div class="fs-lg-2hx fs-2x fw-bold d-flex flex-center">
                        <div class="min-w-70px text-center" data-kt-countup="true" data-kt-countup-value="{{ $prodi }}">
                            0</div>
                    </div>
                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                        Prodi Terdaftar
                    </span>
                </div>
            </div>
            <div class="d-flex flex-column flex-center h-200px w-200px m-3 bg-light rounded-circle">
                <i class="ki-duotone ki-user fs-5x text-warning">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div class="mb-0">
                    <div class="fs-lg-2hx fs-2x fw-bold d-flex flex-center">
                        <div class="min-w-70px text-center" data-kt-countup="true"
                            data-kt-countup-value="{{ $mahasiswa }}">0</div>
                    </div>
                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                        Total Mahasiswa
                    </span>
                </div>
            </div>
            <div class="d-flex flex-column flex-center h-200px w-200px m-3 bg-light rounded-circle">
                <i class="ki-duotone ki-user-tick fs-5x text-success">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>
                <div class="mb-0">
                    <div class="fs-lg-2hx fs-2x fw-bold d-flex flex-center">
                        <div class="min-w-70px text-center" data-kt-countup="true" data-kt-countup-value="{{ $dosen }}">
                            0</div>
                    </div>
                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                        Total Dosen
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection