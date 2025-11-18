<?php

namespace App\Http\Controllers;

use App\DataTables\MatakuliahDataTable;
use App\Http\Requests\MatakuliahRequest;
use App\Models\Akademik\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;

class MatakuliahController extends Controller
{
    protected $modules = ['akademik', 'akademik.matakuliah'];
    /**
     * Display a listing of the resource.
     */
    public function index(MatakuliahDataTable $dataTable)
    {
        if (request()->ajax() && request()->has('filter') && request('filter') != '') {
            $search = request('filter');
            $data = Matakuliah::with('prodi')->where('prodi_id',$search)->get();
            return DataTables::of($data)
                ->addColumn('action', function ($matakuliah) {
                    $editRoute = route('akademik.matakuliah.edit', $matakuliah->id);
                    $deleteRoute = route('akademik.matakuliah.destroy', $matakuliah->id);
                    return view('admin.matakuliah.partials.action', compact('editRoute', 'matakuliah', 'deleteRoute'));
                })
                ->editColumn('kode_prodi', function (Matakuliah $matakuliah) {
                    return "<span class='badge badge-light-primary fs-7 py-3 px-4 text-capitalize'>$matakuliah->kode_prodi</span>";
                })
                ->rawColumns(['action', 'kode_prodi'])
                ->make(true);
        }

        $prodi = \App\Models\Akademik\Prodi::all();
        return $dataTable->render('admin.matakuliah.index',compact('prodi'));
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
            return response()->json(['status' => 'success','message' => 'Matakuliah berhasil dibuat!'], 200);
        }
        return response()->json(['status' => 'success','message' => 'Matakuliah gagal dibuat!'], 500);
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
            return response()->json(['status' => 'error','message' => 'Matakuliah gagal diupdate!'], 500);
        }
        return response()->json(['status' => 'success','message' => 'Matakuliah berhasil diupdate!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matakuliah $matakuliah)
    {
        $result = $matakuliah->delete();
        if (!$result) {
            return response()->json(['status' => 'error','message' => 'Matakuliah gagal dihapus!'], 500);
        }
        return response()->json(['status' => 'success','message' => 'Matakuliah berhasil dihapus!'], 200);
    }
}
