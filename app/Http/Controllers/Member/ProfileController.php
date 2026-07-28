<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $member = $request->user()->member;

        return view('member.profile', compact('member'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $member = $user->member;

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:6'],
            'nim' => ['nullable', 'string', 'max:50'],
            'age' => ['nullable', 'integer', 'min:15', 'max:100'],
            'jurusan' => ['nullable', 'string', 'max:255'],
            'fakultas' => ['nullable', 'string', 'max:255'],
            'universitas' => ['nullable', 'string', 'max:255'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'bio' => ['nullable', 'string'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'hobi' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (! empty($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
        }

        $photoPath = $member->photo;
        if ($request->hasFile('photo')) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $photoPath = $request->file('photo')->store('members', 'public');
        }

        $cvPath = $member->cv;
        if ($request->hasFile('cv')) {
            if ($member->cv) {
                Storage::disk('public')->delete($member->cv);
            }
            $cvPath = $request->file('cv')->store('members/cv', 'public');
        }

        $member->update([
            'nim' => $data['nim'] ?? null,
            'age' => $data['age'] ?? null,
            'jurusan' => $data['jurusan'] ?? null,
            'fakultas' => $data['fakultas'] ?? null,
            'universitas' => $data['universitas'] ?? null,
            'jabatan' => $data['jabatan'] ?? null,
            'phone' => $data['phone'] ?? null,
            'bio' => $data['bio'] ?? null,
            'instagram' => $data['instagram'] ?? null,
            'hobi' => $data['hobi'] ?? null,
            'photo' => $photoPath,
            'cv' => $cvPath,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
