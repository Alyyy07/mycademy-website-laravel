<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\RoleRequest;
use App\Models\Roles;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role as PermissionModelsRole;

class RoleController extends Controller
{
    protected $modules = ['user_management', 'user_management.roles'];
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $roles = $this->getSimplifiedRole();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = 'create';
        $role = new Roles();
        $route = route('user-management.roles.store');
        return view('admin.role.partials.modal', compact('route', 'action', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $role = Roles::create(['name' => $request->name, 'guard_name' => 'web']);

            $permissions = $request->permissions;
            $role->syncPermissions($permissions);
            DB::commit();
            return response()->json(['type' => 'roles', 'message' => 'Role created successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['type' => 'roles', 'message' => 'Role creation failed', 'error' => $th->getMessage()], 500);
        }
    }

    public function edit(String $id)
    {

        $action = 'edit';
        $role = Roles::find($id);
        $route = route('user-management.roles.update', $role->id);
        return view('admin.role.partials.modal', compact('route', 'action', 'role'));
    }

    public function update(RoleRequest $request, Roles $role)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $role->update(['name' => $request->name]);
            $permissions = $request->permissions;
            $rolePermission = PermissionModelsRole::findByName($role->name);

            $menuNames = [];
            foreach ($permissions as $permission) {
                // Hapus suffix seperti -create, -read, -update, -delete
                $menuName = preg_replace('/-(create|read|update|delete)$/', '', $permission);
                // Tambahkan nama menu ke array jika belum ada
                if (!in_array($menuName, $menuNames)) {
                    $menuNames[] = $menuName;
                }
            }
            $result = array_merge($permissions, $menuNames);

            $rolePermission->syncPermissions($result);
            DB::commit();
            return response()->json(['type' => 'roles', 'message' => 'Role updated successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['type' => 'roles', 'message' => 'Role update failed', 'error' => $th->getMessage()], 500);
        }
    }

    private function getSimplifiedRole()
    {
        $rawRoles = Cache::rememberForever('roles_with_permissions', function () {
            return Roles::with('permissions', 'users')->get();
        });
        $integratedRoles = $rawRoles->map(function ($role) {
            $permissions = $role->permissions->pluck('name')->map(function ($permission) {
                return str_replace('-', '.', $permission);
            })->toArray();

            return [
                'id' => $role->id,
                'role' => $role->name,
                'permissions' => $permissions,
                'users' => $role->users->count(),
            ];
        });
        return simplifyPermissions($integratedRoles);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $role = Roles::find($id);
            $role->delete();
            DB::commit();
            return response()->json(['type' => 'roles', 'message' => 'Role deleted successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['type' => 'roles', 'message' => 'Role deletion failed', 'error' => $th->getMessage()], 500);
        }
    }
}
