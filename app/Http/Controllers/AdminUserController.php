<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\CloudinaryService;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function users()
    {
        $title = 'Manage Users';
        $header = 'User Management';
        // $users = User::latest()->paginate(10);
        $users = User::latest()->filter(request(['search']))->paginate(10)->withQueryString();

        return view('manage-users', compact('title', 'header', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'photo' => 'nullable|image',
        ]);

        $photoUrl = null;

        if ($request->hasFile('photo')) {
            $photoUrl = CloudinaryService::upload($request->file('photo'), 'profile');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'photo' => $photoUrl ?? 'https://res.cloudinary.com/dqsnhqpta/image/upload/v1763554774/default_rhbaay.png',
        ]);

        return redirect()->route('admin.users')->with('success', 'User successfully created!');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'min:6'],
            'photo' => ['nullable', 'image'],
        ]);

        if ($request->hasFile('photo')) {
            $user->photo = CloudinaryService::upload($request->file('photo'), 'profile');
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'User updated successfully!');
    }

    // public function destroy(User $user)
    // {
    //     // Jika user punya foto di Cloudinary (opsional)
    //     if ($user->photo) {
    //         // Hapus foto dari Cloudinary jika diperlukan
    //         CloudinaryService::delete($user->photo);
    //     }

    //     $user->delete();

    //     return back()->with('success', 'User deleted successfully!');
    // }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if (auth()->check() && auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        // if ($user->photo) {
        //     CloudinaryService::delete($user->photo);
        // }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
