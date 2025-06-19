<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        // Admin: show all customers
        if ($user->role === 'admin') {
            $users = \App\Models\User::where('role', 'customer')
                ->when($search, function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->get();
        }
        // Manager: only customers from the same region
        elseif ($user->role === 'manager') {
            $users = \App\Models\User::where('role', 'customer')
                ->where('region', $user->region)
                ->when($search, function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->get();
        }
        // Unauthorized for others
        else {
            abort(403, 'Unauthorized');
        }

        return view('user.index', compact('users', 'search'));
    }




    // Show user profile
    public function showProfile($id)
    {
        $user = User::findOrFail($id);
        $cars = $user->cars;  // This will now use created_by_id automatically
// get all cars related to this user
        return view('profile', compact('user', 'cars'));
    }

    // Update user profile (only self)
    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Make sure logged-in user can only update their own profile
        if (Auth::id() !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // Validation rules
        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'payment_method' => ['nullable', Rule::in(['visa_card', 'cash', 'bnpl'])],
            'region' => ['required', Rule::in(['Beirut', 'Mount Lebanon', 'North Lebanon', 'South Lebanon', 'Bekaa', 'Nabatieh'])],
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($user->profile_picture && Storage::exists($user->profile_picture)) {
                Storage::delete($user->profile_picture);
            }
            // Store new picture and save path
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Update other fields
        $user->name = $validated['name'];
        $user->address = $validated['address'] ?? $user->address;
        $user->payment_method = $validated['payment_method'] ?? $user->payment_method;
        $user->region = $validated['region'];

        $user->save();

        return redirect()->route('user.update', $user->id)->with('success', 'Profile updated successfully.');
    }
    public function report(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $reportedUser = User::findOrFail($id);

        // Save to a reports table (you need to create this model and migration)
        \App\Models\Report::create([
            'reporter_id' => auth()->id(),
            'reported_user_id' => $reportedUser->id,
            'reason' => $request->reason,
        ]);

        return redirect()->back()->with('status', 'Your report has been submitted.');
    }
    public function mostReportedUsers()
    {
        $user = Auth::user();

        // Base query: join users and reports, group by reported_user_id
        $query = \App\Models\Report::query()
            ->selectRaw('reported_user_id, COUNT(*) as reports_count')
            ->groupBy('reported_user_id');

        // Manager: only users from the same region
        if ($user->role === 'manager') {
            $query->whereHas('reportedUser', function ($q) use ($user) {
                $q->where('region', $user->region);
            });
        } elseif ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $reportedStats = $query->orderByDesc('reports_count')->get();

        // Get user info for each reported user
        $userIds = $reportedStats->pluck('reported_user_id');
        $users = \App\Models\User::whereIn('id', $userIds)->get()->keyBy('id');

        // Combine stats and user info
        $mostReported = $reportedStats->map(function ($stat) use ($users) {
            $user = $users[$stat->reported_user_id] ?? null;
            return [
                'user' => $user,
                'reports_count' => $stat->reports_count,
            ];
        })->filter(function ($item) {
            return $item['user'] !== null;
        });

        return view('user.most_reported', compact('mostReported'));
    }

}
