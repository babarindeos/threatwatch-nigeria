<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\Report;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = Cache::remember('admin.stats', 180, function () {
            return [
                'total_incidents'      => Incident::count(),
                'pending_incidents'    => Incident::pending()->count(),
                'approved_incidents'   => Incident::approved()->count(),
                'total_users'          => User::where('role', 'user')->count(),
                'pending_reports'      => Report::pending()->count(),
                'total_comments'       => Comment::count(),
                'pending_comments'     => Comment::pending()->count(),
                'total_casualties'     => Incident::approved()->sum('casualties'),
                'total_kidnapped'      => Incident::approved()->sum('kidnapped_count'),
                'incidents_today'      => Incident::whereDate('created_at', today())->count(),
                'incidents_this_month' => Incident::whereMonth('incident_date', now()->month)
                                            ->whereYear('incident_date', now()->year)
                                            ->count(),
            ];
        });

        // Most affected states
        $topStates = Cache::remember('admin.top_states', 300, function () {
            return State::withCount(['incidents' => fn ($q) => $q->approved()])
                ->orderByDesc('incidents_count')
                ->limit(8)
                ->get();
        });

        // Incidents by attack type (donut chart data)
        $byAttackType = Cache::remember('admin.by_attack_type', 300, function () {
            return Incident::approved()
                ->select('attack_type', DB::raw('COUNT(*) as total'))
                ->groupBy('attack_type')
                ->orderByDesc('total')
                ->get();
        });

        // Incidents by severity
        $bySeverity = Cache::remember('admin.by_severity', 300, function () {
            return Incident::select('severity', DB::raw('COUNT(*) as total'))
                ->groupBy('severity')
                ->get()
                ->pluck('total', 'severity');
        });

        // Monthly trend — last 12 months
        $monthlyTrend = Cache::remember('admin.monthly_trend', 600, function () {
            return Incident::select(
                    DB::raw('DATE_FORMAT(incident_date, "%Y-%m") as month'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereDate('incident_date', '>=', now()->subMonths(12)->startOfMonth())
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        });

        // Recent incidents
        $recentIncidents = Incident::with(['state', 'creator'])
            ->latest()
            ->limit(8)
            ->get();

        // Recent users
        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'topStates', 'byAttackType', 'bySeverity',
            'monthlyTrend', 'recentIncidents', 'recentUsers'
        ));
    }
}
