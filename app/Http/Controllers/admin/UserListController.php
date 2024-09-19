<?php

namespace App\Http\Controllers\admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\UserRequest;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
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
        return view('admin.user-list.modal', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
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
