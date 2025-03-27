<?php

namespace App\Http\Controllers;

use App\DataTables\ModulPembelajaranDataTable;
use App\DataTables\RpsMatakuliahDataTable;
use App\Models\Akademik\TahunAjaran;
use App\Models\RpsMatakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;

class ModulPembelajaranController extends Controller
{
    protected $modules = ['modul_pembelajaran'];
    /**
     * Display a listing of the resource.
     */
    public function index(ModulPembelajaranDataTable $dataTable)
    {
        if (request()->ajax() && request()->has('filter') && request('filter') != '') {
            $search = request('filter');
            $data = RpsMatakuliah::with(['mappingMatakuliah.matakuliah', 'mappingMatakuliah.tahunAjaran'])
                ->whereHas('mappingMatakuliah', function ($query) use ($search) {
                    $query->where('tahun_ajaran_id', $search);
                })
                ->get();
            return DataTables::of($data)
                ->addColumn('action', function ($rps) {
                    $showRoute = route('rps-detail.index', ['id' => $rps->id]);
                    return view('admin.modul-pembelajaran.partials.action', compact('rps', 'showRoute'));
                })
                ->editColumn('tanggal_mulai', function ($rps) {
                    return \Carbon\Carbon::parse($rps->tanggal_mulai)->locale('id')->translatedFormat('d F Y');
                })
                ->editColumn('tanggal_selesai', function ($rps) {
                    return \Carbon\Carbon::parse($rps->tanggal_selesai)->locale('id')->translatedFormat('d F Y');
                })
                ->rawColumns(['action', 'tanggal_mulai', 'tanggal_selesai'])
                ->make(true);
        }
        $tahunAjaran = Cache::rememberForever('tahun_ajaran', function () {
            return TahunAjaran::all();
        });
        return $dataTable->render('admin.modul-pembelajaran.index', compact('tahunAjaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function detail(){
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
