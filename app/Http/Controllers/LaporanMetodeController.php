<?php

namespace App\Http\Controllers;

use App\DataTables\DetailLaporanDataTable;
use App\DataTables\LaporanMetodeDataTable;
use App\Exports\DetailLaporanExport;
use App\Models\Akademik\TahunAjaran;
use App\Models\DiscussionMessage;
use App\Models\Kuis;
use App\Models\KuisMahasiswa;
use App\Models\Materi;
use App\Models\MateriMahasiswa;
use App\Models\RpsMatakuliah;
use App\Models\User;
use Carbon\Carbon;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class LaporanMetodeController extends Controller
{
    public function index(LaporanMetodeDataTable $dataTable)
    {
        if (request()->ajax() && request()->has('filter') && request('filter') != '') {
            $search = request('filter');
            $user = Auth::user();
            $data = RpsMatakuliah::with(['mappingMatakuliah.matakuliah', 'mappingMatakuliah.tahunAjaran'])
                ->whereHas('mappingMatakuliah', function ($query) use ($search) {
                    $query->where('tahun_ajaran_id', $search);
                })->whereHas('mappingMatakuliah.matakuliah', function ($query) use ($user) {
                    if ($user->roles->first()->name === 'admin-matakuliah') {
                        $query->where('admin_verifier_id', $user->id);
                    }
                    if ($user->roles->first()->name === 'dosen') {
                        $query->where('dosen_id', $user->id);
                    }
                })->get();
            return DataTables::of($data)
                ->addColumn('action', function ($rps) {
                    $showRoute = route('laporan-metode.index', ['id' => $rps->id]);
                    return view('admin.laporan-metode.partials.action', compact('rps', 'showRoute'));
                })
                ->editColumn('tanggal_mulai', function ($rps) {
                    return Carbon::parse($rps->tanggal_mulai)->locale('id')->translatedFormat('d F Y');
                })
                ->editColumn('tanggal_selesai', function ($rps) {
                    return Carbon::parse($rps->tanggal_selesai)->locale('id')->translatedFormat('d F Y');
                })
                ->rawColumns(['action', 'tanggal_mulai', 'tanggal_selesai'])
                ->make(true);
        }
        $tahunAjaran = Cache::rememberForever('tahun_ajaran', function () {
            return TahunAjaran::all();
        });
        return $dataTable->render('admin.laporan-metode.index', compact('tahunAjaran'));
    }

    public function detail(DetailLaporanDataTable $datatable, Request $request)
    {
        $matkulId = $request->get('id');

        $materiQuery = MateriMahasiswa::whereHas('materi.rpsDetail', function ($q) use ($matkulId) {
            $q->where('rps_matakuliah_id', $matkulId);
        });
        $avgScaleMateri = $materiQuery->avg('skala_pemahaman') ?? 0;
        // Konversi 1–4 ke persen:
        $avgScaleMateriPercent = round($avgScaleMateri * 25, 2);

        //
        // 2) Rata-rata nilai kuis untuk matakuliah ini
        //
        $kuisQuery = KuisMahasiswa::whereHas('kuis.rpsDetail', function ($q) use ($matkulId) {
            $q->where('rps_matakuliah_id', $matkulId);
        });
        $avgNilaiKuis = $kuisQuery->avg('nilai') ?? 0;
        $avgNilaiKuis = round($avgNilaiKuis, 2);

        //
        // 3) Persentase on-time (materi + kuis) untuk matakuliah ini
        //
        $onTimeCount = 0;
        $totalCount  = 0;

        // Materi
        $materiQuery
            ->with('materi.rpsDetail')
            ->get()
            ->each(function ($mm) use (&$onTimeCount, &$totalCount) {
                $next = $mm->materi->rpsDetail->nextRpsDetail();
                $deadline = $next
                    ? Carbon::parse($next->tanggal_pertemuan)
                    : Carbon::parse($mm->materi->rpsDetail->tanggal_pertemuan)->addDays(7);

                if ($mm->created_at->lte($deadline)) {
                    $onTimeCount++;
                }
                $totalCount++;
            });

        // Kuis
        $kuisQuery
            ->with('kuis.rpsDetail')
            ->get()
            ->each(function ($km) use (&$onTimeCount, &$totalCount) {
                $next = $km->kuis->rpsDetail->nextRpsDetail();
                $deadline = $next
                    ? Carbon::parse($next->tanggal_pertemuan)
                    : Carbon::parse($km->kuis->rpsDetail->tanggal_pertemuan)->addDays(7);

                if ($km->created_at->lte($deadline)) {
                    $onTimeCount++;
                }
                $totalCount++;
            });

        $combinedOnTimePct = $totalCount
            ? round($onTimeCount / $totalCount * 100, 2) . '%'
            : '0%';

        $materiAktifIds = Materi::whereHas('rpsDetail', function ($q) use ($matkulId) {
            $q->where('rps_matakuliah_id', $matkulId)
                ->whereNotNull('tanggal_realisasi');
        })->pluck('id');

        // Query pesan untuk materi‐materi tersebut
        $semester       = RpsMatakuliah::find($matkulId)
            ->mappingMatakuliah
            ->semester;
        $mahasiswaIds   = User::role('mahasiswa')
            ->whereHas('mahasiswa', fn($q) => $q->where('semester', $semester))
            ->pluck('id');

        // Ambil jumlah mahasiswa total
        $totalMahasiswa = $mahasiswaIds->count();

        $materiAktifIds = Materi::whereHas('rpsDetail', function ($q) use ($matkulId) {
            $q->where('rps_matakuliah_id', $matkulId)
                ->whereNotNull('tanggal_realisasi');
        })->pluck('id');

        // Ambil daftar mahasiswa yang relevan
        $mahasiswaIds = User::role('mahasiswa')
            ->whereHas('mahasiswa', fn($q) => $q->where('semester', $semester))
            ->pluck('id');

        $sumPct = 0;
        $totalMateri = $materiAktifIds->count();

        if ($totalMateri > 0 && $totalMahasiswa > 0) {
            foreach ($materiAktifIds as $mid) {
                // hitung partisipasi untuk materi $mid
                $participants = DiscussionMessage::where('materi_id', $mid)
                    ->whereIn('sender_id', $mahasiswaIds)
                    ->distinct('sender_id')
                    ->count('sender_id');
                // persentase mahasiswa yang aktif di materi ini
                $pct = $participants / $totalMahasiswa * 100;
                $sumPct += $pct;
            }
            // rata‐rata persentase per materi
            $avgForumByMateri = round($sumPct / $totalMateri, 2) . '%';
        } else {
            $avgForumByMateri = '0%';
        }

        // 1) ΣXi dan N
        $sumSkorMateri        = $materiQuery->sum('skala_pemahaman');
        $countMateriResponses = $materiQuery->count();

        // 2) rata-rata (Xˉ)
        $avgSkorMateri = $countMateriResponses
            ? $sumSkorMateri / $countMateriResponses
            : 0;

        // 3) skor maksimal (N × 4)
        $maxSkorMateri = $countMateriResponses * 4;

        if ($maxSkorMateri > 0) {
            $skalaLikert = ($sumSkorMateri / $maxSkorMateri) * 100;
        } else {
            $skalaLikert = 0;
        }

        $Wm = 0.4;
        $Wt = 0.4;
        $Wf = 0.2;

        // Ambil semua ID mahasiswa dan hitung total materi & kuis per matakuliah
        $mahasiswaIds = User::role('mahasiswa')
            ->whereHas('mahasiswa', fn($q) => $q->where('semester', $semester))
            ->pluck('id');
        $totalMateri = Materi::whereHas('rpsDetail', fn($q) => $q->where('rps_matakuliah_id', $matkulId)
            ->whereNotNull('tanggal_realisasi'))
            ->count();
        $totalKuis   = Kuis::whereHas('rpsDetail', fn($q) => $q->where('rps_matakuliah_id', $matkulId))
            ->count();

        $completionByStudent = [];
        foreach ($mahasiswaIds as $mhsId) {
            //
            // 1) M = 1 jika mahasiswa selesaikan semua materi tepat waktu
            //
            $materiOnTime = MateriMahasiswa::where('user_id', $mhsId)
                ->whereHas('materi.rpsDetail', fn($q) => $q->where('rps_matakuliah_id', $matkulId))
                ->get()
                ->filter(function ($mm) {
                    $next = $mm->materi->rpsDetail->nextRpsDetail();
                    $deadline = $next
                        ? Carbon::parse($next->tanggal_pertemuan)
                        : Carbon::parse($mm->materi->rpsDetail->tanggal_pertemuan)->addDays(7);
                    return $mm->created_at->lte($deadline);
                })
                ->count();
            $M = ($totalMateri > 0 && $materiOnTime == $totalMateri) ? 1 : 0;

            //
            // 2) T = % kuis on‑time
            //
            $kuisOnTime = KuisMahasiswa::where('user_id', $mhsId)
                ->whereHas('kuis.rpsDetail', fn($q) => $q->where('rps_matakuliah_id', $matkulId))
                ->get()
                ->filter(function ($km) {
                    $next = $km->kuis->rpsDetail->nextRpsDetail();
                    $deadline = $next
                        ? Carbon::parse($next->tanggal_pertemuan)
                        : Carbon::parse($km->kuis->rpsDetail->tanggal_pertemuan)->addDays(7);
                    return $km->created_at->lte($deadline);
                })
                ->count();
            $T = $totalKuis > 0 ? ($kuisOnTime / $totalKuis) : 0;

            //
            // 3) F = 1 jika mahasiswa pernah aktif diskusi
            //
            $hasForum = DiscussionMessage::where('sender_id', $mhsId)
                ->whereHas('materi.rpsDetail', fn($q) => $q->where('rps_matakuliah_id', $matkulId))
                ->exists();
            $F = $hasForum ? 1 : 0;

            //
            // 4) CP = Wm*M + Wt*T + Wf*F (kali 100 untuk persen)
            //
            $CP = ($Wm * $M + $Wt * $T + $Wf * $F) * 100;
            $completionByStudent[$mhsId] = round($CP, 2);
        }

        // (Opsional) rata‑rata CP seluruh mahasiswa
        $avgCP = !empty($completionByStudent)
            ? round(array_sum($completionByStudent) / count($completionByStudent), 2)
            : 0;


        $mappingId = RpsMatakuliah::find($matkulId)->mappingMatakuliah->id;
        Log::info('Laporan Metode', [
            'mapping_id' => $mappingId,
            'avg_materi' => $avgScaleMateriPercent,
            'avg_kuis'   => $avgNilaiKuis,
            'on_time'    => $combinedOnTimePct,
            'forum'      => $avgForumByMateri,
            'skala_likert' => $skalaLikert,
            'avg_cp'     => $avgCP,
        ]);
        // Kirim ke view
        return $datatable->render('admin.laporan-metode.detail', [
            'avgMateri' => $avgScaleMateriPercent,
            'avgKuis'          => $avgNilaiKuis,
            'avgOnTime'     => $combinedOnTimePct,
            'forumParticipation' => $avgForumByMateri,
            'skalaLikert' => number_format($skalaLikert, 2),
            'avgCP' => $avgCP,
            'mappingId' => $mappingId,
        ]);
    }

    public function exportExcel($mappingId)
    {
        return Excel::download(
            new DetailLaporanExport($mappingId),
            'DetailLaporan_' . now()->format('Ymd_His') . '.xlsx'
        );
    }
}
