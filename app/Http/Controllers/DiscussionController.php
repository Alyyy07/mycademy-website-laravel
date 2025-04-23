<?php

namespace App\Http\Controllers;

use App\DataTables\ForumDiskusiDataTable;
use App\Models\Akademik\TahunAjaran;
use App\Models\DiscussionMessage;
use App\Models\Materi;
use App\Models\RpsMatakuliah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DiscussionController extends Controller
{
    public function index(ForumDiskusiDataTable $dataTable)
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
        return $dataTable->render('admin.forum-diskusi.index', compact('tahunAjaran'));
    }

    public function detail()
    {
        $rpsMatakuliah = RpsMatakuliah::with('rpsDetails.materi')->findOrFail(request('id'));
        if (!$rpsMatakuliah) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        if (($rpsMatakuliah->mappingMatakuliah->dosen_id != Auth::user()->id && $rpsMatakuliah->mappingMatakuliah->admin_verifier_id != Auth::user()->id) && Auth::user()->roles->first()->name != 'super-admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini');
        }
        return view('admin.forum-diskusi.detail', compact('rpsMatakuliah'));
    }

    public function forum()
    {
        $materi = Materi::findOrFail(request('id'));
        $rpsMatakuliahId = request('rps_id');
        if (!$materi) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        $discussionMessages = $materi->discussions()->with('sender')->get();
        return view('admin.forum-diskusi.show', compact('materi', 'discussionMessages', 'rpsMatakuliahId'));
    }

    public function messages(string $id)
    {
        $messages = DiscussionMessage::with(['sender.roles'])
            ->where('materi_id', $id)
            ->where('created_at', '>', now()->subSeconds(10)) // ambil 10 detik terakhir, bisa disesuaikan
            ->latest()
            ->get();

        $formatted = $messages->map(function ($msg) {
            return [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'name' => $msg->sender->name,
                'photo' => $msg->sender->profile_photo ?? 'image/profile-photo/blank.png',
                'role' => $msg->sender->roles->first()->name ?? '-',
                'content' => $msg->message,
                'created_at' => $msg->created_at->diffForHumans(),
            ];
        });

        return response()->json($formatted);
    }

    public function sendMessage(Request $request, string $id)
    {
        $request->validate(['message' => 'required|string']);
        $materi = Materi::findOrFail($id);

        $msg = $materi->discussions()->create([
            'sender_id' => Auth::user()->id,
            'message' => $request->message,
        ]);
        if ($msg) {
            $photo = Auth::user()->profile_photo ?? 'image/profile-photo/blank.png';
            return response()->json(['success' => true,'id'=> $msg->id, 'content' => $request->message, 'message' => 'Pesan berhasil dikirim!', 'photo' => $photo, 'role' => Auth::user()->roles->first()->name], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pesan gagal dikirim!',
            ], 500);
        }
    }
}
