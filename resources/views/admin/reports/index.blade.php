{{-- ================================================================
     resources/views/admin/reports/index.blade.php
     ================================================================ --}}
@extends('layouts.admin')
@section('title', 'User Reports')
@section('page_title', 'User-Submitted Reports')
@section('page_breadcrumb', 'Review and process community threat reports')

@section('content')

{{-- Status tabs --}}
<div class="flex flex-wrap items-center gap-2 mb-5">
    @foreach([''=>'All', 'pending'=>'Pending', 'reviewed'=>'Reviewed', 'approved'=>'Approved', 'rejected'=>'Rejected'] as $val => $label)
    <a href="{{ route('admin.reports.index') }}{{ $val ? '?status='.$val : '' }}"
       class="text-xs font-semibold px-3 py-1.5 rounded-full border transition-all
              {{ request('status') === $val || (request('status') === null && $val === '') ?
                 'bg-ng-green text-white border-ng-green' :
                 'bg-white text-gray-600 border-gray-200 hover:border-ng-green hover:text-ng-green' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                    <th class="text-left px-5 py-3">Report</th>
                    <th class="text-left px-3 py-3 hidden sm:table-cell">Location</th>
                    <th class="text-left px-3 py-3 hidden md:table-cell">Type</th>
                    <th class="text-left px-3 py-3">Status</th>
                    <th class="text-left px-3 py-3 hidden lg:table-cell">Reporter</th>
                    <th class="text-left px-3 py-3 hidden lg:table-cell">Date</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($reports as $report)
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-5 py-3.5 max-w-xs">
                        <p class="text-sm font-semibold text-gray-900 line-clamp-1">{{ $report->title }}</p>
                        @if($report->casualties > 0 || $report->kidnapped_count > 0)
                        <p class="text-[10px] text-gray-400 mt-0.5">
                            @if($report->casualties > 0) {{ $report->casualties }} killed @endif
                            @if($report->kidnapped_count > 0) · {{ $report->kidnapped_count }} kidnapped @endif
                        </p>
                        @endif
                    </td>
                    <td class="px-3 py-3.5 hidden sm:table-cell">
                        <p class="text-xs text-gray-700">{{ $report->state->name }}</p>
                        @if($report->town)<p class="text-[10px] text-gray-400">{{ $report->town }}</p>@endif
                    </td>
                    <td class="px-3 py-3.5 hidden md:table-cell">
                        <span class="text-xs text-gray-600">{{ $report->attack_type_label }}</span>
                    </td>
                    <td class="px-3 py-3.5">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-lg {{ $report->status_badge }}">
                            {{ ucfirst($report->status) }}
                        </span>
                    </td>
                    <td class="px-3 py-3.5 hidden lg:table-cell">
                        <span class="text-xs text-gray-500">{{ $report->display_name }}</span>
                    </td>
                    <td class="px-3 py-3.5 hidden lg:table-cell">
                        <span class="text-xs text-gray-500">{{ $report->incident_date?->format('d M Y') }}</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <a href="{{ route('admin.reports.show', $report) }}"
                           class="text-xs font-bold text-ng-green hover:text-ng-dark transition-colors">
                            Review →
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400 text-sm">No reports found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reports->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $reports->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
