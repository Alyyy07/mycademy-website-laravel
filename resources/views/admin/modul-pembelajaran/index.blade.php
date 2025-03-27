@extends('layouts.partials.admin.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
@endpush
@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title gap-3">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <input type="text" data-action="search" class="form-control form-control-solid w-250px ps-13"
                    placeholder="Cari" />
            </div>
            <div class="d-flex align-items-center position-relative my-1">
                <div class="input-group input-group-solid flex-nowrap">
                    <span class="input-group-text">
                        <i class="ki-duotone ki-notepad-bookmark fs-3"><span class="path1"></span><span
                                class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                class="path5"></span><span class="path6"></span></i>
                    </span>
                    <div class="overflow-hidden flex-grow-1">
                        <select name="tahun_ajaran_id" data-table="#modulpembelajaran-table" data-action="filter"
                            data-allow-clear="true" data-url="{{ route('mapping-matakuliah.index') }}"
                            data-control="select2" data-placeholder="Pilih Tahun Ajaran"
                            class="form-select form-select-solid w-250px fw-bold">
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}">
                                {{ $ta->tahun_ajaran }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body py-4">
        {{ $dataTable->table() }}
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush