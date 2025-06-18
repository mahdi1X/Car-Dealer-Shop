<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Add this at the top of the controller
    private function isSuperAdmin()
    {
        return auth()->check() && auth()->user()->role === 'admin' || auth()->user()->role == 'manager';
        ; // or check another condition
    }

    public function index()
    {
        if (!$this->isSuperAdmin()) {
            abort(403);
        }

        $users = User::whereIn('role', ['admin', 'manager'])->get();
        return view('admin_users.index', compact('users'));
    }


    public function create()
    {
        return view('admin_users.create');
    }

    public function store(Request $request)
    {


        if (!$this->isSuperAdmin()) {
            abort(403, 'Only the super admin can create users.');
        }

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'address' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'role' => 'required|in:admin,manager', // allow role assignment
            'region' => 'nullable|string',
            'managed_by' => 'nullable|exists:users,id',
        ]);

        $validated['payment_method'] = $validated['payment_method'] ?? 'cash';
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin_users.index')->with('success', 'User created.');
    }


    public function edit(User $admin_user)
    {
        if (!$this->isSuperAdmin()) {
            abort(403);
        }

        return view('admin_users.edit', compact('admin_user'));
    }

    public function update(Request $request, User $admin_user)
    {
        if (!$this->isSuperAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$admin_user->id}",
            'password' => 'nullable|min:6|confirmed',
            'address' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'role' => 'optional|in:admin,manager',
            'region' => 'nullable|string',
            'managed_by' => 'nullable|exists:users,id',
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin_user->update($validated);

        return redirect()->route('admin_users.index')->with('success', 'User updated.');
    }
    public function destroy(User $admin_user)
    {
        if (!$this->isSuperAdmin()) {
            abort(403);
        }

        $admin_user->delete();
        return redirect()->route('admin_users.index')->with('success', 'User deleted.');
    }

}
