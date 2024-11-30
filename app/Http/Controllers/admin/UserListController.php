<?php

namespace App\Http\Controllers\admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\UserRequest;
use App\Models\Roles;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;

class UserListController extends Controller
{
    protected $modules = ['user_management','user_management.user_list'];
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.user-list.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Roles::all();
        $user = new User();
        $action = 'create';
        $route = route('user-management.users.store');
        return view('admin.user-list.partials.form-modal', compact('roles', 'route','user', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = hash('sha256', time() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $data['profile_photo'] = $file->storeAs('image/profile-photo', $filename, 'public');
        }
        $user = User::create($data);
        $user->assignRole($request->role);
        return response()->json(['message' => 'User created successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Roles::all();
        $action = 'edit';
        $route = route('user-management.users.update', $user->id);
        return view('admin.user-list.partials.form-modal', compact('roles', 'route', 'user','action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request,User $user)
    {
        $data = $request->all();
        if ($request->hasFile('profile_photo')) {
            $oldPhoto = $user->profile_photo;
            if ($oldPhoto) {
                unlink(storage_path('app/public/' . $oldPhoto));
            }
            $file = $request->file('profile_photo');
            $filename = hash('sha256', time() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $data['profile_photo'] = $file->storeAs('image/profile-photo', $filename, 'public');
        }
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }else{
            unset($data['password']);
        }
        $user->update($data);
        $user->syncRoles(request()->role);
        return response()->json(['message' => 'User updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        $user->syncRoles([]);
        $photoPath = $user->profile_photo;
        if ($photoPath) {
            unlink(storage_path("app/public/$photoPath"));
        }
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function setStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return response()->json(['message' => 'User status updated successfully'], 200);
    }

    public function bulkDelete()
    {
        $ids = request()->ids;
        foreach ($ids as $id) {
            $user = User::find($id);
            $user->delete();
            $user->syncRoles([]);
            $photoPath = $user->profile_photo;
            if ($photoPath) {
                unlink(storage_path("app/public/$photoPath"));
            }
        }
        return response()->json(['message' => 'All selected users deleted successfully'], 200);
    }

    public function bulkSetStatus()
    {
        $ids = request()->ids;
        foreach ($ids as $id) {
            $user = User::find($id);
            $user->is_active = !$user->is_active;
            $user->save();
        }
        return response()->json(['message' => 'All selected users status updated successfully'], 200);
    }
}
