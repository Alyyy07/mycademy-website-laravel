<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', view('admin.user-list.action'))
            ->editColumn('roles.name', function ($user) {
                return match ($user->roles->pluck('name')->first()) {
                    'admin' => '<span class="badge badge-light-success">Administrator</span>',
                    'camaba' => '<span class="badge badge-light-primary">Camaba</span>',
                };
            })
            ->editColumn('checkbox', function (User $user) {
                return "<div class='form-check form-check-sm form-check-custom form-check-solid'>
                <input class='form-check-input' type='checkbox' value='{$user->id}' />
            </div>";
            })
            ->rawColumns(['roles.name', 'action','checkbox']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->with('roles');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('user-table')
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
            Column::make('checkbox')->title('<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
																<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
															</div>')->addClass('w-10px pe-2')->orderable(false)->searchable(false),
            Column::make('name')->title('User'),
            Column::make('email'),
            Column::make('roles.name')->title('Role')
            ->orderable(false),
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
        return 'User_' . date('YmdHis');
    }
}
