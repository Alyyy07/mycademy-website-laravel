<?php

namespace App\Http\Controllers;

use App\DataTables\RpsDetailDataTable;
use App\DataTables\RpsMatakuliahDataTable;
use App\Http\Requests\RpsDetailRequest;
use App\Http\Requests\RpsMatakuliahRequest;
use App\Models\Akademik\Matakuliah;
use App\Models\Akademik\TahunAjaran;
use App\Models\MappingMatakuliah;
use App\Models\RpsDetail;
use App\Models\RpsMatakuliah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;

class RpsMatakuliahController extends Controller
{
    protected $modules = ['rps_matakuliah'];
    /**
     * Display a listing of the resource.
     */
    public function index(RpsMatakuliahDataTable $dataTable)
    {
        if (request()->ajax() && request()->has('filter') && request('filter') != '') {
            $search = request('filter');
            $data = RpsMatakuliah::with(['mappingMatakuliah.matakuliah', 'mappingMatakuliah.tahunAjaran'])
                ->whereHas('mappingMatakuliah', function ($query) use ($search) {
                    $query->where('tahun_ajaran_id', $search);
                })
                ->get();
            return DataTables::of($data)
                ->addColumn('action', function ($rps) {
                    $showRoute = route('rps-detail.index', ['id' => $rps->id]);
                    return view('admin.rps-matakuliah.partials.action', compact('rps', 'showRoute'));
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
        return $dataTable->render('admin.rps-matakuliah.index', compact('tahunAjaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rpsMatakuliah = new RpsMatakuliah();
        $userId = Auth::user()->id;
        $mappingMatakuliah = collect(MappingMatakuliah::with('matakuliah')->where('admin_verifier_id', $userId)->whereDoesntHave('rpsMatakuliahs')->get());
        $action = 'create';
        $route = route('rps-matakuliah.store');
        return view('admin.rps-matakuliah.partials.form-modal', compact('route', 'mappingMatakuliah', 'rpsMatakuliah', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RpsMatakuliahRequest $request)
    {
        $request->validated();
        $result = RpsMatakuliah::create($request->all());
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        }
        return response()->json(['status' => 'error', 'message' => 'Data gagal disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RpsMatakuliah $rpsMatakuliah)
    {
        $userId = Auth::user()->id;

        $mappingMatakuliah = MappingMatakuliah::with('matakuliah')
            ->where('admin_verifier_id', $userId)
            ->where(function ($query) use ($rpsMatakuliah) {
                $query->whereDoesntHave('rpsMatakuliahs')
                    ->orWhere('id', $rpsMatakuliah->mapping_matakuliah_id);
            })
            ->get();

        $action = 'edit';
        $route = route('rps-matakuliah.update', $rpsMatakuliah->id);
        return view('admin.rps-matakuliah.partials.form-modal', compact('route', 'mappingMatakuliah', 'rpsMatakuliah', 'action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RpsMatakuliahRequest $request, RpsMatakuliah $rpsMatakuliah)
    {
        $request->validated();
        if($rpsMatakuliah->rpsDetails()->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak dapat diubah karena sudah memiliki detail']);
        }
        $result = $rpsMatakuliah->update($request->all());
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil diubah']);
        }
        return response()->json(['status' => 'error', 'message' => 'Data gagal diubah']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RpsMatakuliah $rpsMatakuliah)
    {
        $result = $rpsMatakuliah->delete();
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        }
        return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus']);
    }
}
