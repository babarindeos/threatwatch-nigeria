<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncidentController extends Controller
{
    /**
     * Public incident listing with filters.
     */
    public function index(Request $request): View
    {
        $filters = $request->only([
            'state_id', 'lga_id', 'attack_type', 'severity',
            'date_from', 'date_to', 'search',
        ]);

        $incidents = Incident::with(['state', 'lga'])
            ->approved()
            ->filter($filters)
            ->recent()
            ->paginate(12)
            ->withQueryString();

        $states = State::orderBy('name')->get(['id', 'name']);

        return view('incidents.index', compact('incidents', 'states', 'filters'));
    }

    /**
     * Show single incident detail.
     */
    public function show(string $slug): View
    {
        $incident = Incident::with([
            'state',
            'lga',
            'creator',
            'approver',
            'comments.user',
            'comments.replies.user',
        ])
        ->where('slug', $slug)
        ->approved()
        ->firstOrFail();

        // Increment view count without triggering events/observers
        Incident::withoutTimestamps(fn () =>
            $incident->increment('views')
        );

        // Related incidents: same state or same attack type
        $related = Incident::with(['state'])
            ->approved()
            ->where('id', '!=', $incident->id)
            ->where(function ($q) use ($incident) {
                $q->where('state_id', $incident->state_id)
                  ->orWhere('attack_type', $incident->attack_type);
            })
            ->recent()
            ->limit(4)
            ->get();

        return view('incidents.show', compact('incident', 'related'));
    }

    /**
     * AJAX endpoint: load LGAs for a state.
     */
    public function getLgas(Request $request)
    {
        $request->validate(['state_id' => 'required|exists:states,id']);

        $lgas = \App\Models\Lga::where('state_id', $request->state_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($lgas);
    }
}
