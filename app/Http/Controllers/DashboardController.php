<?php

namespace App\Http\Controllers;

use App\Models\Akademik\DataMahasiswa;
use App\Models\Akademik\Fakultas;
use App\Models\Akademik\Prodi;
use App\Models\MappingMatakuliah;
use App\Models\RpsMatakuliah;
use App\Models\Materi;
use App\Models\Kuis;
use App\Models\RpsDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $modules = ['dashboard'];

    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->roles->first()->name;
        if ($role == 'super-admin') {
            $fakultas  = Fakultas::count();
            $prodi      = Prodi::count();
            $mahasiswa  = User::whereHas('roles', fn($q) => $q->where('name', 'mahasiswa'))->count();
            $dosen      = User::whereHas('roles', fn($q) => $q->where('name', 'dosen'))->count();

            return view('admin.admin-index', compact('fakultas', 'prodi', 'mahasiswa', 'dosen'));
        }
        $maps = MappingMatakuliah::with('matakuliah')
            ->where('dosen_id', $user->id)
            ->orWhere('admin_verifier_id', $user->id)
            ->get();
        $matakuliah = [];
        $mahasiswa  = [];
        $materi     = [];
        $kuis       = [];

        foreach ($maps as $map) {
            $matakuliah[] = $map->matakuliah->nama_matakuliah;
            $totalMhs = DataMahasiswa::where('semester', $map->semester)
                ->where('prodi_id', $map->matakuliah->prodi_id)
                ->count();
            $mahasiswa[] = $totalMhs;
            $rps = RpsMatakuliah::where('mapping_matakuliah_id', $map->id)->first();

            if ($rps) {
                $totalMateri = Materi::whereHas(
                    'rpsDetail',
                    fn($q) =>
                    $q->where('rps_matakuliah_id', $rps->id)
                )->count();
                $materi[] = $totalMateri;
                $totalKuis = Kuis::whereHas(
                    'rpsDetail',
                    fn($q) =>
                    $q->where('rps_matakuliah_id', $rps->id)
                )->count();
                $kuis[] = $totalKuis;
            } else {
                $materi[] = 0;
                $kuis[]   = 0;
            }
        }
        $matakuliah = count($matakuliah);
        $mahasiswa = array_sum($mahasiswa);
        $materi = array_sum($materi);
        $kuis = array_sum($kuis);
        if ($role == 'admin-matakuliah') {
            $pendingList = RpsDetail::with([
                'rpsMatakuliah.mappingMatakuliah.matakuliah',
                'rpsMatakuliah.mappingMatakuliah.dosen'
            ])
                ->where('status_pengganti', 'pending')->whereNotNull('tanggal_pengganti')
                ->whereHas('rpsMatakuliah', function ($q) {
                    $q->whereHas('mappingMatakuliah', function ($q2) {
                        $q2->where('admin_verifier_id', Auth::id());
                    });
                })
                ->orderBy('tanggal_pengganti', 'asc')
                ->get();
            return view('admin.index', compact(
                'matakuliah',
                'mahasiswa',
                'materi',
                'kuis',
                'pendingList'
            ));
        }
        return view('admin.index', compact(
            'matakuliah',
            'mahasiswa',
            'materi',
            'kuis'
        ));
    }
}
