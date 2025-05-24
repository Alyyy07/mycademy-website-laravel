<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Materi;
use App\Models\Kuis;
use App\Models\MappingMatakuliah;
use App\Models\RpsMatakuliah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DetailLaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $mappingId;
    protected $rpsId;
    protected $allMateri;
    protected $allKuis;

    public function __construct(int $mappingId)
    {
        Log::info('DetailLaporanExport initialized with mappingId: ' . $mappingId);
        $this->mappingId = $mappingId;
        $this->rpsId = RpsMatakuliah::where('mapping_matakuliah_id', $mappingId)->value('id');

        // Muat materi dan kuis terkait RPS
        $this->allMateri = Materi::whereHas('rpsDetail', fn($q) =>
            $q->where('rps_matakuliah_id', $this->rpsId)
        )->get();

        Log::info('Materi loaded: ' . $this->allMateri->count() . ' items');

        $this->allKuis = Kuis::whereHas('rpsDetail', fn($q) =>
            $q->where('rps_matakuliah_id', $this->rpsId)
        )->get();
        Log::info('Kuis loaded: ' . $this->allKuis->count() . ' items');
    }

    /**
     * Kumpulan data mahasiswa sesuai matakuliah
     */
    public function collection()
    {
        $mapping = MappingMatakuliah::with('matakuliah')->findOrFail($this->mappingId);
        $semester = $mapping->semester;
        $prodiId  = $mapping->matakuliah->prodi_id;

        return User::role('mahasiswa')
            ->whereHas('mahasiswa', fn($q) =>
                $q->where('semester', $semester)
                  ->where('prodi_id', $prodiId)
            )
            ->with([
                'discussionMessages',
                'materiMahasiswa' => fn($q) =>
                    $q->whereHas('materi.rpsDetail', fn($r) =>
                        $r->where('rps_matakuliah_id', $this->rpsId)
                    ),
                'materiMahasiswa.materi.rpsDetail',
                'kuisMahasiswa' => fn($q) =>
                    $q->whereHas('kuis.rpsDetail', fn($r) =>
                        $r->where('rps_matakuliah_id', $this->rpsId)
                    ),
                'kuisMahasiswa.kuis.rpsDetail',
            ])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'Avg Skala Materi (%)',
            'Avg Nilai Kuis',
            '% Tepat Waktu Materi',
            '% Tepat Waktu Kuis',
            'Keaktifan Forum (count/total %)'
        ];
    }

    public function map($user): array
{
    // rata-rata skala materi
    $avgScale = $user->materiMahasiswa->avg('skala_pemahaman') ?: 0;
    $avgScalePct = round(min($avgScale * 25, 100), 2);

    // rata-rata nilai kuis
    $avgKuis = round($user->kuisMahasiswa->avg('nilai') ?: 0, 2);

    // ambil ID list materi/kuis RPS
    $allMateriIds = $this->allMateri->pluck('id');
    $allKuisIds   = $this->allKuis->pluck('id');

    // persentase tepat waktu materi
    $totalMateri = $allMateriIds->count();
    if ($totalMateri === 0) {
        $pctOnTimeMateri = 0;
    } else {
        $onTimeMateri = $user->materiMahasiswa
            ->whereIn('materi_id', $allMateriIds)
            ->filter(function ($mm) {
                $m = $mm->materi;
                $nextDetail = $m->rpsDetail->nextRpsDetail();
                $deadline = $nextDetail
                    ? Carbon::parse($nextDetail->tanggal_pertemuan)
                    : Carbon::parse($m->rpsDetail->tanggal_pertemuan)->addDays(7);
                return Carbon::parse($mm->created_at)->lte($deadline);
            })->count();

        $pctOnTimeMateri = round($onTimeMateri / $totalMateri * 100);
    }

    // persentase tepat waktu kuis
    $totalKuis = $allKuisIds->count();
    if ($totalKuis === 0) {
        $pctOnTimeKuis = 0;
    } else {
        $onTimeKuis = $user->kuisMahasiswa
            ->whereIn('kuis_id', $allKuisIds)
            ->filter(function ($km) {
                $k = $km->kuis;
                $nextDetail = $k->rpsDetail->nextRpsDetail();
                $deadline = $nextDetail
                    ? Carbon::parse($nextDetail->tanggal_pertemuan)
                    : Carbon::parse($k->rpsDetail->tanggal_pertemuan)->addDays(7);
                return Carbon::parse($km->created_at)->lte($deadline);
            })->count();

        $pctOnTimeKuis = round($onTimeKuis / $totalKuis * 100);
    }

    // keaktifan forum (materi terbuka)
    $openIds    = $allMateriIds;
    $totalOpen  = $openIds->count();
    $activeCount = $user->discussionMessages
        ->pluck('materi_id')
        ->intersect($openIds)
        ->unique()
        ->count();
    $pctForum = $totalOpen
        ? round($activeCount / $totalOpen * 100)
        : 0;

    return [
        $user->name,
        "{$avgScalePct} %",
        number_format($avgKuis, 2),
        "{$pctOnTimeMateri} %",
        "{$pctOnTimeKuis} %",
        "{$activeCount}/{$totalOpen} ({$pctForum} %)",
    ];
}

}
