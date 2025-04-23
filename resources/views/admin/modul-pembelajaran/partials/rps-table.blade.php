<div class="modal fade" tabindex="-1" id="rps_table_modal" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail RPS Matakuliah</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Sesi</th>
                                <th>Tanggal</th>
                                <th>Capaian Pembelajaran</th>
                                <th>Indikator</th>
                                <th>Metode</th>
                                <th>Kriteria</th>
                                <th>Materi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rpsMatakuliah->rpsDetails as $detail)
                            <tr>
                                <td>{{ $detail->sesi_pertemuan }}</td>
                                <td>{{
                                    \Carbon\Carbon::parse($detail->tanggal_pertemuan)->locale('id')->translatedFormat('l,
                                    d F Y') }}</td>
                                <td>{{ $detail->capaian_pembelajaran }}</td>
                                <td>{{ $detail->indikator }}</td>
                                <td>{{ $detail->metode_pembelajaran }}</td>
                                <td>{{ $detail->kriteria_penilaian }}</td>
                                <td>{{ $detail->materi_pembelajaran }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>