<?php

namespace App\DataTables;

use App\Models\Akademik\Matakuliah;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MatakuliahDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action',  function ($matakuliah) {
                $editRoute = route('akademik.matakuliah.edit', $matakuliah->id);
                $deleteRoute = route('akademik.matakuliah.destroy', $matakuliah->id);
                return view('admin.matakuliah.partials.action', compact('editRoute', 'matakuliah', 'deleteRoute'));
            })
            ->editColumn('kode_matakuliah', function (Matakuliah $matakuliah) {
                return "<span class='badge badge-light-primary fs-7 py-3 px-4 text-capitalize'>$matakuliah->kode_matakuliah</span>";
            })
            ->rawColumns(['action', 'kode_matakuliah']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Matakuliah $model): QueryBuilder
    {
        $matakuliah = Cache::rememberForever('matakuliah', function () use ($model) {
            return $model->newQuery()->with('prodi')->get()->toArray(); // Disimpan sebagai array
        });
        
        // Ubah ke collection sebelum `pluck()`
        return $model->newQuery()->whereIn('id', collect($matakuliah)->pluck('id'))->with('prodi');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('matakuliah-table')
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
            Column::make('id')->title('No')->addClass('w-10px pe-2')->orderable(false)->searchable(false)->titleAttr('No'),
            Column::make('kode_matakuliah')->title('Kode Matakuliah')->addClass('text-center')->orderable(false),
            Column::make('prodi.nama_prodi')->title('Prodi'),
            Column::make('nama_matakuliah')->title('Nama Matakuliah'),
            Column::make('deskripsi')->title('Deskripsi'),
            Column::make('sks')->title('SKS'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Matakuliah_' . date('YmdHis');
    }
}
