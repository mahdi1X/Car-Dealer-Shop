<?php

namespace App\Http\Controllers;

use App\Models\AdminReport;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReportController extends Controller
{
    public function show($id)
    {
        $adminReport = AdminReport::with(['report.reportedUser', 'report.reporterUser', 'manager'])->findOrFail($id);

        return view('admin_reports.show', compact('adminReport'));
    }


    public function store(Request $request, Report $report)
    {
        $request->validate([
            'note' => 'required|string|max:2000',
        ]);

        $manager = Auth::user();

        AdminReport::create([
            'report_id' => $report->id,
            'manager_id' => $manager->id,
            'manager_note' => $request->note, // correct this
        ]);

        // Optionally, you can mark the original report as forwarded
        $report->to_admin = true;
        $report->save();

        return redirect()->back()->with('success', 'Report submitted to admin successfully.');
    }
}
