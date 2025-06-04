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
                            data-kt-countup-value="{{ $matakuliah }}">0</div>
                    </div>
                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                        Matakuliah Diampu
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
                        <div class="min-w-70px text-center" data-kt-countup="true"
                            data-kt-countup-value="{{ $mahasiswa }}">
                            0</div>
                    </div>
                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                        Mahasiswa Terdaftar
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
                            data-kt-countup-value="{{ $materi }}">0</div>
                    </div>
                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                        Total Materi
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
                        <div class="min-w-70px text-center" data-kt-countup="true" data-kt-countup-value="{{ $kuis }}">
                            0</div>
                    </div>
                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                        Total Kuis
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@if (Auth::user()->roles->first()->name === 'admin-matakuliah')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pengajuan Tanggal Pengganti (Pending)</h3>
    </div>
    <div class="card-body">
        @if($pendingList->isEmpty())
        <div class="alert alert-warning">
            Belum ada pengajuan tanggal pengganti untuk diproses.
        </div>
        @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Matakuliah</th>
                    <th>Pertemuan Ke</th>
                    <th>Tanggal Asli</th>
                    <th>Tanggal Pengganti</th>
                    <th>Dosen Pengaju</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingList as $item)
                @php
                $mapping = optional($item->rpsMatakuliah)->mappingMatakuliah;
                $namaMtk = optional(optional($mapping)->matakuliah)->nama_matakuliah ?? '-';
                $namaDosen = optional($mapping->dosen)->name ?? '-';
                $sesiPertemuan = $item->sesi_pertemuan ?? '-';
                $tanggalAsli = optional($item->tanggal_pertemuan)->translatedFormat('d/m/Y') ?? '-';
                $tanggalPengganti = optional($item->tanggal_pengganti)->translatedFormat('d/m/Y') ?? '-';
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $namaMtk }}</td>
                    <td>{{ $sesiPertemuan }}</td>
                    <td>{{ $tanggalAsli }}</td>
                    <td>{{ $tanggalPengganti }}</td>
                    <td>{{ $namaDosen }}</td>
                    <td>
                        <button class="btn btn-success btn-sm btn-approve" data-id="{{ $item->id }}">
                            Approve
                        </button>
                        <button class="btn btn-danger btn-sm btn-reject" data-id="{{ $item->id }}">
                            Reject
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endif
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
    // Handler klik Approve
    $('.btn-approve').on('click', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Setujui pengajuan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Setuju',
            cancelButtonText: 'Batal'
        }).then((res) => {
            if (res.isConfirmed) {
                $.ajax({
                    url: "{{ url('/modul-pembelajaran') }}/" + id + "/proses-tanggal-pengganti",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: 'approve'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        let errMsg = 'Terjadi kesalahan.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        Swal.fire('Gagal', errMsg, 'error');
                    }
                });
            }
        });
    });

    // Handler klik Reject
    $('.btn-reject').on('click', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Tolak pengajuan?',
            text: 'Apakah Anda yakin ingin menolak pengajuan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Tolak',
            cancelButtonText: 'Batal'
        }).then((res) => {
            if (res.isConfirmed) {
                $.ajax({
                    url: "{{ url('/modul-pembelajaran') }}/" + id + "/proses-tanggal-pengganti",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: 'reject'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        let errMsg = 'Terjadi kesalahan.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        Swal.fire('Gagal', errMsg, 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush