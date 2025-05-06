<?php

namespace App\Http\Controllers;

use App\DataTables\ModulPembelajaranDataTable;
use App\DataTables\RpsMatakuliahDataTable;
use App\Http\Requests\KuisRequest;
use App\Http\Requests\MateriRequest;
use App\Models\Akademik\TahunAjaran;
use App\Models\Kuis;
use App\Models\KuisOption;
use App\Models\Materi;
use App\Models\RpsDetail;
use App\Models\RpsMatakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

use function Pest\Laravel\json;

class ModulPembelajaranController extends Controller
{
    protected $modules = ['modul_pembelajaran'];
    /**
     * Display a listing of the resource.
     */
    public function index(ModulPembelajaranDataTable $dataTable)
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
                    $showRoute = route('rps-detail.index', ['id' => $rps->id]);
                    return view('admin.modul-pembelajaran.partials.action', compact('rps', 'showRoute'));
                })
                ->editColumn('tanggal_mulai', function ($rps) {
                    return \Carbon\Carbon::parse($rps->tanggal_mulai)->locale('id')->translatedFormat('d F Y');
                })
                ->editColumn('tanggal_selesai', function ($rps) {
                    return \Carbon\Carbon::parse($rps->tanggal_selesai)->locale('id')->translatedFormat('d F Y');
                })
                ->rawColumns(['action', 'tanggal_mulai', 'tanggal_selesai'])
                ->make(true);
        }
        $tahunAjaran = Cache::rememberForever('tahun_ajaran', function () {
            return TahunAjaran::all();
        });
        return $dataTable->render('admin.modul-pembelajaran.index', compact('tahunAjaran'));
    }


    public function detail()
    {
        $rpsMatakuliah = RpsMatakuliah::with('rpsDetails.materi')->findOrFail(request('id'));
        if (!$rpsMatakuliah) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        if (($rpsMatakuliah->mappingMatakuliah->admin_verifier_id != Auth::user()->id && $rpsMatakuliah->mappingMatakuliah->dosen_id != Auth::user()->id) && Auth::user()->roles->first()->name != 'super-admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini');
        }
        return view('admin.modul-pembelajaran.detail', compact('rpsMatakuliah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createMateri()
    {
        $route = route('modul-pembelajaran.materi.create-detail');
        $rpsDetailId = request('id');
        return view('admin.modul-pembelajaran.partials.materi-modal', compact('route', 'rpsDetailId'));
    }

    public function createDetailMateri()
    {
        $rpsDetailId = request('rps_detail_id');
        $tipeMateri = request('tipe_materi');
        $materi = new Materi();
        $materi->status = 'draft';
        $action = 'create';
        $route = route('modul-pembelajaran.materi.store');

        $rpsDetail = RpsDetail::where('id', $rpsDetailId)->first();
        return view('admin.modul-pembelajaran.partials.materi-form', compact('materi', 'tipeMateri', 'route', 'action', 'rpsDetailId', 'rpsDetail'));
    }

    public function createKuis()
    {
        $rpsDetailId = request('id');
        $kuis = new Kuis();
        $kuis->status = 'draft';
        $action = 'create';
        $route = route('modul-pembelajaran.kuis.store');

        $rpsDetail = RpsDetail::where('id', $rpsDetailId)->first();
        return view('admin.modul-pembelajaran.partials.kuis-form', compact('action', 'route', 'kuis', 'rpsDetailId', 'rpsDetail'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeMateri(MateriRequest $request)
    {
        $materi = new Materi();
        $materi->rps_detail_id = $request->rps_detail_id;
        $materi->title = $request->title;
        $materi->tipe_materi = $request->tipe_materi;
        $materi->uploader_id = Auth::user()->id;
        $materi->status = 'draft';
        if ($request->tipe_materi == 'video') {
            $materi->video_path = $request->video_path;
        } elseif ($request->tipe_materi == 'pdf') {
            $fileName = $request->file_path;
            $materi->file_path = $fileName;
        } else {
            $materi->text_content = $request->text_content;
        }
        $materi->save();
        $rpsDetail = RpsDetail::findOrFail($request->rps_detail_id);
        return response()->json([
            'status' => 'success',
            'message' => 'Materi berhasil ditambahkan',
            'redirect_url' => route('modul-pembelajaran.detail', ['id' => $rpsDetail->rps_matakuliah_id]),
        ]);
    }

    public function storeKuis(KuisRequest $request)
    {
        DB::beginTransaction();
        try {
            $kuis = Kuis::create([
                'title' => $request->title,
                'description' => $request->description,
                'rps_detail_id' => $request->rps_detail_id,
                'status' => 'draft',
                'uploader_id' => Auth::user()->id,
            ]);

            foreach ($request->questions as $q) {
                $question = $kuis->questions()->create([
                    'question_text' => $q['question_text'],
                ]);

                foreach ($q['options'] as $option) {
                    $question->options()->create([
                        'option_text' => $option['option_text'],
                        'is_correct' => isset($option['is_correct']) ? 1 : 0,
                    ]);
                }
            }

            DB::commit();
            $rpsDetail = RpsDetail::findOrFail($request->rps_detail_id);
            return response()->json([
                'status' => 'success',
                'message' => 'Tugas berhasil ditambahkan',
                'redirect_url' => route('modul-pembelajaran.detail', ['id' => $rpsDetail->rps_matakuliah_id]),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan kuis',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function editMateri(string $id)
    {
        $materi = Materi::findOrFail($id);
        $action = 'edit';
        $rpsDetailId = $materi->rps_detail_id;
        $tipeMateri = $materi->tipe_materi;
        $pdfPath = $materi->file_path ? asset("storage/$materi->file_path") : null;
        $route = route('modul-pembelajaran.materi.update', ['id' => $materi->id]);

        $rpsDetail = RpsDetail::where('id', $rpsDetailId)->first();
        return view('admin.modul-pembelajaran.partials.materi-form', compact('materi', 'action', 'route', 'tipeMateri', 'rpsDetailId', 'pdfPath', 'rpsDetail'));
    }

    public function editKuis(string $id)
    {
        $kuis = Kuis::with('questions.options')->findOrFail($id);
        $action = 'edit';
        $rpsDetailId = $kuis->rps_detail_id;
        $route = route('modul-pembelajaran.kuis.update', ['id' => $kuis->id]);

        $rpsDetail = RpsDetail::where('id', $rpsDetailId)->first();
        return view('admin.modul-pembelajaran.partials.kuis-form', compact('kuis', 'action', 'route', 'rpsDetailId', 'rpsDetail'));
    }
    public function updateKuis(KuisRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $kuis = Kuis::findOrFail($id);
            $kuis->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            $kuis->questions()->delete();

            foreach ($request->questions as $q) {
                $question = $kuis->questions()->create([
                    'question_text' => $q['question_text'],
                ]);

                $options = [];
                foreach ($q['options'] as $option) {
                    $options[] = [
                        'kuis_question_id' => $question->id,
                        'option_text' => $option['option_text'],
                        'is_correct' => isset($option['is_correct']) ? 1 : 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                KuisOption::insert($options);
            }

            DB::commit();
            $rpsDetail = RpsDetail::findOrFail($kuis->rps_detail_id);
            return response()->json([
                'status' => 'success',
                'message' => 'Tugas berhasil diperbarui',
                'redirect_url' => route('modul-pembelajaran.detail', ['id' => $rpsDetail->rps_matakuliah_id]),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui kuis',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function updateMateri(MateriRequest $request)
    {
        $request->validated();
        $materi = Materi::findOrFail($request->id);
        $materi->title = $request->title;
        $materi->tipe_materi = $request->tipe_materi;
        $materi->uploader_id = Auth::user()->id;
        if ($request->tipe_materi == 'video') {
            $materi->video_path = $request->video_path;
        } elseif ($request->tipe_materi == 'pdf') {
            if ($materi->file_path && $request->file_path != $materi->file_path) {
                unlink(public_path("storage/$materi->file_path"));
            }
            $fileName = $request->file_path;
            $materi->file_path = $fileName;
        } else {
            $materi->text_content = $request->text_content;
        }
        $materi->save();
        $rpsDetail = RpsDetail::findOrFail($request->rps_detail_id);
        return response()->json([
            'status' => 'success',
            'message' => 'Materi berhasil diperbarui',
            'redirect_url' => route('modul-pembelajaran.detail', ['id' => $rpsDetail->rps_matakuliah_id]),
        ]);
    }


    public function destroyMateri(string $id)
    {
        $materi = Materi::findOrFail($id);
        if ($materi->tipe_materi === 'teks' && $materi->text_content) {
            preg_match_all('/<img[^>]+src="([^">]+)"/', $materi->text_content, $matches);
            $imageUrls = $matches[1];

            foreach ($imageUrls as $url) {
                // Jika disimpan di storage public (misalnya: /storage/materi/image.png)
                $path = str_replace(asset('storage') . '/', '', $url);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }


        if ($materi->tipe_materi === 'pdf' && $materi->file_path) {
            unlink(public_path("storage/$materi->file_path"));
        }
        $materi->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Materi berhasil dihapus',
        ]);
    }

    public function destroyKuis(string $id)
    {
        $kuis = Kuis::findOrFail($id);

        foreach ($kuis->questions as $question) {
            // Hapus gambar dari question_text
            if ($question->question_text) {
                preg_match_all('/<img[^>]+src="([^">]+)"/', $question->question_text, $matches);
                $imageUrls = $matches[1];
                foreach ($imageUrls as $url) {
                    $path = str_replace(asset('storage') . '/', '', $url);
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }

            // Hapus gambar dari setiap option
            foreach ($question->options as $option) {
                if ($option->option_text) {
                    preg_match_all('/<img[^>]+src="([^">]+)"/', $option->option_text, $matches);
                    $imageUrls = $matches[1];
                    foreach ($imageUrls as $url) {
                        $path = str_replace(asset('storage') . '/', '', $url);
                        if (Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                        }
                    }
                }
            }
        }

        // Hapus soal dan kuis
        $kuis->questions()->delete();
        $kuis->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kuis berhasil dihapus',
        ]);
    }

    public function updateStatusMateri(Request $request)
    {
        $materi = Materi::findOrFail($request->materi_id);
        $action = $request->action;

        $materi->status = match ($action) {
            'publish' => 'uploaded',
            'verify' => 'verified',
            'reject' => 'rejected',
            default => 'draft',
        };
        $materi->verifier_id = Auth::user()->id;
        $materi->save();

        return response()->json(['message' => 'Status materi berhasil diperbarui.']);
    }

    public function resetStatusMateri(Request $request)
    {
        $materi = Materi::findOrFail($request->materi_id);
        $materi->status = 'uploaded';
        $materi->verifier_id = null;
        $materi->save();

        return response()->json(['message' => 'Status materi berhasil direset.']);
    }

    public function updateStatusKuis(Request $request)
    {
        $kuis = Kuis::findOrFail($request->kuis_id);
        $action = $request->action;

        switch ($action) {
            case 'publish':
                $kuis->status = 'uploaded';
                break;
            case 'verify':
                $kuis->status = 'verified';
                break;
            case 'reject':
                $kuis->status = 'rejected';
                break;
            default:
                $kuis->status = 'draft';
                break;
        }
        $kuis->verifier_id = Auth::user()->id;
        $kuis->save();

        return response()->json(['message' => 'Status kuis berhasil diperbarui.']);
    }

    public function resetStatusKuis(Request $request)
    {
        $kuis = Kuis::findOrFail($request->kuis_id);
        $kuis->status = 'uploaded';
        $kuis->verifier_id = null;
        $kuis->save();

        return response()->json(['message' => 'Status kuis berhasil direset.']);
    }

    public function endSession(Request $request)
    {
        $rpsDetail = RpsDetail::findOrFail($request->rps_detail_id);
        $rpsDetail->tanggal_realisasi = now();
        $rpsDetail->save();

        return response()->json(['message' => 'Pertemuan berhasil diakhiri.']);
    }

    public function endForum(Request $request)
    {
        $rpsDetail = RpsDetail::findOrFail($request->rps_detail_id);
        $rpsDetail->close_forum = true;
        $rpsDetail->save();

        return response()->json(['message' => 'Forum berhasil diakhiri.', 'redirect_url' => route('forum-diskusi.detail', ['id' => $rpsDetail->rps_matakuliah_id])]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('materi/pdf', 'public');
            return response()->json(['file_path' => $path]);
        }

        return response()->json(['error' => 'Upload gagal'], 400);
    }

    public function deleteFile(Request $request)
    {
        $filePath = $request->file_path;
        if ($filePath) {
            Storage::disk('public')->delete($filePath);
            return response()->json(['message' => 'File berhasil dihapus']);
        }

        return response()->json(['error' => 'File tidak ditemukan'], 400);
    }
}
