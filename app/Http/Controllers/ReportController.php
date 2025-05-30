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
            'reported_user_id' => $validated['reported_user_id'],
            'reporter_user_id' => $reporterUserId,
            'reason' => $validated['reason'],
            'to_admin' => $request->has('to_admin'), // detect admin report
        ]);


        return redirect()->route('user.profile', ['id' => $validated['reported_user_id']])
            ->with('success', 'User report submitted successfully.');

    }
    public function index()
    {
        $user = Auth::user();

        // For Manager: show reports by region
        if ($user->role === 'manager') {
            $reports = Report::whereHas('reportedUser', function ($query) use ($user) {
                $query->where('region', $user->region);
            })->with(['reportedUser', 'reporterUser'])->get();

            return view('reports.index', compact('reports'));
        }

        // For Admin: show reports that have been submitted to admin
        if ($user->role === 'admin') {
            $reports = \App\Models\AdminReport::with(['report.reportedUser', 'report.reporterUser', 'manager'])->get();

            return view('admin_reports.index', compact('reports'));
        }

        // Default: deny access
        abort(403, 'Unauthorized');
    }

    public function show($id)
    {
        $report = Report::with(['reportedUser', 'reporterUser'])->findOrFail($id);
        $user = Auth::user();

        // Allow admins unconditionally
        if ($user->role === 'admin') {
            return view('reports.show', compact('report'));
        }

        // Allow managers only if region matches
        if ($user->role === 'manager' && $user->region === $report->reportedUser->region) {
            return view('reports.show', compact('report'));
        }

        // Deny all others
        abort(403, 'Unauthorized');
    }







}

