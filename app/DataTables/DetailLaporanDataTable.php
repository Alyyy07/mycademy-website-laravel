<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Materi;
use App\Models\Kuis;
use App\Models\MappingMatakuliah;
use App\Models\RpsDetail;
use App\Models\RpsMatakuliah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class DetailLaporanDataTable extends DataTable
{
    protected $allMateri;
    protected $allKuis;

    public function __construct()
    {
        // Load semua materi dan kuis untuk matakuliah
        $this->allMateri = Materi::with('rpsDetail')
            ->whereHas('rpsDetail', fn($q) => $q->where('rps_matakuliah_id', request('id')))
            ->get();

        $this->allKuis = Kuis::with('rpsDetail')
            ->whereHas('rpsDetail', fn($q) => $q->where('rps_matakuliah_id', request('id')))
            ->get();
    }

    public function dataTable($query): EloquentDataTable
    {
        $dt = new EloquentDataTable(
            $query->with([
                'discussionMessages',
                'materiMahasiswa' => fn($q) => $q->whereHas('materi.rpsDetail', fn($q2) => $q2->where('rps_matakuliah_id', request('id'))),
                'materiMahasiswa.materi.rpsDetail',
                'kuisMahasiswa' => fn($q) => $q->whereHas('kuis.rpsDetail', fn($q2) => $q2->where('rps_matakuliah_id', request('id'))),
                'kuisMahasiswa.kuis.rpsDetail',
            ])
        );

        // Kolom akumulasi keaktifan forum
        $dt->addColumn('forum_activity', function (User $user) {
            $materiWithOpenForum = Materi::with('rpsDetail')
                ->whereHas('rpsDetail', fn($q) => $q->where('rps_matakuliah_id', request('id'))->whereNotNull('tanggal_realisasi'))
                ->get();
            $openMateriIds = collect($materiWithOpenForum)->pluck('id');
            $totalOpen = $openMateriIds->count();
            $activeCount = $user->discussionMessages
                ->pluck('materi_id')
                ->intersect($openMateriIds)
                ->unique()
                ->count();
            $percent = $totalOpen
                ? round($activeCount / $totalOpen * 100) . '%'
                : '0%';
            return "{$activeCount}/{$totalOpen} (" . $percent . ")";
        });

        // Kolom materi
        foreach ($this->allMateri as $m) {
            $col = 'materi_' . $m->id;
            $dt->addColumn($col, function (User $user) use ($m) {
                $mm = $user->materiMahasiswa->firstWhere('materi_id', $m->id);
                if (! $mm) {
                    return "<div class='text-start' style='width:200px'><span class='badge badge-light-danger'>Belum Selesai</span></div>";
                }
                $next = $m->rpsDetail->nextRpsDetail();
                $deadline = $next
                    ? Carbon::parse($next->tanggal_pertemuan)
                    : Carbon::parse($m->rpsDetail->tanggal_pertemuan)->addDays(7);
                $onTime = $mm->created_at->lte($deadline)
                    ? '<span class="badge badge-light-success">Tepat Waktu</span>'
                    : '<span class="badge badge-light-danger">Terlambat</span>';
                $forumActive = $user->discussionMessages->where('materi_id', $m->id)->isNotEmpty()
                    ? 'Berpartisipasi'
                    : 'Tidak Berpartisipasi';

                return "<div class='text-start' style='width:200px'>"
                    . "<p>Skala: <strong>{$mm->skala_pemahaman}</strong></p>"
                    . "<p>Status : {$onTime}</p>"
                    . "<p>Forum : <strong>{$forumActive}</strong></p>"
                    . "</div>";
            });
        }

        // Kolom kuis
        foreach ($this->allKuis as $k) {
            $col = 'kuis_' . $k->id;
            $dt->addColumn($col, function (User $user) use ($k) {
                $km = $user->kuisMahasiswa->firstWhere('kuis_id', $k->id);
                if (! $km) {
                    return "<div class='text-start' style='width:200px'><span class='badge badge-light-danger'>Belum Selesai</span></div>";
                }
                $next     = $k->rpsDetail->nextRpsDetail();
                $deadline = $next
                    ? Carbon::parse($next->tanggal_pertemuan)
                    : Carbon::parse($k->rpsDetail->tanggal_pertemuan)->addDays(7);

                $statusBadge = $km->created_at->lte($deadline)
                    ? '<span class="badge badge-light-success">Tepat Waktu</span>'
                    : '<span class="badge badge-light-danger">Terlambat</span>';

                return "<div class='text-start' style='width:200px'>"
                    . "<p>Nilai:<strong>{$km->nilai}</strong></p>"
                    . "<p>Status : {$statusBadge}</p>"
                    . "</div>";
            });
        }

        // Rata-rata skala materi
        $dt->addColumn('avg_skala_materi', function (User $user) {
            $avg = $user->materiMahasiswa->avg('skala_pemahaman') ?? 0;
            $avginPercent = $avg * 25;
            if ($avginPercent > 100) {
                $avginPercent = 100;
            }
            $avginPercent = round($avginPercent, 2);
            return number_format($avginPercent, 2) . ' %' . ' ( ' . number_format($avg, 2) . ' / 4 )';
        });

        // Rata-rata nilai kuis
        $dt->addColumn('avg_nilai_kuis', function (User $user) {
            $avg = $user->kuisMahasiswa->avg('nilai') ?? 0;
            return number_format($avg, 2);
        });

        // % tepat waktu materi
        $dt->addColumn('pct_on_time_materi', function (User $user) {
            $total = $user->materiMahasiswa->count();
            if ($total === 0) return '0%';
            $onTime = $user->materiMahasiswa->filter(function ($mm) {
                $m = $mm->materi;
                $next = $m->rpsDetail->nextRpsDetail();
                $deadline = $next
                    ? Carbon::parse($next->tanggal_pertemuan)
                    : Carbon::parse($m->rpsDetail->tanggal_pertemuan)->addDays(7);
                return $mm->created_at->lte($deadline);
            })->count();
            return round($onTime / $total * 100) . '%';
        });

        // % tepat waktu kuis
        $dt->addColumn('pct_on_time_kuis', function (User $user) {
            $total = $user->kuisMahasiswa->count();
            if ($total === 0) return '0%';
            $onTime = $user->kuisMahasiswa->filter(function ($km) {
                $k = $km->kuis;
                $next = $k->rpsDetail->nextRpsDetail();
                $deadline = $next
                    ? Carbon::parse($next->tanggal_pertemuan)
                    : Carbon::parse($k->rpsDetail->tanggal_pertemuan)->addDays(7);
                return $km->created_at->lte($deadline);
            })->count();
            return round($onTime / $total * 100) . '%';
        });

        // Sertakan HTML pada kolom tertentu
        $raw = [];
        $raw[] = 'forum_activity';
        foreach ($this->allMateri as $m) {
            $raw[] = 'materi_' . $m->id;
        }
        foreach ($this->allKuis as $k) {
            $raw[] = 'kuis_' . $k->id;
        }
        $raw = array_merge($raw, ['pct_on_time_materi', 'pct_on_time_kuis']);

        return $dt->rawColumns($raw);
    }

    public function query(User $model)
    {
        $mapping = MappingMatakuliah::with('matakuliah')->findOrFail(request('id'));

        $semester = $mapping->semester;
        $prodiId   = $mapping->matakuliah->prodi_id;

        $rpsId = RpsMatakuliah::where('mapping_matakuliah_id', $mapping->id)
            ->value('id');

        return $model->newQuery()
            ->role('mahasiswa')->whereHas('mahasiswa', function ($q) use ($semester, $prodiId) {
                $q->where('semester', $semester)
                    ->where('prodi_id', $prodiId);
            })->whereHas(
                'materiMahasiswa.materi.rpsDetail',
                fn($q) =>
                $q->where('rps_matakuliah_id', $rpsId)
            )
            ->whereHas(
                'kuisMahasiswa.kuis.rpsDetail',
                fn($q) =>
                $q->where('rps_matakuliah_id', $rpsId)
            )->with([
                'discussionMessages',
                'materiMahasiswa.materi.rpsDetail',
                'kuisMahasiswa.kuis.rpsDetail',
            ]);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('detaillaporan-table')
            ->columns($this->getColumns())
            ->responsive(true)
            ->minifiedAjax()
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 gs-7')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1)
            ->parameters(['order' => []]);
    }

    public function getColumns(): array
    {
        $cols = [
            Column::make('name')->title('Mahasiswa')->addClass('min-w-200px'),
            Column::computed('avg_skala_materi')->title('Rata-Rata Skala Materi')->addClass('text-center min-w-150px'),
            Column::computed('avg_nilai_kuis')->title('Rata-Rata Nilai Kuis')->addClass('text-center min-w-150px'),
            Column::computed('pct_on_time_materi')->title('% Tepat Waktu Materi')->addClass('text-center min-w-100px'),
            Column::computed('pct_on_time_kuis')->title('% Tepat Waktu Kuis')->addClass('text-center min-w-100px'),
            Column::computed('forum_activity')->title('Keaktifan Forum')->addClass('text-center min-w-150px'),
        ];

        foreach ($this->allMateri as $m) {
            $cols[] = Column::computed('materi_' . $m->id)
                ->title(new HtmlString(
                    '<div>'
                        . '<div class="badge badge-light-primary ms-1">Materi</div>'
                        . '<p class="p-0">' . e($m->title) . '</p>'
                        . '</div>'
                ))
                ->addClass('min-w-150px')
                ->orderable(false)
                ->searchable(false);
        }
        foreach ($this->allKuis as $k) {
            $cols[] = Column::computed('kuis_' . $k->id)
                ->addClass('min-w-150px')
                ->title(new HtmlString(
                    '<div>'
                        . '<div class="badge badge-light-warning ms-1">Kuis</div>'
                        . '<p class="p-0">' . e($k->title) . '</p>'
                        . '</div>'
                ))
                ->orderable(false)
                ->searchable(false);
        }

        return $cols;
    }

    protected function filename(): string
    {
        return 'DetailLaporan_' . date('YmdHis');
    }
}
