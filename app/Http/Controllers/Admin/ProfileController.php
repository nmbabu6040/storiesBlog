<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile.edit');
    }



    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio'   => 'nullable|max:1000',
        ]);

        $image = $user->image;

        if ($request->hasFile('image')) {

            if (
                $image &&
                Storage::disk('public')->exists($image)
            ) {
                Storage::disk('public')->delete($image);
            }

            $image = $request
                ->file('image')
                ->store('profile', 'public');
        }

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'bio'   => $request->bio,
            'image' => $image,
        ]);

        activityLog(
            'Profile',
            'Update',
            $user->name
        );

        return back()->with(
            'success',
            'Profile updated successfully.'
        );
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check(
            $request->current_password,
            $user->password
        )) {

            return back()->withErrors([
                'current_password' => 'Current password is incorrect.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        activityLog(
            'Profile',
            'Password Changed',
            $user->name
        );

        return back()->with(
            'success',
            'Password changed successfully.'
        );
    }
}
