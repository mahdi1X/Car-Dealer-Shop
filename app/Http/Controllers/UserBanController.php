<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserBanController extends Controller
{
    public function ban(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string',
            'duration' => 'nullable|numeric|min:1',
        ]);

        $user = User::findOrFail($id);

        $user->ban_reason = $request->reason;

        if ($request->filled('duration')) {
            // Temporary ban
            $user->banned_until = now()->addDays((int) $request->duration);
        } else {
            // Permanent ban
            $user->banned_until = null;
        }

        $user->is_banned = true; // ✅ Set is_banned flag
        $user->save();

        return back()->with('success', 'User has been banned.');
    }



    public function unban($id)
    {
        $user = User::findOrFail($id);

        $user->is_banned = false;
        $user->banned_until = null;
        $user->ban_reason = null;
        $user->save();

        return back()->with('success', 'User has been unbanned.');
    }

}
