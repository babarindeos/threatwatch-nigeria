{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_breadcrumb', 'Welcome back, ' . auth()->user()->firstname . ' · ' . now()->format('l, d F Y'))

@section('content')

{{-- ================================================================
     TOP STAT CARDS
     ================================================================ --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">

    @foreach([
        ['label'=>'Total Incidents',   'value'=>number_format($stats['total_incidents']),      'color'=>'text-gray-900',    'bg'=>'bg-gray-50',    'icon'=>'⚠️'],
        ['label'=>'Pending Review',    'value'=>number_format($stats['pending_incidents']),     'color'=>'text-amber-700',   'bg'=>'bg-amber-50',   'icon'=>'⏳',
         'link' => route('admin.incidents.index', ['status'=>'pending'])],
        ['label'=>'Approved',          'value'=>number_format($stats['approved_incidents']),    'color'=>'text-green-700',   'bg'=>'bg-green-50',   'icon'=>'✅'],
        ['label'=>'User Reports',      'value'=>number_format($stats['pending_reports']),       'color'=>'text-orange-700',  'bg'=>'bg-orange-50',  'icon'=>'📋',
         'link' => route('admin.reports.index', ['status'=>'pending'])],
        ['label'=>'Total Users',       'value'=>number_format($stats['total_users']),           'color'=>'text-blue-700',    'bg'=>'bg-blue-50',    'icon'=>'👥'],
        ['label'=>'Today',             'value'=>number_format($stats['incidents_today']),        'color'=>'text-ng-green',    'bg'=>'bg-ng-muted',   'icon'=>'📅'],
    ] as $card)
    @php $tag = isset($card['link']) ? 'a' : 'div'; @endphp
    <{{ $tag }}
        {{ isset($card['link']) ? 'href="'.$card['link'].'"' : '' }}
        class="stat-card {{ isset($card['link']) ? 'hover:border-ng-green/30 cursor-pointer transition-all' : '' }}">
        <div class="w-9 h-9 {{ $card['bg'] }} rounded-xl flex items-center justify-center text-lg mb-3">
            {{ $card['icon'] }}
        </div>
        <div class="font-display font-extrabold text-2xl {{ $card['color'] }} mb-0.5">
            {{ $card['value'] }}
        </div>
        <div class="text-xs text-gray-500 font-medium">{{ $card['label'] }}</div>
    </{{ $tag }}>
    @endforeach
</div>

{{-- ================================================================
     IMPACT NUMBERS
     ================================================================ --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="bg-red-50 border border-red-100 rounded-2xl p-5">
        <div class="font-display font-extrabold text-2xl text-red-600">{{ number_format($stats['total_casualties']) }}</div>
        <div class="text-xs text-red-500 font-bold uppercase tracking-wider mt-1">Total Fatalities</div>
    </div>
    <div class="bg-orange-50 border border-orange-100 rounded-2xl p-5">
        <div class="font-display font-extrabold text-2xl text-orange-600">{{ number_format($stats['total_kidnapped']) }}</div>
        <div class="text-xs text-orange-500 font-bold uppercase tracking-wider mt-1">Total Kidnapped</div>
    </div>
    <div class="bg-purple-50 border border-purple-100 rounded-2xl p-5">
        <div class="font-display font-extrabold text-2xl text-purple-600">{{ number_format($stats['total_comments']) }}</div>
        <div class="text-xs text-purple-500 font-bold uppercase tracking-wider mt-1">Total Comments</div>
    </div>
    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
        <div class="font-display font-extrabold text-2xl text-blue-600">{{ number_format($stats['incidents_this_month']) }}</div>
        <div class="text-xs text-blue-500 font-bold uppercase tracking-wider mt-1">This Month</div>
    </div>
</div>

{{-- ================================================================
     CHARTS + RECENT ROW
     ================================================================ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

    {{-- Monthly trend chart --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <h3 class="font-display font-bold text-sm text-gray-900 mb-5">Monthly Incident Trend (Last 12 Months)</h3>
        <div class="relative h-52">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    {{-- Severity breakdown --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <h3 class="font-display font-bold text-sm text-gray-900 mb-5">Severity Breakdown</h3>
        <div class="relative h-52 flex items-center justify-center">
            <canvas id="severityChart"></canvas>
        </div>
        <div class="mt-3 space-y-1.5">
            @foreach(['critical'=>['🔴','#ef4444'],'high'=>['🟠','#f97316'],'medium'=>['🟡','#f59e0b'],'low'=>['🟢','#22c55e']] as $level=>$info)
            <div class="flex items-center justify-between text-xs">
                <div class="flex items-center gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-full" style="background:{{ $info[1] }}"></div>
                    <span class="text-gray-600 capitalize">{{ $level }}</span>
                </div>
                <span class="font-bold text-gray-800">{{ number_format($bySeverity[$level] ?? 0) }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ================================================================
     ATTACK TYPES + TOP STATES
     ================================================================ --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

    {{-- Attack type breakdown --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <h3 class="font-display font-bold text-sm text-gray-900 mb-4">Incidents by Attack Type</h3>
        <div class="space-y-2.5">
            @php $maxType = $byAttackType->max('total') ?: 1; @endphp
            @foreach($byAttackType->take(8) as $type)
            <div class="flex items-center gap-3">
                <span class="text-xs font-medium text-gray-600 w-32 flex-shrink-0 truncate">
                    {{ \App\Models\Incident::ATTACK_TYPES[$type->attack_type] ?? $type->attack_type }}
                </span>
                <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-ng-green rounded-full"
                         style="width: {{ ($type->total / $maxType) * 100 }}%"></div>
                </div>
                <span class="text-xs font-bold text-gray-700 w-8 text-right">{{ $type->total }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Top states --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <h3 class="font-display font-bold text-sm text-gray-900 mb-4">Most Affected States</h3>
        <div class="space-y-2.5">
            @php $maxState = $topStates->max('incidents_count') ?: 1; @endphp
            @foreach($topStates as $i => $state)
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-gray-400 w-5 text-right">{{ $i+1 }}</span>
                <span class="text-xs font-medium text-gray-700 w-28 flex-shrink-0 truncate">{{ $state->name }}</span>
                <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-ng-green rounded-full"
                         style="width: {{ ($state->incidents_count / $maxState) * 100 }}%"></div>
                </div>
                <a href="{{ route('admin.incidents.index') }}?state_id={{ $state->id }}"
                   class="text-xs font-bold text-ng-green hover:text-ng-dark w-8 text-right transition-colors">
                    {{ $state->incidents_count }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ================================================================
     RECENT INCIDENTS TABLE
     ================================================================ --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
        <h3 class="font-display font-bold text-sm text-gray-900">Recent Incidents</h3>
        <a href="{{ route('admin.incidents.index') }}"
           class="text-xs font-semibold text-ng-green hover:text-ng-dark transition-colors">View all →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Incident</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3 hidden sm:table-cell">State</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3 hidden md:table-cell">Type</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3">Severity</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3">Status</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3 hidden lg:table-cell">Reporter</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3">Date</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($recentIncidents as $incident)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5">
                        <p class="text-sm font-semibold text-gray-900 line-clamp-1 max-w-xs">
                            {{ $incident->title }}
                        </p>
                    </td>
                    <td class="px-3 py-3.5 hidden sm:table-cell">
                        <span class="text-xs text-gray-600">{{ $incident->state->name }}</span>
                    </td>
                    <td class="px-3 py-3.5 hidden md:table-cell">
                        <span class="text-xs text-gray-600">{{ $incident->attack_type_label }}</span>
                    </td>
                    <td class="px-3 py-3.5">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-lg severity-{{ $incident->severity }}">
                            {{ ucfirst($incident->severity) }}
                        </span>
                    </td>
                    <td class="px-3 py-3.5">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-lg status-{{ $incident->status }}">
                            {{ ucfirst($incident->status) }}
                        </span>
                    </td>
                    <td class="px-3 py-3.5 hidden lg:table-cell">
                        <span class="text-xs text-gray-500">{{ $incident->creator?->full_name ?? 'Admin' }}</span>
                    </td>
                    <td class="px-3 py-3.5">
                        <span class="text-xs text-gray-500">{{ $incident->incident_date?->format('d M') }}</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <a href="{{ route('admin.incidents.show', $incident) }}"
                           class="text-xs font-semibold text-ng-green hover:text-ng-dark transition-colors">
                            View →
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Recent Users --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
        <h3 class="font-display font-bold text-sm text-gray-900">Recent Registrations</h3>
        @if(auth()->user()->isSuperAdmin())
        <a href="{{ route('admin.users.index') }}"
           class="text-xs font-semibold text-ng-green hover:text-ng-dark transition-colors">View all →</a>
        @endif
    </div>
    <div class="divide-y divide-gray-50">
        @foreach($recentUsers as $user)
        <div class="flex items-center gap-3 px-5 py-3.5">
            <img src="{{ $user->avatar_url }}" class="w-8 h-8 rounded-full border border-gray-100 object-cover flex-shrink-0"
                 alt="{{ $user->full_name }}">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">{{ $user->full_name }}</p>
                <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="text-[11px] px-2 py-0.5 rounded-full font-semibold
                    {{ $user->role === 'super_admin' ? 'bg-purple-100 text-purple-700' :
                       ($user->role === 'moderator' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                    {{ $user->role_label }}
                </span>
                <span class="text-[10px] text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color       = '#6b7280';

// Monthly trend line chart
(function() {
    const raw   = @json($monthlyTrend);
    const labels = raw.map(d => {
        const [year, month] = d.month.split('-');
        return new Date(year, month - 1, 1).toLocaleDateString('en-NG', { month: 'short', year: '2-digit' });
    });
    const values = raw.map(d => d.total);

    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Incidents',
                data: values,
                borderColor:     '#009A44',
                backgroundColor: 'rgba(0,154,68,0.08)',
                borderWidth:     2.5,
                tension:         0.4,
                fill:            true,
                pointRadius:     4,
                pointBackgroundColor: '#009A44',
                pointBorderColor:     'white',
                pointBorderWidth:     2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 11 } },
                    grid: { color: '#f1f5f9' },
                },
                x: {
                    ticks: { font: { size: 11 } },
                    grid: { display: false },
                }
            }
        }
    });
})();

// Severity donut chart
(function() {
    const sev  = @json($bySeverity);
    const data = [sev.critical||0, sev.high||0, sev.medium||0, sev.low||0];
    const total = data.reduce((a,b) => a+b, 0);

    new Chart(document.getElementById('severityChart'), {
        type: 'doughnut',
        data: {
            labels: ['Critical', 'High', 'Medium', 'Low'],
            datasets: [{
                data,
                backgroundColor: ['#ef4444','#f97316','#f59e0b','#22c55e'],
                borderWidth:     2,
                borderColor:     'white',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.raw} (${total ? Math.round(ctx.raw/total*100) : 0}%)`
                    }
                }
            }
        }
    });
})();
</script>
@endpush
