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
                ->editColumn('fakultas.nama_fakultas', function (Prodi $prodi) {
                $photo_path = $prodi->fakultas->logo ?? 'image/profile-photo/blank.png';
                return "<div class='d-flex align-items-center text-start'>
                <div class='symbol symbol-circle symbol-50px overflow-hidden me-3'>
                            <div class='symbol-label'>
                                <img src='" . asset("storage/$photo_path") . "' alt='" . $prodi->fakultas->nama_fakultas . "' class='w-100' />
                            </div>
                        </div>
                        <div class='d-flex flex-column'>
                            <p class='text-gray-800 mb-1 fw-bold text-capitalize'>" . $prodi->fakultas->nama_fakultas . "</p>
                            <span>" . $prodi->fakultas->email . "</span>
                        </div>
                        </div>";
            })
                ->editColumn('kode_prodi', function (Prodi $prodi) {
                    return "<span class='badge badge-light-primary fs-7 py-3 px-4 text-capitalize'>$prodi->kode_prodi</span>";
                })
                ->rawColumns(['action', 'kode_prodi','fakultas.nama_fakultas'])
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
            return response()->json(['status' => 'success','message' => 'Prodi berhasil dibuat!'], 200);
        }
        return response()->json(['status' => 'error','message' => 'Prodi gagal dibuat!'], 500);
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
        $result = $prodi->update($request->all());
        if (!$result) {
            return response()->json(['status' => 'error','message' => 'Prodi gagal diupdate!'], 500);
        }
        return response()->json(['status' => 'success','message' => 'Prodi berhasil diupdate!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prodi $prodi)
    {
        $result = $prodi->delete();
        if (!$result) {
            return response()->json(['status' => 'error','message' => 'Prodi gagal dihapus!'], 500);
        }
        return response()->json(['status' => 'success','message' => 'Prodi berhasil dihapus!'], 200);
    }
}
