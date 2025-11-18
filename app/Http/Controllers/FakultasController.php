<?php

namespace App\Http\Controllers;

use App\DataTables\FakultasDataTable;
use App\Http\Requests\FakultasRequest;
use App\Models\Akademik\Fakultas;

class FakultasController extends Controller
{
    protected $modules = ['akademik', 'akademik.fakultas'];
    /**
     * Display a listing of the resource.
     */
    public function index(FakultasDataTable $dataTable)
    {
        return $dataTable->render('admin.fakultas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fakultas = new Fakultas();
        $action = 'create';
        $route = route('akademik.fakultas.store');
        return view('admin.fakultas.partials.form-modal', compact('route', 'fakultas', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FakultasRequest $request)
    {
        $request->validated();
        $data = $request->all();
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = hash('sha256', time() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $data['logo'] = $file->storeAs('image/fakultas-logo', $filename, 'public');
        }
        $fakultas = Fakultas::create($data);
        if ($fakultas) {
            return response()->json(['status' => 'success','message' => 'Fakultas berhasil dibuat!'], 200);
        }
        return response()->json(['status' => 'error','message' => 'Fakultas gagal dibuat!'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fakultas $fakulta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fakultas $fakulta)
    {
        $action = 'edit';
        $route = route('akademik.fakultas.update', $fakulta->id);
        $fakultas = $fakulta;
        return view('admin.fakultas.partials.form-modal', compact('fakultas', 'route', 'action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FakultasRequest $request, Fakultas $fakulta)
    {
        $data = $request->all();
        if ($request->hasFile('logo')) {
            $oldPhoto = $fakulta->logo;
            if ($oldPhoto) {
                unlink(storage_path('app/public/' . $oldPhoto));
            }
            $file = $request->file('logo');
            $filename = hash('sha256', time() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $data['logo'] = $file->storeAs('image/fakultas-logo', $filename, 'public');
        }
        $result = $fakulta->update($data);
        if (!$result) {
            return response()->json(['status' => 'error','message' => 'Fakultas gagal diupdate!'], 500);
        }
        return response()->json(['status' => 'success','message' => 'Fakultas berhasil diupdate!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fakultas $fakulta)
    {
        $photoPath = $fakulta->logo;
        if ($photoPath) {
            unlink(storage_path("app/public/$photoPath"));
        }
        $result = $fakulta->delete();
        if($result){
            return response()->json(['status' => 'success','message' => 'Fakultas berhasil dihapus!'], 200);
        }
        return response()->json(['status' => 'error','message' => 'Fakultas gagal dihapus!'], 500);
    }
}
