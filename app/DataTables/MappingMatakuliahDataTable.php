<?php

namespace App\DataTables;

use App\Models\MappingMatakuliah;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MappingMatakuliahDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action',  function ($mappingMatakuliah) {
                $editRoute = route('mapping-matakuliah.edit', $mappingMatakuliah->id);
                $deleteRoute = route('mapping-matakuliah.destroy', $mappingMatakuliah->id);
                return view('admin.mapping-matakuliah.partials.action', compact('editRoute', 'mappingMatakuliah', 'deleteRoute'));
            })
            ->editColumn('dosen.name', function ($mappingMatakuliah) {
                $photo_path = $mappingMatakuliah->dosen->profile_photo ?? 'image/profile-photo/blank.png';
                return "<div class='d-flex align-items-center text-start'>
                <div class='symbol symbol-circle symbol-50px overflow-hidden me-3'>
                            <div class='symbol-label'>
                                <img src='" . asset("storage/$photo_path") . "' alt='" . $mappingMatakuliah->dosen->name . "' class='w-100' />
                            </div>
                        </div>
                        <div class='d-flex flex-column'>
                            <p class='text-gray-800 mb-1 fw-bold text-capitalize'>" . $mappingMatakuliah->dosen->name . "</p>
                            <span>" . $mappingMatakuliah->dosen->email . "</span>
                        </div>
                        </div>";
            })
            ->editColumn('admin_verifier.name', function ($mappingMatakuliah) {
                $photo_path = $mappingMatakuliah->adminVerifier->profile_photo ?? 'image/profile-photo/blank.png';
                return "<div class='d-flex align-items-center text-start'>
                <div class='symbol symbol-circle symbol-50px overflow-hidden me-3'>
                            <div class='symbol-label'>
                                <img src='" . asset("storage/$photo_path") . "' alt='" . $mappingMatakuliah->adminVerifier->name . "' class='w-100' />
                            </div>
                        </div>
                        <div class='d-flex flex-column'>
                            <p class='text-gray-800 mb-1 fw-bold text-capitalize'>" . $mappingMatakuliah->adminVerifier->name . "</p>
                            <span>" . $mappingMatakuliah->adminVerifier->email . "</span>
                        </div>
                        </div>";
            })
            ->rawColumns(['action', 'dosen.name', 'admin_verifier.name']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(MappingMatakuliah $model): QueryBuilder
    {
        $mappingMatakuliah = Cache::rememberForever('mapping_matakuliah', function () use ($model) {
            return $model->newQuery()
                ->with(['tahunAjaran', 'matakuliah', 'dosen', 'adminVerifier']);
        });

        return $model->newQuery()->whereIn('id', collect($mappingMatakuliah)->pluck('id'))->with(['tahunAjaran', 'matakuliah', 'dosen', 'adminVerifier']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('mappingmatakuliah-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5')
            ->setTableHeadClass('text-center text-muted fw-bold fs-7 text-uppercase gs-0')
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
            Column::make('id')->title('No')->addClass('w-10px pe-2')->searchable(false)->addClass('text-center pe-0'),
            Column::make('tahun_ajaran.tahun_ajaran')->title('Tahun Ajaran')->addClass('text-center pe-0')->orderable(false),
            Column::make('matakuliah.nama_matakuliah')->title('Nama Matakuliah')->addClass('text-center pe-0'),
            Column::make('dosen.name')->title('Nama Dosen')->addClass('text-center pe-0')->orderable(false),
            Column::make('admin_verifier.name')->title('Admin Verifikasi')->addClass('text-center pe-0')->orderable(false),
            Column::make('semester')->title('Semester')->addClass('text-center pe-0'),
            Column::computed('action')->addClass('text-center pe-0')
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
        return 'MappingMatakuliah_' . date('YmdHis');
    }
}
