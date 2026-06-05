{{-- ================================================================
     resources/views/admin/helplines/index.blade.php
     ================================================================ --}}
@extends('layouts.admin')
@section('title', 'Manage Helplines')
@section('page_title', 'Helplines')
@section('page_breadcrumb', 'Manage emergency contact numbers')

@section('content')

<div class="flex items-center justify-between mb-5">
    <div class="flex flex-wrap gap-2">
        <form method="GET" class="flex flex-wrap gap-2">
            <select name="category" class="form-input text-xs py-1.5 w-40" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $val => $label)
                <option value="{{ $val }}" {{ request('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <select name="state_id" class="form-input text-xs py-1.5 w-44" onchange="this.form.submit()">
                <option value="">All (incl. National)</option>
                @foreach($states as $state)
                <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <a href="{{ route('admin.helplines.create') }}" class="btn-primary inline-flex items-center gap-2 flex-shrink-0">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Helpline
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                    <th class="text-left px-5 py-3">Agency</th>
                    <th class="text-left px-3 py-3">Phone</th>
                    <th class="text-left px-3 py-3 hidden sm:table-cell">Category</th>
                    <th class="text-left px-3 py-3 hidden md:table-cell">State</th>
                    <th class="text-left px-3 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($helplines as $line)
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <span class="text-lg">{{ $line->category_icon }}</span>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $line->agency_name }}</p>
                                @if($line->is_national)
                                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded">National</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-3.5">
                        <div>
                            <p class="text-sm font-mono font-semibold text-gray-900">{{ $line->phone }}</p>
                            @if($line->phone_alt)<p class="text-xs font-mono text-gray-400">{{ $line->phone_alt }}</p>@endif
                        </div>
                    </td>
                    <td class="px-3 py-3.5 hidden sm:table-cell">
                        <span class="text-xs text-gray-600">{{ $line->category_label }}</span>
                    </td>
                    <td class="px-3 py-3.5 hidden md:table-cell">
                        <span class="text-xs text-gray-600">{{ $line->state?->name ?? '🇳🇬 National' }}</span>
                    </td>
                    <td class="px-3 py-3.5">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full
                            {{ $line->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $line->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.helplines.edit', $line) }}"
                               class="text-xs font-bold text-ng-green hover:text-ng-dark transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.helplines.destroy', $line) }}"
                                  onsubmit="return confirm('Delete this helpline?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-400 hover:text-red-600 transition-colors">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-400 text-sm">No helplines found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($helplines->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $helplines->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
