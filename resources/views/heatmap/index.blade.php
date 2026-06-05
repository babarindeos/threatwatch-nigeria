{{-- resources/views/heatmap/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Nigeria Security Heatmap — ThreatWatch Nigeria')
@section('meta_description', 'Interactive security incident heatmap showing attack hotspots across all 36 states of Nigeria.')

@section('content')

{{-- Full-page layout: filter sidebar + map --}}
<div class="flex flex-col lg:flex-row h-[calc(100vh-64px)]">

    {{-- ================================================================
         FILTER PANEL
         ================================================================ --}}
    <div class="w-full lg:w-72 xl:w-80 bg-white border-b lg:border-b-0 lg:border-r border-gray-100
                flex flex-col overflow-y-auto z-10 flex-shrink-0 shadow-sm"
         x-data="{ collapsed: false }">

        {{-- Panel header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <h2 class="font-display font-bold text-gray-900 text-base">Security Heatmap</h2>
                <p class="text-xs text-gray-400 mt-0.5">Nigeria — All 36 States + FCT</p>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-ng-green rounded-full pulse-live inline-block"></span>
                <span class="text-xs text-ng-green font-semibold">Live</span>
            </div>
        </div>

        {{-- Incident counter --}}
        <div class="px-5 py-3 bg-ng-muted border-b border-ng-green/10">
            <div class="flex items-center justify-between">
                <span class="text-xs text-gray-600 font-medium">Incidents plotted</span>
                <span id="incident-count" class="font-display font-bold text-ng-green text-lg">—</span>
            </div>
        </div>

        {{-- Filters --}}
        <div class="px-5 py-4 space-y-4 flex-1">

            {{-- State filter --}}
            <div>
                <label class="form-label text-xs">Filter by State</label>
                <select id="filter-state" class="form-input text-xs py-2">
                    <option value="">All States</option>
                    @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Attack Type --}}
            <div>
                <label class="form-label text-xs">Attack Type</label>
                <select id="filter-type" class="form-input text-xs py-2">
                    <option value="">All Types</option>
                    @foreach($attackTypes as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Severity --}}
            <div>
                <label class="form-label text-xs">Severity</label>
                <select id="filter-severity" class="form-input text-xs py-2">
                    <option value="">All Levels</option>
                    <option value="critical">🔴 Critical</option>
                    <option value="high">🟠 High</option>
                    <option value="medium">🟡 Medium</option>
                    <option value="low">🟢 Low</option>
                </select>
            </div>

            {{-- Date range --}}
            <div>
                <label class="form-label text-xs">Time Period</label>
                <select id="filter-days" class="form-input text-xs py-2">
                    <option value="">All Time</option>
                    <option value="7">Last 7 days</option>
                    <option value="30">Last 30 days</option>
                    <option value="90">Last 3 months</option>
                    <option value="180">Last 6 months</option>
                    <option value="365">Last year</option>
                </select>
            </div>

            {{-- Map style toggle --}}
            <div>
                <label class="form-label text-xs">Display Mode</label>
                <div class="grid grid-cols-2 gap-2">
                    <button id="btn-heatmap" onclick="setMode('heatmap')"
                            class="text-xs font-semibold py-2 px-3 rounded-xl border transition-all
                                   bg-ng-green text-white border-ng-green">
                        🔥 Heatmap
                    </button>
                    <button id="btn-markers" onclick="setMode('markers')"
                            class="text-xs font-semibold py-2 px-3 rounded-xl border transition-all
                                   bg-white text-gray-600 border-gray-200 hover:border-ng-green hover:text-ng-green">
                        📍 Markers
                    </button>
                </div>
            </div>

            {{-- Apply --}}
            <button onclick="applyFilters()"
                    class="btn-primary w-full">
                Apply Filters
            </button>

            {{-- Reset --}}
            <button onclick="resetFilters()"
                    class="w-full text-xs font-semibold text-gray-500 hover:text-ng-green
                           border border-gray-200 rounded-xl py-2 transition-colors hover:border-ng-green">
                Reset
            </button>
        </div>

        {{-- Legend --}}
        <div class="px-5 py-4 border-t border-gray-100">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Severity Legend</p>
            <div class="space-y-2">
                @foreach(['critical'=>['🔴','Critical','#ef4444'], 'high'=>['🟠','High','#f97316'], 'medium'=>['🟡','Medium','#f59e0b'], 'low'=>['🟢','Low','#22c55e']] as $level => $info)
                <div class="flex items-center gap-2.5">
                    <div class="w-3 h-3 rounded-full flex-shrink-0" style="background:{{ $info[2] }}"></div>
                    <span class="text-xs text-gray-600 font-medium">{{ $info[1] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ================================================================
         MAP CONTAINER
         ================================================================ --}}
    <div class="flex-1 relative">
        <div id="nigeria-heatmap" class="w-full h-full"></div>

        {{-- Map loading overlay --}}
        <div id="map-loading"
             class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm flex items-center justify-center z-20">
            <div class="text-center text-white">
                <div class="w-12 h-12 border-4 border-ng-green border-t-transparent rounded-full
                            animate-spin mx-auto mb-3"></div>
                <p class="font-display font-bold text-sm">Loading incident data...</p>
            </div>
        </div>

        {{-- Incident popup (floating) --}}
        <div id="incident-popup"
             class="absolute bottom-6 left-1/2 -translate-x-1/2 hidden bg-white rounded-2xl shadow-2xl
                    border border-gray-100 p-4 w-80 z-30 transition-all">
            <button onclick="document.getElementById('incident-popup').classList.add('hidden')"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div id="popup-content"></div>
        </div>

        {{-- Stats overlay top-right --}}
        <div class="absolute top-4 right-4 z-10 space-y-2">
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-sm border border-gray-100 px-3 py-2">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total on map</p>
                <p id="overlay-count" class="font-display font-bold text-lg text-ng-green">—</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('head_styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
    #nigeria-heatmap { background: #1a1a2e; }
    .leaflet-popup-content-wrapper { border-radius: 12px !important; }
    .incident-marker { cursor: pointer; }
    .incident-marker:hover { transform: scale(1.3); }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>
<script>
// ================================================================
// ThreatWatch Heatmap Controller
// ================================================================
let map, heatLayer, markersLayer;
let currentMode  = 'heatmap';
let currentData  = [];

// Nigeria bounds
const NIGERIA_CENTER = [9.0820, 8.6753];
const NIGERIA_ZOOM   = 6;

// Boot map
document.addEventListener('DOMContentLoaded', function () {
    map = L.map('nigeria-heatmap', {
        center: NIGERIA_CENTER,
        zoom:   NIGERIA_ZOOM,
        zoomControl: true,
        minZoom: 5,
        maxZoom: 15,
    });

    // Dark tiles
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap © CARTO',
        subdomains: 'abcd',
        maxZoom: 19,
    }).addTo(map);

    markersLayer = L.layerGroup().addTo(map);

    applyFilters();
});

function applyFilters() {
    const params = new URLSearchParams();
    const state    = document.getElementById('filter-state').value;
    const type     = document.getElementById('filter-type').value;
    const severity = document.getElementById('filter-severity').value;
    const days     = document.getElementById('filter-days').value;

    if (state)    params.set('state_id',    state);
    if (type)     params.set('attack_type', type);
    if (severity) params.set('severity',    severity);
    if (days)     params.set('days',        days);

    document.getElementById('map-loading').classList.remove('hidden');

    fetch(`{{ route('api.heatmap.data') }}?${params.toString()}`)
        .then(r => r.json())
        .then(data => {
            currentData = data;
            renderMap(data);
            document.getElementById('incident-count').textContent = data.length.toLocaleString();
            document.getElementById('overlay-count').textContent  = data.length.toLocaleString();
            document.getElementById('map-loading').classList.add('hidden');
        })
        .catch(() => {
            document.getElementById('map-loading').classList.add('hidden');
        });
}

function renderMap(data) {
    // Clear existing layers
    if (heatLayer) map.removeLayer(heatLayer);
    markersLayer.clearLayers();

    if (currentMode === 'heatmap') {
        renderHeatLayer(data);
    } else {
        renderMarkers(data);
    }
}

function renderHeatLayer(data) {
    const points = data.map(d => [d.lat, d.lng, d.weight]);

    heatLayer = L.heatLayer(points, {
        radius:    28,
        blur:      20,
        maxZoom:   13,
        max:       1.0,
        gradient: {
            0.0: '#22c55e',
            0.3: '#f59e0b',
            0.6: '#f97316',
            0.8: '#ef4444',
            1.0: '#7f1d1d',
        }
    }).addTo(map);
}

function renderMarkers(data) {
    const colors = {
        critical: '#ef4444',
        high:     '#f97316',
        medium:   '#f59e0b',
        low:      '#22c55e',
    };

    data.forEach(function(inc) {
        const color  = colors[inc.severity] || '#009A44';
        const radius = inc.severity === 'critical' ? 10 : inc.severity === 'high' ? 8 : 6;

        const marker = L.circleMarker([inc.lat, inc.lng], {
            radius,
            fillColor:   color,
            color:       'white',
            weight:      1.5,
            opacity:     1,
            fillOpacity: 0.9,
            className:   'incident-marker',
        });

        marker.on('click', function () {
            showPopup(inc);
        });

        marker.addTo(markersLayer);
    });
}

function showPopup(inc) {
    const typeLabels = @json(\App\Models\Incident::ATTACK_TYPES);
    const typeLabel  = typeLabels[inc.attack_type] || inc.attack_type;
    const badgeColor = {
        critical: 'bg-red-100 text-red-800',
        high:     'bg-orange-100 text-orange-800',
        medium:   'bg-amber-100 text-amber-800',
        low:      'bg-green-100 text-green-800',
    }[inc.severity] || 'bg-gray-100 text-gray-800';

    document.getElementById('popup-content').innerHTML = `
        <div class="flex items-center gap-2 mb-2">
            <span class="text-xs font-bold px-2 py-0.5 rounded-lg ${badgeColor}">${inc.severity.toUpperCase()}</span>
            <span class="text-xs text-gray-500 font-medium">${typeLabel}</span>
        </div>
        <p class="font-display font-bold text-sm text-gray-900 mb-2 leading-snug">${inc.title}</p>
        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
            <span>📅 ${inc.date || 'Unknown date'}</span>
            ${inc.casualties > 0 ? `<span class="text-red-600 font-bold">💔 ${inc.casualties} killed</span>` : ''}
        </div>
        <a href="/incidents/${inc.id}" target="_blank"
           class="block text-center bg-ng-green hover:bg-ng-dark text-white text-xs font-bold
                  py-2 px-4 rounded-xl transition-colors">
            View Full Report →
        </a>
    `;

    document.getElementById('incident-popup').classList.remove('hidden');
}

function setMode(mode) {
    currentMode = mode;

    if (mode === 'heatmap') {
        document.getElementById('btn-heatmap').className =
            'text-xs font-semibold py-2 px-3 rounded-xl border transition-all bg-ng-green text-white border-ng-green';
        document.getElementById('btn-markers').className =
            'text-xs font-semibold py-2 px-3 rounded-xl border transition-all bg-white text-gray-600 border-gray-200 hover:border-ng-green hover:text-ng-green';
    } else {
        document.getElementById('btn-markers').className =
            'text-xs font-semibold py-2 px-3 rounded-xl border transition-all bg-ng-green text-white border-ng-green';
        document.getElementById('btn-heatmap').className =
            'text-xs font-semibold py-2 px-3 rounded-xl border transition-all bg-white text-gray-600 border-gray-200 hover:border-ng-green hover:text-ng-green';
    }

    renderMap(currentData);
}

function resetFilters() {
    document.getElementById('filter-state').value    = '';
    document.getElementById('filter-type').value     = '';
    document.getElementById('filter-severity').value = '';
    document.getElementById('filter-days').value     = '';
    applyFilters();
}

// Close popup on map click
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        map.on('click', function() {
            document.getElementById('incident-popup').classList.add('hidden');
        });
    }, 1000);
});
</script>
@endpush
