<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = Report::with(['user', 'state', 'lga'])->latest();

        if ($request->filled('status'))      $query->where('status', $request->status);
        if ($request->filled('state_id'))    $query->where('state_id', $request->state_id);
        if ($request->filled('attack_type')) $query->where('attack_type', $request->attack_type);

        $reports     = $query->paginate(20)->withQueryString();
        $attackTypes = Incident::ATTACK_TYPES;

        return view('admin.reports.index', compact('reports', 'attackTypes'));
    }

    public function show(Report $report): View
    {
        $report->load(['user', 'state', 'lga', 'reviewer']);

        return view('admin.reports.show', compact('report'));
    }

    /**
     * Admin reviews a report (mark as reviewed).
     */
    public function review(Request $request, Report $report): RedirectResponse
    {
        $request->validate([
            'status'      => ['required', 'in:reviewed,approved,rejected'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $report->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Report status updated.');
    }

    /**
     * Convert approved report to a full incident.
     */
    public function convertToIncident(Report $report): RedirectResponse
    {
        $incident = Incident::create([
            'title'           => $report->title,
            'state_id'        => $report->state_id,
            'lga_id'          => $report->lga_id,
            'town'            => $report->town,
            'attack_type'     => $report->attack_type,
            'description'     => $report->description,
            'casualties'      => $report->casualties,
            'kidnapped_count' => $report->kidnapped_count,
            'latitude'        => $report->latitude,
            'longitude'       => $report->longitude,
            'incident_date'   => $report->incident_date,
            'incident_time'   => $report->incident_time,
            'images'          => $report->evidence_files,
            'status'          => 'approved',
            'is_anonymous'    => $report->is_anonymous,
            'created_by'      => auth()->id(),
            'approved_by'     => auth()->id(),
            'approved_at'     => now(),
            'severity'        => 'medium',
        ]);

        $report->update(['status' => 'approved']);

        return redirect()->route('admin.incidents.show', $incident)
            ->with('success', 'Report converted to verified incident successfully.');
    }

    public function destroy(Report $report): RedirectResponse
    {
        $report->delete();

        return redirect()->route('admin.reports.index')
            ->with('success', 'Report deleted.');
    }
}
