<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin_users.index', compact('admins'));
    }

    public function create()
    {
        return view('admin_users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'address' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);

        $validated['payment_method'] = 'cash';
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'admin';

        User::create($validated);
        return redirect()->route('admin_users.index')->with('success', 'Admin created.');
    }

    public function edit(User $admin_user)
    {
        if ($admin_user->role !== 'admin') {
            abort(403);
        }
        return view('admin_users.edit', compact('admin_user'));
    }

    public function update(Request $request, User $admin_user)
    {
        if ($admin_user->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$admin_user->id}",
            'password' => 'nullable|min:6|confirmed',
            'address' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin_user->update($validated);
        return redirect()->route('admin_users.index')->with('success', 'Admin updated.');
    }

    public function destroy(User $admin_user)
    {
        if ($admin_user->role !== 'admin') {
            abort(403);
        }

        $admin_user->delete();
        return redirect()->route('admin_users.index')->with('success', 'Admin deleted.');
    }
}
