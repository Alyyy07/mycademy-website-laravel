<?php

namespace App\DataTables;

use App\Models\Akademik\Prodi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProdiDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action',  function ($prodi) {
                $editRoute = route('akademik.prodi.edit', $prodi->id);
                $deleteRoute = route('akademik.prodi.destroy', $prodi->id);
                return view('admin.prodi.partials.action', compact('editRoute', 'prodi', 'deleteRoute'));
            })
            ->editColumn('kode_prodi', function (Prodi $prodi) {
                return "<span class='badge badge-light-primary fs-7 py-3 px-4 text-capitalize'>$prodi->kode_prodi</span>";
            })
            ->rawColumns(['action', 'kode_prodi']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Prodi $model): QueryBuilder
    {
        $prodi = Cache::rememberForever('prodi_with_fakultas', function () use ($model) {
            return $model->newQuery()->with('fakultas')->get()->toArray();
        });

        return $model->newQuery()->whereIn('id', array_column($prodi, 'id'))->with('fakultas');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('prodi-table')
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
            Column::make('kode_prodi')->title('Kode Prodi')->addClass('text-center')->orderable(false),
            Column::make('fakultas.nama_fakultas')->title('Fakultas'),
            Column::make('nama_prodi')->title('Prodi'),
            Column::make('deskripsi')->title('Deskripsi'),
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
        return 'Prodi_' . date('YmdHis');
    }
}
