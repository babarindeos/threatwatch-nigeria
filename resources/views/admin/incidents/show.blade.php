{{-- ================================================================
     resources/views/admin/incidents/show.blade.php
     ================================================================ --}}
@extends('layouts.admin')
@section('title', 'Incident: ' . Str::limit($incident->title, 40))
@section('page_title', 'Incident Detail')
@section('page_breadcrumb', $incident->title)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Main --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Header card --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="text-xs font-bold px-3 py-1 rounded-lg severity-{{ $incident->severity }}">{{ strtoupper($incident->severity) }}</span>
                <span class="text-xs font-bold px-3 py-1 rounded-lg status-{{ $incident->status }}">{{ strtoupper($incident->status) }}</span>
                <span class="text-xs font-medium px-3 py-1 rounded-lg bg-gray-100 text-gray-600">{{ $incident->attack_type_label }}</span>
            </div>
            <h1 class="font-display font-bold text-xl text-gray-900 mb-4">{{ $incident->title }}</h1>
            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $incident->description }}</p>

            @if($incident->source_url)
            <a href="{{ $incident->source_url }}" target="_blank" rel="noopener"
               class="inline-flex items-center gap-1.5 mt-4 text-xs text-blue-600 hover:text-blue-800 font-medium transition-colors">
                🔗 Source Reference →
            </a>
            @endif
        </div>

        {{-- Images --}}
        @if($incident->images && count($incident->images))
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="font-display font-semibold text-sm text-gray-900 mb-3">Media / Evidence</h3>
            <div class="grid grid-cols-3 gap-3">
                @foreach($incident->images as $img)
                <a href="{{ asset('storage/'.$img) }}" target="_blank"
                   class="aspect-video rounded-xl overflow-hidden border border-gray-100 bg-gray-50 hover:border-ng-green transition-colors block">
                    @if(str_ends_with(strtolower($img), '.pdf'))
                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-500">📄 PDF</div>
                    @else
                    <img src="{{ asset('storage/'.$img) }}" class="w-full h-full object-cover" alt="Evidence">
                    @endif
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Comments --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="font-display font-semibold text-sm text-gray-900 mb-4">
                Comments ({{ $incident->allComments->count() }})
            </h3>
            <div class="space-y-3 max-h-80 overflow-y-auto">
                @forelse($incident->allComments->where('parent_id', null) as $comment)
                <div class="flex gap-3 {{ $comment->status === 'rejected' ? 'opacity-50' : '' }}">
                    <img src="{{ $comment->user->avatar_url }}" class="w-8 h-8 rounded-full flex-shrink-0 object-cover border border-gray-100">
                    <div class="flex-1 bg-gray-50 rounded-xl p-3">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <span class="text-xs font-bold text-gray-900">{{ $comment->user->full_name }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded
                                    {{ $comment->status === 'approved' ? 'bg-green-100 text-green-700' :
                                       ($comment->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $comment->status }}
                                </span>
                                <div class="flex items-center gap-1">
                                    @if($comment->status !== 'approved')
                                    <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">@csrf @method('PATCH')
                                        <button class="text-[10px] text-green-600 hover:text-green-800 font-bold">✓</button>
                                    </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}"
                                          onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <button class="text-[10px] text-red-500 hover:text-red-700 font-bold">✕</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-700">{{ $comment->comment }}</p>
                    </div>
                </div>
                @empty
                <p class="text-xs text-gray-400 text-center py-4">No comments yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-4">

        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="font-display font-semibold text-sm text-gray-900 mb-4">Actions</h3>
            <div class="space-y-2">
                @if($incident->status !== 'approved')
                <form method="POST" action="{{ route('admin.incidents.approve', $incident) }}">
                    @csrf @method('PATCH')
                    <button class="btn-primary w-full text-xs py-2.5 flex items-center justify-center gap-2">
                        ✅ Approve & Publish
                    </button>
                </form>
                @endif

                @if($incident->status !== 'rejected')
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                            class="w-full text-xs font-semibold py-2.5 px-4 rounded-xl border border-red-200
                                   text-red-600 hover:bg-red-50 transition-colors">
                        ✕ Reject Incident
                    </button>
                    <div x-show="open" class="mt-2">
                        <form method="POST" action="{{ route('admin.incidents.reject', $incident) }}">
                            @csrf @method('PATCH')
                            <textarea name="rejection_reason" rows="3"
                                      placeholder="Reason for rejection..."
                                      required class="form-input text-xs resize-none mb-2"></textarea>
                            <button type="submit" class="btn-danger w-full text-xs py-2">Confirm Reject</button>
                        </form>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.incidents.toggle-featured', $incident) }}">
                    @csrf @method('PATCH')
                    <button class="w-full text-xs font-semibold py-2.5 px-4 rounded-xl border border-amber-200
                                   text-amber-700 hover:bg-amber-50 transition-colors">
                        {{ $incident->is_featured ? '★ Remove from Featured' : '☆ Mark as Featured' }}
                    </button>
                </form>

                <a href="{{ route('admin.incidents.edit', $incident) }}"
                   class="block text-center w-full text-xs font-semibold py-2.5 px-4 rounded-xl
                          border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
                    ✏️ Edit Incident
                </a>

                <a href="{{ route('incidents.show', $incident->slug) }}" target="_blank"
                   class="block text-center w-full text-xs font-semibold py-2.5 px-4 rounded-xl
                          border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
                    👁 View Public Page
                </a>

                @if(auth()->user()->isSuperAdmin())
                <form method="POST" action="{{ route('admin.incidents.destroy', $incident) }}"
                      onsubmit="return confirm('Permanently delete this incident? This cannot be undone.')">
                    @csrf @method('DELETE')
                    <button class="w-full text-xs font-semibold py-2 px-4 rounded-xl text-red-400
                                   hover:text-red-600 hover:bg-red-50 transition-colors border border-transparent hover:border-red-200">
                        🗑 Delete Incident
                    </button>
                </form>
                @endif
            </div>
        </div>

        {{-- Details --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="font-display font-semibold text-sm text-gray-900 mb-4">Details</h3>
            <dl class="space-y-2.5 text-xs">
                <div class="flex justify-between gap-2"><dt class="text-gray-500">State</dt><dd class="font-semibold text-gray-900">{{ $incident->state->name }}</dd></div>
                @if($incident->lga)<div class="flex justify-between gap-2"><dt class="text-gray-500">LGA</dt><dd class="font-semibold text-gray-900">{{ $incident->lga->name }}</dd></div>@endif
                @if($incident->town)<div class="flex justify-between gap-2"><dt class="text-gray-500">Town</dt><dd class="font-semibold text-gray-900">{{ $incident->town }}</dd></div>@endif
                <div class="flex justify-between gap-2"><dt class="text-gray-500">Date</dt><dd class="font-semibold text-gray-900">{{ $incident->formatted_date }}</dd></div>
                @if($incident->incident_time)<div class="flex justify-between gap-2"><dt class="text-gray-500">Time</dt><dd class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($incident->incident_time)->format('H:i') }}</dd></div>@endif
                <div class="flex justify-between gap-2"><dt class="text-gray-500">Fatalities</dt><dd class="font-bold text-red-600">{{ $incident->casualties }}</dd></div>
                <div class="flex justify-between gap-2"><dt class="text-gray-500">Kidnapped</dt><dd class="font-bold text-orange-600">{{ $incident->kidnapped_count }}</dd></div>
                <div class="flex justify-between gap-2"><dt class="text-gray-500">Views</dt><dd class="font-semibold text-gray-900">{{ number_format($incident->views) }}</dd></div>
                <div class="flex justify-between gap-2"><dt class="text-gray-500">Reporter</dt><dd class="font-semibold text-gray-900">{{ $incident->reporter_name }}</dd></div>
                @if($incident->approved_at)
                <div class="pt-2 border-t border-gray-50">
                    <dt class="text-gray-500 mb-1">Approved by</dt>
                    <dd class="font-semibold text-gray-900">{{ $incident->approver?->full_name }}</dd>
                    <dd class="text-gray-400">{{ $incident->approved_at->format('d M Y, H:i') }}</dd>
                </div>
                @endif
                @if($incident->rejection_reason)
                <div class="pt-2 border-t border-gray-50">
                    <dt class="text-red-500 font-semibold mb-1">Rejection Reason</dt>
                    <dd class="text-gray-700">{{ $incident->rejection_reason }}</dd>
                </div>
                @endif
            </dl>
        </div>
    </div>
</div>
@endsection
