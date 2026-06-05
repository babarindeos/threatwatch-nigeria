{{-- ================================================================
     resources/views/admin/comments/index.blade.php
     ================================================================ --}}
@extends('layouts.admin')
@section('title', 'Moderate Comments')
@section('page_title', 'Comments')

@section('content')
<div class="flex flex-wrap gap-2 mb-5">
    @foreach([''=>'All','pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected'] as $val => $label)
    <a href="{{ route('admin.comments.index') }}{{ $val ? '?status='.$val : '' }}"
       class="text-xs font-semibold px-3 py-1.5 rounded-full border transition-all
              {{ request('status') === $val || (request('status') === null && $val === '') ?
                 'bg-ng-green text-white border-ng-green' :
                 'bg-white text-gray-600 border-gray-200 hover:border-ng-green' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="divide-y divide-gray-50">
        @forelse($comments as $comment)
        <div class="flex items-start gap-4 px-5 py-4 hover:bg-gray-50/50 transition-colors">
            <img src="{{ $comment->user->avatar_url }}"
                 class="w-8 h-8 rounded-full border border-gray-100 flex-shrink-0 object-cover">
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2 mb-1">
                    <span class="text-sm font-bold text-gray-900">{{ $comment->user->full_name }}</span>
                    <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded
                        {{ $comment->status === 'approved' ? 'bg-green-100 text-green-700' :
                           ($comment->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ $comment->status }}
                    </span>
                    @if($comment->parent_id)
                    <span class="text-[10px] bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded font-medium">Reply</span>
                    @endif
                </div>
                <p class="text-sm text-gray-700 line-clamp-2">{{ $comment->comment }}</p>
                @if($comment->incident)
                <a href="{{ route('admin.incidents.show', $comment->incident) }}"
                   class="text-xs text-ng-green hover:text-ng-dark font-medium mt-1 inline-block transition-colors">
                    On: {{ Str::limit($comment->incident->title, 60) }} →
                </a>
                @endif
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                @if($comment->status !== 'approved')
                <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                    @csrf @method('PATCH')
                    <button class="text-xs font-bold text-green-600 hover:text-green-800 px-2 py-1 rounded-lg
                                   hover:bg-green-50 transition-colors">
                        ✓ Approve
                    </button>
                </form>
                @endif
                @if($comment->status !== 'rejected')
                <form method="POST" action="{{ route('admin.comments.reject', $comment) }}">
                    @csrf @method('PATCH')
                    <button class="text-xs font-bold text-amber-600 hover:text-amber-800 px-2 py-1 rounded-lg
                                   hover:bg-amber-50 transition-colors">
                        ✕ Reject
                    </button>
                </form>
                @endif
                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}"
                      onsubmit="return confirm('Delete this comment?')">
                    @csrf @method('DELETE')
                    <button class="text-xs text-red-400 hover:text-red-600 px-2 py-1 rounded-lg
                                   hover:bg-red-50 transition-colors">
                        🗑
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-14 text-gray-400 text-sm">No comments found.</div>
        @endforelse
    </div>
    @if($comments->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $comments->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
