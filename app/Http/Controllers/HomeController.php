<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\State;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Cache homepage stats for 5 minutes
        $stats = Cache::remember('homepage.stats', 300, function () {
            return [
                'total_incidents'      => Incident::approved()->count(),
                'total_casualties'     => Incident::approved()->sum('casualties'),
                'total_kidnapped'      => Incident::approved()->sum('kidnapped_count'),
                'critical_incidents'   => Incident::approved()->where('severity', 'critical')->count(),
                'incidents_this_month' => Incident::approved()
                    ->whereMonth('incident_date', now()->month)
                    ->whereYear('incident_date', now()->year)
                    ->count(),
            ];
        });

        // Latest 6 approved incidents
        $latestIncidents = Cache::remember('homepage.latest_incidents', 120, function () {
            return Incident::with(['state', 'lga'])
                ->approved()
                ->recent()
                ->limit(6)
                ->get();
        });

        // Top 5 most affected states
        $topStates = Cache::remember('homepage.top_states', 600, function () {
            return State::select('states.id', 'states.name', DB::raw('COUNT(incidents.id) as incident_count'))
                ->leftJoin('incidents', function ($join) {
                    $join->on('states.id', '=', 'incidents.state_id')
                         ->where('incidents.status', 'approved')
                         ->whereNull('incidents.deleted_at');
                })
                ->groupBy('states.id', 'states.name')
                ->orderByDesc('incident_count')
                ->limit(5)
                ->get();
        });

        // Incident breakdown by attack type (for stats bar)
        $attackTypeStats = Cache::remember('homepage.attack_types', 600, function () {
            return Incident::approved()
                ->select('attack_type', DB::raw('COUNT(*) as total'))
                ->groupBy('attack_type')
                ->orderByDesc('total')
                ->get()
                ->keyBy('attack_type');
        });

        return view('home', compact(
            'stats',
            'latestIncidents',
            'topStates',
            'attackTypeStats'
        ));
    }
}
