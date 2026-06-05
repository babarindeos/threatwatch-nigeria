{{-- ================================================================
     resources/views/reports/my.blade.php
     ================================================================ --}}
@extends('layouts.app')
@section('title', 'My Reports — ThreatWatch Nigeria')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">

    <div class="flex items-center justify-between mb-7">
        <div>
            <h1 class="font-display font-bold text-2xl text-gray-900">My Reports</h1>
            <p class="text-sm text-gray-500 mt-1">Track the status of your submitted threat reports</p>
        </div>
        <a href="{{ route('reports.create') }}"
           class="btn-primary inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            New Report
        </a>
    </div>

    @if($reports->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
        <svg class="w-14 h-14 mx-auto mb-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <p class="font-display font-bold text-lg text-gray-400">No reports yet</p>
        <p class="text-sm text-gray-400 mt-1">You haven't submitted any threat reports.</p>
        <a href="{{ route('reports.create') }}"
           class="inline-flex items-center gap-2 mt-5 btn-primary">
            Submit your first report →
        </a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($reports as $report)
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:border-ng-green/20 transition-all">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="inline-flex text-[11px] font-bold px-2.5 py-1 rounded-lg {{ $report->status_badge }}">
                            {{ strtoupper($report->status) }}
                        </span>
                        <span class="text-[11px] font-medium bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg">
                            {{ $report->attack_type_label }}
                        </span>
                        @if($report->is_anonymous)
                        <span class="text-[11px] font-medium bg-purple-100 text-purple-700 px-2.5 py-1 rounded-lg">
                            Anonymous
                        </span>
                        @endif
                    </div>

                    <h3 class="font-display font-semibold text-gray-900 text-sm leading-snug mb-1.5">
                        {{ $report->title }}
                    </h3>

                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3 text-ng-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $report->state->name }}{{ $report->lga ? ' · ' . $report->lga->name : '' }}{{ $report->town ? ', ' . $report->town : '' }}
                        </span>
                        <span>📅 {{ $report->incident_date?->format('d M Y') }}</span>
                        <span>Submitted {{ $report->created_at->diffForHumans() }}</span>
                    </div>

                    @if($report->admin_notes && $report->status !== 'pending')
                    <div class="mt-3 bg-gray-50 border border-gray-100 rounded-xl px-3 py-2.5 text-xs text-gray-600">
                        <strong class="text-gray-700">Admin note:</strong> {{ $report->admin_notes }}
                    </div>
                    @endif
                </div>

                {{-- Status indicator --}}
                <div class="flex-shrink-0 text-right">
                    @if($report->status === 'pending')
                    <div class="flex items-center gap-1.5 text-xs text-amber-600 font-medium">
                        <div class="w-2 h-2 bg-amber-400 rounded-full animate-pulse"></div>
                        Under Review
                    </div>
                    @elseif($report->status === 'approved')
                    <div class="flex items-center gap-1.5 text-xs text-green-600 font-medium">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Published
                    </div>
                    @elseif($report->status === 'rejected')
                    <div class="flex items-center gap-1.5 text-xs text-red-600 font-medium">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        Not Published
                    </div>
                    @else
                    <div class="text-xs text-blue-600 font-medium">Reviewed</div>
                    @endif
                    <p class="text-[10px] text-gray-400 mt-1">{{ $report->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $reports->links() }}</div>
    @endif
</div>
@endsection
