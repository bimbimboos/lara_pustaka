<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id_user)],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        // Siapkan data untuk update
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        // Handle upload foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Upload foto baru
            $photoPath = $request->file('photo')->store('profile-photos', 'public');
            $updateData['photo'] = $photoPath;
        }

        // Update menggunakan Model User langsung
        \App\Models\User::where('id_user', $user->id_user)->update($updateData);

        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully!');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Hapus foto jika ada
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Logout dulu
        Auth::logout();

        // Hapus user menggunakan query builder
        \App\Models\User::destroy($user->id_user);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
