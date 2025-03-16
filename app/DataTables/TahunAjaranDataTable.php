<?php

namespace App\DataTables;

use App\Models\Akademik\TahunAjaran;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TahunAjaranDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action',  function ($tahunAjaran) {
                $editRoute = route('akademik.tahun-ajaran.edit', $tahunAjaran->id);
                $deleteRoute = route('akademik.tahun-ajaran.destroy', $tahunAjaran->id);
                return view('admin.tahun-ajaran.partials.action', compact('editRoute', 'tahunAjaran', 'deleteRoute'));
            })
            ->editColumn('is_active', function (TahunAjaran $tahunAjaran) {
                $checkedLabel = $tahunAjaran->is_active ? 'Active' : 'Inactive';
                $isChecked = $tahunAjaran->is_active ? 'checked' : '';
                $setStatusRoute = route('akademik.tahun-ajaran.setStatus', $tahunAjaran->id);

                return "<div class='form-check form-switch form-check-custom form-check-success form-check-solid' radio-action='set-status' button-url='$setStatusRoute'>
                <input class='form-check-input h-20px w-35px' is-active-radio type='checkbox' value='$tahunAjaran->id' $isChecked id='kt_flexSwitchCustomDefault_$tahunAjaran->id'/>
                <label class='form-check-label' for='kt_flexSwitchCustomDefault_$tahunAjaran->id'>$checkedLabel</label>
                </div>";
            })
            ->editColumn('kode_tahun_ajaran', function (TahunAjaran $tahunAjaran) {
                return "<span class='badge badge-light-primary fs-7 py-3 px-4 text-capitalize'>$tahunAjaran->kode_tahun_ajaran</span>";
            })
            ->editColumn('tanggal_mulai', function (TahunAjaran $tahunAjaran) {
                return \Carbon\Carbon::parse($tahunAjaran->tanggal_mulai)->format('d F Y');
            })
            ->editColumn('tanggal_selesai', function (TahunAjaran $tahunAjaran) {
                return \Carbon\Carbon::parse($tahunAjaran->tanggal_selesai)->format('d F Y');
            })
            ->rawColumns(['action', 'is_active', 'kode_tahun_ajaran']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(TahunAjaran $model)
    {
        $tahunAjaran = Cache::rememberForever('tahun_ajaran', function () use ($model) {
            return $model->all();
        });

        return TahunAjaran::whereIn('id', $tahunAjaran->pluck('id'));
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('tahunajaran-table')
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
            Column::make('kode_tahun_ajaran')->title('Kode Tahun Ajaran')->addClass('text-center')->orderable(false),
            Column::make('tahun_ajaran')->title('Tahun Ajaran')
                ->orderable(false),
            Column::make('tanggal_mulai')->title('Tanggal Mulai'),
            Column::make('tanggal_selesai')->title('Tanggal Selesai'),
            Column::make('is_active')->title('Status'),
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
        return 'TahunAjaran_' . date('YmdHis');
    }
}
