<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Helpline;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HelplinesController extends Controller
{
    public function index(Request $request): View
    {
        $query = Helpline::with(['state', 'lga'])->ordered();

        if ($request->filled('state_id'))  $query->where('state_id', $request->state_id);
        if ($request->filled('category'))  $query->where('category', $request->category);

        $helplines  = $query->paginate(25)->withQueryString();
        $states     = State::orderBy('name')->get(['id', 'name']);
        $categories = Helpline::CATEGORIES;

        return view('admin.helplines.index', compact('helplines', 'states', 'categories'));
    }

    public function create(): View
    {
        $states     = State::orderBy('name')->get(['id', 'name']);
        $categories = Helpline::CATEGORIES;

        return view('admin.helplines.create', compact('states', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateHelpline($request);

        Helpline::create([
            ...$validated,
            'is_national' => $request->boolean('is_national'),
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.helplines.index')
            ->with('success', 'Helpline added successfully.');
    }

    public function edit(Helpline $helpline): View
    {
        $states     = State::orderBy('name')->get(['id', 'name']);
        $categories = Helpline::CATEGORIES;
        $lgas       = $helpline->state_id
            ? \App\Models\Lga::where('state_id', $helpline->state_id)->orderBy('name')->get(['id', 'name'])
            : collect();

        return view('admin.helplines.edit', compact('helpline', 'states', 'lgas', 'categories'));
    }

    public function update(Request $request, Helpline $helpline): RedirectResponse
    {
        $validated = $this->validateHelpline($request);

        $helpline->update([
            ...$validated,
            'is_national' => $request->boolean('is_national'),
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.helplines.index')
            ->with('success', 'Helpline updated successfully.');
    }

    public function destroy(Helpline $helpline): RedirectResponse
    {
        $helpline->delete();

        return redirect()->route('admin.helplines.index')
            ->with('success', 'Helpline deleted.');
    }

    private function validateHelpline(Request $request): array
    {
        return $request->validate([
            'agency_name' => ['required', 'string', 'max:255'],
            'phone'       => ['required', 'string', 'max:50'],
            'phone_alt'   => ['nullable', 'string', 'max:50'],
            'category'    => ['required', 'in:' . implode(',', array_keys(Helpline::CATEGORIES))],
            'state_id'    => ['nullable', 'exists:states,id'],
            'lga_id'      => ['nullable', 'exists:lgas,id'],
            'address'     => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:1000'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
