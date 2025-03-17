<?php

namespace App\Http\Controllers;

use App\DataTables\MatakuliahDataTable;
use App\Http\Requests\MatakuliahRequest;
use App\Models\Akademik\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MatakuliahController extends Controller
{
    protected $modules = ['akademik', 'akademik.matakuliah'];
    /**
     * Display a listing of the resource.
     */
    public function index(MatakuliahDataTable $dataTable)
    {
        return $dataTable->render('admin.matakuliah.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $matakuliah = new Matakuliah();
        $prodi = Cache::rememberForever('prodi', function () {
            return \App\Models\Akademik\Prodi::all();
        });
        $action = 'create';
        $route = route('akademik.matakuliah.store');
        return view('admin.matakuliah.partials.form-modal', compact('route', 'prodi', 'matakuliah', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MatakuliahRequest $request)
    {
        $request->validated();
        $matakuliah = Matakuliah::create($request->all());
        if ($matakuliah) {
            return response()->json(['message' => 'Matakuliah berhasil dibuat!'], 200);
        }
        return response()->json(['message' => 'Matakuliah gagal dibuat!'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Matakuliah $matakuliah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matakuliah $matakuliah)
    {
        $action = 'edit';
        $prodi = Cache::rememberForever('prodi', function () {
            return \App\Models\Akademik\Prodi::all();
        });
        $route = route('akademik.matakuliah.update', $matakuliah->id);
        return view('admin.matakuliah.partials.form-modal', compact('matakuliah', 'prodi', 'route', 'action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MatakuliahRequest $request, Matakuliah $matakuliah)
    {
        $request->validated();
        $result = $matakuliah->update($request->all());
        if (!$result) {
            return response()->json(['message' => 'Matakuliah gagal diupdate!'], 500);
        }
        return response()->json(['message' => 'Matakuliah berhasil diupdate!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matakuliah $matakuliah)
    {
        $result = $matakuliah->delete();
        if (!$result) {
            return response()->json(['message' => 'Matakuliah gagal dihapus!'], 500);
        }
        return response()->json(['message' => 'Matakuliah berhasil dihapus!'], 200);
    }
}
