<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        return view('user.profile');
    }

    public function calendar()
    {
        return view('user.calendar');
    }

    public function preferences()
    {
        return view('user.preferences');
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|string',
            'nationality' => 'nullable|string',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'phone', 'birthday', 'gender', 'nationality', 'address', 'bio']);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function deleteAvatar()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->avatar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return back()->with('success', 'Profile picture removed.');
    }
}
