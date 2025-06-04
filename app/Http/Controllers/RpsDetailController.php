<?php

namespace App\Http\Controllers;

use App\DataTables\RpsDetailDataTable;
use App\Http\Requests\RpsDetailRequest;
use App\Models\RpsDetail;
use App\Models\RpsMatakuliah;
use Illuminate\Http\Request;

class RpsDetailController extends Controller
{
    protected $modules = ['rps_matakuliah'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rpsMatakuliah = RpsMatakuliah::findOrFail(request('id'));
        return (new RpsDetailDataTable($rpsMatakuliah))->render('admin.rps-detail.index', compact('rpsMatakuliah'));
    }

    public function create()
    {
        $rpsDetail = new RpsDetail();
        $rpsMatakuliah = RpsMatakuliah::findOrFail(request('id'));
        $rpsDetail->rps_matakuliah_id = $rpsMatakuliah->id;
        $action = 'create';
        $route = route('rps-detail.store');
        return view('admin.rps-detail.partials.form-modal', compact('rpsDetail', 'route', 'action', 'rpsMatakuliah'));
    }

    public function edit(RpsDetail $rpsDetail)
    {
        $route = route('rps-detail.update', $rpsDetail->id);
        $action = 'edit';
        return view('admin.rps-detail.partials.form-modal', compact('rpsDetail', 'route', 'action'));
    }

    public function store(RpsDetailRequest $request)
    {
        $request->validated();
        $result = RpsDetail::create($request->all());
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        }
        return response()->json(['status' => 'error', 'message' => 'Data gagal disimpan']);
    }

    public function update(RpsDetailRequest $request, RpsDetail $rpsDetail)
    {
        $result = $rpsDetail->update($request->all());
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        }
        return response()->json(['status' => 'error', 'message' => 'Data gagal disimpan']);
    }

    public function destroy(RpsDetail $rpsDetail)
    {
        $result = $rpsDetail->delete();
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        }
        return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus']);
    }
}
