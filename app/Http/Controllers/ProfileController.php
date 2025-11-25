<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\CloudinaryService;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function profile()
    {
        $title = 'Profile';
        $header = 'My Profile';
        $tab = 'Account';
        $user = Auth::user();
        return view('profile', compact('title', 'header', 'tab', 'user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());
        $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
        ]);

        return back()->with('success', 'Account information updated successfully!');
    }

    public function updatePhoto(Request $request)
    {
        $file = $request->file('photo');
        if (!$file) {
            return back()->with('error', 'File tidak ditemukan');
        }

        $uploadedFileUrl = CloudinaryService::upload($file, 'profile');

        $user = User::find(Auth::id());
        $user->update([
            'photo' => $uploadedFileUrl,
        ]);

        return back()->with('success', 'Foto berhasil diperbarui!');
    }

    public function password()
    {
        $title = 'Profile';
        $header = 'My Profile';
        $tab = 'Password';
        $user = Auth::user();
        return view('profile', compact('title', 'header', 'tab', 'user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = User::find(Auth::id());
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password does not match our records.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Profile $profile)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
