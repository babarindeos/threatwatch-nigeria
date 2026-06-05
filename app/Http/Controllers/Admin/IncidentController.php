<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Lga;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class IncidentController extends Controller
{
    /**
     * List all incidents with filters.
     */
    public function index(Request $request): View
    {
        $query = Incident::with(['state', 'lga', 'creator'])->latest();

        if ($request->filled('status'))      $query->where('status', $request->status);
        if ($request->filled('severity'))    $query->where('severity', $request->severity);
        if ($request->filled('attack_type')) $query->where('attack_type', $request->attack_type);
        if ($request->filled('state_id'))    $query->where('state_id', $request->state_id);
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(fn ($q) =>
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('town', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
            );
        }

        $incidents   = $query->paginate(20)->withQueryString();
        $states      = State::orderBy('name')->get(['id', 'name']);
        $attackTypes = Incident::ATTACK_TYPES;

        return view('admin.incidents.index', compact('incidents', 'states', 'attackTypes'));
    }

    /**
     * Show create form.
     */
    public function create(): View
    {
        $states      = State::orderBy('name')->get(['id', 'name']);
        $attackTypes = Incident::ATTACK_TYPES;
        $severities  = Incident::SEVERITIES;

        return view('admin.incidents.create', compact('states', 'attackTypes', 'severities'));
    }

    /**
     * Store a new incident.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateIncident($request);

        $imagePaths = $this->handleImageUpload($request);

        $incident = Incident::create([
            ...$validated,
            'created_by'  => auth()->id(),
            'images'      => $imagePaths ?: null,
            'status'      => 'approved',   // Admin-created = auto approved
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        Cache::flush();

        return redirect()->route('admin.incidents.show', $incident)
            ->with('success', 'Incident created successfully.');
    }

    /**
     * Show single incident detail.
     */
    public function show(Incident $incident): View
    {
        $incident->load([
            'state', 'lga', 'creator', 'approver',
            'allComments.user', 'allComments.replies.user',
        ]);

        return view('admin.incidents.show', compact('incident'));
    }

    /**
     * Show edit form.
     */
    public function edit(Incident $incident): View
    {
        $states      = State::orderBy('name')->get(['id', 'name']);
        $lgas        = $incident->state_id
            ? Lga::where('state_id', $incident->state_id)->orderBy('name')->get(['id', 'name'])
            : collect();
        $attackTypes = Incident::ATTACK_TYPES;
        $severities  = Incident::SEVERITIES;

        return view('admin.incidents.edit', compact('incident', 'states', 'lgas', 'attackTypes', 'severities'));
    }

    /**
     * Update incident.
     */
    public function update(Request $request, Incident $incident): RedirectResponse
    {
        $validated = $this->validateIncident($request, $incident->id);

        $imagePaths = $this->handleImageUpload($request);

        if ($imagePaths) {
            // Delete old images
            if ($incident->images) {
                foreach ($incident->images as $oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $validated['images'] = $imagePaths;
        }

        $incident->update($validated);

        Cache::flush();

        return redirect()->route('admin.incidents.show', $incident)
            ->with('success', 'Incident updated successfully.');
    }

    /**
     * Approve an incident.
     */
    public function approve(Incident $incident): RedirectResponse
    {
        $incident->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        Cache::flush();

        return back()->with('success', 'Incident approved and is now publicly visible.');
    }

    /**
     * Reject an incident.
     */
    public function reject(Request $request, Incident $incident): RedirectResponse
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        $incident->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        Cache::flush();

        return back()->with('success', 'Incident rejected.');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Incident $incident): RedirectResponse
    {
        $incident->update(['is_featured' => ! $incident->is_featured]);
        Cache::flush();

        return back()->with('success', $incident->is_featured
            ? 'Incident marked as featured.'
            : 'Incident removed from featured.');
    }

    /**
     * Soft delete.
     */
    public function destroy(Incident $incident): RedirectResponse
    {
        // Delete images from storage
        if ($incident->images) {
            foreach ($incident->images as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $incident->delete();
        Cache::flush();

        return redirect()->route('admin.incidents.index')
            ->with('success', 'Incident deleted.');
    }

    // ----------------------------------------------------------------
    // Private helpers
    // ----------------------------------------------------------------

    private function validateIncident(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title'           => ['required', 'string', 'min:10', 'max:255'],
            'state_id'        => ['required', 'exists:states,id'],
            'lga_id'          => ['nullable', 'exists:lgas,id'],
            'town'            => ['nullable', 'string', 'max:200'],
            'attack_type'     => ['required', 'in:' . implode(',', array_keys(Incident::ATTACK_TYPES))],
            'severity'        => ['required', 'in:' . implode(',', Incident::SEVERITIES)],
            'description'     => ['required', 'string', 'min:30'],
            'casualties'      => ['nullable', 'integer', 'min:0'],
            'kidnapped_count' => ['nullable', 'integer', 'min:0'],
            'incident_date'   => ['required', 'date'],
            'incident_time'   => ['nullable', 'date_format:H:i'],
            'latitude'        => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'       => ['nullable', 'numeric', 'between:-180,180'],
            'source_url'      => ['nullable', 'url', 'max:500'],
            'is_featured'     => ['boolean'],
            'is_anonymous'    => ['boolean'],
        ]);
    }

    private function handleImageUpload(Request $request): array
    {
        $paths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('incidents/images', 'public');
            }
        }

        return $paths;
    }
}
