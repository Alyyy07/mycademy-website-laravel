<?php

namespace App\DataTables;

use App\Models\Akademik\DataMahasiswa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DataMahasiswaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($mahasiswa) {
                $editRoute = route('akademik.data-mahasiswa.edit', $mahasiswa->id);
                $deleteRoute = route('akademik.data-mahasiswa.destroy', $mahasiswa->id);
                return view('admin.data-mahasiswa.partials.action', compact('editRoute', 'mahasiswa', 'deleteRoute'));
            })
            ->editColumn('nama', function (DataMahasiswa $mahasiswa) {
                $photo_path = $mahasiswa->user->profile_photo ?? 'image/profile-photo/blank.png';
                return "<div class='symbol symbol-circle symbol-50px overflow-hidden me-3'>
                        <div class='symbol-label'>
                            <img src='" . asset("storage/$photo_path") . "' alt='" . $mahasiswa->user->name . "' class='w-100' />
                        </div>
                    </div>
                    <div class='d-flex flex-column'>
                        <p class='text-gray-800 mb-1 fw-bold text-capitalize'>" . $mahasiswa->user->name . "</p>
                        <span>" . $mahasiswa->user->email . "</span>
                    </div>";
            })
            ->editColumn('tanggal_lahir', function (DataMahasiswa $mahasiswa) {
                return \Carbon\Carbon::parse($mahasiswa->tanggal_lahir)->locale('id')->translatedFormat('d F Y');
            })
            ->rawColumns(['action', 'nama', 'tanggal_lahir']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(DataMahasiswa $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['prodi', 'user'])->orderBy('npm', 'asc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('datamahasiswa-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->drawCallbackWithLivewire(file_get_contents(public_path('assets/js/custom/custom-datatable.js')))
            ->orderBy(1);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('No')
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),
            Column::make('npm')->title('NPM'),
            Column::make('nama')->title('Mahasiswa')->addClass('d-flex align-items-center'),
            Column::make('prodi.nama_prodi')->title('Program Studi'),
            Column::make('nik')->title('NIK'),
            Column::make('tempat_lahir')->title('Tempat Lahir'),
            Column::make('tanggal_lahir')->title('Tanggal Lahir'),
            Column::make('jenis_kelamin')->title('Jenis Kelamin'),
            Column::make('agama')->title('Agama'),
            Column::make('alamat')->title('Alamat')->addClass('text-truncate'),
            Column::make('no_hp')->title('No HP'),
            Column::make('nama_ibu')->title('Nama Ibu'),
            Column::make('semester')->title('Semester'),
            Column::computed('action')
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
        return 'DataMahasiswa_' . date('YmdHis');
    }
}
