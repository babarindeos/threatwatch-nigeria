{{-- ================================================================
     resources/views/admin/incidents/index.blade.php
     ================================================================ --}}
@extends('layouts.admin')
@section('title', 'Manage Incidents')
@section('page_title', 'Incidents')
@section('page_breadcrumb', 'Manage all security incidents')

@section('content')

{{-- Actions bar --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
    <div class="flex flex-wrap items-center gap-2">
        @foreach([''=>'All','pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected'] as $val => $label)
        @php $count = match($val) {
            'pending'  => \App\Models\Incident::pending()->count(),
            'approved' => \App\Models\Incident::approved()->count(),
            'rejected' => \App\Models\Incident::where('status','rejected')->count(),
            default    => \App\Models\Incident::count(),
        }; @endphp
        <a href="{{ route('admin.incidents.index') }}{{ $val ? '?status='.$val : '' }}"
           class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full border transition-all
                  {{ request('status') === $val || (request('status') === null && $val === '') ?
                     'bg-ng-green text-white border-ng-green' :
                     'bg-white text-gray-600 border-gray-200 hover:border-ng-green hover:text-ng-green' }}">
            {{ $label }}
            <span class="font-bold">{{ $count }}</span>
        </a>
        @endforeach
    </div>
    <a href="{{ route('admin.incidents.create') }}" class="btn-primary inline-flex items-center gap-2 flex-shrink-0">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Incident
    </a>
</div>

{{-- Filters --}}
<div class="bg-white rounded-2xl border border-gray-100 p-4 mb-5 shadow-sm">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        @if(request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <div class="flex-1 min-w-36">
            <label class="form-label text-xs">State</label>
            <select name="state_id" class="form-input text-xs py-2">
                <option value="">All States</option>
                @foreach($states as $state)
                <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-36">
            <label class="form-label text-xs">Attack Type</label>
            <select name="attack_type" class="form-input text-xs py-2">
                <option value="">All Types</option>
                @foreach($attackTypes as $val => $label)
                <option value="{{ $val }}" {{ request('attack_type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-32">
            <label class="form-label text-xs">Severity</label>
            <select name="severity" class="form-input text-xs py-2">
                <option value="">All</option>
                @foreach(['low','medium','high','critical'] as $s)
                <option value="{{ $s }}" {{ request('severity') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-40">
            <label class="form-label text-xs">Search</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Title, town..." class="form-input text-xs py-2">
        </div>
        <button type="submit" class="btn-primary text-xs py-2">Filter</button>
        @if(request()->hasAny(['state_id','attack_type','severity','search']))
        <a href="{{ route('admin.incidents.index') }}{{ request('status') ? '?status='.request('status') : '' }}"
           class="text-xs text-gray-500 hover:text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-100 transition-colors">Clear</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Incident</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3 hidden sm:table-cell">Location</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3 hidden md:table-cell">Type</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3">Severity</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3">Status</th>
                    <th class="text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 py-3 hidden lg:table-cell">Date</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($incidents as $incident)
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-5 py-3.5 max-w-xs">
                        <div class="flex items-start gap-2">
                            @if($incident->is_featured)
                            <span class="text-yellow-400 mt-0.5 flex-shrink-0">⭐</span>
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 line-clamp-1">{{ $incident->title }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">by {{ $incident->creator?->full_name ?? 'Admin' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-3.5 hidden sm:table-cell">
                        <p class="text-xs font-medium text-gray-700">{{ $incident->state->name }}</p>
                        @if($incident->lga)<p class="text-[10px] text-gray-400">{{ $incident->lga->name }}</p>@endif
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
                        <span class="text-xs text-gray-500">{{ $incident->incident_date?->format('d M Y') }}</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.incidents.show', $incident) }}"
                               class="text-xs font-bold text-ng-green hover:text-ng-dark transition-colors">View</a>
                            <a href="{{ route('admin.incidents.edit', $incident) }}"
                               class="text-xs font-semibold text-gray-500 hover:text-gray-700 transition-colors">Edit</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-14 text-gray-400 text-sm">
                        No incidents found matching your filters.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($incidents->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $incidents->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
