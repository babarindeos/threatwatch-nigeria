<?php

namespace App\Http\Controllers;

use App\Models\Helpline;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HelplinesController extends Controller
{
    public function index(Request $request): View
    {
        $states   = State::orderBy('name')->get(['id', 'name']);
        $categories = Helpline::CATEGORIES;

        // National helplines always show first
        $nationalHelplines = Helpline::active()
            ->national()
            ->ordered()
            ->get();

        // State-specific query
        $stateHelplines = collect();
        //dd($stateHelplines);
        $selectedState  = null;

        if ($request->filled('state_id')) {
            $selectedState = State::find($request->state_id);

            $query = Helpline::active()
                ->where('state_id', $request->state_id)
                ->ordered();

            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            $stateHelplines = $query->get();
        }
        

        return view('helplines.index', compact(
            'states', 'categories',
            'nationalHelplines', 'stateHelplines',
            'selectedState'
        ));
    }
}
