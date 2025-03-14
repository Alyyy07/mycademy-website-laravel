<?php

namespace App\DataTables;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
            ->addColumn('action', function ($user) {
                $editRoute = route('user-management.users.edit', $user->id);
                $deleteRoute = route('user-management.users.destroy', $user->id);
                $impersonateRoute = route('user-management.impersonate', $user->id);
                return view('admin.user-list.partials.action', compact('editRoute', 'user','deleteRoute', 'impersonateRoute'));
            })
            ->editColumn('roles.name', function ($user) {
                $name = $user->roles?->pluck('name')->first() ?? 'No Role';
                $badgeColor = match ($name) {
                    'super-admin' => 'success',
                    'admin-matakuliah' => 'primary',
                    'dosen' => 'info',
                    default => 'dark'
                };
                return "<span class='badge badge-light-$badgeColor fs-7 py-3 px-4 text-capitalize'>".str_replace("-"," ",$name)."</span>";
            })
            ->editColumn('checkbox', function (User $user) {
                if($user->id === Auth::id()) {
                    return '';
                }   
                return "<div class='form-check form-check-sm form-check-custom form-check-solid'>
                <input class='form-check-input' check-target='user' type='checkbox' value='{$user->id}' />
            </div>";
            })
            ->editColumn('name', function (User $user) {
                $photo_path = $user->profile_photo ?? 'image/profile-photo/blank.png';
                return "<div class='symbol symbol-circle symbol-50px overflow-hidden me-3'>
                            <div class='symbol-label'>
                                <img src='" . asset("storage/$photo_path") . "' alt='$user->name' class='w-100' />
                            </div>
                        </div>
                        <div class='d-flex flex-column'>
                            <p class='text-gray-800 mb-1 fw-bold text-capitalize'>$user->name</p>
                            <span>$user->email</span>
                        </div>";
            })
            ->editColumn('is_active', function (User $user) {
                $checkedLabel = $user->is_active ? 'Active' : 'Inactive';
                $isChecked = $user->is_active ? 'checked' : '';
                $isDisabled = $user->id === Auth::id() ? 'disabled' : '';
                $setStatusRoute = route('user-management.users.setStatus', $user->id);

                return "<div class='form-check form-switch form-check-custom form-check-success form-check-solid' radio-action='set-status' button-url='$setStatusRoute'>
                <input class='form-check-input h-20px w-35px' is-active-radio type='checkbox' value='$user->id' $isChecked $isDisabled id='kt_flexSwitchCustomDefault_$user->id'/>
                <label class='form-check-label' for='kt_flexSwitchCustomDefault_$user->id'>$checkedLabel</label>
                </div>";
            })
            ->editColumn('last_login_at', function ($user) {
                if ($user->is_online) {
                    return '<span class="badge badge-success fs-7 py-3 px-4 fw-bold"><span class="badge badge-circle w-6px h-6px me-1" style="background-color:white"></span>Online</span>';
                }
                $last_login = $user->last_login_at ? Carbon::parse($user->last_login_at)->diffForHumans() : "Belum Login";
                return "<span class='badge badge-light fs-7 py-3 px-4 fw-bold'>$last_login</span>";
            })
            ->rawColumns(['roles.name', 'name', 'is_active', 'last_login_at', 'action', 'checkbox']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        $users = Cache::rememberForever('users_with_roles', function () use ($model) {
            return $model->newQuery()->with('roles')->get()->toArray();
        });

        Log::info('Users from cache:', $users);

        return $model->newQuery()->whereIn('id', array_column($users, 'id'))->with('roles');
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
																<input class="form-check-input" type="checkbox" check-action="user" />
															</div>')->addClass('w-10px pe-2')->orderable(false)->searchable(false)->titleAttr('Select All'),
            Column::make('name')->title('User')->addClass('d-flex align-items-center'),
            Column::make('roles.name')->title('Role')
                ->orderable(false),
            Column::make('last_login_at')->title('Last Login'),
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
        return 'User_' . date('YmdHis');
    }
}
