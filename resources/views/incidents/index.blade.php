{{-- resources/views/incidents/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Security Incidents — ThreatWatch Nigeria')
@section('meta_description', 'Browse all verified security incidents across Nigeria. Filter by state, attack type, and severity.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display font-bold text-3xl text-gray-900">Security Incidents</h1>
            <p class="text-sm text-gray-500 mt-1.5">
                {{ number_format($incidents->total()) }} verified report{{ $incidents->total() !== 1 ? 's' : '' }} from across Nigeria
            </p>
        </div>
        <a href="{{ route('reports.create') }}"
           class="inline-flex items-center gap-2 bg-ng-green hover:bg-ng-dark text-white
                  font-bold text-sm px-5 py-2.5 rounded-xl transition-colors shadow-sm flex-shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Report a Threat
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('incidents.index') }}"
          class="bg-white rounded-2xl border border-gray-100 p-4 mb-6 shadow-sm"
          x-data="{ showAdvanced: {{ (!empty($filters['date_from']) || !empty($filters['date_to']) || !empty($filters['search'])) ? 'true' : 'false' }} }">

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            {{-- State --}}
            <div>
                <label class="form-label text-xs">State</label>
                <select name="state_id" class="form-input text-xs py-2 border border-gray-300 rounded-r-lg"
                        onchange="loadLgas(this.value)">
                    <option value="">All States</option>
                    @foreach($states as $state)
                    <option value="{{ $state->id }}" {{ ($filters['state_id'] ?? '') == $state->id ? 'selected' : '' }}>
                        {{ $state->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Attack Type --}}
            <div>
                <label class="form-label text-xs">Attack Type</label>
                <select name="attack_type" class="form-input text-xs py-2 border border-gray-300 rounded-r-lg">
                    <option value="">All Types</option>
                    @foreach(\App\Models\Incident::ATTACK_TYPES as $val => $label)
                    <option value="{{ $val }}" {{ ($filters['attack_type'] ?? '') === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Severity --}}
            <div>
                <label class="form-label text-xs">Severity</label>
                <select name="severity" class="form-input text-xs py-2 border border-gray-300 rounded-r-lg">
                    <option value="">All Levels</option>
                    @foreach(['low'=>'Low','medium'=>'Medium','high'=>'High','critical'=>'Critical'] as $val => $label)
                    <option value="{{ $val }}" {{ ($filters['severity'] ?? '') === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Submit --}}
            <div class="flex items-end items-center">
                <button type="submit" class="btn-primary w-full border bg-green-600 text-white rounded-lg hover:bg-green-700 py-1">Filter</button>
            </div>

            {{-- Toggle advanced --}}
            <div class="flex items-end">
                <button type="button" @click="showAdvanced = !showAdvanced"
                        class="w-full text-xs font-semibold text-gray-500 hover:text-ng-green
                               border border-gray-200 rounded-xl px-3 py-2 transition-colors">
                    <span x-text="showAdvanced ? 'Less filters ▲' : 'More filters ▼'"></span>
                </button>
            </div>
        </div>

        {{-- Advanced filters --}}
        <div x-show="showAdvanced" x-collapse class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-3 pt-3 border-t border-gray-100">
            <div class="flex items-center gap-2">
                <label class="form-label text-xs">Search</label>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                       placeholder="Keywords in title or description..."
                       class="form-input text-xs py-2 border border-gray-300 rounded-r-lg flex-1 px-2">
            </div>
            <div>
                <label class="form-label text-xs">Date From</label>
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                       class="form-input text-xs py-2 border border-gray-300 rounded-r-lg px-2">
            </div>
            <div>
                <label class="form-label text-xs">Date To</label>
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                       class="form-input text-xs py-2 border border-gray-300 rounded-r-lg px-2">
            </div>
        </div>

        {{-- Active filters & clear --}}
        @if(array_filter($filters))
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
            <span class="text-xs text-gray-500 font-medium">Active filters:</span>
            @foreach(array_filter($filters) as $key => $value)
            <span class="inline-flex items-center gap-1 text-xs bg-ng-muted text-ng-dark
                         border border-ng-green/20 px-2.5 py-1 rounded-full font-medium">
                {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}
            </span>
            @endforeach
            <a href="{{ route('incidents.index') }}"
               class="ml-auto text-xs text-red-500 hover:text-red-700 font-semibold transition-colors">
                ✕ Clear all
            </a>
        </div>
        @endif
    </form>

    {{-- Incidents Grid --}}
    @if($incidents->isEmpty())
    <div class="text-center py-20">
        <svg class="w-14 h-14 mx-auto mb-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <p class="font-display font-bold text-lg text-gray-400">No incidents found</p>
        <p class="text-sm text-gray-400 mt-1">Try adjusting your filters</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($incidents as $incident)
            @include('partials.incident-card', ['incident' => $incident])
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $incidents->withQueryString()->links() }}
    </div>
    @endif

</div>
@endsection
