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
        $users = User::with(['profile', 'roles'])->paginate(10);
        return view('users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'full_name' => 'required|string|max:255',
            'identifier_number' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
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
            'department' => $validated['department'],
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
            'department' => 'nullable|string|max:255',
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
                'department' => $validated['department'] ?? null,
            ]
        );

        $user->roles()->sync($validated['roles'] ?? []);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }
}
