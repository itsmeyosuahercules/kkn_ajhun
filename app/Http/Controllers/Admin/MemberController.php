<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MembersTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\MembersImport;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MemberController extends Controller
{
    public function index(): View
    {
        $members = Member::with('user')->withCount('reports')->latest()->paginate(12);

        return view('admin.members.index', compact('members'));
    }

    public function create(): View
    {
        return view('admin.members.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request, true);

        DB::transaction(function () use ($data, $request) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'member',
            ]);

            $photoPath = $request->hasFile('photo')
                ? $request->file('photo')->store('members', 'public')
                : null;

            $cvPath = $request->hasFile('cv')
                ? $request->file('cv')->store('members/cv', 'public')
                : null;

            Member::create([
                'user_id' => $user->id,
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
        });

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Member $member): View
    {
        $member->load('user');

        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        $data = $this->validateData($request, false, $member);

        $member->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (! empty($data['password'])) {
            $member->user->update(['password' => Hash::make($data['password'])]);
        }

        if ($request->hasFile('photo')) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        if ($request->hasFile('cv')) {
            if ($member->cv) {
                Storage::disk('public')->delete($member->cv);
            }
            $data['cv'] = $request->file('cv')->store('members/cv', 'public');
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
            'photo' => $data['photo'] ?? $member->photo,
            'cv' => $data['cv'] ?? $member->cv,
        ]);

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function downloadTemplate(): BinaryFileResponse
    {
        return Excel::download(new MembersTemplateExport, 'template-import-anggota.xlsx');
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ]);

        $import = new MembersImport;
        Excel::import($import, $request->file('file'));

        $message = "Berhasil mengimpor {$import->imported} anggota.";

        if (! empty($import->failures)) {
            $errorLines = collect($import->failures)
                ->map(fn ($f) => "Baris {$f['row']}: ".implode(', ', $f['errors']))
                ->implode(' | ');

            return redirect()->route('admin.members.index')
                ->with('success', $message)
                ->with('import_errors', $errorLines);
        }

        return redirect()->route('admin.members.index')->with('success', $message);
    }

    public function destroy(Member $member): RedirectResponse
    {
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }
        if ($member->cv) {
            Storage::disk('public')->delete($member->cv);
        }

        $user = $member->user;
        $member->delete();
        $user?->delete();

        return back()->with('success', 'Anggota berhasil dihapus.');
    }

    private function validateData(Request $request, bool $isCreate, ?Member $member = null): array
    {
        $userId = $member?->user_id;

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'.($userId ? ",$userId" : '')],
            'password' => [$isCreate ? 'required' : 'nullable', 'string', 'min:6'],
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
    }
}
