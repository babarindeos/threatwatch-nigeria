{{-- ================================================================
     resources/views/helplines/index.blade.php
     ================================================================ --}}
@extends('layouts.app')
@section('title', 'Emergency Helplines — ThreatWatch Nigeria')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="font-display font-bold text-3xl text-gray-900 mb-2">Emergency Helplines</h1>
        <p class="text-sm text-gray-500">Official emergency contacts for security agencies across Nigeria.
            <strong class="text-red-600">In immediate danger? Call 199 or 112 now.</strong>
        </p>
    </div>

    {{-- SOS Banner --}}
    <div class="bg-red-600 text-white rounded-2xl p-5 mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <p class="font-display font-bold text-xl mb-1">🚨 Emergency? Don't wait.</p>
            <p class="text-red-100 text-sm">If you are in immediate danger, call the police emergency line immediately.</p>
        </div>
        <div class="flex gap-3 flex-shrink-0">
            <a href="tel:199" class="bg-white text-red-600 font-bold px-5 py-2.5 rounded-xl text-sm hover:bg-red-50 transition-colors">
                📞 Call 199
            </a>
            <a href="tel:112" class="bg-white/20 border border-white/30 text-white font-bold px-5 py-2.5 rounded-xl text-sm hover:bg-white/30 transition-colors">
                <span class="text-white">📞</span> Call 112
            </a>
        </div>
    </div>

    {{-- Filter form --}}
    <form method="GET" class="bg-white rounded-2xl border border-gray-100 p-4 mb-7 shadow-sm flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-40">
            <label class="form-label text-xs">Filter by State</label>
            <select name="state_id" class="form-input text-sm py-2 px-1 border border-gray-300 rounded-r-lg">
                <option value="">All States (National)</option>
                @foreach($states as $state)
                <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>
                    {{ $state->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-36">
            <label class="form-label text-xs">Category</label>
            <select name="category" class="form-input text-sm py-2 px-1 border border-gray-300 rounded-r-lg">
                <option value="">All Categories</option>
                @foreach($categories as $val => $label)
                <option value="{{ $val }}" {{ request('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-primary border border-gray-300 rounded-lg py-2 bg-green-600 hover:bg-green-700 text-white text-sm px-3">Search</button>
        @if(request()->hasAny(['state_id','category']))
        <a href="{{ route('helplines') }}" class="text-sm text-gray-500 hover:text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-100 transition-colors">Clear</a>
        @endif
    </form>

    {{-- National Helplines --}}
    <div class="mb-10">
        <h2 class="font-display font-bold text-lg text-gray-900 mb-4 flex items-center gap-2">
            🇳🇬 National Emergency Numbers
            <span class="text-xs font-normal text-gray-400">(Available Nationwide)</span>
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($nationalHelplines as $line)
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:border-ng-green/30 hover:shadow-md transition-all group">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-ng-muted flex items-center justify-center text-xl flex-shrink-0">
                        {{ $line->category_icon }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm text-gray-900 group-hover:text-ng-green transition-colors leading-snug">
                            {{ $line->agency_name }}
                        </h3>
                        @if($line->description)
                        <p class="text-xs text-gray-400 mt-0.5 line-clamp-2">{{ $line->description }}</p>
                        @endif
                        <div class="flex flex-wrap gap-2 mt-3">
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $line->phone) }}"
                               class="inline-flex items-center gap-1.5 bg-ng-green hover:bg-ng-dark
                                      text-white text-xs font-bold px-3.5 py-1.5 rounded-lg transition-colors">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $line->phone }}
                            </a>
                            @if($line->phone_alt)
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $line->phone_alt) }}"
                               class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200
                                      text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                {{ $line->phone_alt }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- State-specific helplines --}}
    @if($selectedState && $stateHelplines->isNotEmpty())
    <div>
        <h2 class="font-display font-bold text-lg text-gray-900 mb-4">
            📍 {{ $selectedState->name }} State Contacts
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($stateHelplines as $line)
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:border-ng-green/30 transition-all">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-xl flex-shrink-0">
                        {{ $line->category_icon }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm text-gray-900 leading-snug">{{ $line->agency_name }}</h3>
                        @if($line->address)
                        <p class="text-xs text-gray-400 mt-0.5">📍 {{ $line->address }}</p>
                        @endif
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $line->phone) }}"
                           class="inline-flex items-center gap-1.5 mt-2.5 bg-ng-green hover:bg-ng-dark
                                  text-white text-xs font-bold px-3.5 py-1.5 rounded-lg transition-colors">
                            📞 {{ $line->phone }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @elseif($selectedState && $stateHelplines->isEmpty())
    <div class="text-center py-10 text-gray-400">
        <p>No specific helplines listed for {{ $selectedState->name }} yet.</p>
        <p class="text-sm mt-1">Use the national numbers above.</p>
    </div>
    @endif
</div>
@endsection
