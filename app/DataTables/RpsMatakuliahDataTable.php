<?php

namespace App\DataTables;

use App\Models\RpsMatakuliah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

use function PHPSTORM_META\map;

class RpsMatakuliahDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($rps) {
                $showRoute = route('rps-detail.index', ['id' => $rps->id]);
                $editRoute = route('rps-matakuliah.edit', $rps->id);
                $deleteRoute = route('rps-matakuliah.destroy', $rps->id);
                return view('admin.rps-matakuliah.partials.action', compact('rps', 'showRoute', 'editRoute', 'deleteRoute'));
            })
            ->editColumn('tanggal_mulai', function ($rps) {
                return \Carbon\Carbon::parse($rps->tanggal_mulai)->locale('id')->translatedFormat('d F Y');
            })
            ->editColumn('tanggal_selesai', function ($rps) {
                return \Carbon\Carbon::parse($rps->tanggal_selesai)->locale('id')->translatedFormat('d F Y');
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(RpsMatakuliah $model): QueryBuilder
    {
        $user = Auth::user();

        if ($user->roles->first()->name === 'admin-matakuliah') {
            $rpsMatakuliah = $model->newQuery()->with(['mappingMatakuliah.matakuliah', 'mappingMatakuliah.tahunAjaran'])->whereHas('mappingMatakuliah', function ($query) use ($user) {
                $query->where('admin_verifier_id', $user->id);
            })->get()->toArray();
        } else {
            $rpsMatakuliah = Cache::rememberForever('rps_matakuliah_with_mapping_matakuliah', function () use ($model) {
                return $model->newQuery()->with(['mappingMatakuliah.matakuliah', 'mappingMatakuliah.tahunAjaran'])->get()->toArray();
            });
        }

        return $model->newQuery()->whereIn('id', array_column($rpsMatakuliah, 'id'))->with(['mappingMatakuliah.matakuliah', 'mappingMatakuliah.tahunAjaran']);
    }

    /**
     * Optional method if you want to use the HTML builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('rpsmatakuliah-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->drawCallbackWithLivewire(file_get_contents(public_path('assets/js/custom/custom-datatable.js')))
            ->orderBy(1)
            ->parameters([
                'order' => [],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('No')->addClass('w-10px pe-2')->orderable(false)->searchable(false),
            Column::make('mapping_matakuliah.tahun_ajaran.tahun_ajaran')->title('Tahun Ajaran')->orderable(false),
            Column::make('mapping_matakuliah.matakuliah.nama_matakuliah')->title('Nama Matakuliah')->orderable(false),
            Column::make('mapping_matakuliah.semester')->title('Semester')->orderable(false)->addClass('text-center'),
            Column::make('tanggal_mulai')->title('Tanggal Mulai'),
            Column::make('tanggal_selesai')->title('Tanggal Selesai'),
            Column::computed('action')->addClass('text-center')
                ->exportable(false)
                ->printable(false)
                ->width(60),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'RpsMatakuliah_' . date('YmdHis');
    }
}
