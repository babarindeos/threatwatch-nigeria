<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Report;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['create', 'store']);
    }

    /**
     * Show the report submission form.
     */
    public function create(): View
    {
        $states = State::orderBy('name')->get(['id', 'name']);

        return view('reports.create', compact('states'));
    }

    /**
     * Store a user-submitted threat report.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'           => ['required', 'string', 'min:10', 'max:255'],
            'state_id'        => ['required', 'exists:states,id'],
            'lga_id'          => ['nullable', 'exists:lgas,id'],
            'town'            => ['nullable', 'string', 'max:200'],
            'attack_type'     => ['required', 'in:' . implode(',', array_keys(Incident::ATTACK_TYPES))],
            'description'     => ['required', 'string', 'min:30', 'max:5000'],
            'casualties'      => ['nullable', 'integer', 'min:0', 'max:99999'],
            'kidnapped_count' => ['nullable', 'integer', 'min:0', 'max:99999'],
            'incident_date'   => ['required', 'date', 'before_or_equal:today'],
            'incident_time'   => ['nullable', 'date_format:H:i'],
            'latitude'        => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'       => ['nullable', 'numeric', 'between:-180,180'],
            'is_anonymous'    => ['boolean'],
            'reporter_name'   => ['nullable', 'string', 'max:150'],
            'reporter_phone'  => ['nullable', 'string', 'max:20'],
            'evidence_files'  => ['nullable', 'array', 'max:5'],
            'evidence_files.*'=> ['file', 'mimes:jpg,jpeg,png,pdf,mp4', 'max:10240'],
        ]);

        // Handle file uploads
        $filePaths = [];
        if ($request->hasFile('evidence_files')) {
            foreach ($request->file('evidence_files') as $file) {
                $filePaths[] = $file->store('reports/evidence', 'public');
            }
        }

        Report::create([
            ...$validated,
            'user_id'        => auth()->id(),
            'evidence_files' => $filePaths ?: null,
            'is_anonymous'   => $request->boolean('is_anonymous'),
            'casualties'     => $validated['casualties'] ?? 0,
            'kidnapped_count'=> $validated['kidnapped_count'] ?? 0,
            'status'         => 'pending',
        ]);

        return redirect()->route('reports.my')
            ->with('success', 'Your report has been submitted and is awaiting review. Thank you for keeping Nigeria safe!');
    }

    /**
     * Show the authenticated user's submitted reports.
     */
    public function myReports(): View
    {
        $reports = Report::where('user_id', auth()->id())
            ->with(['state', 'lga'])
            ->latest()
            ->paginate(10);

        return view('reports.my', compact('reports'));
    }
}
