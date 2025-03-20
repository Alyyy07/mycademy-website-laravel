<?php

namespace App\Http\Controllers;

use App\DataTables\ProdiDataTable;
use App\Http\Requests\ProdiRequest;
use App\Models\Akademik\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;

class ProdiController extends Controller
{
    protected $modules = ['akademik', 'akademik.prodi'];
    /**
     * Display a listing of the resource.
     */
    public function index(ProdiDataTable $dataTable)
    {
        if (request()->ajax() && request()->has('filter') && request()->filter != '') {
            $search = request()->filter;
            $data = Prodi::with('fakultas')->where('fakultas_id',$search)->get();
            return DataTables::of($data)
                ->addColumn('action', function ($prodi) {
                    $editRoute = route('akademik.prodi.edit', $prodi->id);
                    $deleteRoute = route('akademik.prodi.destroy', $prodi->id);
                    return view('admin.prodi.partials.action', compact('editRoute', 'prodi', 'deleteRoute'));
                })
                ->editColumn('kode_prodi', function (Prodi $prodi) {
                    return "<span class='badge badge-light-primary fs-7 py-3 px-4 text-capitalize'>$prodi->kode_prodi</span>";
                })
                ->rawColumns(['action', 'kode_prodi'])
                ->make(true);
        }

        $fakultas = Cache::rememberForever('fakultas', function () {
            return \App\Models\Akademik\Fakultas::all();
        });

        return $dataTable->render('admin.prodi.index', compact('fakultas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fakultas = Cache::rememberForever('fakultas', function () {
            return \App\Models\Akademik\Fakultas::all();
        });
        $prodi = new Prodi();
        $action = 'create';
        $route = route('akademik.prodi.store');
        return view('admin.prodi.partials.form-modal', compact('route', 'fakultas', 'prodi', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdiRequest $request)
    {
        $request->validated();
        $prodi = Prodi::create($request->all());
        if ($prodi) {
            return response()->json(['message' => 'Prodi berhasil dibuat!'], 200);
        }
        return response()->json(['message' => 'Prodi gagal dibuat!'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Prodi $prodi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodi $prodi)
    {
        $action = 'edit';
        $fakultas = Cache::rememberForever('fakultas', function () {
            return \App\Models\Akademik\Fakultas::all();
        });
        $route = route('akademik.prodi.update', $prodi->id);
        return view('admin.prodi.partials.form-modal', compact('prodi', 'fakultas', 'route', 'action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdiRequest $request, Prodi $prodi)
    {
        $request->validated();
        $result = $prodi->update($request->all());
        if (!$result) {
            return response()->json(['message' => 'Prodi gagal diupdate!'], 500);
        }
        return response()->json(['message' => 'Prodi berhasil diupdate!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prodi $prodi)
    {
        $result = $prodi->delete();
        if (!$result) {
            return response()->json(['message' => 'Prodi gagal dihapus!'], 500);
        }
        return response()->json(['message' => 'Prodi berhasil dihapus!'], 200);
    }
}
