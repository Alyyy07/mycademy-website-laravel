<?php

namespace App\Http\Controllers\admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\UserRequest;
use App\Models\Akademik\DataMahasiswa;
use App\Models\Roles;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserListController extends Controller
{

    protected $modules = ['user_management', 'user_management.user_list'];
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
        $roles = Cache::rememberForever('roles', function () {
            return Roles::all();
        });
        $user = new User();
        $action = 'create';
        $route = route('user-management.users.store');
        return view('admin.user-list.partials.form-modal', compact('roles', 'route', 'user', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();

        DB::beginTransaction();
        try {
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = hash('sha256', time() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $data['profile_photo'] = $file->storeAs('image/profile-photo', $filename, 'public');
            }

            $user = User::create($data);
            $user->assignRole($request->role);

            if ($request->role == 'mahasiswa') {
                DataMahasiswa::create([
                    'user_id' => $user->id,
                    'nama' => $request->name,
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'success','message' => 'User berhasil dibuat!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error','message' => 'Terjadi kesalahan saat membuat user!', 'error' => $e->getMessage()], 500);
        }
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
        $roles = Cache::rememberForever('roles', function () {
            return Roles::all();
        });
        $action = 'edit';
        $route = route('user-management.users.update', $user->id);
        return view('admin.user-list.partials.form-modal', compact('roles', 'route', 'user', 'action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->all();

        DB::beginTransaction();
        try {
            if ($request->hasFile('profile_photo')) {
            $oldPhoto = $user->profile_photo;
            if ($oldPhoto) {
                unlink(storage_path('app/public/' . $oldPhoto));
            }
            $file = $request->file('profile_photo');
            $filename = hash('sha256', time() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $data['profile_photo'] = $file->storeAs('image/profile-photo', $filename, 'public');
            }

            if (!$request->password) {
            unset($data['password']);
            }

            $user->update($data);
            $user->syncRoles(request()->role);

            DB::commit();
            return response()->json(['status' => 'success','message' => 'User berhasil diupdate!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat mengupdate user!', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->syncRoles([]);
        $photoPath = $user->profile_photo;
        if ($photoPath) {
            unlink(storage_path("app/public/$photoPath"));
        }
        $result = $user->delete();
        if (!$result) {
            return response()->json(['status' => 'error','message' => 'User gagal dihapus!'], 500);
        }
        return response()->json(['status' => 'success','message' => 'User berhasil dihapus!'], 200);
    }

    public function setStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $result = $user->save();
        $message = $user->is_active ? 'User berhasil diaktifkan!' : 'User berhasil dinonaktifkan!';
        if (!$result) {
            return response()->json(['status' => 'error','message' => 'Status user gagal diupdate!'], 500);
        }
        return response()->json(['status' => 'success','message' => $message], 200);
    }

    public function bulkDelete()
    {
        $ids = request()->ids;

        DB::beginTransaction();
        try {
            foreach ($ids as $id) {
                $user = User::find($id);
                if ($user) {
                    $user->syncRoles([]);
                    $photoPath = $user->profile_photo;
                    if ($photoPath) {
                        unlink(storage_path("app/public/$photoPath"));
                    }
                    $user->delete();
                }
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'User yang dipilih berhasil dihapus!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat menghapus user!', 'error' => $e->getMessage()], 500);
        }
    }

    public function bulkSetStatus()
    {
        $ids = request()->ids;

        DB::beginTransaction();
        try {
            foreach ($ids as $id) {
                $user = User::find($id);
                if ($user) {
                    $user->is_active = !$user->is_active;
                    $user->save();
                }
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Status user yang dipilih berhasil diupdate!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat mengupdate status user!', 'error' => $e->getMessage()], 500);
        }
    }
}
