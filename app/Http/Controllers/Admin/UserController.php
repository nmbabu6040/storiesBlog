<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::with('roles')
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|exists:roles,name',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $image = $request
                ->file('image')
                ->store('profile', 'public');
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'image'    => $image,
        ]);

        $user->assignRole($request->role);

        activityLog(
            'User',
            'Create',
            $user->name
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $roles = Role::all();

        return view(
            'admin.users.edit',
            compact('user', 'roles')
        );
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password' => 'nullable|confirmed|min:8',
        ]);

        // নিজের Role নিজে পরিবর্তন করতে পারবে না
        if (
            auth()->id() == $user->id &&
            $request->role != $user->roles->first()?->name
        ) {
            return back()->with(
                'error',
                'You cannot change your own role.'
            );
        }

        // Image Upload
        $image = $user->image;

        if ($request->hasFile('image')) {

            if (
                $user->image &&
                Storage::disk('public')->exists($user->image)
            ) {
                Storage::disk('public')->delete($user->image);
            }

            $image = $request
                ->file('image')
                ->store('profile', 'public');
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'image' => $image,
        ];

        // Password পরিবর্তন (Optional)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Role Update
        $user->syncRoles([$request->role]);

        activityLog(
            'User',
            'Update',
            $user->name
        );

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User updated successfully.'
            );
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        // নিজের account delete করা যাবে না
        if ($user->id == auth()->id()) {

            return back()->with(
                'error',
                'You cannot delete your own account.'
            );
        }

        // Super Admin delete করা যাবে না
        if ($user->hasRole('Super Admin')) {

            return back()->with(
                'error',
                'Super Admin cannot be deleted.'
            );
        }

        $user->delete();

        activityLog(
            'User',
            'Delete',
            $user->name
        );

        return back()->with(
            'success',
            'User moved to trash.'
        );
    }

    public function trash()
    {
        $this->authorize('viewAny', User::class);

        $trashUsers = User::onlyTrashed()
            ->with('roles')
            ->latest('deleted_at')
            ->paginate(10);

        return view(
            'admin.users.trash',
            compact('trashUsers')
        );
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('restore', $user);

        $user->restore();

        activityLog(
            'User',
            'Restore',
            $user->name
        );

        return back()->with(
            'success',
            'User restored successfully.'
        );
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('forceDelete', $user);

        // Super Admin permanently delete করা যাবে না
        if ($user->hasRole('Super Admin')) {

            return back()->with(
                'error',
                'Super Admin cannot be permanently deleted.'
            );
        }

        // Image delete
        if (
            $user->image &&
            Storage::disk('public')->exists($user->image)
        ) {
            Storage::disk('public')->delete($user->image);
        }

        $user->forceDelete();

        activityLog(
            'User',
            'Permanent Delete',
            $user->name
        );

        return back()->with(
            'success',
            'User permanently deleted.'
        );
    }
}
