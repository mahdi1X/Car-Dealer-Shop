<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class ReportController extends Controller
{
    public function create(User $user)
    {
        return view('reports.create', ['reportedUser' => $user]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reported_user_id' => 'required|exists:users,id',
            'reason' => 'required|string|max:2000',
        ]);

        $reporterUserId = auth()->id();
        $reportedUserId = $validated['reported_user_id'];

        // Check if the report already exists
        $alreadyReported = Report::where('reporter_user_id', $reporterUserId)
            ->where('reported_user_id', $reportedUserId)
            ->exists();

        if ($alreadyReported) {
            return back()->with('error', 'You have already reported this user.');
        }

        // Create report if not exists
        Report::create([
            'reported_user_id' => $reportedUserId,
            'reporter_user_id' => $reporterUserId,
            'reason' => $validated['reason'],
        ]);

        return redirect()->route('user.profile', ['id' => $validated['reported_user_id']])
            ->with('success', 'User report submitted successfully.');

    }

}

