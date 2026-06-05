<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HeatmapController extends Controller
{
    /**
     * Heatmap page view.
     */
    public function index(): View
    {
        $states      = State::orderBy('name')->get(['id', 'name']);
        $attackTypes = Incident::ATTACK_TYPES;

        return view('heatmap.index', compact('states', 'attackTypes'));
    }

    /**
     * JSON data for heatmap points (Leaflet HeatLayer).
     */
    public function data(Request $request): JsonResponse
    {
        $request->validate([
            'state_id'    => ['nullable', 'exists:states,id'],
            'attack_type' => ['nullable', 'string'],
            'severity'    => ['nullable', 'in:low,medium,high,critical'],
            'date_from'   => ['nullable', 'date'],
            'date_to'     => ['nullable', 'date'],
            'days'        => ['nullable', 'integer', 'min:1', 'max:3650'],
        ]);

        $cacheKey = 'heatmap.data.' . md5(serialize($request->all()));

        $data = Cache::remember($cacheKey, 300, function () use ($request) {
            $query = Incident::forHeatmap();

            if ($request->filled('state_id')) {
                $query->where('state_id', $request->state_id);
            }
            if ($request->filled('attack_type')) {
                $query->where('attack_type', $request->attack_type);
            }
            if ($request->filled('severity')) {
                $query->where('severity', $request->severity);
            }
            if ($request->filled('date_from')) {
                $query->whereDate('incident_date', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->whereDate('incident_date', '<=', $request->date_to);
            }
            if ($request->filled('days')) {
                $query->whereDate('incident_date', '>=', now()->subDays($request->days)->toDateString());
            }

            return $query->get()->map(function ($incident) {
                // Weight based on severity + casualties
                $severityWeight = match ($incident->severity) {
                    'critical' => 1.0,
                    'high'     => 0.75,
                    'medium'   => 0.5,
                    default    => 0.25,
                };

                $casualtyBoost = min($incident->casualties / 100, 0.5);
                $weight        = min($severityWeight + $casualtyBoost, 1.0);

                return [
                    'lat'         => (float) $incident->latitude,
                    'lng'         => (float) $incident->longitude,
                    'weight'      => $weight,
                    'id'          => $incident->id,
                    'title'       => $incident->title,
                    'attack_type' => $incident->attack_type,
                    'severity'    => $incident->severity,
                    'date'        => $incident->incident_date?->format('d M Y'),
                    'casualties'  => $incident->casualties,
                ];
            });
        });

        return response()->json($data);
    }

    /**
     * State-level statistics for choropleth overlay.
     */
    public function stateStats(Request $request): JsonResponse
    {
        $stats = Cache::remember('heatmap.state_stats', 600, function () {
            return State::select([
                    'states.id',
                    'states.name',
                    'states.latitude',
                    'states.longitude',
                    DB::raw('COUNT(incidents.id) as total'),
                    DB::raw('SUM(CASE WHEN incidents.severity = \'critical\' THEN 1 ELSE 0 END) as critical_count'),
                    DB::raw('SUM(COALESCE(incidents.casualties, 0)) as total_casualties'),
                    DB::raw('SUM(COALESCE(incidents.kidnapped_count, 0)) as total_kidnapped'),
                ])
                ->leftJoin('incidents', function ($join) {
                    $join->on('states.id', '=', 'incidents.state_id')
                         ->where('incidents.status', 'approved')
                         ->whereNull('incidents.deleted_at');
                })
                ->groupBy('states.id', 'states.name', 'states.latitude', 'states.longitude')
                ->get();
        });

        return response()->json($stats);
    }
}
