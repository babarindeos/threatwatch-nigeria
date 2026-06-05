{{-- ================================================================
     resources/views/admin/reports/show.blade.php
     ================================================================ --}}
@extends('layouts.admin')
@section('title', 'Review Report')
@section('page_title', 'Review Report')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 max-w-5xl">

    {{-- Main --}}
    <div class="lg:col-span-2 space-y-4">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="text-xs font-bold px-2.5 py-1 rounded-lg {{ $report->status_badge }}">{{ strtoupper($report->status) }}</span>
                <span class="text-xs font-medium px-2.5 py-1 rounded-lg bg-gray-100 text-gray-600">{{ $report->attack_type_label }}</span>
                @if($report->is_anonymous)
                <span class="text-xs font-medium px-2.5 py-1 rounded-lg bg-purple-100 text-purple-700">Anonymous</span>
                @endif
            </div>
            <h1 class="font-display font-bold text-xl text-gray-900 mb-4">{{ $report->title }}</h1>
            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $report->description }}</p>
        </div>

        {{-- Evidence --}}
        @if($report->evidence_files && count($report->evidence_files))
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="font-display font-semibold text-sm text-gray-900 mb-3">Evidence Files</h3>
            <div class="grid grid-cols-3 gap-3">
                @foreach($report->evidence_files as $file)
                <a href="{{ asset('storage/'.$file) }}" target="_blank"
                   class="aspect-video rounded-xl overflow-hidden border border-gray-100 bg-gray-50 hover:border-ng-green transition-colors block">
                    @if(str_ends_with(strtolower($file), '.pdf'))
                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-500">📄 PDF</div>
                    @elseif(str_contains($file, 'mp4'))
                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-500">🎥 Video</div>
                    @else
                    <img src="{{ asset('storage/'.$file) }}" class="w-full h-full object-cover">
                    @endif
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="space-y-4">

        {{-- Review Form --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="font-display font-semibold text-sm text-gray-900 mb-4">Review Action</h3>
            <form method="POST" action="{{ route('admin.reports.review', $report) }}" class="space-y-3">
                @csrf @method('PATCH')
                <div>
                    <label class="form-label text-xs">Update Status</label>
                    <select name="status" required class="form-input text-sm">
                        @foreach(['pending'=>'Pending','reviewed'=>'Mark as Reviewed','approved'=>'Approve','rejected'=>'Reject'] as $val => $label)
                        <option value="{{ $val }}" {{ $report->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label text-xs">Admin Notes</label>
                    <textarea name="admin_notes" rows="3" placeholder="Internal notes..."
                              class="form-input text-sm resize-none">{{ $report->admin_notes }}</textarea>
                </div>
                <button type="submit" class="btn-primary w-full text-sm py-2.5">Update Status</button>
            </form>
        </div>

        {{-- Convert to Incident --}}
        @if(in_array($report->status, ['reviewed','approved']))
        <div class="bg-ng-muted border border-ng-green/20 rounded-2xl p-5">
            <h3 class="font-display font-semibold text-sm text-ng-dark mb-2">Convert to Incident</h3>
            <p class="text-xs text-ng-dark/70 mb-3">This will create a verified public incident from this report.</p>
            <form method="POST" action="{{ route('admin.reports.convert', $report) }}"
                  onsubmit="return confirm('Convert this report into a public incident?')">
                @csrf
                <button class="btn-primary w-full text-sm py-2.5">
                    ✅ Publish as Incident
                </button>
            </form>
        </div>
        @endif

        {{-- Report Details --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="font-display font-semibold text-sm text-gray-900 mb-4">Report Details</h3>
            <dl class="space-y-2 text-xs">
                <div class="flex justify-between gap-2"><dt class="text-gray-500">State</dt><dd class="font-semibold text-gray-900">{{ $report->state->name }}</dd></div>
                @if($report->lga)<div class="flex justify-between gap-2"><dt class="text-gray-500">LGA</dt><dd class="font-semibold text-gray-900">{{ $report->lga->name }}</dd></div>@endif
                @if($report->town)<div class="flex justify-between gap-2"><dt class="text-gray-500">Town</dt><dd class="font-semibold text-gray-900">{{ $report->town }}</dd></div>@endif
                <div class="flex justify-between gap-2"><dt class="text-gray-500">Date</dt><dd class="font-semibold text-gray-900">{{ $report->incident_date?->format('d M Y') }}</dd></div>
                <div class="flex justify-between gap-2"><dt class="text-gray-500">Fatalities</dt><dd class="font-bold text-red-600">{{ $report->casualties }}</dd></div>
                <div class="flex justify-between gap-2"><dt class="text-gray-500">Kidnapped</dt><dd class="font-bold text-orange-600">{{ $report->kidnapped_count }}</dd></div>
                <div class="flex justify-between gap-2"><dt class="text-gray-500">Reporter</dt><dd class="font-semibold text-gray-900">{{ $report->display_name }}</dd></div>
                @if($report->reporter_phone && !$report->is_anonymous)
                <div class="flex justify-between gap-2"><dt class="text-gray-500">Phone</dt><dd class="font-semibold text-gray-900">{{ $report->reporter_phone }}</dd></div>
                @endif
                <div class="flex justify-between gap-2"><dt class="text-gray-500">Submitted</dt><dd class="text-gray-600">{{ $report->created_at->format('d M Y, H:i') }}</dd></div>
                @if($report->reviewer)
                <div class="flex justify-between gap-2 pt-2 border-t border-gray-50">
                    <dt class="text-gray-500">Reviewed by</dt>
                    <dd class="font-semibold text-gray-900">{{ $report->reviewer->full_name }}</dd>
                </div>
                @endif
            </dl>
        </div>
    </div>
</div>
@endsection
