{{-- resources/views/admin/users/show.blade.php --}}
@extends('layouts.admin')
@section('title', $user->full_name . ' — User Profile')
@section('page_title', 'User Profile')
@section('page_breadcrumb', $user->full_name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 max-w-5xl">

    {{-- Profile Card --}}
    <div class="space-y-4">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm text-center">
            <img src="{{ $user->avatar_url }}"
                 class="w-20 h-20 rounded-full border-4 border-ng-muted mx-auto mb-4 object-cover"
                 alt="{{ $user->full_name }}">
            <h2 class="font-display font-bold text-lg text-gray-900">{{ $user->full_name }}</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</p>
            <div class="flex items-center justify-center gap-2 mt-3">
                <span class="text-xs font-bold px-3 py-1 rounded-full
                    {{ $user->role === 'super_admin' ? 'bg-purple-100 text-purple-700' :
                       ($user->role === 'moderator' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                    {{ $user->role_label }}
                </span>
                <span class="text-xs font-bold px-3 py-1 rounded-full
                    {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $user->is_active ? 'Active' : 'Suspended' }}
                </span>
            </div>
        </div>

        {{-- Stats --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="font-display font-semibold text-sm text-gray-900 mb-4">Activity</h3>
            <dl class="space-y-3">
                @foreach([
                    ['Incidents Submitted', $user->incidents->count(), '⚠️'],
                    ['Reports Filed',       $user->reports->count(),   '📋'],
                    ['Joined',              $user->created_at->format('d M Y'), '📅'],
                    ['Last Email Verified', $user->email_verified_at?->format('d M Y') ?? 'Unverified', '✉️'],
                ] as [$label, $val, $icon])
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs text-gray-500 flex items-center gap-1.5">
                        {{ $icon }} {{ $label }}
                    </span>
                    <span class="text-xs font-bold text-gray-900">{{ $val }}</span>
                </div>
                @endforeach
            </dl>
        </div>

        {{-- Actions --}}
        @if(auth()->user()->isSuperAdmin() && auth()->id() !== $user->id)
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm space-y-2">
            <h3 class="font-display font-semibold text-sm text-gray-900 mb-3">Admin Actions</h3>

            {{-- Toggle Status --}}
            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                @csrf @method('PATCH')
                <button class="w-full text-xs font-semibold py-2.5 px-4 rounded-xl border transition-colors
                               {{ $user->is_active
                                  ? 'border-red-200 text-red-600 hover:bg-red-50'
                                  : 'border-green-200 text-green-600 hover:bg-green-50' }}">
                    {{ $user->is_active ? '🔒 Suspend Account' : '🔓 Activate Account' }}
                </button>
            </form>

            {{-- Change Role --}}
            <form method="POST" action="{{ route('admin.users.change-role', $user) }}" class="flex gap-2">
                @csrf @method('PATCH')
                <select name="role" class="form-input text-xs py-2 flex-1">
                    @foreach(['user'=>'User','moderator'=>'Moderator','super_admin'=>'Super Admin'] as $val => $label)
                    <option value="{{ $val }}" {{ $user->role === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary text-xs py-2 px-3 flex-shrink-0">Set</button>
            </form>

            {{-- Delete --}}
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                  onsubmit="return confirm('Permanently delete {{ $user->full_name }}? All their data will be soft-deleted.')">
                @csrf @method('DELETE')
                <button class="w-full text-xs text-red-400 hover:text-red-600 hover:bg-red-50
                               py-2 px-4 rounded-xl border border-transparent hover:border-red-200 transition-colors">
                    🗑 Delete User
                </button>
            </form>
        </div>
        @endif
    </div>

    {{-- Activity --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Recent Incidents --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-display font-semibold text-sm text-gray-900">
                    Recent Incidents ({{ $user->incidents->count() }})
                </h3>
            </div>
            @if($user->incidents->isEmpty())
            <p class="text-sm text-gray-400 text-center py-8">No incidents submitted yet.</p>
            @else
            <div class="divide-y divide-gray-50">
                @foreach($user->incidents->take(5) as $incident)
                <div class="flex items-center justify-between gap-3 px-5 py-3.5 hover:bg-gray-50/50">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $incident->title }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $incident->state->name }} · {{ $incident->incident_date?->format('d M Y') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-lg severity-{{ $incident->severity }}">
                            {{ ucfirst($incident->severity) }}
                        </span>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-lg status-{{ $incident->status }}">
                            {{ ucfirst($incident->status) }}
                        </span>
                        <a href="{{ route('admin.incidents.show', $incident) }}"
                           class="text-xs text-ng-green hover:text-ng-dark font-semibold transition-colors">→</a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Recent Reports --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-display font-semibold text-sm text-gray-900">
                    Submitted Reports ({{ $user->reports->count() }})
                </h3>
            </div>
            @if($user->reports->isEmpty())
            <p class="text-sm text-gray-400 text-center py-8">No reports submitted yet.</p>
            @else
            <div class="divide-y divide-gray-50">
                @foreach($user->reports->take(5) as $report)
                <div class="flex items-center justify-between gap-3 px-5 py-3.5 hover:bg-gray-50/50">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $report->title }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $report->state->name }} · {{ $report->incident_date?->format('d M Y') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-lg {{ $report->status_badge }}">
                            {{ ucfirst($report->status) }}
                        </span>
                        <a href="{{ route('admin.reports.show', $report) }}"
                           class="text-xs text-ng-green hover:text-ng-dark font-semibold transition-colors">→</a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
