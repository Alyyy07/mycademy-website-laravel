<?php

namespace App\DataTables;

use App\Models\RpsDetail;
use App\Models\RpsMatakuliah;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RpsDetailDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    protected $rpsMatakuliah;

    public function __construct(RpsMatakuliah $rpsMatakuliah)
    {
        $this->rpsMatakuliah = $rpsMatakuliah;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action',  function ($rpsDetail) {
                $editRoute = route('rps-detail.edit', $rpsDetail->id);
                $deleteRoute = route('rps-detail.destroy', $rpsDetail->id);
                return view('admin.rps-detail.partials.action', compact('editRoute', 'rpsDetail', 'deleteRoute'));
            })
            ->editColumn('tanggal_pertemuan', function ($rpsDetail) {
                return \Carbon\Carbon::parse($rpsDetail->tanggal_pertemuan)->locale('id')->translatedFormat('d F Y');
            })
            ->editColumn('capaian_pembelajaran', function ($rpsDetail) {
                return "<div class='text-start'>" . $rpsDetail->capaian_pembelajaran . "</div>";
            })
            ->editColumn('indikator', function ($rpsDetail) {
                return "<div class='text-start'>" . $rpsDetail->indikator . "</div>";
            })
            ->editColumn('metode_pembelajaran', function ($rpsDetail) {
                return "<div class='text-start'>" . $rpsDetail->metode_pembelajaran . "</div>";
            })
            ->editColumn('kriteria_penilaian', function ($rpsDetail) {
                return "<div class='text-start'>" . $rpsDetail->kriteria_penilaian . "</div>";
            })
            ->editColumn('materi_pembelajaran', function ($rpsDetail) {
                return "<div class='text-start'>" . $rpsDetail->materi_pembelajaran . "</div>";
            })
            ->rawColumns(['action', 'tanggal_pertemuan', 'capaian_pembelajaran', 'indikator', 'metode_pembelajaran', 'kriteria_penilaian', 'materi_pembelajaran']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(): QueryBuilder
    {
        return RpsDetail::where('rps_matakuliah_id', $this->rpsMatakuliah->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('rpsdetail-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addTableClass('table align-middle table-row-bordered fs-6 gy-5 gs-7')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->drawCallbackWithLivewire(file_get_contents(public_path('assets/js/custom/custom-datatable.js')))
            ->orderBy(1)
            ->scrollX(true)
            ->scrollY('50vh')
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
            Column::make('sesi_pertemuan')->title('Pertemuan ke')->addClass('text-center align-top')->orderable(false),
            Column::make('tanggal_pertemuan')->title('Tanggal Pertemuan'),
            Column::make('capaian_pembelajaran')->title('Capaian Pembelajaran')->addClass('text-center'),
            Column::make('indikator')->title('Indikator')->addClass('text-center'),
            Column::make('metode_pembelajaran')->title('Metode Pembelajaran')->addClass('text-center'),
            Column::make('kriteria_penilaian')->title('Kriteria Penilaian')->addClass('text-center'),
            Column::make('materi_pembelajaran')->title('Materi Pembelajaran')->addClass('text-center'),
            Column::computed('action')->addClass('text-center')
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
        return 'RpsDetail_' . date('YmdHis');
    }
}
