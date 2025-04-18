<?php

namespace App\Http\Controllers;

use App\DataTables\DataMahasiswaDataTable;
use App\Http\Requests\DataMahasiswaRequest;
use App\Models\Akademik\DataMahasiswa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataMahasiswaController extends Controller
{
    protected $modules = ['akademik', 'akademik.data_mahasiswa'];
    /**
     * Display a listing of the resource.
     */
    public function index(DataMahasiswaDataTable $dataTable)
    {
        if(request()->ajax() && request()->has('filter') && request('filter') != '') {
            $search = request('filter');
            $data = DataMahasiswa::with(['prodi','user'])->where('prodi_id', $search)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($mahasiswa) {
                    $editRoute = route('akademik.data-mahasiswa.edit', $mahasiswa->id);
                    $deleteRoute = route('akademik.data-mahasiswa.destroy', $mahasiswa->id);
                    return view('admin.data-mahasiswa.partials.action', compact('editRoute', 'mahasiswa', 'deleteRoute'));
                })
                ->editColumn('nama', function (DataMahasiswa $mahasiswa) {
                    $photo_path = $mahasiswa->user->profile_photo ?? 'image/profile-photo/blank.png';
                    return "<div class='symbol symbol-circle symbol-50px overflow-hidden me-3'>
                            <div class='symbol-label'>
                                <img src='" . asset("storage/$photo_path") . "' alt='" . $mahasiswa->user->name . "' class='w-100' />
                            </div>
                        </div>
                        <div class='d-flex flex-column'>
                            <p class='text-gray-800 mb-1 fw-bold text-capitalize'>" . $mahasiswa->user->name . "</p>
                            <span>" . $mahasiswa->user->email . "</span>
                        </div>";
                })
                ->editColumn('tanggal_lahir', function (DataMahasiswa $mahasiswa) {
                    return \Carbon\Carbon::parse($mahasiswa->tanggal_lahir)->locale('id')->translatedFormat('d F Y');
                })
                ->rawColumns(['action','nama', 'tanggal_lahir'])
                ->make(true);
        }

        $prodi = \App\Models\Akademik\Prodi::all();
        return $dataTable->render('admin.data-mahasiswa.index', compact('prodi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataMahasiswa $dataMahasiswa)
    {
        $action = 'edit';
        $route = route('akademik.data-mahasiswa.update', $dataMahasiswa->id);
        $prodi = \App\Models\Akademik\Prodi::all();
        $mahasiswa = $dataMahasiswa;
        return view('admin.data-mahasiswa.partials.form-modal', compact('route', 'mahasiswa', 'action', 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DataMahasiswaRequest $request, DataMahasiswa $dataMahasiswa)
    {
        $result = $dataMahasiswa->update($request->all());
        if ($result) {
            return response()->json(['status' => 'success','message' => 'Data Mahasiswa berhasil diperbarui!'], 200);
        }
        return response()->json(['status' => 'error','message' => 'Data Mahasiswa gagal diperbarui!'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
