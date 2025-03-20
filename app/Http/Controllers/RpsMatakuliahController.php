<?php

namespace App\Http\Controllers;

use App\DataTables\RpsMatakuliahDataTable;
use App\Http\Requests\RpsMatakuliahRequest;
use App\Models\Akademik\Matakuliah;
use App\Models\MappingMatakuliah;
use App\Models\RpsMatakuliah;
use Illuminate\Http\Request;
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
                    $query->where('matakuliah_id', $search);
                })
                ->get();
            return DataTables::of($data)
                ->addColumn('action', function ($rps) {
                    $showRoute = route('rps-matakuliah.show', $rps->id);
                    return view('admin.rps-matakuliah.partials.action', compact('rps', 'showRoute'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $matakuliah = Cache::rememberForever('matakuliah', function () {
            return Matakuliah::all();
        });
        return $dataTable->render('admin.rps-matakuliah.index', compact('matakuliah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rps = new RpsMatakuliah();
        $mappingMatakuliah = collect(MappingMatakuliah::with('matakuliah')->get());
        $action = 'create';
        $route = route('rps-matakuliah.store');
        return view('admin.rps-matakuliah.partials.form-modal', compact('route', 'mappingMatakuliah', 'rps', 'action'));
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
    public function show(RpsMatakuliah $rpsMatakuliah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RpsMatakuliah $rpsMatakuliah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RpsMatakuliah $rpsMatakuliah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RpsMatakuliah $rpsMatakuliah)
    {
        //
    }
}
