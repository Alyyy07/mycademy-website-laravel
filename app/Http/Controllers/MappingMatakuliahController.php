<?php

namespace App\Http\Controllers;

use App\DataTables\MappingMatakuliahDataTable;
use App\Http\Requests\MappingMatakuliahRequest;
use App\Models\Akademik\Matakuliah;
use App\Models\Akademik\Prodi;
use App\Models\Akademik\TahunAjaran;
use App\Models\MappingMatakuliah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;

class MappingMatakuliahController extends Controller
{
    protected $modules = ['mapping_matakuliah'];
    /**
     * Display a listing of the resource.
     */
    public function index(MappingMatakuliahDataTable $dataTable)
    {
        if (request()->ajax() && request()->has('filter') && request('filter') != '') {
            $search = request('filter');
            $data = MappingMatakuliah::with(['tahunAjaran', 'matakuliah', 'dosen', 'adminVerifier'])->where('tahun_ajaran_id', $search)->get();
            return DataTables::of($data)
                ->addColumn('action', function ($mappingMatakuliah) {
                    $editRoute = route('mapping-matakuliah.edit', $mappingMatakuliah->id);
                    $deleteRoute = route('mapping-matakuliah.destroy', $mappingMatakuliah->id);
                    return view('admin.mapping-matakuliah.partials.action', compact('editRoute', 'mappingMatakuliah', 'deleteRoute'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $tahunAjaran = Cache::rememberForever('tahun_ajaran', function () {
            return TahunAjaran::all();
        });
        return $dataTable->render('admin.mapping-matakuliah.index', compact('tahunAjaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mappingMatakuliah = new MappingMatakuliah();
        $matakuliah = Cache::rememberForever('matakuliah', function () {
            return Matakuliah::all();
        });
        $dosen = User::role('dosen')->get();
        $adminVerifier = User::role('admin-matakuliah')->get();
        $action = 'create';
        $route = route('mapping-matakuliah.store');
        return view('admin.mapping-matakuliah.partials.form-modal', compact('route', 'mappingMatakuliah', 'dosen', 'adminVerifier', 'matakuliah', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MappingMatakuliahRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $data['tahun_ajaran_id'] = TahunAjaran::getActive()['id'];
        $result = MappingMatakuliah::create($data);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        }
        return response()->json(['status' => 'error', 'message' => 'Data gagal disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(MappingMatakuliah $mappingMatakuliah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MappingMatakuliah $mappingMatakuliah)
    {
        $matakuliah = Matakuliah::all();
        $dosen = User::role('dosen')->get();
        $adminVerifier = User::role('admin-matakuliah')->get();
        $action = 'edit';
        $route = route('mapping-matakuliah.update', $mappingMatakuliah->id);
        return view('admin.mapping-matakuliah.partials.form-modal', compact('route', 'mappingMatakuliah', 'dosen', 'adminVerifier', 'matakuliah', 'action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MappingMatakuliahRequest $request, MappingMatakuliah $mappingMatakuliah)
    {
        $request->validated();
        $result = $mappingMatakuliah->update($request->all());
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil diubah']);
        }
        return response()->json(['status' => 'error', 'message' => 'Data gagal diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MappingMatakuliah $mappingMatakuliah)
    {
        $result = $mappingMatakuliah->delete();
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        }
        return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus']);
    }
}
