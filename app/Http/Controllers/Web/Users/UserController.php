<?php

namespace App\Http\Controllers\Web\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = \App\Models\Role::orderBy('name')->get();
        $studyPrograms = \App\Models\StudyProgram::with('faculty')->orderBy('name')->get();
        $units = \App\Models\Unit::orderBy('name')->get();
        $users = User::with(['profile.studyProgram.faculty', 'profile.unit', 'roles'])->get();
        return view('users.index', compact('users', 'roles', 'studyPrograms', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'full_name' => 'required|string|max:255',
            'identifier_number' => 'nullable|string|max:50',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'unit_id' => 'nullable|exists:units,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'is_active' => true,
        ]);

        $user->profile()->create([
            'full_name' => $validated['full_name'],
            'identifier_number' => $validated['identifier_number'],
            'study_program_id' => $validated['study_program_id'] ?? null,
            'unit_id' => $validated['unit_id'] ?? null,
        ]);

        if (!empty($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        }

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }



    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'identifier_number' => 'nullable|string|max:50',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'unit_id' => 'nullable|exists:units,id',
            'is_active' => 'boolean',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user->update([
            'is_active' => $request->has('is_active'),
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => $validated['full_name'],
                'identifier_number' => $validated['identifier_number'] ?? null,
                'study_program_id' => $validated['study_program_id'] ?? null,
                'unit_id' => $validated['unit_id'] ?? null,
            ]
        );

        $user->roles()->sync($validated['roles'] ?? []);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }
}
