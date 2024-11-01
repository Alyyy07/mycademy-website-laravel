<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\RoleRequest;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as PermissionModelsRole;

class RoleController extends Controller
{
    protected $modules = ['user-management', 'user-management.roles'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = 'create';
        $route = route('user-management.roles.store');
        return view('admin.role.partials.modal', compact('route', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $role = Roles::create(['name' => $request->role_name, 'guard_name' => 'web']);

            $permissions = $request->permissions;
            $descriptivePermissions = $this->expandArray($permissions);
            $registeredPermissions = Permission::whereIn('name', $descriptivePermissions)->get()->pluck('name')->toArray();
            $role->syncPermissions($registeredPermissions);
            DB::commit();
            return response()->json(['message' => 'Role created successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Role creation failed', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    private function expandArray($inputArray)
    {
        $expandedArray = [];
        foreach ($inputArray as $item) {
            $parts = explode('.', $item);
            $currentCombination = "";
            foreach ($parts as $part) {
                $subParts = explode('-', $part);
                foreach ($subParts as $index => $subPart) {
                    if ($currentCombination === "") {
                        $currentCombination = $subPart;
                    } else {
                        $currentCombination .= ($index === 0 ? "." : "-") . $subPart;
                    }
                    if (!in_array($currentCombination, $expandedArray)) {
                        $expandedArray[] = $currentCombination;
                    }
                }
            }
        }
        return $expandedArray;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
