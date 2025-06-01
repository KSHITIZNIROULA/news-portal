<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class AdminPublisherController extends Controller
{
    public function index()
    {
        $publishers = User::role('publisher')
            ->with('roles')
            ->paginate(10);
        return view('admin.publisherIndex', compact('publishers'));
    }

    public function create()
    {
        $roles = Role::all()->pluck('name', 'name'); // For role dropdown
        return view('admin.publisherCreate', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:publisher'], // Restrict to 'publisher' role
        ]);

        $publisher = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $publisher->assignRole($request->role);

        return redirect()->route('admin.publishers.index')->with('success', 'Publisher created successfully.');
    }

    public function edit(User $user)
    {
        if (!$user->hasRole('publisher')) {
            abort(403, 'Unauthorized action.');
        }
        $roles = Role::all()->pluck('name', 'name');
        return view('admin.publisherEdit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if (!$user->hasRole('publisher')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:publisher'],
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);
        $user->syncRoles($request->role);

        return redirect()->route('admin.publishers.index')->with('success', 'Publisher updated successfully.');
    }

    public function destroy(User $user)
    {
        if (!$user->hasRole('publisher')) {
            abort(403, 'Unauthorized action.');
        }

        $user->delete();
        return redirect()->route('admin.publishers.index')->with('success', 'Publisher deleted successfully.');
    }
}