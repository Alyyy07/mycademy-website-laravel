<?php

namespace App\DataTables;

use App\Models\Akademik\Fakultas;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FakultasDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action',  function ($fakultas) {
                $editRoute = route('akademik.fakultas.edit', $fakultas->id);
                $deleteRoute = route('akademik.fakultas.destroy', $fakultas->id);
                return view('admin.fakultas.partials.action', compact('editRoute', 'fakultas', 'deleteRoute'));
            })
            ->editColumn('kode_fakultas', function (Fakultas $fakultas) {
                return "<span class='badge badge-light-primary fs-7 py-3 px-4 text-capitalize'>$fakultas->kode_fakultas</span>";
            })
            ->editColumn('nama_fakultas', function (Fakultas $fakultas) {
                $photo_path = $fakultas->logo ?? 'image/profile-photo/blank.png';
                return "<div class='symbol symbol-circle symbol-50px overflow-hidden me-3'>
                            <div class='symbol-label'>
                                <img src='" . asset("storage/$photo_path") . "' alt='$fakultas->nama_fakultas' class='w-100' />
                            </div>
                        </div>
                        <div class='d-flex flex-column'>
                            <p class='text-gray-800 mb-1 fw-bold text-capitalize'>$fakultas->nama_fakultas</p>
                            <span>$fakultas->email</span>
                        </div>";
            })
            ->rawColumns(['action', 'kode_fakultas', 'nama_fakultas']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Fakultas $model)
    {
        $fakultas = Cache::rememberForever('fakultas', function () use ($model) {
            return $model->all();
        });
        return Fakultas::whereIn('id', $fakultas->pluck('id'));
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('fakultas-table')
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
            Column::make('kode_fakultas')->title('Kode Fakultas')->addClass('text-center')->orderable(false),
            Column::make('nama_fakultas')->title('Fakultas')->addClass('d-flex align-items-center'),
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
        return 'Fakultas_' . date('YmdHis');
    }
}
