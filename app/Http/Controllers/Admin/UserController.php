<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all(); // Fetch all roles for the dropdown
        $coordinators = User::whereHas('roles', function ($query) {
            $query->where('name', 'coordinator');
        })->get(); // Fetch coordinators for technician assignment

        return view('admin.users.create', compact('roles', 'coordinators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,technician,coordinator',
            'crop_category' => 'nullable|string|required_if:role,coordinator',
            'coordinator_id' => 'nullable|exists:users,id|required_if:role,technician',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'crop_category' => $request->role === 'coordinator' ? $request->crop_category : null,
            'coordinator_id' => $request->role === 'technician' ? $request->coordinator_id : null,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all(); // Fetch all permissions
        $coordinators = User::whereHas('roles', function ($query) {
            $query->where('name', 'coordinator');
        })->get(); // Fetch only users with the coordinator role

        return view('admin.users.edit', compact('user', 'roles', 'permissions', 'coordinators'));
    }



    public function update(Request $request, User $user)
    {
        \Log::info('Updating user:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
            'crop_category' => 'nullable|string|required_if:roles.0,coordinator',
            'coordinator_id' => 'nullable|exists:users,id|required_if:roles.0,technician',
        ]);

        \Log::info('Roles received:', $request->roles);
        \Log::info('Crop Category:', [$request->crop_category]);

        // Force crop_category update
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'crop_category' => in_array('coordinator', $request->roles) ? $request->crop_category : null,
            'coordinator_id' => in_array('technician', $request->roles) ? $request->coordinator_id : null,
        ];

        \Log::info('Data to update:', $updateData);

        $user->update($updateData);
        \Log::info('User after update:', $user->fresh()->toArray());

        // Sync roles and permissions
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }




    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
