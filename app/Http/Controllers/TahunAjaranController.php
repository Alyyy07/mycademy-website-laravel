<?php

namespace App\Http\Controllers;

use App\DataTables\TahunAjaranDataTable;
use App\Http\Requests\TahunAjaranRequest;
use App\Models\Akademik\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    protected $modules = ['akademik', 'akademik.tahun_ajaran'];
    /**
     * Display a listing of the resource.
     */
    public function index(TahunAjaranDataTable $dataTable)
    {
        return $dataTable->render('admin.tahun-ajaran.index');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunAjaran = new TahunAjaran();
        $action = 'create';
        $route = route('akademik.tahun-ajaran.store');
        return view('admin.tahun-ajaran.partials.form-modal', compact( 'route', 'tahunAjaran', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TahunAjaranRequest $request)
    {
        $request->validated();
        $data = $request->except(['tahun_ajaran_awal', 'tahun_ajaran_akhir']);
        $data['tahun_ajaran'] = $request->tahun_ajaran_awal . '/' . $request->tahun_ajaran_akhir;
       
        $tahunAjaran = TahunAjaran::create($data);
        if($tahunAjaran){
            return response()->json(['status' => 'success','message' => 'Tahun Ajaran berhasil dibuat!'], 200);
        }
        return response()->json(['status' => 'error','message' => 'Tahun Ajaran gagal dibuat!'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(TahunAjaran $tahunAjaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        $action = 'edit';
        $route = route('akademik.tahun-ajaran.update', $tahunAjaran->id);
        return view('admin.tahun-ajaran.partials.form-modal', compact( 'route', 'tahunAjaran', 'action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TahunAjaranRequest $request, TahunAjaran $tahunAjaran)
    {
        $request->validated();
        $data = $request->except(['tahun_ajaran_awal', 'tahun_ajaran_akhir']);
        $data['tahun_ajaran'] = $request->tahun_ajaran_awal . '/' . $request->tahun_ajaran_akhir;
        $result = $tahunAjaran->update($data);
        
        if($result){
            return response()->json(['status' => 'success','message' => 'Tahun Ajaran berhasil diupdate!'], 200);
        }
        return response()->json(['status' => 'error','message' => 'Tahun Ajaran gagal dibuat!'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
        if($tahunAjaran->is_active){
            return response()->json(['status' => 'error','message' => 'Tahun Ajaran tidak bisa dihapus karena sedang aktif!'], 500);
        }
        $result = $tahunAjaran->delete();
        if($result){
            return response()->json(['status' => 'success','message' => 'Tahun Ajaran berhasil dihapus!'], 200);
        }
        return response()->json(['status' => 'error','message' => 'Tahun Ajaran gagal dihapus!'], 500);
    }

    public function setStatus(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->is_active = !$tahunAjaran->is_active;
        $tahunAjaran->save();
        return response()->json(['status' => 'success','message' => 'Status Tahun Ajaran berhasil diupdate!'], 200);
    }
}
